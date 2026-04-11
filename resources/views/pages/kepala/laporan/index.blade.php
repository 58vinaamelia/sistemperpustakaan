@extends('layouts.kepala.app')

@section('title', 'Laporan')

@section('content')

<div class="mt-8 px-6">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                📊 Laporan Peminjaman & Pengembalian
            </h1>
            <p class="text-sm text-gray-500">
                Data seluruh peminjaman & pengembalian buku
            </p>
        </div>

        {{-- 🔥 TOMBOL CETAK & PDF --}}
       <div class="flex gap-3">

    {{-- CETAK --}}
    <a href="{{ route('kepala.laporan.cetak', request()->all()) }}" target="_blank"
        class="flex items-center gap-2 bg-green-100 hover:bg-green-200 text-green-800 px-5 py-2 rounded-xl shadow text-sm font-semibold border border-green-300">
        🖨️ <span>Cetak</span>
    </a>

    {{-- PDF --}}
    <a href="{{ route('kepala.laporan.pdf', request()->all()) }}"
        class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl shadow-md text-sm font-semibold">
        📄 <span>PDF</span>
    </a>

</div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-end">

            <div>
                <label class="text-xs text-gray-500">Bulan</label>
                <input type="month" name="bulan" value="{{ request('bulan') }}"
                    class="border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-gray-500">Dari</label>
                <input type="date" name="dari" value="{{ request('dari') }}"
                    class="border rounded-lg px-3 py-2 text-sm">
            </div>

            <div>
                <label class="text-xs text-gray-500">Sampai</label>
                <input type="date" name="sampai" value="{{ request('sampai') }}"
                    class="border rounded-lg px-3 py-2 text-sm">
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-5 py-2 rounded-lg text-sm">
                Filter
            </button>

            <a href="{{ route('kepala.laporan.index') }}"
               class="text-gray-500 text-sm">
               Reset
            </a>

        </form>
    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow-sm border overflow-hidden mb-10">

        <div class="px-6 py-4 border-b flex justify-between items-center">
            <h2 class="text-lg font-semibold text-gray-700">
                Data Peminjaman & Pengembalian
            </h2>

            <span class="text-xs text-gray-400">
                Total: {{ $peminjaman->total() }} data
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
                    <tr>
                        <th class="px-6 py-3">No</th>
                        <th class="px-6 py-3">Anggota</th>
                        <th class="px-6 py-3">Buku</th>
                        <th class="px-6 py-3">Tgl Pinjam</th>
                        <th class="px-6 py-3">Jatuh Tempo</th>
                        <th class="px-6 py-3">Tgl Kembali</th>
                        <th class="px-6 py-3 text-center">Denda</th>
                        <th class="px-6 py-3 text-center">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($peminjaman as $item)
                    @php
                        $jatuhTempo = $item->tanggal_pinjam
                            ? strtotime($item->tanggal_pinjam . ' +7 days')
                            : null;

                        $tanggalCek = $item->tanggal_kembali
                            ? strtotime($item->tanggal_kembali)
                            : time();

                        $isTerlambat = $jatuhTempo && $tanggalCek > $jatuhTempo;

                        $denda = 0;

                        if ($isTerlambat) {
                            $hariTelat = floor(($tanggalCek - $jatuhTempo) / (60 * 60 * 24));
                            $denda = $hariTelat * 1000;
                        }
                    @endphp

                    <tr class="hover:bg-gray-50">

                        <td class="px-6 py-4">
                            {{ ($peminjaman->currentPage() - 1) * $peminjaman->perPage() + $loop->iteration }}
                        </td>

                        <td class="px-6 py-4 font-medium">
                            {{ $item->user->name ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->buku->judul ?? '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->tanggal_pinjam ? date('d M Y', strtotime($item->tanggal_pinjam)) : '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $jatuhTempo ? date('d M Y', $jatuhTempo) : '-' }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $item->tanggal_kembali ? date('d M Y', strtotime($item->tanggal_kembali)) : '-' }}
                        </td>

                        <td class="px-6 py-4 text-center text-red-600 font-semibold">
                            @if($denda > 0)
                                Rp {{ number_format($denda, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($isTerlambat)
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Terlambat
                                </span>
                            @elseif($item->status == 'dipinjam')
                                <span class="bg-yellow-300 text-yellow-900 px-3 py-1 rounded-full text-xs">
                                    Dipinjam
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $peminjaman->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
