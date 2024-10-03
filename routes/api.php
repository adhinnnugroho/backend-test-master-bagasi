<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\VoucherController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/login', [AuthController::class, 'loginResponse'])->name('login');

Route::name('services.')->prefix('services')->middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::resources([
        'product' => ProductController::class,
        'voucher' => VoucherController::class,
    ]);

    Route::name('product-services.')->prefix('product-services')->group(function () {
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('update');
    });

    Route::name('voucher-services.')->prefix('voucher-services')->group(function () {
        Route::post('/apply', [VoucherController::class, 'ApplyVoucher'])->name('apply');
        Route::post('/update/{id}', [VoucherController::class, 'update'])->name('update');
        Route::get('run-voucher-activation', [VoucherController::class, 'runVoucherActivation'])->name('run-voucher-activation');
        // wget url
    });
});
