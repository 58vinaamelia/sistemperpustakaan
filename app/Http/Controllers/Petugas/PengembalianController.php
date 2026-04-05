<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas\Pengembalian;
use App\Models\Petugas\Peminjaman;
use App\Models\Anggota\Pinjambuku; // 🔥 pastikan ini model anggota/anggota pinjam buku
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
    public function terima(Request $request, $id)
{
    $pengembalian = Pengembalian::findOrFail($id);

    // ✅ ambil tanggal dari pengajuan anggota
    $tanggal = $pengembalian->tanggal_kembali;

    // 1️⃣ Update status pengembalian
    $pengembalian->status = 'diterima';
    $pengembalian->save();

    // 2️⃣ Update peminjaman
    if ($pengembalian->peminjaman_id) {
        $peminjaman = Peminjaman::find($pengembalian->peminjaman_id);

        if ($peminjaman) {
            $peminjaman->status = 'selesai';
            $peminjaman->tanggal_kembali = $tanggal; // ✅ FIX
            $peminjaman->save();
        }
    }

    // 3️⃣ Update pinjam buku
    $pinjam = Pinjambuku::where('user_id', $pengembalian->user_id)
        ->where('buku_id', $pengembalian->buku_id)
        ->get();

    foreach ($pinjam as $p) {
        $p->status = 'dikembalikan';
        $p->tanggal_kembali = $tanggal; // ✅ FIX
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
