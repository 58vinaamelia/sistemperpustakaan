<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Pinjambuku;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends \Illuminate\Routing\Controller
{
    /**
     * 📋 Tampilkan tabel peminjaman anggota
     */
    public function index()
    {
        // Ambil hanya data milik anggota login, termasuk relasi buku
        $peminjaman = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.anggota.peminjaman.index', compact('peminjaman'));
    }

    /**
     * 🔍 Detail peminjaman
     */
    public function show($id)
    {
        // Pastikan hanya bisa melihat miliknya sendiri
        $data = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.anggota.peminjaman.detail', compact('data'));
    }

    /**
     * 🗑 Hapus peminjaman
     */
    public function destroy($id)
    {
        // Pastikan hanya bisa menghapus miliknya sendiri
        $data = Pinjambuku::where('user_id', Auth::id())
            ->findOrFail($id);

        $data->delete();

        return redirect()->route('anggota.peminjaman.index')
            ->with('success', 'Data berhasil dihapus');
    }
}
