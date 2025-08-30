<?php

namespace App\Http\Controllers;

use App\Models\Reseller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $allResellers = Reseller::get();

        $topRatedResellers = $allResellers->take(4);

        $otherResellers = $allResellers->skip(4);

        return view('home', [
            'topRatedResellers' => $topRatedResellers,
            'otherResellers' => $otherResellers,
        ]);
    }
}
