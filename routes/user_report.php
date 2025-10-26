<?php

use App\Http\Controllers\UserReportController;
use Illuminate\Support\Facades\Route;

Route::resource("user_report", UserReportController::class);
