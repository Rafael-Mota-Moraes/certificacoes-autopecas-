<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class AbacatePayWebhookController extends Controller
{
    public function handle(Request $request): \Illuminate\Http\JsonResponse
    {
        $payload = $request->all();
        Log::debug('Webhook AbacatePay Recebido:', $payload);

        if (isset($payload['event']) && $payload['event'] === 'billing.paid') {
            $certificateId = $payload['data']['pixQrCode']['metadata']['certificate_id'] ?? null;

            Log::debug("Certificate ID extraído: " . ($certificateId ?? 'NULO'));

            if (!$certificateId) {
                Log::warning('Webhook AbacatePay recebido sem certificate_id nos metadados.');
                return response()->json(['status' => 'error', 'message' => 'Metadata missing']);
            }

            $certificate = Certificate::find($certificateId);

            if (!$certificate) {
                Log::error("Certificado #{$certificateId} NÃO ENCONTRADO no banco.");
                return response()->json(['status' => 'error', 'message' => 'Certificate not found']);
            }

            Log::debug("Certificado #{$certificateId} encontrado. Status atual: {$certificate->status}");

            if ($certificate->status === 'pending_payment') {
                $certificate->update(['status' => 'paid']);
                Log::info("Certificado #{$certificateId} ATUALIZADO para 'paid'.");
            } else {
                Log::info("Certificado #{$certificateId} já estava com status '{$certificate->status}'. Ignorando.");
            }
        }

        return response()->json(['status' => 'received'], Response::HTTP_OK);
    }
}
