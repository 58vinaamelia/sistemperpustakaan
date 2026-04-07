<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use App\Models\Petugas\Buku;
use Illuminate\Support\Facades\Storage;

class BukuController extends \Illuminate\Routing\Controller
{
    // ==========================
    // LIST
    // ==========================
    public function index(Request $request)
    {
        $search = $request->search;

        $buku = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%$search%");
        })->latest()->get();

        return view('pages.petugas.buku.index', compact('buku'));
    }

    // ==========================
    // CREATE FORM
    // ==========================
    public function create()
    {
        return view('pages.petugas.buku.create');
    }

    // ==========================
    // STORE (FIX DUPLIKAT)
    // ==========================
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|unique:buku,judul', // 🔥 TIDAK BOLEH SAMA
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'stok' => 'required|numeric',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'judul.unique' => 'Judul buku sudah ada!',
        ]);

        $foto = null;

        if ($request->hasFile('foto')) {
            $foto = $request->file('foto')->store('buku', 'public');
        }

        Buku::create([
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'foto' => $foto,
        ]);

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Buku berhasil ditambahkan');
    }

    // ==========================
    // SHOW
    // ==========================
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.petugas.buku.show', compact('buku'));
    }

    // ==========================
    // EDIT
    // ==========================
    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.petugas.buku.edit', compact('buku'));
    }

    // ==========================
    // UPDATE (FIX DUPLIKAT)
    // ==========================
    public function update(Request $request, $id)
{
    // VALIDASI 🔥
    $request->validate([
        'judul' => 'required',
        'pengarang' => 'required',
        'penerbit' => 'required',
        'tahun' => 'required|numeric',
        'stok' => 'required|integer|min:0', // ❗ ini penting
    ]);

    $buku = Buku::findOrFail($id);

    $buku->update([
        'judul' => $request->judul,
        'pengarang' => $request->pengarang,
        'penerbit' => $request->penerbit,
        'tahun_terbit' => $request->tahun,
        'stok' => $request->stok,
        'deskripsi' => $request->deskripsi,
    ]);

    return redirect()->route('petugas.buku.index')
        ->with('success', 'Buku berhasil diupdate');
} 

    // ==========================
    // DELETE
    // ==========================
    public function destroy($id)
    {
        $buku = Buku::findOrFail($id);

        if ($buku->foto) {
            Storage::disk('public')->delete($buku->foto);
        }

        $buku->delete();

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Buku berhasil dihapus');
    }
}
