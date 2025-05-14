<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CategoryShow;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentWebhookController;
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
use App\Livewire\WishlistPage;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/{any}', function () {
    return view('admin');
})->where('any', '.*');



// 🌐 Public Routes
Route::get('/', \App\Livewire\HomePage::class)->name('home');

Route::get('/product', \App\Livewire\ProductsIndex::class)->name('products.index');
Route::get('/products/{product}', ProductShow::class)->name('products.show');

Route::get('/wishlist', WishlistPage::class)->middleware('auth')->name('wishlist');

Route::get('/categories/{category}', CategoryShow::class)->name('categories.show');

// 🛒 Cart Routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{rowId}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{rowId}', [CartController::class, 'destroy'])->name('cart.destroy');

// 👤 Guest-Only Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', Login::class)->name('login');
    Route::get('register', Register::class)->name('register');
    Route::get('password/reset', Email::class)->name('password.request');
    Route::get('password/reset/{token}', Reset::class)->name('password.reset');
});

// 🔐 Authenticated-Only Routes
Route::middleware('auth')->group(function () {
    // Email Verification
    Route::get('email/verify', Verify::class)->middleware('throttle:6,1')->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', EmailVerificationController::class)->middleware('signed')->name('verification.verify');
    Route::get('password/confirm', Confirm::class)->name('password.confirm');
    Route::post('logout', LogoutController::class)->name('logout');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

    // Order Routes
    Route::get('/orders', \App\Livewire\Orders::class)->name('orders.index');
    Route::get('/orders/{order}', \App\Livewire\OrderShow::class)->name('orders.show');

    // Profile
    Route::get('/profile', \App\Livewire\Profile::class)->name('profile');
});

// 💳 Razorpay & PayPal Integration
Route::post('/razorpay/order/create', [CheckoutController::class, 'createRazorpayOrder'])->name('razorpay.order.create');
Route::post('/webhook/razorpay', [CheckoutController::class, 'handleRazorpayWebhook'])->name('razorpay.webhook');

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');
Route::get('/paypal/success', [CheckoutController::class, 'paypalSuccess'])->name('checkout.paypal.success');
Route::get('/paypal/cancel', [CheckoutController::class, 'paypalCancel'])->name('checkout.paypal.cancel');


// Webhook routes - should be exempt from CSRF protection
Route::prefix('webhooks')->group(function () {
    Route::post('stripe', [PaymentWebhookController::class, 'handleStripeWebhook']);
    Route::post('razorpay', [PaymentWebhookController::class, 'handleRazorpayWebhook']);
    Route::post('paypal', [PaymentWebhookController::class, 'handlePaypalWebhook']);
});


// 🧹 Optional: remove if not using Laravel UI
// Auth::routes();
