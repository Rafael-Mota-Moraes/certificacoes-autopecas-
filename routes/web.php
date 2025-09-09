<?php

use App\Http\Controllers\ResellerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

include_once __DIR__ . "/user.php";

// This single line creates all the necessary routes for the Reseller CRUD:
// GET /resellers - index
// GET /resellers/create - create
// POST /resellers - store
// GET /resellers/{reseller} - show
// GET /resellers/{reseller}/edit - edit
// PUT/PATCH /resellers/{reseller} - update
// DELETE /resellers/{reseller} - destroy
Route::resource("resellers", ResellerController::class);
