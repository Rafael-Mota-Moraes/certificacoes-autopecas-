<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Reseller;

trait ChecksCertificateEligibility
{
    public const MINIMUM_REVIEWS_REQUIRED = 100;
    public const MINIMUM_RATING_REQUIRED = 4;
    public const REQUIRED_HIGH_RATING_PERCENTAGE = 0.8;


    protected function checkEligibility(Reseller $reseller): array
    {
        $reviewsQuery = $reseller->reviews();
        $totalReviewsCount = $reviewsQuery->count();
        $meetsReviews = $totalReviewsCount >= self::MINIMUM_REVIEWS_REQUIRED;

        $highRatedReviewsCount = $reviewsQuery->clone()
            ->where('rating', '>=', self::MINIMUM_RATING_REQUIRED)
            ->count();

        $positivePercentage = ($totalReviewsCount > 0) ? ($highRatedReviewsCount / $totalReviewsCount) : 0;
        $meetsPercentage = $positivePercentage >= self::REQUIRED_HIGH_RATING_PERCENTAGE;

        return [
            'meetsReviews' => $meetsReviews,
            'meetsPercentage' => $meetsPercentage,
            'isEligible' => $meetsReviews && $meetsPercentage,
            'totalReviews' => $totalReviewsCount,
            'positivePercentage' => $positivePercentage,
        ];
    }
}