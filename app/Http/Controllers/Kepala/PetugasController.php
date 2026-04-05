<?php

namespace App\Http\Controllers\Kepala;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class PetugasController extends \Illuminate\Routing\Controller
{
    // ==========================
    // TAMPILKAN DATA PETUGAS
    // ==========================
    public function index()
    {
        $petugas = User::where('role', 'petugas')->latest()->get();

        return view('pages.kepala.petugas.index', compact('petugas'));
    }

    // ==========================
    // FORM TAMBAH PETUGAS
    // ==========================
    public function create()
    {
        return view('pages.kepala.petugas.create');
    }

    // ==========================
    // SIMPAN DATA PETUGAS
    // ==========================
    public function store(Request $request)
    {
        // VALIDASI
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        // SIMPAN
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // ✅ lebih aman
            'role' => 'petugas'
        ]);

        // REDIRECT KE INDEX
        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Petugas berhasil ditambahkan');
    }

    // ==========================
    // HAPUS PETUGAS
    // ==========================
    public function destroy($id)
    {
        $petugas = User::findOrFail($id);
        $petugas->delete();

        return redirect()->route('kepala.petugas.index')
            ->with('success', 'Petugas berhasil dihapus');
    }
}
