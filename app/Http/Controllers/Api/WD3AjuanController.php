<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;

class WD3AjuanController extends Controller
{
    // Melihat ajuan yang dirujuk ke tingkat Fakultas
    public function index()
    {
        $data = Ajuan::with(['mahasiswa', 'handler'])
            ->where('tingkat_penanganan', 'Fakultas')
            ->get();
            
        return response()->json($data);
    }

    // WD3 menentukan jadwal pertemuan (Jadwal ditentukan WD3 sendiri)
    public function setJadwal(Request $request, $id)
    {
        $request->validate([
            'tanggal_jadwal' => 'required|date',
        ]);

        $ajuan = Ajuan::where('id_ajuan', $id)
            ->where('tingkat_penanganan', 'Fakultas')
            ->firstOrFail();

        $ajuan->update([
            'tanggal_jadwal' => $request->tanggal_jadwal,
            'status' => 'disetujui' // Status menjadi disetujui setelah WD3 set jadwal
        ]);

        return response()->json(['message' => 'Jadwal telah ditentukan oleh WD3', 'data' => $ajuan]);
    }

    // Update Selesai atau Rujuk ke Universitas
    public function complete(Request $request, $id)
    {
        $request->validate([
            'catatan_sesi' => 'required',
            'tingkat_penanganan' => 'required|in:Fakultas,Universitas',
        ]);

        $ajuan = Ajuan::where('id_ajuan', $id)->firstOrFail();

        $ajuan->update([
            'catatan_sesi' => $request->catatan_sesi,
            'tingkat_penanganan' => $request->tingkat_penanganan,
            'status' => ($request->tingkat_penanganan == 'Universitas') ? 'reschedule' : 'terkirim',
        ]);

        $message = $request->tingkat_penanganan == 'Universitas' 
            ? 'Ajuan dirujuk ke tingkat Universitas (Cetak Surat Rujukan)' 
            : 'Sesi konseling tingkat fakultas selesai';

        return response()->json(['message' => $message, 'data' => $ajuan]);
    }
}
