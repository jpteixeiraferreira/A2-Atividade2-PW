<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use App\Models\User;
use App\Services\CotacaoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComprarController extends Controller
{
    protected $cotacaoService;
    public function __construct(CotacaoService $cotacaoService)
    {
        $this->cotacaoService = $cotacaoService;
    }

    public function create()
    {
        return view('comprar');
    }

    public function comprar(Request $request)
    {
        $request->validate([
            'inputCode' => 'required|string',
            'inputQtd' => 'required|integer|min:1',
        ], [
            'inputCode.required' => 'Informe o código da ação',
            'inputQtd.required' => 'Informe a quantidade',
            'inputQtd.integer' => 'Quantidade inválida',
            'inputQtd.min' => 'A quantidade deve ser pelo menos 1',
        ]);

        $user = Auth::user();
        $acao = strtoupper($request->inputCode);
        $quantidade = $request->inputQtd;

        try {
            $cotacao = $this->cotacaoService->buscarCotacao($acao);
            $precoAtual = $cotacao['preco'];

            $valorCompra = $precoAtual * $quantidade;

            if ($user->saldo < $valorCompra) {
                return back()->withErrors(['saldo' => 'Saldo insuficiente para realizar a compra']);

            }

            $carteira = Carteira::firstOrNew([
                'user_id' => $user->id,
                'acao' => $acao
            ]);

            $novaQuantidade = $carteira->quantidade + $quantidade;
            $carteira->quantidade = $novaQuantidade;
            $carteira->user_id = $user->id;
            $carteira->save();

            /** @var \App\Models\User $user */
            $user = Auth::user();
            $user->saldo -= $valorCompra;
            $user->save();
           return response()->json($user);

            return back()->with('success', "Compra realizada! Você comprou $quantidade ações de $acao por R$ " . number_format($valorCompra, 2, ',', '.'));
        } catch (\Exception $e) {
            return back()->withErrors(['erro' => 'Erro ao realizar a compra: ' . $e->getMessage()]);
        }
    }
}
