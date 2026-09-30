<?php
use App\Http\Controllers\ActivationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::post('/login',[AuthController::class,'login']);
Route::post('/activate',[ActivationController::class,'activate']);

Route::middleware('session.auth')->group(function () {
    Route::get('/me',[AuthController::class,'me']);
    Route::post('/logout',[AuthController::class,'logout']);
    Route::middleware('role.admin')->prefix('admin')->group(function () {
        Route::get('/users',[UserController::class,'index']);
        Route::post('/users',[UserController::class,'store']);
        Route::get('/users/{user}',[UserController::class,'show']);
        Route::put('/users/{user}',[UserController::class,'update']);
    });
});
