<?php

namespace App\Http\Controllers;

use App\Models\Carteira;
use App\Services\CotacaoService;
use Illuminate\Http\Request;


class CarteiraController extends Controller
{
    protected $cotacaoService;

    public function __construct(CotacaoService $cotacaoService)
    {
        $this->cotacaoService = $cotacaoService;
    }

    public function index()
    {
        // Pega todas as ações do usuário logado
        $carteira = Carteira::where('user_id', auth()->id())->get();

        $resultados = [];

        foreach ($carteira as $item) {
            $cotacao = $this->cotacaoService->buscarCotacao($item->acao); // retorna ['nome', 'preco']
            $total = $item->quantidade * $cotacao['preco'];

            $resultados[] = [
                'codigo' => $item->acao,
                'quantidade' => $item->quantidade,
                'preco_atual' => number_format($cotacao['preco'], 2, ',', '.'),
                'total' => number_format($total, 2, ',', '.'),
            ];
        }

        return view('carteira', ['acoes' => $resultados]);
    }
}