<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CategoryShow;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Passwords\Confirm;
use App\Livewire\Auth\Passwords\Email;
use App\Livewire\Auth\Passwords\Reset;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\Verify;
use App\Livewire\ProductShow;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public Routes

Route::get('/', \App\Livewire\HomePage::class)->name('home');

// Auth Routes (Guest Only)
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('password/reset', Email::class)->name('password.request');
    Route::get('password/reset/{token}', Reset::class)->name('password.reset');
});

// Auth Routes (Logged-in Users Only)
Route::middleware('auth')->group(function () {
    Route::get('email/verify', Verify::class)->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::get('password/confirm', Confirm::class)->name('password.confirm');
    Route::post('logout', LogoutController::class)->name('logout');
});


// Product Routes
Route::get('/product', \App\Livewire\ProductsIndex::class)->name('products.index');
 Route::get('/products/{product}', ProductShow::class)->name('products.show');

// Product Routes
// Route::get('/product', [ProductController::class, 'index'])->name('products.index');
 //Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Category Routes
Route::get('/categories/{category}', CategoryShow::class)->name('categories.show');

// Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::get('/checkout/success', [CheckoutController::class, 'success'])
    ->name('checkout.success');

Route::middleware('auth')->get('/orders', \App\Livewire\Orders::class)->name('orders.index');
Route::middleware('auth')->get('/orders/{order}', \App\Livewire\OrderShow::class)->name('orders.show');

// PayPal Routes
Route::get('/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
Route::get('/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('checkout.paypal.cancel');

Route::middleware('auth')->get('/profile', \App\Livewire\Profile::class)->name('profile');
// Optional default auth routes (if you're still using Laravel UI)
Auth::routes();


