<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Petugas\Anggota;
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
    // PROSES LOGIN (FIX)
    // ======================
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();
            $role = strtolower(trim($user->role));

            // 🔥 REDIRECT SESUAI ROLE
            if ($role == 'petugas') {
                return redirect()->route('petugas.dashboard');
            } elseif ($role == 'kepala') {
                return redirect()->route('kepala.dashboard');
            } else {
                return redirect()->route('anggota.dashboard.index');
            }
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

        // SIMPAN KE USERS
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'anggota',
        ]);

        // SIMPAN KE ANGGOTA
        Anggota::create([
            'nama' => $user->name,
            'email' => $user->email,
            'password' => $user->password,
        ]);

        return redirect('/login')->with('success','Akun berhasil dibuat');
    }
}
