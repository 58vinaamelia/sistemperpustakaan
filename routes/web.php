<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// CONTROLLER
use App\Http\Controllers\AuthController;

// ANGGOTA
use App\Http\Controllers\Anggota\BukuController;
use App\Http\Controllers\Anggota\PengembalianController as AnggotaPengembalianController;
use App\Http\Controllers\Anggota\PinjambukuController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;

// PETUGAS
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\PeminjamanController;
use App\Http\Controllers\Petugas\AnggotaController;
use App\Http\Controllers\Petugas\PengembalianController as PetugasPengembalianController;

// KEPALA
use App\Http\Controllers\Kepala\DashboardController as KepalaDashboardController;
use App\Http\Controllers\Kepala\LaporanController;
use App\Http\Controllers\Kepala\BukuController as KepalaBukuController; // ✅ FIX PENTING

/*
|--------------------------------------------------------------------------
| ROOT
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class,'loginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);

Route::get('/register', function () {
    return view('auth.register');
});
Route::post('/register', [AuthController::class,'register']);

/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');

/*
|--------------------------------------------------------------------------
| DASHBOARD GLOBAL
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $user = Auth::user();
    $role = strtolower(trim($user->role));

    if ($role == 'petugas') {
        return redirect()->route('petugas.dashboard');
    } elseif ($role == 'kepala') {
        return redirect()->route('kepala.dashboard');
    } else {
        return redirect()->route('anggota.dashboard.index');
    }
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| ANGGOTA
|--------------------------------------------------------------------------
*/

Route::prefix('anggota')->name('anggota.')->middleware('auth')->group(function() {

    Route::get('/dashboard', [AnggotaDashboardController::class, 'index'])
        ->name('dashboard.index');

    Route::get('/buku', [BukuController::class,'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class,'detail'])->name('buku.detail');
    Route::get('/buku/{id}/pinjam', [BukuController::class,'formPinjam'])->name('buku.pinjam.form');
    Route::post('/buku/{id}/pinjam', [BukuController::class,'pinjam'])->name('buku.pinjam.store');

    Route::get('/peminjaman', [PinjambukuController::class, 'index'])->name('peminjaman.index');

    Route::get('/pengembalian', [AnggotaPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [AnggotaPengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/store', [AnggotaPengembalianController::class, 'store'])->name('pengembalian.store');
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::prefix('petugas')->name('petugas.')->middleware('auth')->group(function() {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('dashboard');

    // BUKU (FULL CRUD)
    Route::get('/buku', [PetugasBukuController::class,'index'])->name('buku.index');
    Route::get('/buku/create', [PetugasBukuController::class,'create'])->name('buku.create');
    Route::post('/buku/store', [PetugasBukuController::class,'store'])->name('buku.store');
    Route::get('/buku/{id}', [PetugasBukuController::class,'show'])->name('buku.show');
    Route::get('/buku/{id}/edit', [PetugasBukuController::class,'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [PetugasBukuController::class,'update'])->name('buku.update');
    Route::delete('/buku/{id}', [PetugasBukuController::class,'destroy'])->name('buku.destroy');

    // PEMINJAMAN
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])->name('peminjaman.konfirmasi');
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])->name('peminjaman.tolak');

    // PENGEMBALIAN
    Route::get('/pengembalian', [PetugasPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('/pengembalian/{id}/terima', [PetugasPengembalianController::class, 'terima'])->name('pengembalian.terima');
    Route::post('/pengembalian/{id}/tolak', [PetugasPengembalianController::class, 'tolak'])->name('pengembalian.tolak');
    Route::delete('/pengembalian/{id}', [PetugasPengembalianController::class, 'delete'])->name('pengembalian.delete');

    // ANGGOTA
    Route::get('/anggota', [AnggotaController::class, 'index'])->name('anggota.index');
});

/*
|--------------------------------------------------------------------------
| KEPALA (VIEW ONLY)
|--------------------------------------------------------------------------
*/

Route::prefix('kepala')->name('kepala.')->middleware('auth')->group(function() {

    Route::get('/dashboard', [KepalaDashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    // 📚 BUKU (VIEW ONLY)
    Route::get('/buku', [KepalaBukuController::class,'index'])->name('buku.index');
    Route::get('/buku/{id}', [KepalaBukuController::class,'show'])->name('buku.show');

});
