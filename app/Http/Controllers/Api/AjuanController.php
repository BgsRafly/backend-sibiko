<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;

class AjuanController extends Controller
{
    // 1. LIST ajuan milik mahasiswa
    // 1. LIST ajuan milik mahasiswa
public function index(Request $request)
    {
    $user = $request->user();
    $mahasiswa = $user->mahasiswa;

    // Ambil data langsung dari tabel ajuan berdasarkan NIM mahasiswa
    $data = Ajuan::where('nim', $mahasiswa->nim)->get();

    return response()->json($data);
    }

    // 2. CREATE ajuan
    public function store(Request $request)
{
    $request->validate([
        'judul_konseling'   => 'required',
        'deskripsi_masalah' => 'required',
        'jenis_layanan'     => 'required',
    ]);

    $mahasiswa = $request->user()->mahasiswa;

    // DEBUG: Jika id_staff kosong, kirim pesan error agar kita tahu
    if (is_null($mahasiswa->id_dosen_pa)) {
        return response()->json([
            'message' => 'Gagal! Mahasiswa ini belum memiliki Staff (id_staff null di database mahasiswa)',
            'debug_mahasiswa_data' => $mahasiswa
        ], 422);
    }

    $ajuan = Ajuan::create([
        'nim'               => $mahasiswa->nim,
        'judul_konseling'   => $request->judul_konseling,
        'deskripsi_masalah' => $request->deskripsi_masalah,
        'jenis_layanan'     => $request->jenis_layanan,
        'status'            => 'pending',
        'tingkat_penanganan'=> 'Prodi',
        'tanggal_pengajuan' => now(),
        'id_handler'        => $mahasiswa->id_dosen_pa, 
    ]);

    return response()->json([
        'message' => 'Ajuan berhasil dibuat',
        'data'    => $ajuan
    ], 201);
}

    // 3. DETAIL ajuan
   public function show(Request $request)
    {
    // Mengambil data mahasiswa dari user yang login
    $mahasiswa = $request->user()->mahasiswa;

    // Mencari SATU ajuan TERBARU milik mahasiswa tersebut
    $ajuan = Ajuan::where('nim', $mahasiswa->nim)
        ->latest('tanggal_pengajuan') // Urutkan berdasarkan tanggal terbaru
        ->first();

    if (!$ajuan) {
        return response()->json([
            'message' => 'Anda belum pernah membuat ajuan'
        ], 404);
    }

    return response()->json($ajuan);
    }

    

    // 4. UPDATE ajuan
    public function update(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        // Validasi: Hanya status 'pending' yang boleh diubah
        if ($ajuan->status !== 'pending') {
            return response()->json([
                'message' => 'Ajuan tidak dapat diubah karena status sudah ' . $ajuan->status
            ], 403);
        }

        $ajuan->update($request->only([
            'judul_konseling',
            'deskripsi_masalah',
            'jenis_layanan',
        ]));

        return response()->json([
            'message' => 'Ajuan berhasil diperbarui',
            'data'    => $ajuan
        ]);
    }

    // 5. DELETE ajuan
    public function destroy(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        // Validasi: Hanya status 'pending' yang boleh dihapus
        if ($ajuan->status !== 'pending') {
            return response()->json([
                'message' => 'Ajuan tidak dapat dihapus karena status sudah ' . $ajuan->status
            ], 403);
        }

        $ajuan->delete();

        return response()->json([
            'message' => 'Ajuan berhasil dihapus'
        ]);
    }
}