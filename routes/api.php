<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CampaignController;
use App\Http\Middleware\ApiTokenMiddleware;
use App\Http\Middleware\PermissionMiddleware;

Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    Route::post('/reset-password', [AuthController::class, 'resetPassword']);
});

Route::middleware(ApiTokenMiddleware::class)->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    Route::get('/customers', [CustomerController::class, 'index'])->middleware(PermissionMiddleware::class.':customers.view');
    Route::post('/customers', [CustomerController::class, 'store'])->middleware(PermissionMiddleware::class.':customers.create');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->middleware(PermissionMiddleware::class.':customers.view');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->middleware(PermissionMiddleware::class.':customers.update');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->middleware(PermissionMiddleware::class.':customers.delete');

    Route::get('/campaigns', [CampaignController::class, 'index'])->middleware(PermissionMiddleware::class.':campaigns.view');
    Route::post('/campaigns', [CampaignController::class, 'store'])->middleware(PermissionMiddleware::class.':campaigns.create');
    Route::get('/campaigns/{campaign}', [CampaignController::class, 'show'])->middleware(PermissionMiddleware::class.':campaigns.view');
    Route::put('/campaigns/{campaign}', [CampaignController::class, 'update'])->middleware(PermissionMiddleware::class.':campaigns.update');
    Route::delete('/campaigns/{campaign}', [CampaignController::class, 'destroy'])->middleware(PermissionMiddleware::class.':campaigns.delete');
});
