<?php

use App\Http\Controllers\ResellerController;
use Illuminate\Support\Facades\Route;

// This single line creates all the necessary routes for the Reseller CRUD:
// GET /resellers - index
// GET /resellers/create - create
// POST /resellers - store
// GET /resellers/{reseller} - show
// GET /resellers/{reseller}/edit - edit
// PUT/PATCH /resellers/{reseller} - update
// DELETE /resellers/{reseller} - destroy
Route::resource("resellers", ResellerController::class);
Route::get("/payment", function () {
    return view("resellers.payment");
})->name("payment");
// User must be authenticated to submit ratings
Route::middleware("auth")->group(function () {
    Route::post("reseller-ratings", [
        ResellerController::class,
        "storeRating",
    ])->name("reseller-ratings.store");
});
