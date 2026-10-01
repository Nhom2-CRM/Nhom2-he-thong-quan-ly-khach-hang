<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ScopedResourceController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('session.auth')->group(function () {
    Route::get('/customers', [ScopedResourceController::class, 'customers']);
    Route::get('/customers/export', [ScopedResourceController::class, 'exportCustomers']);
    Route::get('/customers/{id}', [ScopedResourceController::class, 'customer']);

    Route::get('/opportunities', [ScopedResourceController::class, 'opportunities']);
    Route::get('/opportunities/export', [ScopedResourceController::class, 'exportOpportunities']);
    Route::get('/opportunities/{id}', [ScopedResourceController::class, 'opportunity']);

    Route::get('/activities', [ScopedResourceController::class, 'activities']);
    Route::get('/activities/export', [ScopedResourceController::class, 'exportActivities']);
    Route::get('/activities/{id}', [ScopedResourceController::class, 'activity']);

    Route::get('/quotes', [ScopedResourceController::class, 'quotes']);
    Route::get('/quotes/export', [ScopedResourceController::class, 'exportQuotes']);
    Route::get('/quotes/{id}', [ScopedResourceController::class, 'quote']);
});
