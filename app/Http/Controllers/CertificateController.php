<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class CertificateController extends Controller
{
    const MINIMUM_REVIEWS_REQUIRED = 100;
    const MINIMUM_RATING_REQUIRED = 4;
    const REQUIRED_HIGH_RATING_PERCENTAGE = 0.8;

    public function isResellerAbleToRequestCertificate(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            "reseller_id" => "required|exists:resellers,id",
        ]);

        $reviewsQuery = Review::query()->where('reseller_id', $validatedData['reseller_id']);

        $totalReviewsCount = $reviewsQuery->count();

        if ($totalReviewsCount < self::MINIMUM_REVIEWS_REQUIRED) {
            return redirect()->back()->withErrors([
                "Mínimo de " . self::MINIMUM_REVIEWS_REQUIRED . " avaliações não alcançado."
            ]);
        }

        $highRatedReviewsCount = $reviewsQuery->clone()
            ->where('rating', '>=', self::MINIMUM_RATING_REQUIRED)
            ->count();

        $hasRequiredPercentage = ($highRatedReviewsCount / $totalReviewsCount) >= self::REQUIRED_HIGH_RATING_PERCENTAGE;

        if (!$hasRequiredPercentage) {
            return redirect()->back()->withErrors([
                "A revendedora não possui 80% de avaliações com " . self::MINIMUM_RATING_REQUIRED . " estrelas ou mais."
            ]);
        }

        return redirect()->with("success", "Revendedora apta a emitir certificado");
    }


    public
}
