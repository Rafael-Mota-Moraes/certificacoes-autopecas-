<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class AbacatePayService
{
    private PendingRequest $client;

    public function __construct()
    {
        $apiUrl = config('services.abacatepay.url');
        $apiKey = config('services.abacatepay.key');

        if (!$apiUrl || !$apiKey) {
            throw new \InvalidArgumentException('A URL e a Chave da API do Abacate Pay devem ser configuradas.');
        }

        $this->client = Http::withToken($apiKey)
            ->baseUrl($apiUrl)
            ->acceptJson()
            ->throw();
    }


    public function createPixCharge(float $amount, array $metadata = []): array
    {
        $response = $this->client->post("pixQrCode/create", [
            'amount' => $amount,
            'metadata' => $metadata,
        ]);

        return $response->json();
    }
}