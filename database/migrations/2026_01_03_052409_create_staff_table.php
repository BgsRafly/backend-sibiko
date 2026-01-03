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
        Schema::create('staff', function (Blueprint $table) {
    $table->id('id_staff');

    $table->string('nip', 50)->unique();
    $table->unsignedBigInteger('id_user');

    $table->string('nama_lengkap');
    $table->enum('jabatan', [
        'Dosen PA',
        'Konselor',
        'Wakil Dekan 3',
        'Admin'
    ]);

    $table->timestamps();

    $table->foreign('id_user')
        ->references('id')
        ->on('users')
        ->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
