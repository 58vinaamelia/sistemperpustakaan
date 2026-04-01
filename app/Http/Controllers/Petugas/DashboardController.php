<?php

namespace App\Http\Controllers\Petugas;

use App\Models\Petugas\Pinjambuku;
use App\Models\User;
use App\Models\Petugas\Buku;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil input pencarian
        $search = $request->input('search');

        // Total anggota
        $totalAnggota = User::where('role', 'anggota')->count();

        // Total buku
        $totalBuku = Buku::count();

        // Total denda
        $totalDenda = Pinjambuku::sum('denda');

        // Ambil data peminjaman, dengan relasi user & buku, search & pagination
        $peminjaman = Pinjambuku::with(['user', 'buku'])
            ->when($search, function ($query, $search) {
                $query->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%$search%");
                })
                ->orWhereHas('buku', function ($q) use ($search) {
                    $q->where('judul', 'like', "%$search%");
                });
            })
            ->orderBy('tanggal_pinjam', 'desc')
            ->paginate(10)   // <-- 10 data per halaman
            ->withQueryString(); // <-- biar search tetap di url saat pindah halaman

        // Kirim ke view
        return view('pages.petugas.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalDenda',
            'peminjaman'
        ));
    }
}
