<?php

use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

// Otomatis berprefix /api (tanpa CSRF, cocok buat webhook).
Route::get('/balance', [PaymentController::class, 'balance']);
Route::post('/xendit/webhook', [PaymentController::class, 'webhook']);
