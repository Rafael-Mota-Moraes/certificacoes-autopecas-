<?php

namespace App\Console\Commands;

use App\Services\AbacatePayService;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;

class SimulateAbacatePayPix extends Command
{

    protected $signature = 'simulate:abacatepay-pix {charge_id : O ID da cobrança do AbacatePay a ser simulada}';


    protected $description = 'Simula o pagamento de uma cobrança PIX no AbacatePay para testar webhooks';


    public function handle(AbacatePayService $abacatePayService)
    {
        $chargeId = $this->argument('charge_id');

        $this->info("🚀 Simulando pagamento para a cobrança: {$chargeId}");

        try {
            $response = $abacatePayService->simulatePixPayment($chargeId);

            $this->info("✅ Requisição de simulação enviada com sucesso!");
            $this->line("O AbacatePay agora deve enviar uma notificação para o seu webhook.");

            // ALTERADO: Imprime a resposta de sucesso também
            $this->line("\nResposta completa da API de sucesso:");
            $this->line(json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            return self::SUCCESS;

        } catch (RequestException $e) {
            $this->error("❌ Falha ao simular o pagamento.");
            $this->error("Status Code: " . $e->response->status());

            // NOVO: Bloco para tentar formatar a resposta de erro
            $this->error("Resposta da API:");
            $errorBody = $e->response->body();
            $decodedJson = json_decode($errorBody, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                // Se for um JSON válido, imprime formatado
                $this->line(json_encode($decodedJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            } else {
                // Se não for JSON, imprime o texto puro
                $this->line($errorBody);
            }

            return self::FAILURE;
        } catch (\Exception $e) {
            $this->error("❌ Ocorreu um erro inesperado: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}