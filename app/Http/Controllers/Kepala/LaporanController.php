<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Anggota\Pinjambuku;

class LaporanController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        // validasi input tanggal
        $request->validate([
            'dari' => 'nullable|date',
            'sampai' => 'nullable|date|after_or_equal:dari',
        ]);

        $peminjaman = Pinjambuku::with(['user', 'buku'])
            ->when($request->dari, function ($query) use ($request) {
                $query->whereDate('tanggal_pinjam', '>=', $request->dari);
            })
            ->when($request->sampai, function ($query) use ($request) {
                $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
            })
            ->orderBy('tanggal_pinjam', 'desc') // urut terbaru
            ->get();

        return view('pages.kepala.laporan.index', compact('peminjaman'));
    }
}
