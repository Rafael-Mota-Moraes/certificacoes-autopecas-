<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Reseller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request): array|null
    {
        $validatedData = $request->validate(["reseller_id" => "required|integer|exists:resellers,id"]);

        $reseller_id = $validatedData["reseller_id"];

        return Reseller::with('reviews')->find($reseller_id);
    }
}
