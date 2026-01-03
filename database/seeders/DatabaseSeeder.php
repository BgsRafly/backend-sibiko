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
        // 1. BUAT AKUN USER (LOGIN)
        
        // Akun WD3
        $userWD3 = User::create([
            'nip_nim' => '19800101',
            'password' => Hash::make('password123'),
            'role' => 'wakil_dekan_3',
        ]);

        // Akun Dosen PA
        $userDosen = User::create([
            'nip_nim' => '19850505',
            'password' => Hash::make('password123'),
            'role' => 'dosen',
        ]);

        // Akun Mahasiswa
        $userMhs = User::create([
            'nip_nim' => '2408561062',
            'password' => Hash::make('password123'),
            'role' => 'mahasiswa',
        ]);

        // 2. BUAT DATA PROFIL STAFF (WD3 & DOSEN)
        
        $wd3 = Staff::create([
            'id_user' => $userWD3->id,
            'nip' => '19800101',
            'nama_staff' => 'Dr. Bagus WD3, M.T',
            'jabatan' => 'Wakil Dekan 3',
        ]);

        $dosen = Staff::create([
            'id_user' => $userDosen->id,
            'nip' => '19850505',
            'nama_staff' => 'Dosen PA S.Kom, M.Cs',
            'jabatan' => 'Dosen PA',
        ]);

        // 3. BUAT DATA PROFIL MAHASISWA
        
        Mahasiswa::create([
            'nim' => '2408561062',
            'id_user' => $userMhs->id,
            'id_dosen_pa' => $dosen->id_staff,
            'nama_lengkap' => 'Mahasiswa Contoh',
            'prodi' => 'Informatika',
            'email' => 'mhs@student.univ.ac.id',
            'no_hp' => '08123456789',
        ]);
    }
}