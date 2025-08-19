<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/login', function () {
    return view('login');
})->name("login");

Route::get('/user', function () {
    return view('user');
});


Route::post('/user', [UserController::class, 'create'])->name("user.register");
Route::post('/login', [UserController::class, 'authenticate'])->name("user.login");
