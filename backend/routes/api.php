<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\SharedCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    // API đăng nhập - không cần đăng nhập trước
    Route::post('/login', [AuthController::class, 'login']);

    // Các API Product, Shared Category và Customer - bắt buộc phải đăng nhập
    Route::middleware('auth:sanctum')->group(function () {
        Route::apiResource('products', ProductController::class);
        Route::apiResource('shared-categories', SharedCategoryController::class);
        Route::apiResource('customers', CustomerController::class);
    });
});