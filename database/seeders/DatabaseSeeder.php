<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Staff;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $userAdmin = User::create([
            'username' => '199001012011011001',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);

        Staff::create([
            'id_user'      => $userAdmin->id,
            'nip'          => '199001012011011001',
            'nama_lengkap' => 'Admin FMIPA',
            'jabatan'      => 'Admin',
            'email'        => 'admin.fmipa@unud.ac.id',
            'no_hp'        => '-'
        ]);

        $userVida = User::create([
            'username' => '199006062022032009',
            'password' => Hash::make('vida123'),
            'role'     => 'dosen',
        ]);

        Staff::create([
            'id_user'      => $userVida->id,
            'nip'          => '199006062022032009',
            'nama_lengkap' => 'Gst. Ayu Vida Mastrika Giri, S.Kom., M.Cs.',
            'jabatan'      => 'Dosen PA',
            'no_hp'        => '085737241069',
            'email'        => 'vida@unud.ac.id'
        ]);

        $userAnom = User::create([
            'username' => '198403172019031005',
            'password' => Hash::make('anom123'),
            'role'     => 'konselor',
        ]);

        Staff::create([
            'id_user'      => $userAnom->id,
            'nip'          => '198403172019031005',
            'nama_lengkap' => 'Ir. I Gusti Ngurah Anom Cahyadi Putra, ST., M.Cs',
            'jabatan'      => 'Konselor',
            'no_hp'        => '082146293573',
            'email'        => 'anom.cp@unud.ac.id'
        ]);

        $userGeda = User::create([
            'username' => '198012062006041003',
            'password' => Hash::make('geda123'),
            'role'     => 'dosen',
        ]);

        Staff::create([
            'id_user'      => $userGeda->id,
            'nip'          => '198012062006041003',
            'nama_lengkap' => 'I Gede Santi Astawa, S.T., M.Cs.',
            'jabatan'      => 'Dosen PA',
            'no_hp'        => '087862766628',
            'email'        => 'santi.astawa@unud.ac.id'
        ]);

        $userWD3 = User::create([
            'username' => '196904081994122001',
            'password' => Hash::make('wd3123'),
            'role'     => 'wd3',
        ]);

        Staff::create([
            'id_user'      => $userWD3->id,
            'nip'          => '196904081994122001',
            'nama_lengkap' => 'Ni Nyoman Rupiasih',
            'jabatan'      => 'Wakil Dekan 3',
            'no_hp'        => '-',
            'email'        => 'rupiasih@unud.ac.id'
        ]);
    }
}
