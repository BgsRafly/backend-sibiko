<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ajuan', function (Blueprint $table) {
            $table->integer('id_ajuan', true);
            $table->string('nim', 20)->index('fk_ajuan_mahasiswa');
            $table->integer('id_handler')->nullable();
            $table->string('judul_konseling', 150);
            $table->text('deskripsi_masalah');
            $table->string('jenis_layanan', 50);
            $table->dateTime('tanggal_pengajuan')->useCurrent();
            $table->dateTime('tanggal_jadwal')->nullable();
            $table->enum('status', ['pending', 'reschedule', 'ditolak', 'disetujui', 'pending wd3', 'reschedule wd3', 'ditolak wd3', 'disetujui wd3', 'rujuk universitas', 'selesai'])->default('pending');
            $table->text('catatan_sesi')->nullable();
            $table->enum('tingkat_penanganan', ['Prodi', 'Fakultas', 'Universitas'])->default('Prodi');
            $table->text('alasan_penolakan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ajuan');
    }
};
