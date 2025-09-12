<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Carteira;
use App\Models\User;
use App\Services\CarteiraService;
use App\Services\CotacaoService;
use Illuminate\Http\Request;
use App\Services\HistoricoService;

class VenderController extends Controller
{

    protected $carteiraService;
    protected $cotacaoService;

    protected $historicoService;

    public function __construct(
        CarteiraService $carteiraService,
        CotacaoService $cotacaoService,
        HistoricoService $historicoService
    ) {
        $this->carteiraService = $carteiraService;
        $this->cotacaoService = $cotacaoService;
        $this->historicoService = $historicoService;
    }
    public function index()
    {
        $dadosCarteira = $this->carteiraService->buscarDadosCarteira(Auth::user()->id);
        return view('vender', ['dadosCarteira' => $dadosCarteira]);
    }

    public function vender(Request $request)
    {
        $validated = $request->validate([
            'acao' => 'required|exists:carteira,acao',
            'qtd' => 'required|integer|min:1'
        ], [
            'acao.required' => 'Uma opção deve ser selecionada.',
            'acao.exists'=>'Código da ação deve existir na carteira.',
            'qtd.required' => 'Uma quantidade deve ser inserida',
            'qtd.integer' => 'Quantidade deve ser um número inteiro',
            'qtd.min' => "A quantidade mínima é 1",
        ]);
        return DB::transaction(function () use ($request, $validated) {
            $user = Auth::user();
            $dadosCarteira = $this->carteiraService->buscarDadosCarteira($user->id);
            //Verificar a quantidade que existe na carteira de uma ação específica 
            $qtdCarteira = null;
            foreach ($dadosCarteira as $item) {
                if ($item['codigo'] === $request->acao) {
                    $qtdCarteira = (int) $item['quantidade'];
                    break;
                }
            }

            if ($qtdCarteira < $request->qtd) {
                return redirect()->back()->with('error', 'Quantidade informada maior que a possuída em carteira');
            }

            $precoAtual = $this->cotacaoService->buscarCotacao($request->acao)['preco'];
            $nomeAcao = $this->cotacaoService->buscarCotacao($request->acao)['nome'];
            //Atualizando a carteira
            if ($qtdCarteira - $validated['qtd'] === 0) {
                Carteira::where('user_id', auth()->id())
                    ->where('acao', $validated['acao'])
                    ->delete();
            } else {

                Carteira::where('user_id', auth()->id())
                    ->where('acao', $validated['acao'])
                    ->update([
                        'quantidade' => ($qtdCarteira - $validated['qtd'])
                    ]);
            }

            //Atualizando o saldo do usuário
            $valorTotal = $validated['qtd'] * $precoAtual;
            $user->saldo += $valorTotal;
            $user->save();

            $this->historicoService->registrar('Venda', auth()->id(), $validated['acao'], $validated['qtd'], $precoAtual);
            //atualizando novamente os dados da carteira devido à alteração no banco de dados
            $dadosCarteira = $this->carteiraService->buscarDadosCarteira($user->id);
            return back()->with([
                'success' => "Venda realizada com sucesso! " .
                    "Você vendeu {$validated['qtd']} ações de {$validated['acao']} ({$nomeAcao}) " .
                    "por R$ " . number_format($valorTotal, 2, ',', '.') .
                    " (R$ " . number_format($precoAtual, 2, ',', '.') . " por ação). " .
                    "Saldo atual: R$ " . number_format($user->saldo, 2, ',', '.'),
                'carteira' => $dadosCarteira
            ]);
        });
    }
}
