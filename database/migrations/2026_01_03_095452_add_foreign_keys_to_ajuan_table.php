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
        Schema::table('ajuan', function (Blueprint $table) {
            $table->foreign(['nim'], 'fk_ajuan_mahasiswa')->references(['nim'])->on('mahasiswa')->onUpdate('no action')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ajuan', function (Blueprint $table) {
            $table->dropForeign('fk_ajuan_mahasiswa');
        });
    }
};
