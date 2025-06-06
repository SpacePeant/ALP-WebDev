<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;

Route::post('/midtrans/webhook', [CheckoutController::class, 'handleMidtransWebhook']);
