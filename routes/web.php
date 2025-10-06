<?php

use App\Http\Controllers\ResellerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');

require_once __DIR__ . "/user.php";
require_once __DIR__ . "/resellers.php";