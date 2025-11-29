<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use App\Models\Comment;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    const TOP_RATED_LIMIT = 8;

    const OTHERS_PER_PAGE = 12;


    public function index(Request $request)
    {
        $search = $request->input('search');

        $allCertifiedResellers = Reseller::with(['certificate', 'address', 'contacts'])
            ->withAvg('reviews', 'rating')
            ->whereHas('certificate', function ($query) {
                $query->where('status', 'paid');
            })
            ->orderByDesc('reviews_avg_rating')
            ->get();

        $topRatedResellers = $allCertifiedResellers->take(self::TOP_RATED_LIMIT);

        $topRatedIds = $topRatedResellers->pluck('id');

        $avgSubQuery = '(select avg("reviews"."rating") from "reviews" where "resellers"."id" = "reviews"."reseller_id")';

        $otherResellersQuery = Reseller::with(['certificate', 'address', 'contacts'])
            ->withAvg('reviews', 'rating');

        if ($search) {
            $otherResellersQuery->where('name', 'like', '%' . $search . '%');
        } else {
            $otherResellersQuery->whereNotIn('id', $topRatedIds);
        }

        $otherResellers = $otherResellersQuery
            ->orderByRaw("{$avgSubQuery} IS NULL ASC")
            ->orderByRaw("{$avgSubQuery} DESC")
            ->orderBy('name', 'asc')
            ->paginate(self::OTHERS_PER_PAGE);

        $comments = Comment::all();

        $resellersForMap = Reseller::with(['address', 'certificate', 'contacts'])
            ->whereHas('address', function ($query) {
                $query->whereNotNull('latitude')->whereNotNull('longitude');
            })
            ->get();

        return view('home', [
            'topRatedResellers' => $topRatedResellers,
            'otherResellers' => $otherResellers,
            'comments' => $comments,
            'resellersForMap' => $resellersForMap,
        ]);
    }
}
