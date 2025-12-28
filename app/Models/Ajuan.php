<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ajuan extends Model
{
    protected $table = 'ajuan';
    protected $primaryKey = 'id_ajuan';

    protected $fillable = [
        'nim',
        'judul_konseling',
        'deskripsi_masalah',
        'jenis_layanan',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(
            Mahasiswa::class,
            'nim',
            'nim'
        );
    }
}
