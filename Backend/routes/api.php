<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;

// Đăng nhập
Route::post('/login', [AuthController::class, 'login']);

// Các API yêu cầu phiên đăng nhập hợp lệ
Route::middleware('session.auth')->group(function () {

    // Kiểm tra phiên và lấy thông tin user hiện tại
    Route::get('/me', [SessionController::class, 'me']);

    // Đăng xuất và vô hiệu phiên phía server
    Route::post('/logout', [SessionController::class, 'logout']);

});