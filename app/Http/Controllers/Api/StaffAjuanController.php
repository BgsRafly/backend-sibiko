<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;
use Illuminate\Http\Request;

class StaffAjuanController extends Controller
{
    // Melihat daftar ajuan yang masuk ke Staff tersebut
    public function index(Request $request) {
        $staff = $request->user()->staff;
        
        $data = Ajuan::with('mahasiswa')
            ->where('id_handler', $staff->id_staff)
            ->get();

        return response()->json($data);
    }

    // Detail Ajuan
    public function show(Request $request, $id) {
        $staff = $request->user()->staff;
        
        $ajuan = Ajuan::with('mahasiswa')
            ->where('id_handler', $staff->id_staff)
            ->where('id_ajuan', $id)
            ->firstOrFail();

        return response()->json($ajuan);
    }

    // Update Status (Terima, Tolak, Reschedule)
    public function updateStatus(Request $request, $id) {
        $staff = $request->user()->staff;
        $ajuan = Ajuan::where('id_handler', $staff->id_staff)
            ->where('id_ajuan', $id)
            ->firstOrFail();

        $request->validate([
            'status' => 'required|in:disetujui,ditolak,reschedule',
            'alasan_penolakan' => 'required_if:status,ditolak',
            'tanggal_jadwal' => 'required_if:status,reschedule|date',
        ]);

        $ajuan->update([
            'status' => $request->status,
            'alasan_penolakan' => $request->alasan_penolakan ?? $ajuan->alasan_penolakan,
            'tanggal_jadwal' => $request->tanggal_jadwal ?? $ajuan->tanggal_jadwal,
        ]);

        return response()->json(['message' => 'Status ajuan diperbarui', 'data' => $ajuan]);
    }

    // Menyelesaikan Sesi (Selesai / Rujuk ke WD3)
    public function completeSession(Request $request, $id) {
        $staff = $request->user()->staff;
        $ajuan = Ajuan::where('id_handler', $staff->id_staff)
            ->where('id_ajuan', $id)
            ->firstOrFail();

        $request->validate([
            'catatan_sesi' => 'required',
            'tingkat_penanganan' => 'required|in:Prodi,Fakultas', // Fakultas berarti rujukan ke WD3
        ]);

        $ajuan->update([
            'catatan_sesi' => $request->catatan_sesi,
            'tingkat_penanganan' => $request->tingkat_penanganan,
            'status' => ($request->tingkat_penanganan == 'Fakultas') ? 'pending' : 'terkirim', 
            // Jika ke fakultas, id_handler harus diupdate ke ID WD3 (logika tambahan diperlukan)
        ]);

        return response()->json(['message' => 'Sesi diperbarui']);
    }
}
