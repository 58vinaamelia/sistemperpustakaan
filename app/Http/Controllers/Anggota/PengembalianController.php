<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Models\Anggota\Pinjambuku;
use App\Models\Anggota\Pengembalian;
use App\Models\Anggota\Buku;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $pengembalian = Pengembalian::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.anggota.pengembalian.index', compact('pengembalian'));
    }

    public function create()
    {
        $peminjaman = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->get();

        return view('pages.anggota.pengembalian.create', compact('peminjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tanggal_kembali' => 'required|date',
            'kondisi_buku' => 'required'
        ]);

        $pinjam = Pinjambuku::with('buku')
            ->where('buku_id', $request->buku_id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->first();

        if (!$pinjam) {
            return back()->with('error', 'Data peminjaman tidak ditemukan.');
        }

        $tglKembali = Carbon::parse($request->tanggal_kembali);
        $tglTempo   = Carbon::parse($pinjam->tanggal_jatuh_tempo);

        $denda = 0;

        // denda keterlambatan
        if ($tglKembali->gt($tglTempo)) {
            $hariTelat = $tglTempo->diffInDays($tglKembali);
            $denda += $hariTelat * 5000;
        }

        // denda kondisi
        if ($request->kondisi_buku == 'rusak') {
            $denda += 20000;
        }

        if ($request->kondisi_buku == 'hilang') {
            $denda += 50000;
        }

        // SIMPAN PENGEMBALIAN
        Pengembalian::create([
            'nama' => Auth::user()->name,
            'user_id' => Auth::id(),
            'buku_id' => $pinjam->buku_id,
            'tanggal_pinjam' => $pinjam->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $pinjam->tanggal_jatuh_tempo,
            'tanggal_kembali' => $tglKembali,
            'denda' => $denda,
            'kondisi_buku' => $request->kondisi_buku,
            'status' => 'menunggu',
        ]);

        // tambah stok jika tidak hilang
        if ($request->kondisi_buku != 'hilang' && $pinjam->buku) {
            $pinjam->buku->increment('stok');
        }

        // ubah status pinjaman
        $pinjam->update([
            'status' => 'menunggu'
        ]);

        $buku = Buku::find($pinjam->buku_id);

        return view('pages.anggota.pengembalian.struk', [
            'nama' => Auth::user()->name,
            'judul' => $buku?->judul ?? '-',
            'tanggal_pinjam' => $pinjam->tanggal_pinjam,
            'tanggal_kembali' => $tglKembali,
            'denda' => $denda,
            'kondisi_buku' => $request->kondisi_buku
        ]);
    }
}
