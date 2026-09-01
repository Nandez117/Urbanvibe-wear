<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// String-based reference para el Controlador de Usuarios
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
