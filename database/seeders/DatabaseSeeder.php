<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. ADMIN - Admin FMIPA
        $userAdmin = User::create([
            'username' => '199001012011011001',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        Staff::create([
            'id_user'      => $userAdmin->id,
            'nip'          => '199001012011011001',
            'nama_lengkap' => 'Admin FMIPA',
            'jabatan'      => 'Admin'
        ]);

        // 2. DOSEN 1 - Bu Vida
        $userVida = User::create([
            'username' => '199006062022032009',
            'password' => Hash::make('vida123'),
            'role'     => 'dosen',
        ]);

        Staff::create([
            'id_user'      => $userVida->id,
            'nip'          => '199006062022032009',
            'nama_lengkap' => 'Gst. Ayu Vida Mastrika Giri, S.Kom., M.Cs.',
            'jabatan'      => 'Dosen PA'
        ]);

        // 3. KONSELOR - Pak Anom
        $userAnom = User::create([
            'username' => '198403172019031005',
            'password' => Hash::make('anom123'),
            'role'     => 'konselor',
        ]);

        Staff::create([
            'id_user'      => $userAnom->id,
            'nip'          => '198403172019031005',
            'nama_lengkap' => 'Ir. I Gusti Ngurah Anom Cahyadi Putra, ST., M.Cs',
            'jabatan'      => 'Konselor'
        ]);

        // 4. DOSEN 2 - Pak Gede Santi
        $userGeda = User::create([
            'username' => '198012062006041003',
            'password' => Hash::make('geda123'),
            'role'     => 'dosen',
        ]);

        Staff::create([
            'id_user'      => $userGeda->id,
            'nip'          => '198012062006041003',
            'nama_lengkap' => 'I Gede Santi Astawa, S.T., M.Cs.',
            'jabatan'      => 'Dosen PA'
        ]);

        // 5. WAKIL DEKAN 3 - Bu Rupiasih
        $userWD3 = User::create([
            'username' => '196904081994122001',
            'password' => Hash::make('wd3123'),
            'role'     => 'wd3',
        ]);

        Staff::create([
            'id_user'      => $userWD3->id,
            'nip'          => '196904081994122001',
            'nama_lengkap' => 'Ni Nyoman Rupiasih',
            'jabatan'      => 'Wakil Dekan 3'
        ]);
    }
}
