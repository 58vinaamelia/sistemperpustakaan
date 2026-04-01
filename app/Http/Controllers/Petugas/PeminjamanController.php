<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Anggota\Pinjambuku;

class PeminjamanController extends \Illuminate\Routing\Controller
{
    /**
     * 📋 LIST DATA
     */
    public function index()
    {
        $peminjaman = Pinjambuku::with(['user','buku'])
                        ->latest()
                        ->paginate(10);

        return view('pages.petugas.peminjaman.index', compact('peminjaman'));
    }

    /**
     * 🔍 DETAIL
     */
    public function show($id)
    {
        $item = Pinjambuku::with(['user','buku'])->findOrFail($id);
        return view('pages.petugas.peminjaman.show', compact('item'));
    }

    /**
     * ✅ KONFIRMASI
     */
    public function konfirmasi($id)
    {
        $pinjam = Pinjambuku::with('buku')->findOrFail($id);

        // 🔥 FIX: kalau status kosong → jadi pending
        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        // 🔥 hanya bisa diproses kalau pending
        if ($pinjam->status != 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        // 🔥 ubah jadi dipinjam
        $pinjam->status = 'dipinjam';
        $pinjam->save();

        // 🔥 kurangi stok buku
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

        // 🔥 FIX: kalau kosong → pending
        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        // 🔥 hanya bisa ditolak kalau pending
        if ($pinjam->status != 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        // 🔥 ubah jadi ditolak
        $pinjam->status = 'ditolak';
        $pinjam->save();

        return back()->with('success', 'Peminjaman ditolak');
    }

    /**
     * 🔁 KEMBALIKAN
     */
    public function kembalikan($id)
    {
        $pinjam = Pinjambuku::with('buku')->findOrFail($id);

        // 🔥 hanya bisa dikembalikan kalau dipinjam
        if ($pinjam->status != 'dipinjam') {
            return back()->with('success', 'Buku belum dipinjam');
        }

        $today = now();
        $pinjam->tanggal_kembali = $today;

        // 🔥 cek telat atau tidak
        if ($today > $pinjam->tanggal_jatuh_tempo) {
            $hariTelat = $today->diffInDays($pinjam->tanggal_jatuh_tempo);
            $pinjam->denda = $hariTelat * 1000;
            $pinjam->status = 'telat';
        } else {
            $pinjam->status = 'selesai';
        }

        $pinjam->save();

        // 🔥 tambah stok kembali
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
