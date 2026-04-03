<?php

namespace App\Http\Controllers\Kepala;

use App\Models\User;
use App\Models\kepala\Buku;
use App\Models\kepala\Peminjaman;
use Illuminate\Support\Facades\Schema;

class DashboardController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        // TOTAL ANGGOTA
        $totalAnggota = User::where('role', 'anggota')->count();

        // TOTAL BUKU
        $totalBuku = Buku::count();

        // ✅ CEK DULU TABEL ADA ATAU TIDAK
        if (Schema::hasTable('peminjaman')) {
            $totalPeminjaman = Peminjaman::count();
        } else {
            $totalPeminjaman = 0;
        }

        // ❌ NONAKTIF (biar aman)
        $peminjamanTerlambat = 0;

        return view('pages.kepala.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalPeminjaman',
            'peminjamanTerlambat'
        ));
    }
}
