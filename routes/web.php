<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GunungController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ETicketController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gunung', [GunungController::class, 'index'])->name('gunung.index');
Route::get('/gunung/{id}', [GunungController::class, 'show'])->name('gunung.show');

// Auth Routes (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::get('/forgot-password', [AuthController::class, 'forgotForm'])->name('password.request');
});

// Protected Routes (Simulated with simple guest check for now, 
// as real auth will be handled via JWT in JS)
Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::get('/booking/{id}', [BookingController::class, 'show'])->name('booking.show');

Route::get('/payment/{booking_id}', [PaymentController::class, 'create'])->name('payment.create');
Route::get('/payment/{booking_id}/success', [PaymentController::class, 'success'])->name('payment.success');

Route::get('/eticket/{booking_id}', [ETicketController::class, 'show'])->name('eticket.show');
