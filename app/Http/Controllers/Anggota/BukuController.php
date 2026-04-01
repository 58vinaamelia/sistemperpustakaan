<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Buku;
use App\Models\Anggota\Pinjambuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BukuController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $buku = Buku::when($search, function ($query, $search) {
            $query->where('judul', 'like', "%$search%")
                  ->orWhere('pengarang', 'like', "%$search%");
        })->get();

        return view('pages.anggota.buku.index', compact('buku'));
    }

    public function detail($id)
    {
        $buku = Buku::findOrFail($id);

        // 🔥 FIX: pakai huruf kecil
        $dipinjam = Pinjambuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        return view('pages.anggota.buku.detail', compact('buku', 'dipinjam'));
    }

    public function formPinjam($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.anggota.buku.create', compact('buku'));
    }

    public function pinjam($id)
    {
        $buku = Buku::findOrFail($id);

        // 🔥 FIX: huruf kecil
        $cek = Pinjambuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Kamu sudah meminjam buku ini');
        }

        if ($buku->stok > 0) {

            // ❌ HAPUS INI (stok jangan dikurangi di sini)
            // $buku->decrement('stok');

            Pinjambuku::create([
                'user_id' => Auth::id(),
                'nama' => Auth::user()->name,
                'buku_id' => $buku->id,
                'tanggal_pinjam' => Carbon::today(),
                'tanggal_jatuh_tempo' => Carbon::today()->addDays(7),

                // 🔥 PALING PENTING
                'status' => 'pending'
            ]);

            return redirect()->route('anggota.peminjaman.index')
                ->with('success', 'Menunggu konfirmasi petugas');
        }

        return back()->with('error', 'Stok habis');
    }
}
