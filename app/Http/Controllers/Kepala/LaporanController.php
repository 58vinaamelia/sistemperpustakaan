<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Models\Anggota\PinjamBuku;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends \Illuminate\Routing\Controller
{
    // =========================
    // INDEX (HALAMAN UTAMA)
    // =========================
    public function index(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

        // FILTER BULAN
        if ($request->filled('bulan')) {
            $bulan = explode('-', $request->bulan);

            $query->whereYear('tanggal_pinjam', $bulan[0])
                  ->whereMonth('tanggal_pinjam', $bulan[1]);
        }

        // FILTER RANGE
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

    // =========================
    // CETAK (PRINT)
    // =========================
    public function cetak(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

        // 🔥 BIAR FILTER IKUT KE CETAK
        if ($request->filled('bulan')) {
            $bulan = explode('-', $request->bulan);

            $query->whereYear('tanggal_pinjam', $bulan[0])
                  ->whereMonth('tanggal_pinjam', $bulan[1]);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();

        return view('pages.kepala.laporan.cetak', compact('peminjaman'));
    }

    // =========================
    // PDF DOWNLOAD
    // =========================
    public function pdf(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

        // 🔥 FILTER IKUT KE PDF
        if ($request->filled('bulan')) {
            $bulan = explode('-', $request->bulan);

            $query->whereYear('tanggal_pinjam', $bulan[0])
                  ->whereMonth('tanggal_pinjam', $bulan[1]);
        }

        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')->get();

        $pdf = Pdf::loadView('pages.kepala.laporan.cetak', compact('peminjaman'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}
