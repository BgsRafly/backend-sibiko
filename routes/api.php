<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AjuanController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Middleware\RoleMiddleware;



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ajuan', [AjuanController::class, 'index']);
    Route::post('/ajuan', [AjuanController::class, 'store']);
    Route::get('/ajuan/{id}', [AjuanController::class, 'show']);
    Route::put('/ajuan/{id}', [AjuanController::class, 'update']);
    Route::delete('/ajuan/{id}', [AjuanController::class, 'destroy']);

    Route::middleware(['auth:sanctum', RoleMiddleware::class.':dosen,konselor'])->group(function () {
    Route::get('/staff/dashboard', [StaffController::class, 'dashboard']);
    Route::get('/staff/ajuan', [StaffController::class, 'listAjuan']);
});

});

