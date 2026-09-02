<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

// String-based reference for the User Controller
Route::get('/users', 'App\Http\Controllers\UserController@index')->name('users.index');
Route::get('/users/{id}/edit', 'App\Http\Controllers\UserController@edit')->name('users.edit');
Route::put('/users/{id}', 'App\Http\Controllers\UserController@update')->name('users.update');
Route::delete('/users/{id}', 'App\Http\Controllers\UserController@destroy')->name('users.destroy');

Route::get('/categories', 'App\Http\Controllers\CategoryController@index')->name('categories.index');
Route::post('/categories', 'App\Http\Controllers\CategoryController@store')->name('categories.store');
Route::get('/categories/{id}/edit', 'App\Http\Controllers\CategoryController@edit')->name('categories.edit');
Route::put('/categories/{id}', 'App\Http\Controllers\CategoryController@update')->name('categories.update');
Route::delete('/categories/{id}', 'App\Http\Controllers\CategoryController@destroy')->name('categories.destroy');

Route::get('/products', 'App\Http\Controllers\ProductController@index')->name('products.index');
Route::get('/products/create', 'App\Http\Controllers\ProductController@create')->name('products.create');
Route::post('/products', 'App\Http\Controllers\ProductController@store')->name('products.store');
Route::get('/products/{id}/edit', 'App\Http\Controllers\ProductController@edit')->name('products.edit');
Route::put('/products/{id}', 'App\Http\Controllers\ProductController@update')->name('products.update');
Route::delete('/products/{id}', 'App\Http\Controllers\ProductController@destroy')->name('products.destroy');

Route::get('/orders', 'App\Http\Controllers\OrderController@index')->name('orders.index');
Route::get('/orders/create', 'App\Http\Controllers\OrderController@create')->name('orders.create');
Route::post('/orders', 'App\Http\Controllers\OrderController@store')->name('orders.store');
Route::get('/orders/{id}/edit', 'App\Http\Controllers\OrderController@edit')->name('orders.edit');
Route::put('/orders/{id}', 'App\Http\Controllers\OrderController@update')->name('orders.update');
Route::delete('/orders/{id}', 'App\Http\Controllers\OrderController@destroy')->name('orders.destroy');
