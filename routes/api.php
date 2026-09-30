<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::middleware('session.auth')->group(function () {
    Route::post('/change-password', [AuthController::class, 'changePassword']);
});
