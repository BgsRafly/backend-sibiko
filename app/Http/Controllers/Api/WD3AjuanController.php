<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;
use App\Models\SuratRujukan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

    return DB::transaction(function () use ($request, $ajuan) {
        // 1. Update status ajuan
        $ajuan->update([
            'catatan_sesi' => $request->catatan_sesi,
            'tingkat_penanganan' => $request->tingkat_penanganan,
            'status' => ($request->tingkat_penanganan == 'Universitas') ? 'reschedule' : 'terkirim',
        ]);

        // 2. Jika dirujuk ke Universitas, buat record Surat Rujukan
        if ($request->tingkat_penanganan == 'Universitas') {
            $nomorSurat = 'SR/' . $ajuan->id_ajuan . '/WD3/' . Carbon::now()->format('Y');
            
            SuratRujukan::create([
                'id_ajuan' => $ajuan->id_ajuan,
                'nomor_surat' => $nomorSurat,
                'keterangan_universitas' => $request->catatan_sesi, // Menggunakan catatan WD3
                'tanggal_cetak' => Carbon::now()->toDateString(),
            ]);
        }

        $message = $request->tingkat_penanganan == 'Universitas' 
            ? 'Ajuan berhasil dirujuk ke Universitas dan nomor surat telah digenerate.' 
            : 'Sesi tingkat fakultas selesai.';

        return response()->json(['message' => $message, 'data' => $ajuan]);
    });
}

public function cetakRujukan($id)
{
    // Mengambil data ajuan beserta detail rujukan dari tabel surat_rujukan
    $ajuan = Ajuan::with(['mahasiswa', 'suratRujukan'])
        ->where('id_ajuan', $id)
        ->where('tingkat_penanganan', 'Universitas')
        ->firstOrFail();

    if (!$ajuan->suratRujukan) {
        return response()->json(['message' => 'Data rujukan belum dibuat'], 404);
    }

    return response()->json([
        'message' => 'Data siap cetak',
        'data' => [
            'nomor_surat' => $ajuan->suratRujukan->nomor_surat,
            'mahasiswa' => $ajuan->mahasiswa->nama_lengkap,
            'nim' => $ajuan->mahasiswa->nim,
            'keterangan' => $ajuan->suratRujukan->keterangan_universitas,
            'tanggal' => $ajuan->suratRujukan->tanggal_cetak,
        ]
    ]);
}
}
