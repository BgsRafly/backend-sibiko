<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Api\AjuanController;
use App\Http\Controllers\Api\StaffController;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\Api\StaffAjuanController;
use App\Http\Controllers\Api\WD3AjuanController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\MahasiswaController;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/ajuan', [AjuanController::class, 'index']);
    Route::post('/ajuan', [AjuanController::class, 'store']);
    Route::get('/ajuan/{id}', [AjuanController::class, 'show']);
    Route::put('/ajuan/{id}', [AjuanController::class, 'update']);
    Route::delete('/ajuan/{id}', [AjuanController::class, 'destroy']);
    // Profil Mahasiswa
    Route::get('/mahasiswa/me', [MahasiswaController::class, 'showProfile']);
    Route::put('/mahasiswa/update-profil', [MahasiswaController::class, 'updateProfile']);

   Route::middleware(['auth:sanctum'])->group(function () {
    // Endpoint khusus Staff
    Route::prefix('staff')->group(function () {
        Route::get('/ajuan', [StaffAjuanController::class, 'index']);
        Route::get('/ajuan/{id}', [StaffAjuanController::class, 'show']);
        Route::put('/ajuan/{id}/status', [StaffAjuanController::class, 'updateStatus']);
        Route::put('/ajuan/{id}/complete', [StaffAjuanController::class, 'completeSession']);
    });
    Route::prefix('wd3')->group(function () {
        Route::get('/ajuan', [WD3AjuanController::class, 'index']);      // List ajuan rujukan
        Route::get('/ajuan/{id}', [WD3AjuanController::class, 'show']);  // Detail ajuan rujukan
        Route::put('/ajuan/{id}/jadwal', [WD3AjuanController::class, 'setJadwal']); // WD3 menentukan jadwal sendiri
        Route::put('/ajuan/{id}/selesai', [WD3AjuanController::class, 'complete']); // Selesai atau Rujuk ke Univ
        Route::get('/ajuan/{id}/cetak', [WD3AjuanController::class, 'cetakRujukan']);
    });
});

Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard & Statistik Utama
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);
    Route::get('/admin/ajuan/all', [AdminController::class, 'allAjuan']);
    
    // Admin Mahasiswa (Identified by User ID)
    Route::get('/admin/mahasiswa', [AdminController::class, 'indexMahasiswa']);
    Route::post('/admin/mahasiswa', [AdminController::class, 'storeMahasiswa']); // Tambahan
    Route::get('/admin/mahasiswa/{id}', [AdminController::class, 'showMahasiswa']);
    Route::put('/admin/mahasiswa/{id}', [AdminController::class, 'updateMahasiswa']);
    Route::delete('/admin/mahasiswa/{id}', [AdminController::class, 'destroyMahasiswa']);

    // Admin Staff (Identified by User ID)
    Route::get('/admin/staff', [AdminController::class, 'indexStaff']);
    Route::post('/admin/staff', [AdminController::class, 'storeStaff']); // Tambahan
    Route::get('/admin/staff/{id}', [AdminController::class, 'showStaff']);
    Route::put('/admin/staff/{id}', [AdminController::class, 'updateStaff']);
    Route::delete('/admin/staff/{id}', [AdminController::class, 'destroyStaff']);
});

});

