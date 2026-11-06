<?php

// Juan Manuel Hernandez Martelo

use App\Http\Controllers\Api\ProductApiController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::get('/products', [ProductApiController::class, 'index'])->name('api.v1.products.index');
    Route::get('/products/{id}', [ProductApiController::class, 'show'])->name('api.v1.products.show');
});

Route::get('/products', [ProductApiController::class, 'index'])->name('api.products.index');
Route::get('/products/{id}', [ProductApiController::class, 'show'])->name('api.products.show');
