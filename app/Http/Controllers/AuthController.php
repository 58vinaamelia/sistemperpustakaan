<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petugas\Anggota; // 🔥 TAMBAH INI
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends \Illuminate\Routing\Controller
{
    // ======================
    // FORM LOGIN
    // ======================
    public function loginForm()
    {
        return view('auth.login');
    }

    // ======================
    // PROSES LOGIN
    // ======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->with('error','Email atau password salah');
    }

    // ======================
    // PROSES REGISTER
    // ======================
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ]);

        // ✅ SIMPAN KE USERS
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota', // 🔥 penting
        ]);

        // 🔥 SIMPAN KE ANGGOTA
        Anggota::create([
            'nama' => $user->name,
            'email' => $user->email,
            // ❗ password optional (boleh dihapus kalau mau)
            'password' => $user->password,
        ]);

        return redirect('/login')->with('success','Akun berhasil dibuat');
    }
}
