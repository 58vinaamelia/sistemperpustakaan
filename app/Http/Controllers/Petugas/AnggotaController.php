<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Petugas\Anggota;

class AnggotaController extends \Illuminate\Routing\Controller
{
    public function index()
    {
        $anggota = Anggota::all();
        return view('pages.petugas.anggota.index', compact('anggota'));
    }

    public function destroy($id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->delete();

        return redirect()->route('petugas.anggota.index')
                         ->with('info', 'Anggota berhasil dihapus');
    }
}
