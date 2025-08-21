<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get("/user/register", function () {
    return view("user.register");
});

Route::post('/user', [UserController::class, 'create'])->name("user.register");
Route::post('/auth', [UserController::class, 'authenticate'])->name("user.auth");

Route::middleware('auth')->group(function () {
    Route::get("/user/update", function () {
        return view("user.update");
    });
    Route::patch('/user', [UserController::class, 'update'])->name("user.update");
    Route::patch('/user/toggle', [UserController::class, 'toggle'])->name("user.toggle");
});
