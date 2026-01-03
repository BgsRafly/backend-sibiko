<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nim'            => 'required|unique:mahasiswa,nim',
            'nama_lengkap'   => 'required',
            'email'          => 'required|email',
            'password'       => 'required|min:6',
            'prodi'          => 'required',
            'no_hp'          => 'required',
            'nip_dosen_pa'   => 'required',
        ]);

        DB::beginTransaction();

        try {
            $staff = Staff::where('nip', $request->nip_dosen_pa)
                ->whereHas('user', function ($q) {
                    $q->where('role', 'dosen');
                })
                ->first();

            if (!$staff) {
                return response()->json([
                    'message' => 'NIP dosen PA tidak valid'
                ], 422);
            }

            $user = User::create([
                'username' => $request->nim,
                'password' => Hash::make($request->password),
                'role'     => 'mahasiswa',
            ]);


            Mahasiswa::create([
                'nim'          => $request->nim,
                'id_user'      => $user->id,
                'id_dosen_pa'  => $staff->id_staff,
                'nama_lengkap' => $request->nama_lengkap,
                'email'        => $request->email,
                'prodi'        => $request->prodi,
                'no_hp'        => $request->no_hp,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Registrasi mahasiswa berhasil'
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json([
                'message' => 'Registrasi gagal',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
