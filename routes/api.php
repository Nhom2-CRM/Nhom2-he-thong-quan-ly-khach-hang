<?php

<<<<<<< HEAD
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\CustomerController;
<<<<<<< HEAD
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
=======
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
>>>>>>> 72f5237d663e404ee450fd532a2b229ee05201ee
    });
=======
use App\Http\Controllers\Api\V1\ActivityController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::post('/activities', [ActivityController::class, 'store']);
    Route::patch('/activities/{activity}/status', [ActivityController::class, 'updateStatus']);
>>>>>>> feature/S6-06-activity-backend
});