<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Reseller;
use App\Models\Review;
use App\Services\AbacatePayService;
use Carbon\Carbon;

class CertificateController extends Controller
{
    const MINIMUM_REVIEWS_REQUIRED = 100;
    const MINIMUM_RATING_REQUIRED = 4;
    const REQUIRED_HIGH_RATING_PERCENTAGE = 0.8;
    const CERTIFICATE_PRICE = 9990;

    public function generateCertificatePayment(Reseller $reseller, AbacatePayService $abacatePayService)
    {
        $reviewsQuery = Review::query()->where('reseller_id', $reseller->id);
        $totalReviewsCount = $reviewsQuery->count();

        if ($totalReviewsCount < self::MINIMUM_REVIEWS_REQUIRED) {
            return back()->withErrors(["Mínimo de " . self::MINIMUM_REVIEWS_REQUIRED . " avaliações não alcançado."]);
        }

        $highRatedReviewsCount = $reviewsQuery->clone()->where('rating', '>=', self::MINIMUM_RATING_REQUIRED)->count();

        if ($totalReviewsCount === 0) {
            return back()->withErrors(["A revendedora não possui avaliações."]);
        }

        $hasRequiredPercentage = ($highRatedReviewsCount / $totalReviewsCount) >= self::REQUIRED_HIGH_RATING_PERCENTAGE;

        if (!$hasRequiredPercentage) {
            return back()->withErrors(["A revendedora não possui 80% de avaliações com " . self::MINIMUM_RATING_REQUIRED . " estrelas ou mais."]);
        }

        $existingPaid = Certificate::where('reseller_id', $reseller->id)
            ->where('status', 'paid')
            ->first();

        if ($existingPaid)
            return back()->withErrors(["Certificado já foi pago anteriormente."]);

        $existingPending = Certificate::where('reseller_id', $reseller->id)
            ->where('status', 'pending_payment')
            ->orderBy('created_at', 'desc')
            ->first();

        if ($existingPending) {


            $expiresAt = Carbon::parse($existingPending->payment_expires_at);

            if ($expiresAt && $expiresAt->isPast()) {
                $existingPending->delete();
            } else if ($existingPending->pix_qr_code) {
                return view('resellers.payment', [
                    'payment' => $existingPending,
                    'reseller' => $reseller,
                ]);
            } else {
                $existingPending->delete();
            }
        }

        $certificate = Certificate::create([
            'reseller_id' => $reseller->id,
            'amount' => self::CERTIFICATE_PRICE,
            'status' => 'pending_payment',
        ]);

        try {
            $pixCharge = $abacatePayService->createPixCharge(
                $certificate->amount,
                ['certificate_id' => $certificate->id]
            );
        } catch (\Exception $e) {
            $certificate->delete();
            return back()->withErrors(["Não foi possível gerar a cobrança PIX. Tente novamente mais tarde."]);
        }

        $expiresAtRaw = $pixCharge['data']['expires_at'] ?? now()->addMinutes(30);

        $certificate->update([
            'payment_provider_id' => $pixCharge['data']['id'],
            'pix_qr_code' => $pixCharge['data']['brCodeBase64'],
            'pix_emv' => $pixCharge['data']['brCode'],
            'payment_expires_at' => Carbon::parse($expiresAtRaw),
        ]);

        return view('resellers.payment', [
            'payment' => $certificate,
            'reseller' => $reseller,
        ]);
    }
}
