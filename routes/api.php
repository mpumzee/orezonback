<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    // public routes
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);

// protected routes
Route::middleware(['auth:sanctum'])->group(function () {
Route::apiResource('equipment', EquipmentController::class);
Route::get('equipment/search/{name}',[EquipmentController::class,'search']);
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/profile', [AuthController::class, 'profile']);
   
}); 
});




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


