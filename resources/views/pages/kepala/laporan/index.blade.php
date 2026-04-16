@extends('layouts.kepala.app')

@section('title', 'Laporan')

@section('content')

<div class="mt-8 px-6">

    {{-- HEADER --}}
    <div class="mb-6 flex justify-between items-start">

        {{-- TITLE --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-800">
                📊 Laporan Peminjaman & Pengembalian
            </h1>
            <p class="text-sm text-gray-500">
                Data seluruh peminjaman & pengembalian buku
            </p>
        </div>

        {{-- BUTTON CETAK & PDF --}}
        <div class="flex gap-3">

            <a href="{{ route('kepala.laporan.cetak', request()->all()) }}" target="_blank"
                class="flex items-center gap-2 bg-green-100 hover:bg-green-200 text-green-800 px-5 py-2 rounded-xl shadow text-sm font-semibold border border-green-300">
                🖨️ <span>Cetak</span>
            </a>

            <a href="{{ route('kepala.laporan.pdf', request()->all()) }}"
                class="flex items-center gap-2 bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl shadow-md text-sm font-semibold">
                📄 <span>PDF</span>
            </a>

        </div>
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-xl shadow-sm border mb-6">
        <form method="GET" action="{{ route('kepala.laporan.index') }}"
            class="flex flex-wrap gap-4 items-end justify-between">

            <div class="flex flex-wrap gap-4 items-end">

                {{-- BULAN --}}
                <div>
                    <label class="text-xs text-gray-500">Bulan</label>
                    <input type="month" name="bulan" value="{{ request('bulan') }}"
                        class="border rounded-lg px-3 py-2 text-sm">
                </div>

                {{-- DARI --}}
                <div>
                    <label class="text-xs text-gray-500">Dari</label>
                    <input type="date" name="dari" value="{{ request('dari') }}"
                        class="border rounded-lg px-3 py-2 text-sm">
                </div>

                {{-- SAMPAI --}}
                <div>
                    <label class="text-xs text-gray-500">Sampai</label>
                    <input type="date" name="sampai" value="{{ request('sampai') }}"
                        class="border rounded-lg px-3 py-2 text-sm">
                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex items-center gap-3">
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-lg text-sm">
                    Filter
                </button>

                <a href="{{ route('kepala.laporan.index') }}"
                    class="text-gray-500 text-sm hover:underline">
                    Reset
                </a>
            </div>

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
                        <th class="px-6 py-3 text-center">Kondisi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">

                    @forelse($peminjaman as $item)

                    @php
                        $tanggalKembali = $item->tanggal_kembali_real;
                        $kondisi = strtolower(trim($item->kondisi_buku ?? ''));

                        $jatuhTempo = $item->tanggal_pinjam
                            ? strtotime($item->tanggal_pinjam . ' +7 days')
                            : null;

                        $tanggalCek = $tanggalKembali
                            ? strtotime($tanggalKembali)
                            : time();

                        $isTerlambat = $jatuhTempo && $tanggalCek > $jatuhTempo;
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
                            {{ $tanggalKembali ? date('d M Y', strtotime($tanggalKembali)) : '-' }}
                        </td>

                        <td class="px-6 py-4 text-center text-red-600 font-semibold">
                            @if($item->denda_real > 0)
                                Rp {{ number_format($item->denda_real, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">
                            @if($item->status_pengembalian == 'diterima')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Selesai
                                </span>
                            @elseif($item->status_pengembalian == 'menunggu')
                                <span class="bg-yellow-300 text-yellow-900 px-3 py-1 rounded-full text-xs">
                                    Menunggu
                                </span>
                            @elseif($item->status_pengembalian == 'ditolak')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Ditolak
                                </span>
                            @elseif($item->status == 'dipinjam')
                                <span class="bg-yellow-300 text-yellow-900 px-3 py-1 rounded-full text-xs">
                                    Dipinjam
                                </span>
                            @elseif($item->status == 'telat')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Terlambat
                                </span>
                            @elseif($item->status == 'dihapus')
                                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">
                                    Dihapus
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Dikembalikan
                                </span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-center">

                            @if($kondisi == 'baik')
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs">
                                    Baik
                                </span>

                            @elseif($kondisi == 'rusak')
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">
                                    Rusak
                                </span>

                            @elseif($kondisi == 'hilang')
                                <span class="bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs">
                                    Hilang
                                </span>

                            @else
                                <span class="text-gray-400">-</span>
                            @endif

                        </td>

                    </tr>

                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-8 text-gray-400">
                            Tidak ada data
                        </td>
                    </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

        <div class="px-6 py-4 border-t bg-gray-50">
            {{ $peminjaman->withQueryString()->links() }}
        </div>

    </div>

</div>

@endsection
