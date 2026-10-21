<?php

use App\Http\Controllers\Api\V1\ActivityController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::get('/activities', [ActivityController::class, 'index']);
    Route::post('/activities', [ActivityController::class, 'store']);
    Route::patch('/activities/{activity}/status', [ActivityController::class, 'updateStatus']);
});