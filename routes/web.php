<?php

// Esteban Alvarez Garcia, Juan Manuel Hernandez Martelo, Yan Frank Ríos López

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PartnerProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/lang/{locale}', [LocaleController::class, 'switch'])->name('lang.switch');

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register.index');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login.index');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Compatibility aliases
    Route::get('/login-alias', [AuthController::class, 'showLogin'])->name('login');
    Route::get('/register-alias', [AuthController::class, 'showRegister']);
    Route::get('/auth/login', [AuthController::class, 'showLogin'])->name('auth.showLogin');
    Route::post('/auth/login', [AuthController::class, 'login'])->name('auth.login');
    Route::get('/auth/register', [AuthController::class, 'showRegister'])->name('auth.showRegister');
    Route::post('/auth/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout.store')->middleware('auth');
Route::post('/logout-alias', [AuthController::class, 'logout'])->name('auth.logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::get('/profile/edit', [UserController::class, 'edit'])->name('user.edit');
    Route::put('/profile', [UserController::class, 'update'])->name('user.update');
    // Aliases
    Route::get('/profile-alias', [UserController::class, 'profile'])->name('profile.index');
});

Route::get('/products', [ProductController::class, 'index'])->name('product.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('product.show');

Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
Route::get('/partner-products', [PartnerProductController::class, 'index'])->name('partner.index');
Route::get('/partner-products/{id}', [PartnerProductController::class, 'show'])->name('partner.show');
Route::post('/partner-products/{id}/cart', [PartnerProductController::class, 'addToCart'])->name('partner.cart.add');
Route::get('/productos-aliados', [PartnerProductController::class, 'index'])->name('partner.aliados');
Route::get('/productos-aliados/{id}', [PartnerProductController::class, 'show'])->name('partner.aliados.show');
Route::post('/productos-aliados/{id}/cart', [PartnerProductController::class, 'addToCart'])->name('partner.aliados.cart.add');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout')->middleware('auth');

Route::get('/orders', [OrderController::class, 'index'])->name('order.index');

Route::middleware('auth')->group(function () {
    Route::get('/orders/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('order.store');
    Route::get('/orders/{id}/edit', [OrderController::class, 'edit'])->name('order.edit');
    Route::put('/orders/{id}', [OrderController::class, 'update'])->name('order.update');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('order.destroy');
    Route::get('/orders/{id}/invoice', [OrderController::class, 'downloadInvoice'])->name('order.invoice');

    Route::get('/orders/{id}/payments/create', [PaymentController::class, 'create'])->name('payment.create');
    Route::post('/orders/{id}/payments', [PaymentController::class, 'store'])->name('payment.store');
    Route::get('/payment/success/{id}', [PaymentController::class, 'success'])->name('payment.success');

    Route::get('/order-items', [OrderItemController::class, 'index'])->name('orderItem.index');
    Route::get('/order-items/create', [OrderItemController::class, 'create'])->name('orderItem.create');
    Route::post('/order-items', [OrderItemController::class, 'store'])->name('orderItem.store');
    Route::get('/order-items/{id}/edit', [OrderItemController::class, 'edit'])->name('orderItem.edit');
    Route::put('/order-items/{id}', [OrderItemController::class, 'update'])->name('orderItem.update');
    Route::delete('/order-items/{id}', [OrderItemController::class, 'destroy'])->name('orderItem.destroy');

    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/checkout', [WishlistController::class, 'checkout'])->name('wishlist.checkout');
    Route::post('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/reviews', [ReviewController::class, 'index'])->name('review.index');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('review.store');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('review.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('review.destroy');
});

Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('user.index');
    Route::get('/users/{id}/edit', [AdminUserController::class, 'edit'])->name('user.edit');
    Route::put('/users/{id}', [AdminUserController::class, 'update'])->name('user.update');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('user.destroy');

    Route::get('/categories', [AdminCategoryController::class, 'index'])->name('category.index');
    Route::post('/categories', [AdminCategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{id}/edit', [AdminCategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categories/{id}', [AdminCategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{id}', [AdminCategoryController::class, 'destroy'])->name('category.destroy');

    Route::get('/products', [AdminProductController::class, 'index'])->name('product.index');
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('product.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('product.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('product.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('product.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('product.destroy');
});
