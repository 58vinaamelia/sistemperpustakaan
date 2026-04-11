<?php

namespace App\Http\Controllers\Kepala;

use App\Models\User;
use App\Models\Kepala\Buku;
use App\Models\Kepala\PinjamBuku;
use Carbon\Carbon;

class DashboardController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $totalAnggota = User::where('role', 'anggota')->count();

        $totalBuku = Buku::count();

        $totalPeminjaman = PinjamBuku::count();

        // 🔥 HITUNG PEMINJAMAN TERLAMBAT (FIX TOTAL)
        $peminjamanTerlambat = PinjamBuku::get()->filter(function ($item) {

            // kalau tidak ada tanggal pinjam, skip
            if (!$item->tanggal_pinjam) return false;

            // jatuh tempo = tgl pinjam + 7 hari
            $jatuhTempo = Carbon::parse($item->tanggal_pinjam)->addDays(7);

            // pakai tanggal kembali kalau ada
            $tanggalCek = $item->tanggal_kembali
                ? Carbon::parse($item->tanggal_kembali)
                : Carbon::now();

            // cek apakah lewat jatuh tempo
            return $tanggalCek->gt($jatuhTempo);
        })->count();

        return view('pages.kepala.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalPeminjaman',
            'peminjamanTerlambat'
        ));
    }
}
