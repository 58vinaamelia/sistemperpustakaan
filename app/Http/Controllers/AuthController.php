<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
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

            return redirect('/dashboard'); // diarahkan ke dashboard
        }

        return back()->with('error','Email atau password salah');
    }

    // ======================
    // PROSES REGISTER
    // ======================
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255', // 🔥 TAMBAH INI
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6|confirmed'
    ]);

    User::create([
        'name' => $request->name, // 🔥 AMBIL DARI INPUT
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/login')->with('success','Akun berhasil dibuat');
}
}
