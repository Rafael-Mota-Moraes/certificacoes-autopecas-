<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use App\Models\Comment;
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

        $topRatedResellers = Reseller::with('reviews')
            ->withAvg('reviews', 'rating')
            ->whereHas('certificate') 
            ->where('active', true)
            ->orderByDesc('reviews_avg_rating')
            ->take(20)
            ->get();

        $topRatedResellerIds = $topRatedResellers->pluck('id');

        $otherResellers = Reseller::with('reviews')
            ->withAvg('reviews', 'rating')
            ->whereNotIn('id', $topRatedResellerIds) 
            ->orderByDesc('reviews_avg_rating') 
            ->paginate(16);

        $comments = Comment::all();

        return view('home', [
            'topRatedResellers' => $topRatedResellers,
            'otherResellers' => $otherResellers,
            'resellersForMap' => $resellersForMap,
            'comments' => $comments
        ]);
    }
}
