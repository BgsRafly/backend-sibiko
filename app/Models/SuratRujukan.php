<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratRujukan extends Model
{
    protected $table = 'surat_rujukan';
    protected $primaryKey = 'id_surat';
    
    // Matikan timestamps jika tabel Anda tidak memiliki created_at/updated_at
    public $timestamps = true; 

    protected $fillable = [
        'id_ajuan',
        'nomor_surat',
        'keterangan_universitas',
        'tanggal_cetak'
    ];

    public function ajuan()
    {
        return $this->belongsTo(Ajuan::class, 'id_ajuan', 'id_ajuan');
    }
}