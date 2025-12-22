<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->string('nim', 20)->primary();
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_dosen_pa')->nullable();
            $table->string('nama_lengkap', 100);
            $table->string('prodi', 50);
            $table->string('email', 100);
            $table->string('no_hp', 15);
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id')->on('users')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};

