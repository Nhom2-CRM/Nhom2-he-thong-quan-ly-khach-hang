<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\LeadController;
use App\Http\Controllers\Api\V1\OpportunityController;
use App\Http\Controllers\Api\V1\ActivityController;
use App\Http\Controllers\Api\V1\QuotationController;
use App\Http\Controllers\Api\V1\ContractController;

Route::prefix('v1')->group(function () {
    // Public routes
    Route::post('/login', [AuthController::class, 'login']);

    // Authenticated API routes
    Route::middleware(['auth:sanctum', 'data.scope'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('customers', CustomerController::class);
        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('leads', LeadController::class);
        Route::apiResource('opportunities', OpportunityController::class);
        Route::apiResource('activities', ActivityController::class);
        Route::apiResource('quotations', QuotationController::class);
        Route::apiResource('contracts', ContractController::class);
    });
});