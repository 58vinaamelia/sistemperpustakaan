<?php

namespace App\Http\Controllers\Anggota;

use Illuminate\Http\Request;
use App\Models\Anggota\Pinjambuku;
use App\Models\Anggota\Pengembalian;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends \Illuminate\Routing\Controller
{
    // ✅ HALAMAN INDEX (TABEL DATA)
    public function index()
    {
        $pengembalian = Pengembalian::with('buku')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('pages.anggota.pengembalian.index', compact('pengembalian'));
    }

    // ✅ HALAMAN FORM (CREATE)
    public function create()
    {
        $peminjaman = Pinjambuku::with('buku')
            ->where('user_id', Auth::id())
            ->where('status', 'Dipinjam')
            ->get();

        return view('pages.anggota.pengembalian.create', compact('peminjaman'));
    }

    // ✅ SIMPAN DATA
    public function store(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'tanggal_kembali' => 'required|date',
        ]);

        // ambil data pinjaman
        $pinjam = Pinjambuku::where('buku_id', $request->buku_id)
            ->where('user_id', Auth::id())
            ->where('status', 'Dipinjam')
            ->first();

        if (!$pinjam) {
            return back()->with('error', 'Data peminjaman tidak ditemukan atau sudah dikembalikan.');
        }

        // 🔥 HITUNG DENDA
        $tglKembali = Carbon::parse($request->tanggal_kembali);
        $tglTempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);

        $denda = 0;

        if ($tglKembali->gt($tglTempo)) {
            $hariTelat = $tglTempo->diffInDays($tglKembali);
            $denda = $hariTelat * 1000;
        }

        // ✅ SIMPAN DATA
        Pengembalian::create([
            'nama' => Auth::user()->name,
            'user_id' => Auth::id(),
            'buku_id' => $pinjam->buku_id,
            'tanggal_pinjam' => $pinjam->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $pinjam->tanggal_jatuh_tempo,
            'tanggal_kembali' => $tglKembali,
            'denda' => $denda,
        ]);

        // ✅ UPDATE STATUS PINJAM
        $pinjam->update([
            'status' => 'Dikembalikan'
        ]);

        return redirect()->route('anggota.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan');
    }

    // ❌ TIDAK DIPAKAI
    public function show($id)
    {
        abort(404);
    }

    public function edit($id)
    {
        abort(404);
    }

    public function update(Request $request, $id)
    {
        abort(404);
    }

    public function destroy($id)
    {
        abort(404);
    }
}
