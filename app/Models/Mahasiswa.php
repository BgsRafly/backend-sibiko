<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim'; // Sesuai Primary Key di gambar
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'nim',
        'id_user',
        'id_dosen_pa',
        'nama_lengkap',
        'email',
        'prodi',
        'no_hp',
    ];

    // Relasi ke tabel Staff (Dosen PA)
    public function dosenPA()
    {
        return $this->belongsTo(Staff::class, 'id_dosen_pa', 'id_staff');
    }

    // Relasi ke tabel Ajuan
    public function ajuan()
    {
        return $this->hasMany(Ajuan::class, 'nim', 'nim');
    }

    // Relasi ke tabel Users (Untuk Auth)
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}