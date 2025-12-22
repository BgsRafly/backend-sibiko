<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
   public function register(Request $request)
{
    $request->validate([
        'nim'           => 'required|unique:mahasiswa,nim',
        'nama_lengkap'  => 'required',
        'email'         => 'required|email',
        'password'      => 'required|min:6',
        'prodi'         => 'required',
        'no_hp'         => 'required',
    ]);

    DB::beginTransaction();

    try {
        // 1. Buat user
        $user = User::create([
            'username' => $request->nim,
            'password' => Hash::make($request->password),
            'role'     => 'mahasiswa',
        ]);

        // 2. Buat mahasiswa
        Mahasiswa::create([
            'nim'          => $request->nim,
            'id_user'      => $user->id,
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
            'error' => $e->getMessage()
        ], 500);
    }
}


}
