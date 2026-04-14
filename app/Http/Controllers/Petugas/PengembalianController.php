<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Petugas\Pengembalian;
use App\Models\Petugas\Peminjaman;
use App\Models\Anggota\Pinjambuku;
use Illuminate\Http\Request;

class PengembalianController extends \Illuminate\Routing\Controller
{
    // ==========================
    // TAMPIL DATA
    // ==========================
    public function index()
    {
        $data = Pengembalian::with(['user', 'buku'])
            ->latest()
            ->get();

        return view('pages.petugas.pengembalian.index', compact('data'));
    }

    // ==========================
    // TERIMA PENGEMBALIAN
    // ==========================
    public function terima($id)
    {
        $pengembalian = Pengembalian::with('buku')->findOrFail($id);

        $tanggal = $pengembalian->tanggal_kembali;

        // ✅ STATUS PENGEMBALIAN
        $pengembalian->status = 'diterima';
        $pengembalian->save();

        // ==========================
        // UPDATE PEMINJAMAN
        // ==========================
        if ($pengembalian->peminjaman_id) {
            $peminjaman = Peminjaman::find($pengembalian->peminjaman_id);

            if ($peminjaman) {
                $peminjaman->status = 'selesai';
                $peminjaman->tanggal_kembali = $tanggal;
                $peminjaman->save();
            }
        }

        // ==========================
        // UPDATE PINJAM BUKU (ANGGOTA)
        // ==========================
        $pinjam = Pinjambuku::where('user_id', $pengembalian->user_id)
            ->where('buku_id', $pengembalian->buku_id)
            ->get();

        foreach ($pinjam as $p) {
            $p->status = 'selesai'; // 🔥 samakan semua jadi selesai
            $p->tanggal_kembali = $tanggal;
            $p->save();
        }

        return back()->with('success', 'Pengembalian diterima');
    }

    // ==========================
    // TOLAK
    // ==========================
    public function tolak($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $pengembalian->status = 'ditolak';
        $pengembalian->save();

        // 🔥 BALIKIN STATUS KE DIPINJAM
        $pinjam = Pinjambuku::where('user_id', $pengembalian->user_id)
            ->where('buku_id', $pengembalian->buku_id)
            ->get();

        foreach ($pinjam as $p) {
            $p->status = 'dipinjam';
            $p->save();
        }

        return back()->with('error', 'Pengembalian ditolak');
    }

    // ==========================
    // LIHAT STRUK
    // ==========================
    public function struk($id)
    {
        $data = Pengembalian::with('buku')->findOrFail($id);

        return view('pages.petugas.pengembalian.struk', [
            'nama' => $data->nama,
            'judul' => $data->buku->judul ?? '-',
            'tanggal_pinjam' => $data->tanggal_pinjam,
            'tanggal_kembali' => $data->tanggal_kembali,
            'denda' => $data->denda,
            'status' => strtoupper($data->status) // 🔥 ambil dari DB
        ]);
    }

    // ==========================
    // DELETE
    // ==========================
    public function delete($id)
    {
        $pengembalian = Pengembalian::findOrFail($id);
        $pengembalian->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
