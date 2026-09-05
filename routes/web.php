<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

// String-based reference for the User Controller
Route::get('/users', 'App\Http\Controllers\UserController@index')->name('users.index');
Route::get('/users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('users.edit');
Route::put('/users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update');
Route::delete('/users/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');

Route::get('/register', 'App\Http\Controllers\AuthController@showRegister')->name('register')->middleware('guest');
Route::post('/register', 'App\Http\Controllers\AuthController@register')->name('register.store')->middleware('guest');
Route::get('/login', 'App\Http\Controllers\AuthController@showLogin')->name('login')->middleware('guest');
Route::post('/login', 'App\Http\Controllers\AuthController@login')->name('login.store')->middleware('guest');
Route::post('/logout', 'App\Http\Controllers\AuthController@logout')->name('logout')->middleware('auth');

Route::get('/categories', 'App\Http\Controllers\CategoryController@index')->name('categories.index');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store')->name('categories.store');
Route::get('/categories/{id}/edit', 'App\Http\Controllers\CategoryController@edit')->name('categories.edit');
Route::put('/categories/{id}', 'App\Http\Controllers\CategoryController@update')->name('categories.update');
Route::delete('/categories/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('categories.destroy');

Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('products.create');
Route::post('/products', 'App\Http\Controllers\ProductController@store')->name('products.store');
Route::get('/products/{id}', 'App\Http\Controllers\ProductController@show')->name('products.show');
Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('products.edit');
Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->name('products.update');
Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy')->name('products.destroy');

Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('orders.index');
Route::get('/orders/create', 'App\Http\Controllers\OrderController@create')->name('orders.create');
Route::post('/orders', 'App\Http\Controllers\OrderController@store')->name('orders.store');
Route::get('/orders/{id}/edit', 'App\Http\Controllers\OrderController@edit')->name('orders.edit');
Route::put('/orders/{id}', 'App\Http\Controllers\OrderController@update')->name('orders.update');
Route::delete('/orders/{id}', 'App\Http\Controllers\OrderController@destroy')->name('orders.destroy');
Route::get('/cart', 'App\Http\Controllers\CartController@index')->name('cart.index');
Route::post('/cart/add/{id}', 'App\Http\Controllers\CartController@add')->name('cart.add');
Route::put('/cart/{id}', 'App\Http\Controllers\CartController@update')->name('cart.update');
Route::delete('/cart/{id}', 'App\Http\Controllers\CartController@remove')->name('cart.remove');
Route::post('/cart/checkout', 'App\Http\Controllers\CartController@checkout')->name('cart.checkout')->middleware('auth');
Route::get('/orders/{id}/payments/create', 'App\Http\Controllers\PaymentController@create')->name('payments.create');
Route::post('/orders/{id}/payments', 'App\Http\Controllers\PaymentController@store')->name('payments.store');
Route::get('/payment/success/{id}', 'App\Http\Controllers\PaymentController@success')->name('payment.success');

Route::get('/order-items', 'App\Http\Controllers\OrderItemController@index')->name('order-items.index');
Route::get('/order-items/create', 'App\Http\Controllers\OrderItemController@create')->name('order-items.create');
Route::post('/order-items', 'App\Http\Controllers\OrderItemController@store')->name('order-items.store');
Route::get('/order-items/{id}/edit', 'App\Http\Controllers\OrderItemController@edit')->name('order-items.edit');
Route::put('/order-items/{id}', 'App\Http\Controllers\OrderItemController@update')->name('order-items.update');
Route::delete('/order-items/{id}', 'App\Http\Controllers\OrderItemController@destroy')->name('order-items.destroy');

Route::get('/reviews', 'App\Http\Controllers\ReviewController@index')->name('reviews.index');
Route::get('/reviews/create', 'App\Http\Controllers\ReviewController@create')->name('reviews.create');
Route::post('/reviews', 'App\Http\Controllers\ReviewController@store')->name('reviews.store');
Route::get('/reviews/{id}/edit', 'App\Http\Controllers\ReviewController@edit')->name('reviews.edit');
Route::put('/reviews/{id}', 'App\Http\Controllers\ReviewController@update')->name('reviews.update');
Route::delete('/reviews/{id}', 'App\Http\Controllers\ReviewController@destroy')->name('reviews.destroy');
