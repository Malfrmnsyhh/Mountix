<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\GunungController;
use App\Http\Controllers\Api\V1\JalurController;
use App\Http\Controllers\Api\V1\BookingController;
use App\Http\Controllers\Api\V1\PaymentController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();
  return response()->json(['message' => 'Email sukses diverifikasi.']);
})->middleware(['auth:api', 'signed'])->name('verification.verify');

Route::prefix('v1')->name('api.v1.')->group(function () {
  // Auth Endpoints
  Route::group(['prefix' => 'auth'], function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('reset-password', [AuthController::class, 'resetPassword']);

    Route::middleware('auth:api')->group(function () {
      Route::post('logout', [AuthController::class, 'logout']);
      Route::post('refresh', [AuthController::class, 'refresh']);
      Route::get('me', [AuthController::class, 'me']);
    });
  });

  // Public API Endpoints (Bisa diakses tanpa login)
  Route::apiResource('gunung', GunungController::class)->only(['index', 'show']);
  Route::apiResource('gunung.jalur', JalurController::class)->only(['index', 'show']);

  // Protected API Endpoints (User yang sudah login)
  Route::middleware(['auth:api'])->group(function () {
    // Transaksi Booking
    Route::apiResource('booking', BookingController::class);

    // Payment & Ticket
    Route::post('booking/{booking}/payment', [PaymentController::class, 'store']);
    Route::get('booking/{booking}/ticket', [BookingController::class, 'ticket']);

    Route::get('user/profile', function () {
      return response()->json(['data' => auth('api')->user()]);
    });
  });

  // Protected API Endpoints (Hanya untuk Admin)
  Route::middleware(['auth:api', \App\Http\Middleware\RoleMiddleware::class . ':admin'])->prefix('admin')->group(function () {
    Route::apiResource('gunung', GunungController::class)->except(['index', 'show']);
    Route::apiResource('jalur', JalurController::class)->except(['index', 'show']);

    // Verifikasi Pembayaran oleh Admin
    Route::post('payment/{payment}/verify', [PaymentController::class, 'verify']);
  });
});