<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CustomerController;
use App\Http\Controllers\Api\V1\OpportunityController;

Route::prefix('v1')->middleware(['auth:sanctum', 'check.data.scope'])->group(function () {
    // Customer API Endpoints
    Route::apiResource('customers', CustomerController::class);

    // Opportunity API Endpoints (S2-09 Stage Transition & Forecast)
    Route::patch('opportunities/{opportunity}/stage', [OpportunityController::class, 'updateStage']);
});