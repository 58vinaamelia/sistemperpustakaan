<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Models\Anggota\Pinjambuku;
use App\Models\Anggota\Buku;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PinjamBukuController extends \Illuminate\Routing\Controller
{
    /**
     * 📋 LIST PEMINJAMAN USER
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
     * ➕ FORM PINJAM
     */
    public function create()
    {
        return view('pages.anggota.pinjambuku.create');
    }

    /**
     * 💾 SIMPAN DATA
     */
    public function store(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        $buku = Buku::findOrFail($id);

        // ❗ CEK: sudah pinjam belum (yang masih aktif)
        $cek = Pinjambuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->exists();

        if ($cek) {
            return back()->with('error', 'Kamu masih meminjam buku ini');
        }

        // ❗ CEK stok
        if ($buku->stok <= 0) {
            return back()->with('error', 'Stok buku habis');
        }

        // ✅ SIMPAN DATA
        Pinjambuku::create([
            'user_id' => Auth::id(),
            'nama' => Auth::user()->name,
            'buku_id' => $buku->id,
            'tanggal_pinjam' => Carbon::today(),
            'tanggal_jatuh_tempo' => Carbon::today()->addDays(7),
            'status' => 'pending'
        ]);

        return redirect()->route('anggota.peminjaman.index')
            ->with('success', 'Menunggu konfirmasi petugas');
    }
}
