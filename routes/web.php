<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
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
    Route::get('/cart',     fn() => view('pages.cart'))->name('cart');
    Route::get('/checkout', fn() => view('pages.checkout'))->name('checkout');
    
    // Rute untuk memproses data checkout dan melihat riwayat pesanan
    Route::post('/checkout', [App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/my-orders', [App\Http\Controllers\CheckoutController::class, 'history'])->name('user.orders');
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
    });

Route::middleware(['auth', 'web.role:ranger'])->prefix('ranger-hub')->name('ranger.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\RangerController::class, 'dashboard'])->name('dashboard');
    Route::post('/tasks/{id}/take', [App\Http\Controllers\RangerController::class, 'takeTask'])->name('tasks.take');
    Route::post('/assignments/{id}/complete', [App\Http\Controllers\RangerController::class, 'completeTask'])->name('tasks.complete');
    Route::put('/profile', [App\Http\Controllers\RangerController::class, 'updateProfile'])->name('profile.update');
});