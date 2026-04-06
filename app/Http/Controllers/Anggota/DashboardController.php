<?php

namespace App\Http\Controllers\Anggota;

use App\Models\Anggota\Pinjambuku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class DashboardController extends \Illuminate\Routing\Controller
{
    public function index(Request $request)
    {
        // Query peminjaman milik user login
        $query = Pinjambuku::with(['buku','user'])
                    ->where('user_id', Auth::id())
                    ->latest();

        // Jika ada keyword search
        if ($request->has('search') && !empty($request->search)) {
            $keyword = $request->search;

            // Filter berdasarkan judul buku
            $query->whereHas('buku', function($q) use ($keyword) {
                $q->where('judul', 'like', "%{$keyword}%");
            });
        }

        $peminjaman = $query->get();

        // 🔥 TAMBAHAN WAJIB (BIAR CARD JALAN)
        $totalDipinjam = Pinjambuku::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->count();

        $totalDikembalikan = Pinjambuku::where('user_id', Auth::id())
            ->where('status', 'dikembalikan')
            ->count();

        // 🔥 KIRIM KE VIEW
        return view('pages.anggota.dashboard.index', compact(
            'peminjaman',
            'totalDipinjam',
            'totalDikembalikan'
        ));
    }
}
