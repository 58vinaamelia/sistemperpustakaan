<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Pinjambuku;
use App\Models\Anggota\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class PeminjamanController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $peminjaman = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.anggota.peminjaman.index', compact('peminjaman'));
    }

    public function show($id)
    {
        $data = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('pages.anggota.peminjaman.detail', compact('data'));
    }

    public function store(Request $request)
    {
        $userId = Auth::id();

        // 🔥 MAX 3 BUKU PER USER
        $jumlahPinjam = Pinjambuku::where('user_id', $userId)
            ->where('status', 'dipinjam')
            ->count();

        if ($jumlahPinjam >= 3) {
            return back()->with('error', 'Maksimal hanya boleh meminjam 3 buku!');
        }

        // 🔍 CEK BUKU
        $buku = Buku::findOrFail($request->buku_id);

        // ❌ STOK HABIS
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis!');
        }

        // 🔥 KURANGI STOK
        $buku->decrement('stok');

        // ✅ SIMPAN PINJAMAN
        Pinjambuku::create([
            'user_id' => $userId,
            'buku_id' => $request->buku_id,
            'tanggal_pinjam' => now(),
            'status' => 'dipinjam'
        ]);

        return back()->with('success', 'Buku berhasil dipinjam');
    }

    public function destroy($id)
    {
        $data = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // 🔥 KEMBALIKAN STOK JIKA MASIH DIPINJAM
        if ($data->status == 'dipinjam') {
            $data->buku->increment('stok');
        }

        $data->delete();

        return back()->with('success', 'Buku berhasil dikembalikan');
    }
}
