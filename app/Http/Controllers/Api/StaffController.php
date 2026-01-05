<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function dashboard(Request $request)
    {
        $staff = $request->user()->staff;
        $role = $request->user()->role;

        $query = \App\Models\Ajuan::where('id_handler', $staff->id_staff);

        if ($role === 'wd3') {
            $query = \App\Models\Ajuan::where('tingkat_penanganan', 'Fakultas');
        }

        $stats = [
            'total_masuk' => (clone $query)->count(),
            'perlu_tindakan' => (clone $query)->whereIn('status', ['pending', 'reschedule'])->count(),
            'jadwal_hari_ini' => (clone $query)
                ->where('status', 'disetujui')
                ->whereDate('tanggal_jadwal', now())
                ->count(),
            'total_mhs' => (clone $query)->distinct('nim')->count('nim')
        ];
    }

    public function listAjuan()
    {
        return response()->json(
            Ajuan::with('mahasiswa')->get()
        );
    }
}
