<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ajuan extends Model
{
    use HasFactory;

    protected $table = 'ajuan';
    protected $primaryKey = 'id_ajuan';

    protected $fillable = [
        'nim',
        'id_handler',
        'judul_konseling',
        'deskripsi_masalah',
        'jenis_layanan',
        'tanggal_pengajuan',
        'tanggal_jadwal',
        'status',
        'catatan_dosen',
        'catatan_wd3',
        'tingkat_penanganan',
        'alasan_penolakan'
    ];

    public $timestamps = false;

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function handler()
    {
        return $this->belongsTo(Staff::class, 'id_handler', 'id_staff');
    }

    public function suratRujukan()
    {
        return $this->hasOne(SuratRujukan::class, 'id_ajuan', 'id_ajuan');
    }
}
