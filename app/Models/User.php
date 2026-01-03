<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = ['password'];

    public function mahasiswa()
    {
        return $this->hasOne(Mahasiswa::class, 'id_user', 'id');
    }
    public function staff()
    {
    return $this->hasOne(Staff::class, 'id_user', 'id');
    }

}

