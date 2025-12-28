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
        'nama_lengkap',
        'email',
        'prodi',
        'no_hp',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function ajuan()
{
    return $this->hasMany(
        Ajuan::class,
        'nim',
        'nim'
    );
}

}
