<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\OpportunityController;
use App\Http\Middleware\CheckDataScope;

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('/login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
        
        // Báo cáo dự báo doanh số (Giám đốc kinh doanh)[cite: 1]
        Route::get('/opportunities/forecast', [OpportunityController::class, 'forecastReport']);

        // RESTful resources
        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('opportunities', OpportunityController::class);
    });
});