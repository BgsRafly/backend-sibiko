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
    public function index()
    {
        $data = Ajuan::with(['mahasiswa', 'handler'])->where('tingkat_penanganan', 'Fakultas')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $ajuan = Ajuan::with(['mahasiswa', 'handler'])->where('id_ajuan', $id)->where('tingkat_penanganan', 'Fakultas')->firstOrFail();
        return response()->json($ajuan);
    }

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
            'status' => 'reschedule wd3'
        ]);

        return response()->json(['message' => 'Jadwal telah ditawarkan ke mahasiswa', 'data' => $ajuan]);
    }

    public function complete(Request $request, $id)
    {
        $request->validate([
            'catatan_sesi' => 'required',
            'tingkat_penanganan' => 'required|in:Fakultas,Universitas',
        ]);

        $ajuan = Ajuan::where('id_ajuan', $id)->firstOrFail();

        return DB::transaction(function () use ($request, $ajuan) {
            $statusBaru = ($request->tingkat_penanganan == 'Universitas')
                ? 'rujuk universitas'
                : 'selesai';

            $ajuan->update([
                'catatan_wd3' => $request->catatan_sesi,
                'tingkat_penanganan' => $request->tingkat_penanganan,
                'status' => $statusBaru,
            ]);

            if ($request->tingkat_penanganan == 'Universitas') {
                $nomorSurat = 'SR/' . $ajuan->id_ajuan . '/WD3/' . Carbon::now()->format('Y');
                SuratRujukan::create([
                    'id_ajuan' => $ajuan->id_ajuan,
                    'nomor_surat' => $nomorSurat,
                    'keterangan_universitas' => $request->catatan_sesi,
                    'tanggal_cetak' => Carbon::now()->toDateString(),
                ]);
            }

            $message = $request->tingkat_penanganan == 'Universitas'
                ? 'Ajuan berhasil dirujuk ke Universitas.'
                : 'Sesi tingkat fakultas selesai.';

            return response()->json(['message' => 'Status diperbarui', 'data' => $ajuan]);
        });
    }

    public function cetakRujukan($id)
    {
        $ajuan = Ajuan::with(['mahasiswa', 'suratRujukan'])
            ->where('id_ajuan', $id)
            ->where('tingkat_penanganan', 'Universitas')
            ->firstOrFail();

        if (!$ajuan->suratRujukan) {
            return response()->json(['message' => 'Data rujukan belum dibuat'], 404);
        }

        $tanggalCetak = Carbon::parse($ajuan->suratRujukan->tanggal_cetak)->locale('id')->isoFormat('DD MMMM YYYY');

        return response()->json([
            'message' => 'Data siap cetak',
            'data' => [
                'nomor_surat' => $ajuan->suratRujukan->nomor_surat,
                'tanggal' => $tanggalCetak,
                'perihal' => 'Rujukan Penanganan Konseling Mahasiswa',
                'mahasiswa' => [
                    'nama' => $ajuan->mahasiswa->nama_lengkap,
                    'nim' => $ajuan->mahasiswa->nim,
                    'prodi' => $ajuan->mahasiswa->prodi,
                    'fakultas' => 'Matematika dan Ilmu Pengetahuan Alam'
                ],
                'keterangan' => $ajuan->suratRujukan->keterangan_universitas
            ]
        ]);
    }
}
