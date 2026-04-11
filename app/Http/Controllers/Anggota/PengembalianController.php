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
    // ==========================
    // INDEX
    // ==========================
    public function index()
    {
        $pengembalian = Pengembalian::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.anggota.pengembalian.index', compact('pengembalian'));
    }

    // ==========================
    // FORM CREATE
    // ==========================
    public function create()
    {
        $peminjaman = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->get();

        return view('pages.anggota.pengembalian.create', compact('peminjaman'));
    }

    // ==========================
    // STORE (PENGEMBALIAN)
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tanggal_kembali' => 'required|date',
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
        if ($tglKembali->gt($tglTempo)) {
            $hariTelat = $tglTempo->diffInDays($tglKembali);
            $denda = $hariTelat * 1000;
        }

        // ✅ SIMPAN DATA PENGEMBALIAN
        Pengembalian::create([
            'nama' => Auth::user()->name,
            'user_id' => Auth::id(),
            'buku_id' => $pinjam->buku_id,
            'tanggal_pinjam' => $pinjam->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $pinjam->tanggal_jatuh_tempo,
            'tanggal_kembali' => $tglKembali,
            'denda' => $denda,
            'status' => 'menunggu',
        ]);

        // ==========================
        // 🔥 TAMBAH STOK BUKU
        // ==========================
        if ($pinjam->buku) {
            $pinjam->buku->stok += 1;
            $pinjam->buku->save();
        }

        // ==========================
        // UPDATE STATUS PINJAM
        // ==========================
        $pinjam->update([
            'status' => 'menunggu'
        ]);

        return redirect()->route('anggota.pengembalian.index')
            ->with('success', 'Pengembalian dikirim, menunggu konfirmasi petugas.');
    }
}
