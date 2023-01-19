<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthProfileController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\JobController;
use App\Http\Controllers\API\DepositController;
use App\Http\Controllers\API\AdminController ;

Route::post('auth/profile', [ AuthProfileController::class, 'profile']);

Route::post('login', [ AuthProfileController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    
    Route::post('logout', [AuthProfileController::class, 'logout']);

    Route::post('contract', [ContractController::class, 'store']);
    Route::get('contracts/{contract}', [ContractController::class, 'showDetails']);
    Route::get('contracts', [ContractController::class, 'show']);

    Route::post('job', [JobController::class, 'store']);
    Route::get('jobs/unpaid', [JobController::class, 'show']);
    Route::post('jobs/{job}/pay', [JobController::class, 'payment']);

    Route::post('balances/deposit', [DepositController::class, 'deposit']);

    Route::get('admin/best-profession', [AdminController::class, 'query']);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
