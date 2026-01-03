<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajuan extends Model
{
    use HasFactory;

    protected $table = 'ajuan';
    protected $primaryKey = 'id_ajuan';

    // Sesuaikan fillable dengan kolom di gambar kiri
    protected $fillable = [
        'nim', // Tetap nim sesuai permintaan Anda
        'id_handler', // Di gambar kiri namanya id_handler, bukan id_staff
        'judul_konseling',
        'deskripsi_masalah',
        'jenis_layanan',
        'tanggal_pengajuan',
        'tanggal_jadwal',
        'status',
        'catatan_sesi',
        'tingkat_penanganan',
        'alasan_penolakan'
    ];

    public $timestamps = false; 

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    /**
     * Relasi ke Staff/Handler
     */
    public function handler()
    {
        // Sesuaikan nama foreign key menjadi id_handler sesuai gambar kiri
        return $this->belongsTo(Staff::class, 'id_handler', 'id_staff');
    }
    public function suratRujukan()
    {
    // Hubungkan id_ajuan di tabel ajuan dengan id_ajuan di tabel surat_rujukan
    return $this->hasOne(SuratRujukan::class, 'id_ajuan', 'id_ajuan');
    }
}