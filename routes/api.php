<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CampaignController;
use App\Http\Controllers\Api\CustomerController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Mọi lỗi 401 / 403 / 404 / 500 phát sinh trong các route này
| sẽ được Handler::renderJson() bắt và trả về JSON có cấu trúc:
|
|   {
|     "success": false,
|     "error": {
|       "status_code": 403,
|       "title": "...",
|       "message": "...",
|       "primary_action": { "label": "...", "url": "..." },
|       "secondary_action": null | { "label": "...", "url": "..." }
|     }
|   }
|
| (SCRUM-91)
|
*/

// ─── Public routes ────────────────────────────────────────────────────────────
Route::post('/login', [AuthController::class, 'login'])->name('api.login');

// ─── Protected routes (Sanctum) ───────────────────────────────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('/me',      [AuthController::class, 'me'])->name('api.me');

    // Customers
    Route::apiResource('customers', CustomerController::class);

    // Campaigns
    Route::apiResource('campaigns', CampaignController::class);
    Route::patch('campaigns/{campaign}/status', [CampaignController::class, 'changeStatus'])
         ->name('campaigns.status');
});
