<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use App\Models\User;
use App\Services\CotacaoService;
use App\Services\HistoricoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ComprarController extends Controller
{
    protected $cotacaoService;
    protected $historicoService;
    
    public function __construct(CotacaoService $cotacaoService, HistoricoService $historicoService)
    {
        $this->cotacaoService = $cotacaoService;
        $this->historicoService = $historicoService;
    }

    public function create()
    {
        return view('comprar');
    }

    public function comprar(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'inputCode' => 'required|string|max:10',
            'inputQtd' => 'required|integer|min:1|max:10000',
        ], [
            'inputCode.required' => 'Informe o código da ação',
            'inputCode.max' => 'Código da ação muito longo',
            'inputQtd.required' => 'Informe a quantidade',
            'inputQtd.integer' => 'Quantidade deve ser um número inteiro',
            'inputQtd.min' => 'A quantidade deve ser pelo menos 1',
            'inputQtd.max' => 'A quantidade não pode ser maior que 10.000',
        ]);

        $user = Auth::user();
        $acao = strtoupper(trim($request->inputCode));
        $quantidade = (int) trim($request->inputQtd);

        // Iniciar transação para garantir consistência dos dados
        return DB::transaction(function () use ($user, $acao, $quantidade) {
                // 1. Consultar cotação na API
                $cotacao = $this->cotacaoService->buscarCotacao($acao);
                if($cotacao['error'] ?? false){
                    return redirect()->back()->withErrors(['cotacao'=>$cotacao['error']]);
                }

                $precoAtual = $cotacao['preco'];
                $nomeAcao = $cotacao['nome'];

                // 2. Calcular valor total da compra
                $valorCompra = $precoAtual * $quantidade;

                // 3. Verificar se o usuário possui saldo suficiente
                if ($user->saldo < $valorCompra) {
                    return back()->withErrors([
                        'saldo' => 'Saldo insuficiente. Você possui R$ ' . 
                                  number_format($user->saldo, 2, ',', '.') . 
                                  ' e precisa de R$ ' . number_format($valorCompra, 2, ',', '.')
                    ]);
                }

                // 4. Buscar ou criar registro na carteira
                $carteira = Carteira::where('user_id', $user->id)
                                   ->where('acao', $acao)
                                   ->first();

                if ($carteira) {
                    // Atualizar carteira existente
                    $quantidadeAnterior = $carteira->quantidade;
                    $quantidadeTotal = $quantidadeAnterior + $quantidade;
                    $carteira->quantidade = $quantidadeTotal;
                } else {
                    // Criar nova entrada na carteira
                    $carteira = new Carteira([
                        'user_id' => $user->id,
                        'acao' => $acao,
                        'quantidade' => $quantidade,
                    ]);
                }

                // 5. Salvar carteira
                $carteira->save();
                $this->historicoService->registrar('Compra', $user->id, $acao, $quantidade, $valorCompra);
                // 6. Atualizar saldo do usuário
                $user->saldo -= $valorCompra;
                $user->save();

                // 7. Buscar dados atualizados da carteira
                $carteiraData = $this->buscarDadosCarteira($user->id);

                // 8. Retornar sucesso com dados da carteira
                return back()->with([
                    'success' => "Compra realizada com sucesso! " .
                                "Você comprou {$quantidade} ações de {$acao} ({$nomeAcao}) " .
                                "por R$ " . number_format($valorCompra, 2, ',', '.') . 
                                " (R$ " . number_format($precoAtual, 2, ',', '.') . " por ação). " .
                                "Saldo restante: R$ " . number_format($user->saldo, 2, ',', '.'),
                    'carteira' => $carteiraData
                ]);

        });
    }

    private function buscarDadosCarteira($userId)
    {
        $carteira = Carteira::where('user_id', $userId)->get();
        $dadosCarteira = [];

        foreach ($carteira as $item) {
            try {
                // Buscar cotação atual da ação
                $cotacao = $this->cotacaoService->buscarCotacao($item->acao);
                $precoAtual = $cotacao['preco'];
                $total = $precoAtual * $item->quantidade;

                $dadosCarteira[] = [
                    'codigo' => $item->acao,
                    'quantidade' => $item->quantidade,
                    'preco_atual' => number_format($precoAtual, 2, ',', '.'),
                    'total' => number_format($total, 2, ',', '.'),
                ];
            } catch (\Exception $e) {
                // Se não conseguir buscar a cotação, usar preço médio
                $total = $item->preco_medio * $item->quantidade;
                $dadosCarteira[] = [
                    'codigo' => $item->acao,
                    'quantidade' => $item->quantidade,
                    'preco_atual' => 'N/A',
                    'total' => number_format($total, 2, ',', '.'),
                ];
            }
        }

        return $dadosCarteira;
    }
}

