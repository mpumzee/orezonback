<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BuyerController;
use App\Http\Controllers\Api\V1\EquipmentController;
use App\Http\Controllers\Api\V1\MetalsController;
use App\Http\Controllers\Api\V1\PackageController;
use App\Http\Controllers\Api\V1\SellerController;
use App\Http\Controllers\Api\V1\SellerPackageController;
use App\Http\Controllers\UserEmailVerificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('verify-email/{id}', [UserEmailVerificationController::class, 'verify'])->name('verification.verify');

Route::prefix('v1')->group(function() {
    // Public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);

    Route::post('buyer', [BuyerController::class, 'store']);
    Route::get('buyer', [BuyerController::class, 'index']);
    Route::get('buyer/{id}', [BuyerController::class, 'show']);
    Route::put('buyer/{id}', [BuyerController::class, 'update']);
    Route::delete('buyer/{id}', [BuyerController::class, 'destroy']);

    Route::prefix('packages')->group(function () {
        Route::post('/register', [PackageController::class, 'createPackage']);
        Route::put('/update/{id}', [PackageController::class, 'updatePackage']);
        Route::put('/update-status/{id}', [PackageController::class, 'updateStatus']);
        Route::get('/', [PackageController::class, 'getPackages']);
        Route::get('/{id}', [PackageController::class, 'find']);
    });

    Route::prefix('sellers')->group(function () {
        Route::post('/register', [SellerController::class, 'registerSeller']);
        Route::put('/update/{id}', [SellerController::class, 'update']);
        Route::get('/', [SellerController::class, 'getSellers']);
        Route::get('/{id}', [SellerController::class, 'find']);
    });

    // Protected routes
    Route::middleware(['auth:sanctum'])->group(function () {
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

            Route::post('/seller/select-package', [SellerPackageController::class, 'selectPackage']);
        });

        // Buyer-only routes
        Route::middleware('role:buyer')->group(function () {
            Route::get('/buyer/dashboard', function () {
                return response()->json(['message' => 'Welcome Buyer']);
            });
        });
    });
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
 