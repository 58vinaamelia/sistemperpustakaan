<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Petugas\Buku; // 🔥 FIX: pakai model petugas
use App\Models\Anggota\Pinjambuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BukuController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        // 🔥 FIX: pakai relasi biar stokTersedia jalan
        $query = Buku::with('pinjambuku')
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->where('judul', 'like', "%$search%")
                        ->orWhere('pengarang', 'like', "%$search%");
                });
            });

        if ($request->lihat_semua) {
            $buku = $query->latest()->get();
        } else {
            $buku = $query->latest()->limit(6)->get();
        }

        // 🔥 ambil buku yang sedang dipinjam user
        $bukuDipinjam = Pinjambuku::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->pluck('buku_id')
            ->toArray();

        // 🔥 set flag
        foreach ($buku as $item) {
            $item->dipinjam_sendiri = in_array($item->id, $bukuDipinjam);
        }

        return view('pages.anggota.buku.index', compact('buku'));
    }

    public function detail($id)
    {
        $buku = Buku::with('pinjambuku')->findOrFail($id);

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

        $buku = Buku::with('pinjambuku')->findOrFail($id);

        // 🔥 max 3 buku
        $jumlahPinjam = Pinjambuku::where('user_id', $userId)
            ->whereIn('status', ['pending', 'dipinjam'])
            ->count();

        if ($jumlahPinjam >= 3) {
            return back()->with('error', 'Maksimal 3 buku!');
        }

        // 🔥 FIX: pakai stok real
        if ($buku->stokTersedia() <= 0) {
            return back()->with('error', 'Stok habis!');
        }

        // 🔥 SIMPAN PENDING
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
