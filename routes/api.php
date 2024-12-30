<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EquipmentController;
use App\Http\Controllers\Api\V1\MetalsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);

    // Protected routes
    // Route::middleware(['auth:sanctum'])->group(function () {
        // Routes accessible to all authenticated users
        Route::apiResource('equipment', EquipmentController::class); // Fixed issue
        Route::get('equipment/search/{name}', [EquipmentController::class, 'search']);
        Route::apiResource('/metals', MetalsController::class);
        Route::get('metals/search/{name}', [MetalsController::class, 'search']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/profile', [AuthController::class, 'profile']);

        // Admin-only routes
        Route::middleware('role:admin')->group(function () {
            Route::get('/admin/dashboard', function () {
                return response()->json(['message' => 'Welcome Admin']);
            });
        });

        // Seller-only routes
        Route::middleware('role:seller')->group(function () {
            Route::get('/seller/dashboard', function () {
                return response()->json(['message' => 'Welcome Seller']);
            });
        });

        // Buyer-only routes
        Route::middleware('role:buyer')->group(function () {
            Route::get('/buyer/dashboard', function () {
                return response()->json(['message' => 'Welcome Buyer']);
            });
        });
 
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 