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
        $buku = Buku::findOrFail($id);

        // ❗ CEK SUDAH PINJAM / PENDING
        $cek = Pinjambuku::where('user_id', Auth::id())
            ->where('buku_id', $id)
            ->whereIn('status', ['dipinjam', 'pending'])
            ->exists();

        if ($cek) {
            return back()->with('error', 'Kamu sudah meminjam buku ini');
        }

        // ❗ CEK SEDANG DIPINJAM ORANG LAIN
        $dipinjam = Pinjambuku::where('buku_id', $id)
            ->where('status', 'dipinjam')
            ->exists();

        if ($dipinjam) {
            return back()->with('error', 'Buku sedang dipinjam orang lain');
        }

        // ❗ CEK STOK
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
