<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\PaymentController; // <-- 1. Import PaymentController Anda

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * 2. Rute untuk Webhook Midtrans
 * -------------------------------------------------------------------------
 * Ini adalah rute yang akan Anda masukkan ke dashboard Midtrans.
 * Midtrans akan mengirim notifikasi pembayaran ke URL ini.
 * Kita menggunakan metode POST karena Midtrans mengirim data via POST.
 */
// Route::post('/api/midtrans/webhook', [PaymentController::class, 'handleNotification']);
