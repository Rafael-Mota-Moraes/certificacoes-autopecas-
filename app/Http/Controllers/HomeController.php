<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $resellersForMap = Reseller::with('address')
            ->withAvg('reviews', 'rating')
            ->whereHas('address', function ($query) {
                $query->whereNotNull('latitude')->whereNotNull('longitude');
            })->get();
        
        $topRatedReseller = Reseller::with('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->take(5)
            ->get();

        $otherResellers = Reseller::with('reviews')
            ->withAvg('reviews', 'rating')
            ->orderByDesc('reviews_avg_rating')
            ->offset(5)
            ->get();

        return view('home', [
            'topRatedResellers' => $topRatedReseller,
            'otherResellers' => $otherResellers,
            'resellersForMap' => $resellersForMap,
        ]);
    }
}
