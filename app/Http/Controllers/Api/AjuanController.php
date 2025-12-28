<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class AjuanController extends Controller
{
    // 1. LIST ajuan milik mahasiswa
    public function index(Request $request)
    {
        $user = $request->user();

        $mahasiswa = $user->mahasiswa;

        return response()->json(
            $mahasiswa->ajuan
        );
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

        $ajuan = Ajuan::create([
            'nim'               => $mahasiswa->nim,
            'judul_konseling'   => $request->judul_konseling,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'jenis_layanan'     => $request->jenis_layanan,
        ]);

        return response()->json([
            'message' => 'Ajuan berhasil dibuat',
            'data'    => $ajuan
        ], 201);
    }

    // 3. DETAIL ajuan
    public function show(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        return response()->json($ajuan);
    }

    // 4. UPDATE ajuan
    public function update(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        $ajuan->update($request->only([
            'judul_konseling',
            'deskripsi_masalah',
            'jenis_layanan',
        ]));

            if ($ajuan->status !== 'menunggu') {
        return response()->json([
            'message' => 'Ajuan tidak dapat diubah atau dihapus'
        ], 403);
}
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

        $ajuan->delete();

            if ($ajuan->status !== 'menunggu') {
        return response()->json([
            'message' => 'Ajuan tidak dapat diubah atau dihapus'
        ], 403);
}


        return response()->json([
            'message' => 'Ajuan berhasil dihapus'
        ]);
    }
}
