<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get("/user/register", function () {
    return view("user.register");
})->name("register");

Route::get("/user/login", function () {
    return view("user.login");
})->name("login");


Route::post("/user", [UserController::class, "create"])->name("user.register");

Route::post("/auth", [UserController::class, "authenticate"])->name(
    "user.auth",
);


Route::post('/logout', [UserController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get("forgot-password", [
    ForgotPasswordController::class,
    "showLinkRequestForm",
])->name("password.request");

Route::post("forgot-password", [
    ForgotPasswordController::class,
    "sendResetLinkEmail",
])->name("password.email");

Route::get("reset-password/{token}", [
    ResetPasswordController::class,
    "showResetForm",
])->name("password.reset");

Route::post("reset-password", [ResetPasswordController::class, "reset"])->name(
    "password.update",
);

Route::middleware("auth")->group(function () {
    Route::get("/user/update", function () {
        return view("user.update");
    });
    Route::patch("/user", [UserController::class, "update"])->name(
        "user.update",
    );
    Route::patch("/user/toggle", [UserController::class, "toggle"])->name(
        "user.toggle",
    );
    Route::get('/user/profile', function () {
        return view('user.profile');
    });

    Route::patch("/user/profile", [UserController::class, "updateProfilePhoto"])->name("user.updatePhoto");
});
