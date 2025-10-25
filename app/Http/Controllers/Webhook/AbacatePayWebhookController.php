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

        if (isset($payload['event']) && $payload['event'] === 'pix.paid') {

            $certificateId = $payload['data']['metadata']['certificate_id'] ?? null;

            if (!$certificateId) {
                Log::warning('Webhook AbacatePay recebido sem certificate_id nos metadados.');
                return response()->json(['status' => 'error', 'message' => 'Metadata missing']);
            }

            $certificate = Certificate::find($certificateId);

            if ($certificate && $certificate->status === 'pending_payment') {
                $certificate->update(['status' => 'paid']);

                Log::info("Certificado #{$certificate->id} pago com sucesso via Webhook.");
            }
        }

        return response()->json(['status' => 'received'], Response::HTTP_OK);
    }
}