<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/login', function () {
    return view('login');
})->name("login");

include_once __DIR__ . "/user.php";
