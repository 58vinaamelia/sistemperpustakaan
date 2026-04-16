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
        $search = $request->input('search');

        // TOTAL DATA
        $totalAnggota = User::where('role', 'anggota')->count();
        $totalBuku = Buku::count();
        $totalDenda = Pinjambuku::sum('denda');

        // QUERY DASAR
        $query = Pinjambuku::with(['user', 'buku'])
            ->where('status', '<>', 'dihapus')
            ->when($search, function ($q, $search) {
                $q->where(function ($sub) use ($search) {
                    $sub->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'like', "%$search%");
                    })
                    ->orWhereHas('buku', function ($b) use ($search) {
                        $b->where('judul', 'like', "%$search%");
                    });
                });
            })
            ->orderBy('tanggal_pinjam', 'desc');

        // 🔥 LOGIC 5 DATA ATAU SEMUA
        if ($request->lihat_semua) {
            $peminjaman = $query->paginate(10)->withQueryString(); // banyak + pagination
        } else {
            $peminjaman = $query->paginate(5)->withQueryString(); // default cuma 5
        }

        return view('pages.petugas.dashboard.index', compact(
            'totalAnggota',
            'totalBuku',
            'totalDenda',
            'peminjaman'
        ));
    }
}
