<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $resellersForMap = Reseller::with('address')->whereHas('address', function ($query) {
            $query->whereNotNull('latitude')->whereNotNull('longitude');
        })->get();

        return view('home', [
            'topRatedResellers' => Reseller::inRandomOrder()->take(5)->get(),
            'otherResellers' => Reseller::inRandomOrder()->take(8)->get(),
            'resellersForMap' => $resellersForMap,
        ]);
    }
}
