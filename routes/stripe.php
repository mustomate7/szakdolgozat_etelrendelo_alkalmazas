<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::post('/stripe/checkout', [OrderController::class, 'saveOrder'])->name('stripe.checkout');
    Route::get('/success', [OrderController::class, 'success'])->name('stripe.success');
    Route::get('/cancel', [OrderController::class, 'cancel'])->name('stripe.cancel');
});
Route::post('/stripe/webhook', [OrderController::class, 'webhook'])->name('stripe.webhook');
