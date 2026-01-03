<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Staff;
use App\Models\Mahasiswa;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        
        $userDosen = User::create([
            'username' => '19850505',
            'password' => Hash::make('password123'),
            'role'     => 'dosen',
        ]);

        $userMhs = User::create([
            'username' => '2408561062',
            'password' => Hash::make('password123'),
            'role'     => 'mahasiswa',
        ]);

        $userWD3 = User::create([
            'username' => '19800101',
            'password' => Hash::make('password123'),
            'role'     => 'wakil_dekan_3',
        ]);

        // 2. BUAT PROFIL STAFF 
        
        $dosen = Staff::create([
            'id_user'    => $userDosen->id,
            'nip'        => '19850505',
            'nama_staff' => 'Dosen PA S.Kom, M.Cs',
            'jabatan'    => 'Dosen PA',
        ]);

        Staff::create([
            'id_user'    => $userWD3->id,
            'nip'        => '19800101',
            'nama_staff' => 'Dr. Bagus Adi, M.T.',
            'jabatan'    => 'Wakil Dekan 3',
        ]);

        
        Mahasiswa::create([
            'nim'         => '2408561062',     
            'id_user'     => $userMhs->id,     
            'id_dosen_pa' => $dosen->id_staff, 
            'nama_lengkap'=> 'Mahasiswa Contoh',
            'prodi'       => 'Informatika',
            'email'       => 'mhs@student.univ.ac.id',
            'no_hp'       => '08123456789',
        ]);
    }
}