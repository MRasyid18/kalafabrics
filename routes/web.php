<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\RangerController;
use App\Http\Controllers\B2bController;

/*
|--------------------------------------------------------------------------
| Web Routes - KalaFabrics
|--------------------------------------------------------------------------
*/

/* ══════════════════════════════════════
   HALAMAN PUBLIK (semua bisa akses)
══════════════════════════════════════ */
Route::get('/', fn() => view('pages.home'))->name('home');
Route::get('/catalog', fn() => view('pages.catalog'))->name('catalog');
Route::get('/impact', fn() => view('pages.impact'))->name('impact');
Route::get('/education', fn() => view('pages.education'))->name('education');
Route::get('/ranger', fn() => view('pages.ranger'))->name('ranger');
Route::get('/contact', fn() => view('pages.contact'))->name('contact');

/* ══════════════════════════════════════
   AUTH ROUTES
══════════════════════════════════════ */
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/* ══════════════════════════════════════
   HALAMAN PENGGUNA (harus login)
══════════════════════════════════════ */
Route::middleware(['auth', 'web.role:b2c,b2b,ranger'])->group(function () {
    Route::get('/cart', fn() => view('pages.cart'))->name('cart');
    Route::get('/checkout', fn() => view('pages.checkout'))->name('checkout');
    
    // Rute untuk memproses data checkout dan melihat riwayat pesanan
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/my-orders', [CheckoutController::class, 'history'])->name('user.orders');
});

/* ══════════════════════════════════════
   HALAMAN ADMIN
══════════════════════════════════════ */
Route::prefix('admin')
    ->middleware(['auth', 'web.role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', ProductController::class);
        Route::resource('/orders', OrderController::class);
    });

/* ══════════════════════════════════════
   HALAMAN RANGER
══════════════════════════════════════ */
Route::middleware(['auth', 'web.role:ranger'])->prefix('ranger-hub')->name('ranger.')->group(function () {
    Route::get('/dashboard', [RangerController::class, 'dashboard'])->name('dashboard');
    Route::post('/tasks/{id}/take', [RangerController::class, 'takeTask'])->name('tasks.take');
    Route::post('/assignments/{id}/complete', [RangerController::class, 'completeTask'])->name('tasks.complete');
    Route::put('/profile', [RangerController::class, 'updateProfile'])->name('profile.update');
});

/* ══════════════════════════════════════
   HALAMAN B2B
══════════════════════════════════════ */
Route::middleware(['auth', 'web.role:b2b'])->prefix('b2b')->name('b2b.')->group(function () {
    Route::get('/dashboard', [B2bController::class, 'dashboard'])->name('dashboard');
    
    // Manajemen Limbah
    Route::get('/donasi/baru', [B2bController::class, 'createDonation'])->name('donations.create');
    Route::post('/donasi', [B2bController::class, 'storeDonation'])->name('donations.store');
    Route::get('/riwayat', [B2bController::class, 'history'])->name('donations.history');
});