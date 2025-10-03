<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CustomOrderDashboardController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderManagementController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// Fallback route for serving storage files if symlink doesn't work
Route::get('/storage/{path}', function ($path) {
    $file = storage_path('app/public/' . $path);

    if (!file_exists($file)) {
        abort(404);
    }

    return response()->file($file);
})->where('path', '.*');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [UserManagementController::class, 'show'])->name('users.show');

    Route::get('/products', [ProductManagementController::class, 'index'])->name('products.index');
    Route::get('/products/create', [ProductManagementController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductManagementController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [ProductManagementController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [ProductManagementController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');

    Route::get('/orders', [OrderManagementController::class, 'index'])->name('orders.index');
    Route::post('/orders/{order}/status', [OrderManagementController::class, 'updateStatus'])->name('orders.updateStatus');

    Route::get('/custom-orders', [CustomOrderDashboardController::class, 'index'])->name('custom-orders.index');
    Route::get('/custom-orders/{id}', [CustomOrderDashboardController::class, 'show'])->name('custom-orders.show');
    Route::post('/custom-orders/{id}/status', [CustomOrderDashboardController::class, 'updateStatus'])->name('custom-orders.updateStatus');
});
