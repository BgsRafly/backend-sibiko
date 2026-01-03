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
            $table->bigIncrements('id_staff');
            $table->string('nip', 50)->unique();
            $table->unsignedBigInteger('id_user')->index('staff_id_user_foreign');
            $table->string('nama_lengkap');
            $table->enum('jabatan', ['Dosen PA', 'Konselor', 'Wakil Dekan 3', 'Admin']);
            $table->timestamps();
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
