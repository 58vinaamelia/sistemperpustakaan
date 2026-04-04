@extends('layouts.petugas.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col min-h-screen">

    <!-- SEARCH -->
    <form action="{{ route('petugas.dashboard') }}" method="GET">
        <div class="mt-4 mb-4">
            <div class="relative max-w-xl mx-auto">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                    <i class="ti ti-search text-lg"></i>
                </span>
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama / judul buku..."
                    class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 bg-white
                           focus:outline-none focus:ring-2 focus:ring-blue-400 shadow-sm">
            </div>
        </div>
    </form>

    <!-- CARDS -->
    <div class="flex justify-center gap-6 mb-6 flex-wrap">
        <div class="bg-white rounded-xl shadow-sm flex items-center gap-4 px-5 py-4 w-60">
            <div class="bg-orange-100 p-3 rounded-full">
                <i class="ti ti-users text-orange-500"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Anggota</p>
                <h2 class="text-lg font-bold">{{ $totalAnggota }}</h2>
            </div>
        </div>

        
        <div class="bg-white rounded-xl shadow-sm flex items-center gap-4 px-5 py-4 w-60">
            <div class="bg-blue-100 p-3 rounded-full">
                <i class="ti ti-book text-blue-500"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Total Buku</p>
                <h2 class="text-lg font-bold">{{ $totalBuku }}</h2>
            </div>
        </div>
    </div>

    <!-- TABLE PEMINJAMAN -->
    <div class="bg-white rounded-xl shadow p-6 mt-4 mb-6 flex-1 flex flex-col">
        <h5 class="font-semibold mb-4">Semua Data Peminjaman</h5>

        <div class="overflow-x-auto flex-1">
            <table class="w-full text-sm text-center border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3">Nama</th>
                        <th>Buku</th>
                        <th>Tgl Pinjam</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($peminjaman as $item)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="py-3">{{ $item->user->name ?? '-' }}</td>
                        <td>{{ $item->buku->judul ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam }}</td>
                        <td>{{ $item->tanggal_jatuh_tempo }}</td>

                        <!-- STATUS (SUDAH FIX) -->
                        <td>
                            @php
                                $status = strtolower(trim($item->status ?? ''));

                                if ($status === '' || $status === null) {
                                    $status = 'pending';
                                }

                                switch ($status) {
                                    case 'pending':
                                        $label = 'Pending';
                                        $bgColor = 'bg-orange-100';
                                        $textColor = 'text-orange-600';
                                        break;

                                    case 'dipinjam':
                                        $label = 'Dipinjam';
                                        $bgColor = 'bg-blue-100';
                                        $textColor = 'text-blue-600';
                                        break;

                                    case 'ditolak':
                                        $label = 'Ditolak';
                                        $bgColor = 'bg-red-100';
                                        $textColor = 'text-red-600';
                                        break;

                                    case 'selesai':
                                        $label = 'Selesai';
                                        $bgColor = 'bg-green-100';
                                        $textColor = 'text-green-600';
                                        break;

                                    case 'telat':
                                        $label = 'Telat';
                                        $bgColor = 'bg-yellow-100';
                                        $textColor = 'text-yellow-600';
                                        break;

                                    default:
                                        $label = ucfirst($item->status ?? 'Tidak diketahui');
                                        $bgColor = 'bg-gray-100';
                                        $textColor = 'text-gray-600';
                                        break;
                                }
                            @endphp

                            <span class="{{ $bgColor }} {{ $textColor }} px-3 py-1 rounded-full text-xs">
                                {{ $label }}
                            </span>
                        </td>

                        <!-- AKSI (TIDAK DIUBAH) -->
                        <td class="py-2">
                            <div class="flex justify-center items-center gap-2">

                                <!-- DELETE -->
                                <form action="{{ route('petugas.peminjaman.destroy', $item->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Yakin hapus data?')"
                                      class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-1 rounded border border-red-700 shadow-sm transition">
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-8 text-gray-500">Data peminjaman kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINASI -->
        <div class="mt-4 flex justify-between">
            @if ($peminjaman->onFirstPage())
                <span class="px-4 py-2 text-gray-400 border rounded cursor-not-allowed">« Previous</span>
            @else
                <a href="{{ $peminjaman->previousPageUrl() }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">« Previous</a>
            @endif

            @if ($peminjaman->hasMorePages())
                <a href="{{ $peminjaman->nextPageUrl() }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded hover:bg-gray-200">Next »</a>
            @else
                <span class="px-4 py-2 text-gray-400 border rounded cursor-not-allowed">Next »</span>
            @endif
        </div>
    </div>

</div>

<!-- SCRIPT SEARCH -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    let input = document.querySelector('input[name="search"]');
    let timeout = null;

    if (input) {
        input.addEventListener('keyup', function () {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                this.form.submit();
            }, 500);
        });
    }
});
</script>

@endsection
