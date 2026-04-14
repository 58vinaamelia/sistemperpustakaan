<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Models\Anggota\PinjamBuku;
use App\Models\Anggota\Pengembalian;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanController extends \Illuminate\Routing\Controller
{
    // =========================
    // INDEX
    // =========================
    public function index(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

        // 🔥 FILTER BULAN
        if ($request->filled('bulan')) {
            $bulan = explode('-', $request->bulan);

            $query->whereYear('tanggal_pinjam', $bulan[0])
                  ->whereMonth('tanggal_pinjam', $bulan[1]);
        }

        // 🔥 FILTER RANGE
        if ($request->filled('dari') && $request->filled('sampai')) {
            $query->whereBetween('tanggal_pinjam', [
                $request->dari,
                $request->sampai
            ]);
        }

        $peminjaman = $query->orderBy('tanggal_pinjam', 'desc')
                            ->paginate(10);

        // 🔥 AMBIL DATA PENGEMBALIAN TERBARU
        foreach ($peminjaman as $item) {

            $pengembalian = Pengembalian::where('user_id', $item->user_id)
                ->where('buku_id', $item->buku_id)
                ->latest() // 🔥 penting
                ->first();

            $item->kondisi_buku = $pengembalian->kondisi_buku ?? null;
            $item->tanggal_kembali_real = $pengembalian->tanggal_kembali ?? null;
        }

        return view('pages.kepala.laporan.index', compact('peminjaman'));
    }

    // =========================
    // CETAK
    // =========================
    public function cetak(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

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

        foreach ($peminjaman as $item) {

            $pengembalian = Pengembalian::where('user_id', $item->user_id)
                ->where('buku_id', $item->buku_id)
                ->latest()
                ->first();

            $item->kondisi_buku = $pengembalian->kondisi_buku ?? null;
            $item->tanggal_kembali_real = $pengembalian->tanggal_kembali ?? null;
        }

        return view('pages.kepala.laporan.cetak', compact('peminjaman'));
    }

    // =========================
    // PDF
    // =========================
    public function pdf(Request $request)
    {
        $query = PinjamBuku::with(['user', 'buku']);

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

        foreach ($peminjaman as $item) {

            $pengembalian = Pengembalian::where('user_id', $item->user_id)
                ->where('buku_id', $item->buku_id)
                ->latest()
                ->first();

            $item->kondisi_buku = $pengembalian->kondisi_buku ?? null;
            $item->tanggal_kembali_real = $pengembalian->tanggal_kembali ?? null;
        }

        $pdf = Pdf::loadView('pages.kepala.laporan.cetak', compact('peminjaman'));

        return $pdf->download('laporan-peminjaman.pdf');
    }
}
