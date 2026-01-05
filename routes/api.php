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

// --- Public Routes ---
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// --- Protected Routes (Butuh Token) ---
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/logout', [AuthController::class, 'logout']);

    // ROUTES MAHASISWA
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard']);

        // Profil
        Route::get('/profile', [MahasiswaController::class, 'showProfile']);
        Route::post('/update-profile', [MahasiswaController::class, 'updateProfile']);

        // Ajuan Konseling
        Route::get('/ajuan', [AjuanController::class, 'index']);       // List Riwayat
        Route::post('/ajuan', [AjuanController::class, 'store']);      // Buat Baru
        Route::get('/ajuan/{id}', [AjuanController::class, 'show']);   // Detail
        Route::put('/ajuan/{id}', [AjuanController::class, 'update']); // Edit
        Route::delete('/ajuan/{id}', [AjuanController::class, 'destroy']); // Hapus
    });

    // ROUTES STAFF (Dosen PA & Konselor)
    Route::prefix('staff')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard']);

        Route::get('/ajuan', [StaffAjuanController::class, 'index']);      // List Masuk
        Route::get('/ajuan/{id}', [StaffAjuanController::class, 'show']);  // Detail

        // Aksi: Terima/Tolak/Reschedule
        Route::put('/ajuan/{id}/status', [StaffAjuanController::class, 'updateStatus']);
        // Aksi: Selesai/Rujuk
        Route::put('/ajuan/{id}/complete', [StaffAjuanController::class, 'completeSession']);
    });

    // ROUTES WD3 (Wakil Dekan 3)
    Route::prefix('wd3')->group(function () {
        Route::get('/dashboard', [StaffController::class, 'dashboard']);

        Route::get('/ajuan', [WD3AjuanController::class, 'index']);        // List Rujukan
        Route::get('/ajuan/{id}', [WD3AjuanController::class, 'show']);    // Detail

        // Aksi WD3
        Route::put('/ajuan/{id}/jadwal', [WD3AjuanController::class, 'setJadwal']); // Set Jadwal
        Route::put('/ajuan/{id}/complete', [WD3AjuanController::class, 'complete']); // Selesai/Rujuk Univ
        Route::get('/ajuan/{id}/cetak', [WD3AjuanController::class, 'cetakRujukan']); // Data Cetak
    });

    // ROUTES ADMIN
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard']);
        Route::get('/laporan', [AdminController::class, 'laporan']);

        // Monitoring Ajuan
        // PERBAIKAN: Ubah '/ajuan/all' jadi '/ajuan' agar sesuai frontend
        Route::get('/ajuan', [AdminController::class, 'allAjuan']);

        // Manajemen Mahasiswa
        Route::get('/mahasiswa', [AdminController::class, 'indexMahasiswa']);
        Route::post('/mahasiswa', [AdminController::class, 'storeMahasiswa']);
        Route::get('/mahasiswa/{id}', [AdminController::class, 'showMahasiswa']);
        Route::put('/mahasiswa/{id}', [AdminController::class, 'updateMahasiswa']);
        Route::delete('/mahasiswa/{id}', [AdminController::class, 'destroyMahasiswa']);

        // Manajemen Staff
        Route::get('/staff', [AdminController::class, 'indexStaff']);
        Route::post('/staff', [AdminController::class, 'storeStaff']);
        Route::get('/staff/{id}', [AdminController::class, 'showStaff']);
        Route::put('/staff/{id}', [AdminController::class, 'updateStaff']);
        Route::delete('/staff/{id}', [AdminController::class, 'destroyStaff']);
    });

});
