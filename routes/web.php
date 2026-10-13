<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PaymentController::class, 'index'])->name('payment.index');
Route::post('/pay', [PaymentController::class, 'store'])->name('payment.store');
Route::get('/payment/{externalId}', [PaymentController::class, 'result'])->name('payment.result');
