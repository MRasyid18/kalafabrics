<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Admin\DashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes - KalaFabrics
|--------------------------------------------------------------------------
*/

/* ══════════════════════════════════════
   HALAMAN PUBLIK (semua bisa akses)
══════════════════════════════════════ */
Route::get('/',          fn() => view('pages.home'))->name('home');
Route::get('/catalog',   fn() => view('pages.catalog'))->name('catalog');
Route::get('/impact',    fn() => view('pages.impact'))->name('impact');
Route::get('/education', fn() => view('pages.education'))->name('education');
Route::get('/ranger',    fn() => view('pages.ranger'))->name('ranger');
Route::get('/contact',   fn() => view('pages.contact'))->name('contact');

/* ══════════════════════════════════════
   AUTH ROUTES
══════════════════════════════════════ */
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register'])->name('register.post');
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
    
    // PERBAIKI BARIS INI: Gunakan 'user.orders' sebagai namanya
    Route::get('/my-orders', [CheckoutController::class, 'history'])->name('user.orders');
});

/* ══════════════════════════════════════
   HALAMAN ADMIN
══════════════════════════════════════ */
Route::prefix('admin')
    ->middleware(['auth', 'web.role:admin'])
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
        Route::resource('/products', App\Http\Controllers\Admin\ProductController::class);
        Route::resource('/orders', App\Http\Controllers\Admin\OrderController::class);
        
        // Rute Manajemen Limbah B2B
        Route::get('/waste', [App\Http\Controllers\Admin\WasteDonationController::class, 'index'])->name('waste.index');
        Route::get('/waste/{id}', [App\Http\Controllers\Admin\WasteDonationController::class, 'show'])->name('waste.show');
        Route::put('/waste/{id}/status', [App\Http\Controllers\Admin\WasteDonationController::class, 'updateStatus'])->name('waste.update_status');
        
        Route::resource('/users', \App\Http\Controllers\Admin\UserController::class);
        Route::resource('/rangers', \App\Http\Controllers\Admin\AdminRangerController::class);
    });

/* ══════════════════════════════════════
   HALAMAN RANGER
══════════════════════════════════════ */
Route::middleware(['auth', 'web.role:ranger'])->prefix('ranger-hub')->name('ranger.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\RangerController::class, 'dashboard'])->name('dashboard');
    Route::get('/waste/{id}/validate', [App\Http\Controllers\RangerController::class, 'showValidateWaste'])->name('waste.validate');
    Route::post('/waste/{id}/validate', [App\Http\Controllers\RangerController::class, 'processValidateWaste'])->name('waste.process');
    Route::post('/tasks/{id}/take', [App\Http\Controllers\RangerController::class, 'takeTask'])->name('tasks.take');
    Route::post('/assignments/{id}/complete', [App\Http\Controllers\RangerController::class, 'completeTask'])->name('tasks.complete');
    Route::put('/profile', [App\Http\Controllers\RangerController::class, 'updateProfile'])->name('profile.update');
});

/* ══════════════════════════════════════
   HALAMAN B2B
══════════════════════════════════════ */
Route::middleware(['auth', 'web.role:b2b'])->prefix('b2b')->name('b2b.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\B2bController::class, 'dashboard'])->name('dashboard');
    // Manajemen Limbah
    Route::get('/donasi/baru', [\App\Http\Controllers\B2bController::class, 'createDonation'])->name('donations.create');
    Route::post('/donasi', [\App\Http\Controllers\B2bController::class, 'storeDonation'])->name('donations.store');
    Route::get('/riwayat', [\App\Http\Controllers\B2bController::class, 'history'])->name('donations.history');
    
    // Tracking & Poin Ledger
    Route::get('/donasi/{id}/lacak', [\App\Http\Controllers\B2bController::class, 'trackDonation'])->name('donations.track');
    Route::get('/poin', [\App\Http\Controllers\B2bController::class, 'pointsLedger'])->name('points.index');
});