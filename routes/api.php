<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    // Route công khai để lấy Token
    Route::post('login', [AuthController::class, 'login']);

    // Các route CRM bắt buộc phải có Sanctum Token
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('customers/check-duplicates', [CustomerController::class, 'checkDuplicates']);
        Route::get('customers/{customer}/360', [CustomerController::class, 'show360']);
        Route::post('customers/merge', [CustomerController::class, 'merge']);
    });
});