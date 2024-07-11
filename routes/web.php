<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaymentController;

Route::get('/payment-form', [PaymentController::class, 'showForm'])->name('payment.form');
Route::post('/process-payment', [PaymentController::class, 'processPayment'])->name('payment.process');
