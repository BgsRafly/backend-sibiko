<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
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

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'id_dosen_pa', 'id_staff');
    }

    public function ajuan()
    {
        return $this->hasMany(Ajuan::class, 'nim', 'nim');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
