<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes – Laravel 13
|--------------------------------------------------------------------------
*/

// ── Authentication ────────────────────────────────────────────────────────────
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ── Dashboard ─────────────────────────────────────────────────────────────────
Route::middleware('auth')->group(function () {
    Route::get('/', fn () => redirect()->route('dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// ── Admin ─────────────────────────────────────────────────────────────────────
// Middleware 'permission' được đăng ký trong bootstrap/app.php (Laravel 13 way)
Route::middleware(['auth', 'permission:manage-users'])->group(function () {
    Route::get('/admin/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])
        ->name('admin.users.index');
    Route::patch('/admin/users/{user}/toggle', [\App\Http\Controllers\Admin\UserController::class, 'toggleActive'])
        ->name('admin.users.toggle');
    Route::patch('/admin/users/{user}/role', [\App\Http\Controllers\Admin\UserController::class, 'changeRole'])
        ->name('admin.users.role');
});
