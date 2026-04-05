<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anggota\Pinjambuku; // ✅ ambil dari sini

class LaporanController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $query = Pinjambuku::with(['user', 'buku']);

        // filter tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }

        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        $peminjaman = $query->latest()->get();

        return view('pages.kepala.laporan.index', compact('peminjaman'));
    }
}
