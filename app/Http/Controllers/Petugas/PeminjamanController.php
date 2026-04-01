<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Anggota\Pinjambuku;
use Illuminate\Routing\Controller;

class PeminjamanController extends Controller
{
    /**
     * 📋 LIST DATA
     */
    public function index()
    {
        $peminjaman = Pinjambuku::with(['user', 'buku'])
                        ->latest()
                        ->paginate(10);

        return view('pages.petugas.peminjaman.index', compact('peminjaman'));
    }

    /**
     * 🔍 DETAIL
     */
    public function show($id)
    {
        $item = Pinjambuku::with(['user', 'buku'])->findOrFail($id);
        return view('pages.petugas.peminjaman.show', compact('item'));
    }

    /**
     * ✅ KONFIRMASI
     */
    public function konfirmasi($id)
    {
        $pinjam = Pinjambuku::with('buku')->findOrFail($id);

        // default status
        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        // hanya pending
        if ($pinjam->status !== 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        // ubah status
        $pinjam->update([
            'status' => 'dipinjam'
        ]);

        // kurangi stok
        if ($pinjam->buku && $pinjam->buku->stok > 0) {
            $pinjam->buku->decrement('stok');
        }

        return back()->with('success', 'Peminjaman disetujui');
    }

    /**
     * ❌ TOLAK
     */
    public function tolak($id)
    {
        $pinjam = Pinjambuku::findOrFail($id);

        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        if ($pinjam->status !== 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        $pinjam->update([
            'status' => 'ditolak'
        ]);

        return back()->with('success', 'Peminjaman ditolak');
    }

    /**
     * 🔁 KEMBALIKAN (FINAL - AUTO SELESAI / TELAT)
     */
    public function kembalikan($id)
    {
        $pinjam = Pinjambuku::with('buku')->findOrFail($id);

        // hanya jika sedang dipinjam
        if ($pinjam->status !== 'dipinjam') {
            return back()->with('success', 'Data tidak valid untuk dikembalikan');
        }

        $today = now();

        // tentukan status
        if ($pinjam->tanggal_jatuh_tempo && $today->gt($pinjam->tanggal_jatuh_tempo)) {
            $hariTelat = $today->diffInDays($pinjam->tanggal_jatuh_tempo);

            $pinjam->update([
                'tanggal_kembali' => $today,
                'status' => 'telat',
                'denda' => $hariTelat * 1000
            ]);
        } else {
            $pinjam->update([
                'tanggal_kembali' => $today,
                'status' => 'selesai',
                'denda' => 0
            ]);
        }

        // tambah stok kembali
        if ($pinjam->buku) {
            $pinjam->buku->increment('stok');
        }

        return back()->with('success', 'Buku berhasil dikembalikan');
    }

    /**
     * 🗑 HAPUS
     */
    public function destroy($id)
    {
        $item = Pinjambuku::findOrFail($id);
        $item->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
