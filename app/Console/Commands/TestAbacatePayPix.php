<?php

namespace App\Console\Commands;

use App\Services\AbacatePayService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

class TestAbacatePayPix extends Command
{

    protected $signature = 'test:abacatepay-pix {amount=1.0}';


    protected $description = 'Cria uma cobrança Pix de teste usando o AbacatePayService';


    public function handle(AbacatePayService $abacatePayService)
    {
        $this->info("Iniciando teste de criação de cobrança Pix com AbacatePay...");

        $amount = (float) $this->argument('amount');
        $metadata = [
            'order_id' => 'cmd-test-' . uniqid(),
            'user' => 'console-test',
        ];

        try {
            $this->line("Enviando requisição para criar cobrança no valor de R$ " . number_format($amount, 2, ',', '.'));

            $response = $abacatePayService->createPixCharge($amount, $metadata);

            $this->info("✅ Cobrança criada com sucesso!");
            $this->line("ID da Transação: " . ($response['id'] ?? 'N/A'));
            $this->line("Status: " . ($response['status'] ?? 'N/A'));
            $this->line("QR Code (EMV): " . ($response['pix_emv'] ?? 'N/A'));

            $this->line("\nResposta completa da API:");
            $this->line(json_encode($response, JSON_PRETTY_PRINT));

            return self::SUCCESS;

        } catch (RequestException $e) {
            $this->error("❌ Falha na requisição à API do AbacatePay.");
            $this->error("Status Code: " . $e->response->status());
            $this->error("Resposta da API: " . $e->response->body());
            return self::FAILURE;

        } catch (\Exception $e) {
            $this->error("❌ Ocorreu um erro inesperado: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}