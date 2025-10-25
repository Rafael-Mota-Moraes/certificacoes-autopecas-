<?php


use App\Http\Controllers\Webhook\AbacatePayWebhookController;
use Illuminate\Support\Facades\Route;

Route::post('/webhooks/abacatepay', [AbacatePayWebhookController::class, 'handle']);
