<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class CotacaoService
{
    protected string $token;
    public function __construct(){
        $this->token = config('services.brapi.token');
    }
    public function buscarCotacao(string $acao): array
    {
         $url = "https://brapi.dev/api/quote/{$acao}?token={$this->token}";
         $response = Http::get($url);

        if ($response->failed()) {
            throw new \Exception("Erro ao buscar cotação");
        }

        $data = $response->json()['results'][0] ?? null;

        if (!$data) {
            throw new \Exception("Ação não encontrada");
        }

        return [
            'nome' => $data['longName'],
            'preco' => $data['regularMarketPrice'],
        ];
    }
}