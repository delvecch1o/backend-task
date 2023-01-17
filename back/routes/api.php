<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthProfileController;
use App\Http\Controllers\API\ContractController;

Route::post('auth/profile', [ AuthProfileController::class, 'profile']);

Route::post('login', [ AuthProfileController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('logout', [AuthProfileController::class, 'logout']);

    Route::post('contract', [ContractController::class, 'store']);
    Route::get('contracts/{contract}', [ContractController::class, 'showDetails']);
    Route::get('contracts', [ContractController::class, 'show']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
