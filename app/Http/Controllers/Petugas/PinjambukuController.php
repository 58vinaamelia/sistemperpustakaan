<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Http\Request;
use App\Models\Petugas\Pinjambuku;

class PinjambukuController extends \Illuminate\Routing\Controller
{
    // 🔥 INDEX + SEARCH + PAGINATION
    public function index(Request $request)
    {
        $search = $request->search;

        $peminjaman = Pinjambuku::with(['user', 'buku'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('buku', function ($q) use ($search) {
                    $q->where('judul', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5) // 🔥 WAJIB (biar links() jalan)
            ->withQueryString(); // 🔥 biar search tidak hilang

        return view('pages.petugas.peminjaman.index', compact('peminjaman'));
    }

    // 🔍 DETAIL
    public function show($id)
    {
        $data = Pinjambuku::with(['user', 'buku'])->findOrFail($id);
        return view('pages.petugas.peminjaman.show', compact('data'));
    }

    // 🗑 HAPUS
    public function destroy($id)
    {
        $data = Pinjambuku::findOrFail($id);
        $data->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}
