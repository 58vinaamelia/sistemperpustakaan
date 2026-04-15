<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Pinjambuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        // 🔥 QUERY DATA PEMINJAMAN
        $query = Pinjambuku::with(['buku','user'])
                    ->where('user_id', $userId)
                    ->latest();

        // 🔍 SEARCH
        if ($request->filled('search')) {
            $keyword = $request->search;

            $query->whereHas('buku', function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%");
            });
        }

        $peminjaman = $query->get();

        // 🔥 TOTAL DIPINJAM (lebih fleksibel)
        $totalDipinjam = Pinjambuku::where('user_id', $userId)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        // 🔥 FIX TOTAL DIKEMBALIKAN (ANTI ERROR DATA KOTOR)
        $totalDikembalikan = Pinjambuku::where('user_id', $userId)
            ->whereRaw('LOWER(TRIM(REPLACE(status, "\"", ""))) = ?', ['dikembalikan'])
            ->count();

        return view('pages.anggota.dashboard.index', compact(
            'peminjaman',
            'totalDipinjam',
            'totalDikembalikan'
        ));
    }
}
