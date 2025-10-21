<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Review;
use App\Services\AbacatePayService;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    const MINIMUM_REVIEWS_REQUIRED = 100;
    const MINIMUM_RATING_REQUIRED = 4;
    const REQUIRED_HIGH_RATING_PERCENTAGE = 0.8;
    const CERTIFICATE_PRICE = 99.90;

    public function generateCertificatePayment(Request $request, AbacatePayService $abacatePayService)
    {
        $validatedData = $request->validate([
            "reseller_id" => "required|exists:resellers,id",
        ]);

        $resellerId = $validatedData['reseller_id'];

        $reviewsQuery = Review::query()->where('reseller_id', $resellerId);
        $totalReviewsCount = $reviewsQuery->count();

        if ($totalReviewsCount < self::MINIMUM_REVIEWS_REQUIRED) {
            return back()->withErrors(["Mínimo de " . self::MINIMUM_REVIEWS_REQUIRED . " avaliações não alcançado."]);
        }

        $highRatedReviewsCount = $reviewsQuery->clone()->where('rating', '>=', self::MINIMUM_RATING_REQUIRED)->count();
        $hasRequiredPercentage = ($highRatedReviewsCount / $totalReviewsCount) >= self::REQUIRED_HIGH_RATING_PERCENTAGE;

        if (!$hasRequiredPercentage) {
            return back()->withErrors(["A revendedora não possui 80% de avaliações com " . self::MINIMUM_RATING_REQUIRED . " estrelas ou mais."]);
        }

        $certificate = Certificate::create([
            'reseller_id' => $resellerId,
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

        $certificate->update([
            'payment_provider_id' => $pixCharge['data']['id'],
            'pix_qr_code' => $pixCharge['data']['brCodeBase64'],
            'pix_emv' => $pixCharge['data']['brCode'],
        ]);

        return view('certificates.payment', [
            'qrCode' => $certificate->pix_qr_code,
            'emv' => $certificate->pix_emv,
        ]);
    }


}
