<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $primaryKey = 'id_staff';

    protected $fillable = [
        'id_user',
        'nip',
        'nama_lengkap',
        'jabatan',
        'no_hp',
        'email',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function mahasiswaPA()
    {
        return $this->hasMany(Mahasiswa::class, 'id_staff_pa');
    }

    public function ajuan()
    {
        return $this->hasMany(Ajuan::class, 'id_staff');
    }
}
