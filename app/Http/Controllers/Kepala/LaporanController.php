<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Models\Anggota\PinjamBuku;

class LaporanController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
{
    $query = PinjamBuku::with(['user', 'buku']);

    // FILTER BULAN (FIX)
    if ($request->filled('bulan')) {
        $bulan = explode('-', $request->bulan); // [2026, 01]

        $query->whereYear('tanggal_pinjam', $bulan[0])
              ->whereMonth('tanggal_pinjam', $bulan[1]);
    }

    // FILTER RANGE TANGGAL (FIX)
    if ($request->filled('dari') && $request->filled('sampai')) {
        $query->whereBetween('tanggal_pinjam', [
            $request->dari,
            $request->sampai
        ]);
    }

    $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')
                        ->paginate(10);

    return view('pages.kepala.laporan.index', compact('peminjaman'));
}

}
