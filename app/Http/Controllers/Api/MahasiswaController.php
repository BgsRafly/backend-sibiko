<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaController extends Controller
{

    public function dashboard(Request $request)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $stats = [
            'total' => \App\Models\Ajuan::where('nim', $mahasiswa->nim)->count(),
            'pending' => \App\Models\Ajuan::where('nim', $mahasiswa->nim)
                ->whereIn('status', ['pending', 'reschedule'])->count(),
            'approved' => \App\Models\Ajuan::where('nim', $mahasiswa->nim)
                ->where('status', 'disetujui')->count(),
            'completed' => \App\Models\Ajuan::where('nim', $mahasiswa->nim)
                ->where('status', 'selesai')->count(),
        ];

        $recent = \App\Models\Ajuan::where('nim', $mahasiswa->nim)
            ->latest('tanggal_pengajuan')
            ->take(5)
            ->get();

        return response()->json([
            'stats' => $stats,
            'recent_activities' => $recent
        ]);
    }

    /**
     * Update Profil Mahasiswa (Kecuali NIM)
     */
    public function updateProfile(Request $request)
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Cari data mahasiswa berdasarkan id_user
        $mahasiswa = Mahasiswa::where('id_user', $user->id)->first();

        if (!$mahasiswa) {
            return response()->json(['message' => 'Data profil tidak ditemukan'], 404);
        }

        // 3. Validasi input sesuai kolom di tabel
        $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'prodi'        => 'required|string|max:50',
            'email'        => 'required|email|max:100',
            'no_hp'        => 'required|string|max:15',
        ]);

        // 4. Update data (Tanpa menyentuh Primary Key 'nim')
        $mahasiswa->update([
            'nama_lengkap' => $request->nama_lengkap,
            'prodi'        => $request->prodi,
            'email'        => $request->email,
            'no_hp'        => $request->no_hp,
        ]);

        return response()->json([
            'message' => 'Profil berhasil diperbarui',
            'data'    => $mahasiswa
        ]);
    }

    /**
     * Melihat profil sendiri
     */
    public function showProfile()
    {
        $user = Auth::user();
        $mahasiswa = Mahasiswa::with('staff')->where('id_user', $user->id)->firstOrFail();

        return response()->json($mahasiswa);
    }
}
