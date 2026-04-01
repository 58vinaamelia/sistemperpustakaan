<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// CONTROLLER
use App\Http\Controllers\AuthController;

// ANGGOTA
use App\Http\Controllers\Anggota\BukuController;
use App\Http\Controllers\Anggota\PengembalianController;
use App\Http\Controllers\Anggota\PinjambukuController;
use App\Http\Controllers\Anggota\DashboardController as AnggotaDashboardController;

// PETUGAS
use App\Http\Controllers\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Petugas\BukuController as PetugasBukuController;
use App\Http\Controllers\Petugas\PeminjamanController; // 🔥 FIX pakai ini

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

    if ($user->role == 'petugas') {
        return redirect()->route('petugas.dashboard');
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

    // Buku
    Route::get('/buku', [BukuController::class,'index'])->name('buku.index');
    Route::get('/buku/{id}', [BukuController::class,'detail'])->name('buku.detail');
    Route::get('/buku/{id}/pinjam', [BukuController::class,'formPinjam'])->name('buku.pinjam.form');
    Route::post('/buku/{id}/pinjam', [BukuController::class,'pinjam'])->name('buku.pinjam.store');

    // Peminjaman
    Route::get('/peminjaman', [PinjambukuController::class, 'index'])->name('peminjaman.index');
    Route::get('/peminjaman/{id}', [PinjambukuController::class, 'show'])->name('peminjaman.show');

    // Pengembalian
    Route::get('/pengembalian', [PengembalianController::class, 'index'])->name('pengembalian.index');
    Route::get('/pengembalian/create', [PengembalianController::class, 'create'])->name('pengembalian.create');
    Route::post('/pengembalian/store', [PengembalianController::class, 'store'])->name('pengembalian.store');
});

/*
|--------------------------------------------------------------------------
| PETUGAS
|--------------------------------------------------------------------------
*/

Route::prefix('petugas')->name('petugas.')->middleware('auth')->group(function() {

    Route::get('/dashboard', [PetugasDashboardController::class, 'index'])
        ->name('dashboard');

    // ======================
    // BUKU
    // ======================
    Route::get('/buku', [PetugasBukuController::class,'index'])->name('buku.index');
    Route::get('/buku/create', [PetugasBukuController::class,'create'])->name('buku.create');
    Route::post('/buku/store', [PetugasBukuController::class,'store'])->name('buku.store');
    Route::get('/buku/{id}', [PetugasBukuController::class,'show'])->name('buku.show');
    Route::get('/buku/{id}/edit', [PetugasBukuController::class,'edit'])->name('buku.edit');
    Route::put('/buku/{id}', [PetugasBukuController::class,'update'])->name('buku.update');
    Route::delete('/buku/{id}', [PetugasBukuController::class,'destroy'])->name('buku.destroy');

    // ======================
    // PEMINJAMAN 
    // ======================

    Route::get('/peminjaman', [PeminjamanController::class, 'index'])
        ->name('peminjaman.index');

    Route::get('/peminjaman/{id}', [PeminjamanController::class, 'show'])
        ->name('peminjaman.show');

    // 🔥 KONFIRMASI
    Route::post('/peminjaman/{id}/konfirmasi', [PeminjamanController::class, 'konfirmasi'])
        ->name('peminjaman.konfirmasi');

    // 🔥 TOLAK
    Route::post('/peminjaman/{id}/tolak', [PeminjamanController::class, 'tolak'])
        ->name('peminjaman.tolak');

    // 🔥 PENGEMBALIAN
    Route::post('/peminjaman/{id}/kembalikan', [PeminjamanController::class, 'kembalikan'])
        ->name('peminjaman.kembalikan');

    // DELETE
    Route::delete('/peminjaman/{id}', [PeminjamanController::class, 'destroy'])
        ->name('peminjaman.destroy');

});
