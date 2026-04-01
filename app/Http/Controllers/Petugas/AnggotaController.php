<?php

namespace App\Http\Controllers\Petugas;

use Illuminate\Support\Facades\Auth;
use App\Models\Petugas\Anggota;

class AnggotaController extends \Illuminate\Routing\Controller
{
    public function index()
{
    $user = Auth::user();

    // ✅ HANYA anggota yang boleh masuk
    if ($user && $user->role === 'anggota') {
        if (!Anggota::where('email', $user->email)->exists()) {
            Anggota::create([
                'nama' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
            ]);
        }
    }

    $anggota = Anggota::all();

    return view('pages.petugas.anggota.index', compact('anggota'));
}
}
