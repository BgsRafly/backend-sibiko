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
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->foreign(['id_dosen_pa'], 'fk_mahasiswa_dosen_pa')->references(['id_staff'])->on('staff')->onUpdate('cascade')->onDelete('set null');
            $table->foreign(['id_user'])->references(['id'])->on('users')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign('fk_mahasiswa_dosen_pa');
            $table->dropForeign('mahasiswa_id_user_foreign');
        });
    }
};
