<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use App\Models\Petugas\Buku;
use Illuminate\Support\Facades\Storage;

class BukuController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Buku::when($search, function ($q, $search) {
            return $q->where('judul', 'like', "%$search%");
        })->latest();

        // 🔥 LOGIC 6 DATA ATAU SEMUA
        if ($request->lihat_semua) {
            $buku = $query->get(); // semua data
        } else {
            $buku = $query->limit(6)->get(); // default 6
        }

        return view('pages.petugas.buku.index', compact('buku'));
    }

    public function create()
    {
        return view('pages.petugas.buku.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|unique:buku,judul',
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

            $hashBaru = md5_file($request->file('foto')->getRealPath());
            $files = Storage::disk('public')->files('buku');

            foreach ($files as $file) {
                $path = storage_path('app/public/' . $file);

                if (file_exists($path)) {
                    $hashLama = md5_file($path);

                    if ($hashBaru === $hashLama) {
                        return back()->with('error', 'Foto sudah pernah diupload!');
                    }
                }
            }

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

    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.petugas.buku.show', compact('buku'));
    }

    public function edit($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.petugas.buku.edit', compact('buku'));
    }

    public function update(Request $request, $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'tahun' => 'required|numeric',
            'stok' => 'required|numeric|min:0',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = [
            'judul' => $request->judul,
            'pengarang' => $request->pengarang,
            'penerbit' => $request->penerbit,
            'tahun' => $request->tahun,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
        ];

        if ($request->hasFile('foto')) {

            $hashBaru = md5_file($request->file('foto')->getRealPath());
            $files = Storage::disk('public')->files('buku');

            foreach ($files as $file) {
                $path = storage_path('app/public/' . $file);

                if (file_exists($path)) {
                    $hashLama = md5_file($path);

                    if ($hashBaru === $hashLama) {
                        return back()->with('error', 'Foto sudah pernah digunakan!');
                    }
                }
            }

            // hapus lama
            if ($buku->foto && Storage::disk('public')->exists($buku->foto)) {
                Storage::disk('public')->delete($buku->foto);
            }

            // simpan baru
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        $buku->update($data);

        return redirect()->route('petugas.buku.index')
            ->with('success', 'Buku berhasil diupdate');
    }

    public function destroy($id)
{
    $buku = Buku::findOrFail($id);

    // 🔥 CEK apakah buku sedang dipinjam
    $sedangDipinjam = \App\Models\Anggota\Pinjambuku::where('buku_id', $id)
        ->where('status', 'dipinjam')
        ->exists();

    if ($sedangDipinjam) {
        return redirect()->route('petugas.buku.index')
            ->with('error', 'Buku tidak bisa dihapus karena sedang dipinjam!');
    }

    // hapus foto kalau ada
    if ($buku->foto) {
        Storage::disk('public')->delete($buku->foto);
    }

    $buku->delete();

    return redirect()->route('petugas.buku.index')
        ->with('success', 'Buku berhasil dihapus');
}

}
