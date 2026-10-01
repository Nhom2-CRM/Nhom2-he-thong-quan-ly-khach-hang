<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserAssignmentController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('session.auth')->group(function (): void {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role.admin')->prefix('admin')->group(function (): void {
        Route::get('/users', [UserAssignmentController::class, 'index']);
        Route::get('/assignment-options', [UserAssignmentController::class, 'options']);
        Route::put('/users/{user}/assignments', [UserAssignmentController::class, 'update']);
    });
});
