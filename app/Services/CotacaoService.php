<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;


class CotacaoService
{
    protected string $token;
    public function __construct()
    {
        $this->token = config('services.brapi.token');
    }
    public function buscarCotacao(string $acao): array
    {
        $url = "https://brapi.dev/api/quote/{$acao}?token={$this->token}";
        $response = Http::get($url);

        if ($response->failed()) {
            return ['error' => 'Não foi possível buscar a cotação. Tente novamente mais tarde.'];
        }

        $data = $response->json()['results'][0] ?? null;

        if (!$data) {
            return ['error' => 'Não foi possível encontrar a cotação para a ação informada, confira o código.'];
        }
        if (!isset($data['longName'], $data['regularMarketPrice'])) {
            return ['error' => 'O código informado é inválido.'];
        }

        return [
            'nome' => $data['longName'],
            'preco' => $data['regularMarketPrice'],
        ];
    }
}
