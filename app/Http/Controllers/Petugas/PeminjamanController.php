<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Anggota\Pinjambuku;
use App\Models\Petugas\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    /**
     * 📋 LIST DATA
     */
    public function index()
    {
        $peminjaman = Pinjambuku::with(['user', 'buku'])
                        ->where('status', '<>', 'dihapus')
                        ->latest()
                        ->paginate(10);

        return view('pages.petugas.peminjaman.index', compact('peminjaman'));
    }

    /**
     * 🔍 DETAIL
     */
    public function show($id)
    {
        $item = Pinjambuku::with(['user', 'buku'])->findOrFail($id);
        return view('pages.petugas.peminjaman.show', compact('item'));
    }

    /**
     * ✅ KONFIRMASI
     */
    public function konfirmasi($id)
    {
        $pinjam = Pinjambuku::with('buku')->findOrFail($id);

        // default status
        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        // hanya pending
        if ($pinjam->status !== 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        // ubah status
        $pinjam->update([
            'status' => 'dipinjam'
        ]);

        // kurangi stok
        if ($pinjam->buku && $pinjam->buku->stok > 0) {
            $pinjam->buku->decrement('stok');
        }

        return back()->with('success', 'Peminjaman disetujui');
    }

    /**
     * ❌ FORM TOLAK
     */
    public function formTolak($id)
    {
        $pinjam = Pinjambuku::with(['user', 'buku'])->findOrFail($id);

        if ($pinjam->status !== 'pending') {
            return back()->with('error', 'Hanya peminjaman pending yang bisa ditolak.');
        }

        return view('pages.petugas.peminjaman.tolak', compact('pinjam'));
    }

    /**
     * ❌ TOLAK
     */
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|max:500',
        ]);

        $pinjam = Pinjambuku::findOrFail($id);

        if (empty($pinjam->status)) {
            $pinjam->status = 'pending';
        }

        if ($pinjam->status !== 'pending') {
            return back()->with('success', 'Sudah diproses');
        }

        $pinjam->update([
            'status' => 'ditolak',
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        return redirect()->route('petugas.peminjaman.index')->with('success', 'Peminjaman ditolak.');
    }

    /**
     * � FORM KEMBALIKAN
     */
    public function formKembalikan($id)
    {
        $pinjam = Pinjambuku::with(['user', 'buku'])->findOrFail($id);

        if ($pinjam->status !== 'dipinjam') {
            return back()->with('error', 'Hanya peminjaman yang sedang dipinjam yang bisa dikembalikan.');
        }

        return view('pages.petugas.peminjaman.kembalikan', compact('pinjam'));
    }

    /**
     * 🔁 KEMBALIKAN (FINAL - DENGAN FORM)
     */
    public function kembalikan(Request $request, $id)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_buku' => 'required|in:baik,rusak,hilang',
        ]);

        $pinjam = Pinjambuku::with(['buku', 'user'])->findOrFail($id);

        if ($pinjam->status !== 'dipinjam') {
            return back()->with('error', 'Data tidak valid untuk dikembalikan');
        }

        $tanggalKembali = Carbon::parse($request->tanggal_kembali);
        $denda = 0;

        if ($pinjam->tanggal_jatuh_tempo) {
            $tanggalJatuhTempo = Carbon::parse($pinjam->tanggal_jatuh_tempo);

            if ($tanggalKembali->gt($tanggalJatuhTempo)) {
                $hariTelat = $tanggalJatuhTempo->diffInDays($tanggalKembali);
                $denda += $hariTelat * 1000;
            }
        }

        if ($request->kondisi_buku === 'rusak') {
            $denda += 20000;
        }

        if ($request->kondisi_buku === 'hilang') {
            $denda += 50000;
        }

        // Simpan di tabel pengembalian agar langsung muncul di index pengembalian petugas
        Pengembalian::create([
            'nama' => $pinjam->user->name ?? $pinjam->nama,
            'user_id' => $pinjam->user_id,
            'buku_id' => $pinjam->buku_id,
            'tanggal_pinjam' => $pinjam->tanggal_pinjam,
            'tanggal_jatuh_tempo' => $pinjam->tanggal_jatuh_tempo,
            'tanggal_kembali' => $tanggalKembali,
            'denda' => $denda,
            'kondisi_buku' => $request->kondisi_buku,
            'status' => 'diterima',
        ]);

        $statusPengembalian = 'selesai';

        if (!empty($pinjam->tanggal_jatuh_tempo)) {
            $tanggalJatuhTempo = isset($tanggalJatuhTempo)
                ? $tanggalJatuhTempo
                : Carbon::parse($pinjam->tanggal_jatuh_tempo);

            if ($tanggalKembali->gt($tanggalJatuhTempo)) {
                $statusPengembalian = 'telat';
            }
        }

        $pinjam->update([
            'tanggal_kembali' => $tanggalKembali,
            'status' => $statusPengembalian,
            'denda' => $denda,
        ]);

        if ($pinjam->buku && $request->kondisi_buku !== 'hilang') {
            $pinjam->buku->increment('stok');
        }

        return redirect()->route('petugas.pengembalian.index')
            ->with('success', 'Buku berhasil dikembalikan dan masuk ke data pengembalian. Denda: Rp ' . number_format($denda, 0, ',', '.'));
    }

    /**
     * 🗑 HAPUS
     */
    public function destroy($id)
    {
        $item = Pinjambuku::with('buku')->findOrFail($id);

        if ($item->status === 'dipinjam' && $item->buku) {
            $item->buku->increment('stok');
        }

        $item->delete();

        return back()->with('success', 'Data peminjaman disembunyikan dari daftar, tetapi tetap tersimpan untuk laporan.');
    }
}
