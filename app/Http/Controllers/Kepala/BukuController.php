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

        $buku = Buku::when($search, function ($query, $search) {
            return $query->where('judul', 'like', "%$search%");
        })->latest()->get();

        return view('pages.kepala.buku.index', compact('buku'));
    }

    // DETAIL
    public function show($id)
    {
        $buku = Buku::findOrFail($id);
        return view('pages.kepala.buku.show', compact('buku'));
    }
}
