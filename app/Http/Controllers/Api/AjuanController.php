<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use App\Models\Staff;
use Illuminate\Http\Request;

class AjuanController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $mahasiswa = $user->mahasiswa;

        $data = Ajuan::with('handler')
            ->where('nim', $mahasiswa->nim)
            ->latest('tanggal_pengajuan')
            ->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_konseling'   => 'required|string|max:150',
            'deskripsi_masalah' => 'required|string',
            'jenis_layanan'     => 'required|string|in:Akademik,Karir,Pribadi,Sosial',
            'tanggal_jadwal'    => 'required|date'
        ]);

        $mahasiswa = $request->user()->mahasiswa;

        if (!$mahasiswa) {
            return response()->json(['message' => 'Profil mahasiswa tidak ditemukan'], 404);
        }

        $idHandler = $this->determineHandler($request->jenis_layanan, $mahasiswa);

        if (is_array($idHandler)) {
            return response()->json($idHandler, 422);
        }

        $ajuan = Ajuan::create([
            'nim'               => $mahasiswa->nim,
            'id_handler'        => $idHandler,
            'judul_konseling'   => $request->judul_konseling,
            'deskripsi_masalah' => $request->deskripsi_masalah,
            'jenis_layanan'     => $request->jenis_layanan,
            'tanggal_pengajuan' => now(),
            'tanggal_jadwal'    => $request->tanggal_jadwal,
            'status'            => 'pending',
            'tingkat_penanganan'=> 'Prodi'
        ]);

        return response()->json([
            'message' => 'Ajuan berhasil dibuat',
            'data'    => $ajuan
        ], 201);
    }

    public function show(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::with('handler')
            ->where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->first();

        if (!$ajuan) {
            return response()->json([
                'message' => 'Anda belum pernah membuat ajuan'
            ], 404);
        }

        return response()->json($ajuan);
    }

    public function update(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

        if ($request->has('status') && $request->status === 'setuju') {
            if ($ajuan->status === 'reschedule') {
                $ajuan->update(['status' => 'disetujui']);
            }
            elseif ($ajuan->status === 'reschedule wd3') {
                $ajuan->update(['status' => 'disetujui wd3']);
            }
            return response()->json(['message' => 'Jadwal disetujui', 'data' => $ajuan]);
        }

        if (!in_array($ajuan->status, ['pending', 'reschedule'])) {
            return response()->json([
                'message' => 'Ajuan tidak dapat diubah karena status sudah ' . $ajuan->status
            ], 403);
        }

        $updateData = $request->only(['judul_konseling', 'deskripsi_masalah', 'jenis_layanan', 'tanggal_jadwal']);

        if ($request->has('tanggal_jadwal')) {
            $updateData['status'] = 'pending';
        }

        if ($request->has('jenis_layanan') && $request->jenis_layanan !== $ajuan->jenis_layanan) {
            $newHandler = $this->determineHandler($request->jenis_layanan, $mahasiswa);
            if (is_array($newHandler)) return response()->json($newHandler, 422);
            $updateData['id_handler'] = $newHandler;
        }

        $ajuan->update($updateData);

        return response()->json([
            'message' => 'Ajuan berhasil diperbarui',
            'data'    => $ajuan
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $mahasiswa = $request->user()->mahasiswa;

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('nim', $mahasiswa->nim)
            ->firstOrFail();

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

    private function determineHandler($jenis, $mahasiswa)
    {
        if ($jenis === 'Akademik' || $jenis === 'Karir') {
            $idHandler = $mahasiswa->id_dosen_pa;
            if (!$idHandler) {
                return ['message' => 'Anda belum memiliki Dosen PA. Hubungi Admin.'];
            }
            return $idHandler;
        }
        else if ($jenis === 'Pribadi' || $jenis === 'Sosial') {
            $konselor = Staff::where('jabatan', 'Konselor')->first();
            if (!$konselor) {
                return ['message' => 'Data Konselor belum tersedia di sistem.'];
            }
            return $konselor->id_staff;
        }
        return null;
    }
}
