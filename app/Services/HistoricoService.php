<?php

namespace App\Services;

use App\Models\Historico;

class HistoricoService
{
    public function registrar(string $tipo, $userId, string $acao, int $quantidade, float $preco): void
    {
        Historico::create([
            'user_id' => $userId,
            'acao' => $acao,
            'tipo' => $tipo, // 'compra' ou 'venda'
            'quantidade' => $quantidade,
            'preco_unitario' => $preco,
            'valor_total' => $quantidade * $preco,
            'data_operacao' => now(),
        ]);
    }
}
