<?php

namespace App\Http\Controllers\Kepala;

use App\Models\User;
use App\Models\Kepala\Buku;
use App\Models\Kepala\PinjamBuku;

class DashboardController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $totalAnggota = User::where('role', 'anggota')->count();

        $totalBuku = Buku::count();

        // ✅ SUDAH FIX
        $totalPeminjaman = PinjamBuku::count();

        $peminjamanTerlambat = 0;

        return view('pages.kepala.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalPeminjaman',
            'peminjamanTerlambat'
        ));
    }
}
