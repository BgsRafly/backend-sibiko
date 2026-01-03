<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ajuan;

class StaffController extends Controller
{
    public function dashboard()
    {
        return response()->json([
            'message' => 'Dashboard Staff',
            'role' => auth()->user()->role
        ]);
    }

    public function listAjuan()
    {
        return response()->json(
            Ajuan::with('mahasiswa')->get()
        );
    }
}
