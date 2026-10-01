<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HandoverLogController;
use App\Http\Controllers\OpportunityController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('session.auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::middleware('admin.role')->group(function (): void {
        Route::get('/accounts', [AccountController::class, 'index']);
        Route::post('/accounts/{user}/lock', [AccountController::class, 'lock']);
        Route::get('/handover-logs', [HandoverLogController::class, 'index']);
    });

    Route::get('/customers', [CustomerController::class, 'index']);
    Route::get('/opportunities', [OpportunityController::class, 'index']);
});
