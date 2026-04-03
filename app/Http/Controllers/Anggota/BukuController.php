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

        // 🔥 TAMBAHAN: CEK STATUS DIPINJAM
        foreach ($buku as $item) {
            $item->sedang_dipinjam = Pinjambuku::where('buku_id', $item->id)
                ->where('status', 'dipinjam')
                ->exists();
        }

        return view('pages.anggota.buku.index', compact('buku'));
    }

    public function detail($id)
    {
        $buku = Buku::findOrFail($id);

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

        $cek = Pinjambuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($cek) {
            return back()->with('error', 'Kamu sudah meminjam buku ini');
        }

        if ($buku->stok > 0) {

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

        return back()->with('error', 'Stok habis');
    }
}
