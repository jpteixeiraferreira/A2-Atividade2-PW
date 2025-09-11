<?php

namespace App\Services;

use App\Models\Carteira;

class CarteiraService
{
    protected $cotacaoService;

    public function __construct(CotacaoService $cotacaoService)
    {
        $this->cotacaoService = $cotacaoService;
    }

    public function buscarDadosCarteira($userId)
    {
        $carteira = Carteira::where('user_id', $userId)->get();
        $dadosCarteira = [];

        foreach ($carteira as $item) {
            try {
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
