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

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('gunung', \App\Http\Controllers\Admin\AdminGunungController::class);
    Route::resource('jalur', \App\Http\Controllers\Admin\AdminJalurController::class);
    
    Route::resource('booking', \App\Http\Controllers\Admin\AdminBookingController::class)->only(['index', 'show', 'update']);
    Route::resource('payment', \App\Http\Controllers\Admin\AdminPaymentController::class)->only(['index', 'show']);
    Route::post('payment/{payment}/verify', [\App\Http\Controllers\Admin\AdminPaymentController::class, 'verify'])->name('payment.verify');
    Route::resource('eticket', \App\Http\Controllers\Admin\AdminETicketController::class)->only(['index', 'show']);
    Route::resource('users', \App\Http\Controllers\Admin\AdminUserController::class)->only(['index', 'show']);
});
