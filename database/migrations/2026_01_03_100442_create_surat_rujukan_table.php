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
    Schema::create('surat_rujukan', function (Blueprint $table) {
        $table->increments('id_surat'); //
        
        $table->integer('id_ajuan'); //
        
        $table->string('nomor_surat', 50); //
        $table->text('keterangan_universitas'); //
        $table->date('tanggal_cetak'); //
        
        $table->timestamps();

        // Foreign Key Constraint
        $table->foreign('id_ajuan')
              ->references('id_ajuan')
              ->on('ajuan')
              ->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_rujukan');
    }
};