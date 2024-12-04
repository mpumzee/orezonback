<?php

use App\Http\Controllers\Api\V1\EquipmentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {

Route::apiResource('equipment', EquipmentController::class);

});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
