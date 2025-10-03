<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CustomOrderController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/products', [ProductController::class, 'index']);
    Route::post('/products/{product}/order', [OrderController::class, 'store']);

    Route::get('/profile', [UserController::class, 'profile']);
    Route::get('/orders', [OrderController::class, 'index']);
    Route::get('/orders/total', [OrderController::class, 'total']);

    Route::get('/custom-orders', [CustomOrderController::class, 'index']);
    Route::post('/custom-orders', [CustomOrderController::class, 'store']);
    Route::get('/custom-orders/{id}', [CustomOrderController::class, 'show']);
});
