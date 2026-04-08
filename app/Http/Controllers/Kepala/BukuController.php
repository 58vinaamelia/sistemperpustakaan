<?php

namespace App\Http\Controllers\Kepala;

use App\Models\Petugas\Buku;
use Illuminate\Http\Request;

class BukuController extends \Illuminate\Routing\Controller
{
    // LIST
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Buku::when($search, function ($q, $search) {
            return $q->where('judul', 'like', "%$search%");
        })->latest();

        // 🔥 LOGIC: 6 DATA ATAU SEMUA
        if ($request->lihat_semua) {
            $buku = $query->get(); // tampil semua
        } else {
            $buku = $query->limit(6)->get(); // default 6
        }

        return view('pages.kepala.buku.index', compact('buku'));
    }

    // DETAIL
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.kepala.buku.show', compact('buku'));
    }
}
