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

        $query = Buku::when($search, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('judul', 'like', "%$search%")
                    ->orWhere('pengarang', 'like', "%$search%");
            });
        });

        // 🔥 FITUR TAMPIL 6 / SEMUA
        if ($request->lihat_semua) {
            $buku = $query->latest()->get();
        } else {
            $buku = $query->latest()->limit(6)->get();
        }

        // 🔥 AMBIL SEMUA BUKU YANG SEDANG DIPINJAM USER SEKALI QUERY
        $bukuDipinjam = Pinjambuku::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->pluck('buku_id')
            ->toArray();

        // 🔥 SET FLAG
        foreach ($buku as $item) {
            $item->dipinjam_sendiri = in_array($item->id, $bukuDipinjam);
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
    $userId = Auth::id();

    $buku = Buku::findOrFail($id);

    // 🔥 max 3 buku (pending + dipinjam)
    $jumlahPinjam = Pinjambuku::where('user_id', $userId)
        ->whereIn('status', ['pending', 'dipinjam'])
        ->count();

    if ($jumlahPinjam >= 3) {
        return back()->with('error', 'Maksimal 3 buku!');
    }

    // ❌ stok dicek saja (JANGAN dikurangi dulu)
    if ($buku->stok <= 0) {
        return back()->with('error', 'Stok habis!');
    }

    // ✅ SIMPAN SEBAGAI PENDING (INI KUNCI FIX)
    Pinjambuku::create([
        'user_id' => $userId,
        'nama' => Auth::user()->name,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => Carbon::today(),
        'tanggal_jatuh_tempo' => Carbon::today()->addDays(7),
        'status' => 'pending'
    ]);

    return redirect()->route('anggota.peminjaman.index')
        ->with('success', 'Permintaan pinjam sedang menunggu persetujuan petugas');
}

}
