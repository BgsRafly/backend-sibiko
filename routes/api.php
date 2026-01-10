<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AjuanController;
use App\Http\Controllers\Api\StaffAjuanController;
use App\Http\Controllers\Api\WD3AjuanController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\MahasiswaController;
use App\Http\Controllers\Api\StaffController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard']);
        Route::get('/profile', [MahasiswaController::class, 'showProfile']);
        Route::post('/update-profile', [MahasiswaController::class, 'updateProfile']);
        Route::get('/ajuan', [AjuanController::class, 'index']);
        Route::post('/ajuan', [AjuanController::class, 'store']);
        Route::get('/ajuan/{id}', [AjuanController::class, 'show']);
        Route::put('/ajuan/{id}', [AjuanController::class, 'update']);
        Route::delete('/ajuan/{id}', [AjuanController::class, 'destroy']);
    });

    Route::prefix('staff')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard']);

        Route::get('/profile', [StaffController::class, 'showProfile']);

        Route::get('/ajuan', [StaffAjuanController::class, 'index']);
        Route::get('/ajuan/{id}', [StaffAjuanController::class, 'show']);
        Route::put('/ajuan/{id}/status', [StaffAjuanController::class, 'updateStatus']);
        Route::put('/ajuan/{id}/complete', [StaffAjuanController::class, 'completeSession']);
    });

    Route::prefix('wd3')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard']);

        Route::get('/profile', [StaffController::class, 'showProfile']);

        Route::get('/ajuan', [WD3AjuanController::class, 'index']);
        Route::get('/ajuan/{id}', [WD3AjuanController::class, 'show']);
        Route::put('/ajuan/{id}/jadwal', [WD3AjuanController::class, 'setJadwal']);
        Route::put('/ajuan/{id}/complete', [WD3AjuanController::class, 'complete']);
        Route::get('/ajuan/{id}/cetak', [WD3AjuanController::class, 'cetakRujukan']);
    });

    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);

        Route::get('/profile', [StaffController::class, 'showProfile']);

        Route::get('/laporan', [AdminController::class, 'laporan']);
        Route::get('/ajuan', [AdminController::class, 'allAjuan']);
        Route::get('/mahasiswa', [AdminController::class, 'indexMahasiswa']);
        Route::post('/mahasiswa', [AdminController::class, 'storeMahasiswa']);
        Route::get('/mahasiswa/{id}', [AdminController::class, 'showMahasiswa']);
        Route::put('/mahasiswa/{id}', [AdminController::class, 'updateMahasiswa']);
        Route::delete('/mahasiswa/{id}', [AdminController::class, 'destroyMahasiswa']);
        Route::get('/staff', [AdminController::class, 'indexStaff']);
        Route::post('/staff', [AdminController::class, 'storeStaff']);
        Route::get('/staff/{id}', [AdminController::class, 'showStaff']);
        Route::put('/staff/{id}', [AdminController::class, 'updateStaff']);
        Route::delete('/staff/{id}', [AdminController::class, 'destroyStaff']);
    });

});
