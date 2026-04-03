<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas\Pengembalian;
use App\Models\Petugas\Peminjaman;
use App\Models\Anggota\Pinjambuku; // 🔥 WAJIB TAMBAH INI
use Illuminate\Http\Request;

class PengembalianController extends \Illuminate\Routing\Controller
{
    // ==========================
    // TAMPIL DATA
    // ==========================
    public function index()
    {
        $data = Pengembalian::with(['user', 'buku'])->latest()->get();
        return view('pages.petugas.pengembalian.index', compact('data'));
    }

    // ==========================
    // TERIMA PENGEMBALIAN (FIX TOTAL)
    // ==========================
    public function terima($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        // 1. update status pengembalian
        $pengembalian->status = 'diterima';
        $pengembalian->save();

        // 2. update peminjaman (tabel petugas)
        if ($pengembalian->peminjaman_id) {
            $peminjaman = Peminjaman::find($pengembalian->peminjaman_id);

            if ($peminjaman) {
                $peminjaman->status = 'selesai';
                $peminjaman->save();
            }
        }

        // 3. 🔥 UPDATE PINJAMBUKU (BIAR ANGGOTA IKUT BERUBAH)
        $pinjam = Pinjambuku::where('user_id', $pengembalian->user_id)
            ->where('buku_id', $pengembalian->buku_id)
            ->whereIn('status', ['pending', 'dipinjam', 'menunggu'])
            ->get();

        foreach ($pinjam as $p) {
            $p->status = 'dikembalikan'; // 🔥 INI YANG BIKIN BERUBAH
            $p->save();
        }

        return back()->with('success', 'Pengembalian dikonfirmasi & semua status berhasil diupdate');
    }

    // ==========================
    // TOLAK PENGEMBALIAN
    // ==========================
    public function tolak($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->status = 'ditolak';
        $pengembalian->save();

        return back()->with('error', 'Pengembalian ditolak');
    }

    // ==========================
    // DELETE DATA
    // ==========================
    public function delete($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
