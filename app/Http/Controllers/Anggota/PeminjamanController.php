<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Pinjambuku;
use App\Models\Anggota\Buku;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends \Illuminate\Routing\Controller
{
    /**
     * 📋 Tampilkan tabel peminjaman anggota
     */
    public function index()
    {
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
        $data = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.anggota.peminjaman.detail', compact('data'));
    }

    /**
     * 🗑 Hapus peminjaman + kembalikan stok
     */
    public function destroy($id)
    {
        $data = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // ✅ CEK: kalau belum dikembalikan, stok dikembalikan
        if ($data->status != 'dikembalikan') {

            if ($data->buku) {
                $data->buku->stok += 1;
                $data->buku->save();
            }
        }

        $data->delete();

        return redirect()->route('anggota.peminjaman.index')
            ->with('success', 'Data berhasil dihapus & stok dikembalikan');
    }
}
