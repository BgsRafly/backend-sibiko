<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mahasiswa;
use App\Models\Staff;
use App\Models\Ajuan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        $userStats = User::select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->get();

        $ajuanStats = Ajuan::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();

        $tingkatStats = Ajuan::select('tingkat_penanganan', DB::raw('count(*) as total'))
            ->groupBy('tingkat_penanganan')
            ->get();

        return response()->json([
            'summary' => [
                'total_mahasiswa' => Mahasiswa::count(),
                'total_staff' => Staff::where('jabatan', '!=', 'Admin')->count(),
                'total_ajuan' => Ajuan::count(),
            ],
            'user_distribution' => $userStats,
            'ajuan_status_breakdown' => $ajuanStats,
            'handling_level_breakdown' => $tingkatStats,
            'latest_activities' => [
                'recent_ajuan' => Ajuan::with('mahasiswa')
                    ->latest('tanggal_pengajuan')
                    ->take(5)
                    ->get(),
                'urgent_referrals' => Ajuan::with('mahasiswa')
                    ->where('tingkat_penanganan', 'Fakultas')
                    ->where('status', 'pending')
                    ->take(5)
                    ->get()
            ]
        ]);
    }

    public function allAjuan(Request $request)
    {
        $query = Ajuan::with(['mahasiswa', 'handler']);

        if ($request->filled('jenis') && $request->jenis != 'Semua') {
            $query->where('jenis_layanan', $request->jenis);
        }

        if ($request->filled('status') && $request->status != 'Semua') {
            if (str_contains($request->status, ',')) {
                $statuses = explode(',', $request->status);
                $query->whereIn('status', $statuses);
            } else {
                $query->where('status', $request->status);
            }
        }

        if ($request->has('start_date') && $request->has('end_date') && $request->start_date != '' && $request->end_date != '') {
            $query->whereBetween('tanggal_pengajuan', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        return response()->json($query->latest('tanggal_pengajuan')->get());
    }

    public function storeMahasiswa(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:users,username',
            'password'     => 'required|min:6',
            'email'        => 'required|email|unique:mahasiswa,email',
            'nama_lengkap' => 'required',
            'prodi'        => 'required',
            'id_dosen_pa'  => 'nullable|exists:staff,id_staff'
        ]);

        return DB::transaction(function () use ($request) {
            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'name'     => $request->nama_lengkap,
                'email'    => $request->email,
                'role'     => 'mahasiswa'
            ]);

            $mahasiswa = Mahasiswa::create([
                'nim'          => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'prodi'        => $request->prodi,
                'email'        => $request->email,
                'no_hp'        => $request->no_hp ?? '-',
                'id_dosen_pa'  => $request->id_dosen_pa,
                'id_user'      => $user->id
            ]);

            return response()->json(['message' => 'Mahasiswa berhasil ditambahkan', 'data' => $mahasiswa], 201);
        });
    }

    public function indexMahasiswa()
    {
        return response()->json(Mahasiswa::with(['user', 'staff'])->get());
    }

    public function showMahasiswa($id_user)
    {
        $mahasiswa = Mahasiswa::with(['user', 'staff'])->where('id_user', $id_user)->firstOrFail();
        return response()->json($mahasiswa);
    }

    public function updateMahasiswa(Request $request, $id_user)
    {
        $mahasiswa = Mahasiswa::where('id_user', $id_user)->firstOrFail();
        $user = User::findOrFail($id_user);

        $request->validate([
            'nama_lengkap' => 'sometimes|required',
            'email' => 'sometimes|required|email',
            'id_dosen_pa' => 'nullable|exists:staff,id_staff',
            'password' => 'nullable|min:6'
        ]);

        return DB::transaction(function () use ($request, $mahasiswa, $user) {
            $mahasiswa->update($request->only(['nama_lengkap', 'prodi', 'email', 'no_hp', 'id_dosen_pa']));

            if ($request->has('username')) $user->update(['username' => $request->username]);
            if ($request->has('email')) $user->update(['email' => $request->email]);

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            return response()->json(['message' => 'Mahasiswa berhasil diperbarui', 'data' => $mahasiswa->load('user')]);
        });
    }

    public function destroyMahasiswa($id_user)
    {
        return DB::transaction(function () use ($id_user) {
            $user = User::findOrFail($id_user);
            $user->delete();
            return response()->json(['message' => 'User dan Data Mahasiswa berhasil dihapus']);
        });
    }

    public function storeStaff(Request $request)
    {
        $request->validate([
            'username'     => 'required|unique:users,username',
            'password'     => 'required|min:6',
            'nama_lengkap' => 'required',
            'jabatan'      => 'required|in:Dosen PA,Konselor,Wakil Dekan 3,Admin',
            'email'        => 'nullable|email',
            'no_hp'        => 'nullable|string'
        ]);

        return DB::transaction(function () use ($request) {
            $roleUser = 'dosen';
            if ($request->jabatan === 'Admin') $roleUser = 'admin';
            if ($request->jabatan === 'Wakil Dekan 3') $roleUser = 'wd3';
            if ($request->jabatan === 'Konselor') $roleUser = 'konselor';

            $user = User::create([
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'name'     => $request->nama_lengkap,
                'email'    => $request->email ?? ($request->username . '@unud.ac.id'),
                'role'     => $roleUser
            ]);

            $staff = Staff::create([
                'nip'          => $request->username,
                'nama_lengkap' => $request->nama_lengkap,
                'jabatan'      => $request->jabatan,
                'email'        => $request->email,
                'no_hp'        => $request->no_hp,
                'id_user'      => $user->id
            ]);

            return response()->json(['message' => 'Staff berhasil ditambahkan', 'data' => $staff], 201);
        });
    }

    public function indexStaff()
    {
        return response()->json(Staff::with('user')->get());
    }

    public function showStaff($id_user)
    {
        return response()->json(Staff::with('user')->where('id_user', $id_user)->firstOrFail());
    }

    public function updateStaff(Request $request, $id_user)
    {
        $staff = Staff::where('id_user', $id_user)->firstOrFail();
        $user = User::findOrFail($id_user);

        $request->validate([
            'nama_lengkap' => 'sometimes|required',
            'jabatan' => 'sometimes|required|in:Dosen PA,Konselor,Wakil Dekan 3,Admin',
            'email' => 'nullable|email',
            'no_hp' => 'nullable|string',
            'password' => 'nullable|min:6'
        ]);

        return DB::transaction(function () use ($request, $staff, $user) {
            $staff->update($request->only(['nama_lengkap', 'jabatan', 'nip', 'email', 'no_hp']));

            if ($request->has('username')) $user->update(['username' => $request->username]);
            if ($request->has('email')) $user->update(['email' => $request->email]);

            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($request->password)]);
            }

            return response()->json(['message' => 'Staff berhasil diperbarui', 'data' => $staff->load('user')]);
        });
    }

    public function destroyStaff($id_user)
    {
        return DB::transaction(function () use ($id_user) {
            $user = User::findOrFail($id_user);
            $user->delete();
            return response()->json(['message' => 'User dan Data Staff berhasil dihapus']);
        });
    }

    public function laporan(Request $request)
    {
        $query = Ajuan::with(['mahasiswa', 'handler']);

        if ($request->has('jenis') && $request->jenis != 'Semua') {
            $query->where('jenis_layanan', $request->jenis);
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('tanggal_pengajuan', [
                $request->start_date . ' 00:00:00',
                $request->end_date . ' 23:59:59'
            ]);
        }

        return response()->json($query->latest('tanggal_pengajuan')->get());
    }
}
