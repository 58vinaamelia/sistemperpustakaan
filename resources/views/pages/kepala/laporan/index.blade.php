@extends('layouts.kepala.app')

@section('title', 'Laporan')

@section('content')

<div class="mt-10 px-8">

    {{-- HEADER --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Laporan Peminjaman</h1>
        <p class="text-sm text-gray-500">Data seluruh peminjaman buku</p>

        @if(request('bulan'))
            <p class="text-sm text-blue-500 mt-1">
                Filter Bulan: {{ request('bulan') }}
            </p>
        @elseif(request('dari') && request('sampai'))
            <p class="text-sm text-blue-500 mt-1">
                Filter: {{ request('dari') }} s/d {{ request('sampai') }}
            </p>
        @endif
    </div>

    {{-- FILTER --}}
    <div class="bg-white p-4 rounded-xl shadow mb-6">
        <form class="flex flex-wrap gap-4 items-end" method="GET">

            {{-- FILTER BULAN --}}
            <div>
                <label class="text-sm text-gray-600">Filter Bulan</label>
                <input type="month" name="bulan"
                    value="{{ request('bulan') }}"
                    class="border rounded-lg px-3 py-2 text-sm w-full">
            </div>

            {{-- ATAU TANGGAL --}}
            <div>
                <label class="text-sm text-gray-600">Dari Tanggal</label>
                <input type="date" name="dari"
                    value="{{ request('dari') }}"
                    class="border rounded-lg px-3 py-2 text-sm w-full">
            </div>

            <div>
                <label class="text-sm text-gray-600">Sampai Tanggal</label>
                <input type="date" name="sampai"
                    value="{{ request('sampai') }}"
                    class="border rounded-lg px-3 py-2 text-sm w-full">
            </div>

            <button type="submit"
                class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                Filter
            </button>

            {{-- RESET --}}
            <a href="{{ route('kepala.laporan.index') }}"
               class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500">
                Reset
            </a>

        </form>
    </div>

    {{-- TABEL --}}
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3">No</th>
                    <th class="px-4 py-3">Nama Anggota</th>
                    <th class="px-4 py-3">Judul Buku</th>
                    <th class="px-4 py-3">Tanggal Pinjam</th>
                    <th class="px-4 py-3">Tanggal Kembali</th>
                    <th class="px-4 py-3">Status</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @forelse($peminjaman as $index => $item)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $index + 1 }}</td>
                    <td class="px-4 py-3">{{ $item->user->name ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $item->buku->judul ?? '-' }}</td>
                    <td class="px-4 py-3">
                        {{ $item->tanggal_pinjam ? date('d-m-Y', strtotime($item->tanggal_pinjam)) : '-' }}
                    </td>
                    <td class="px-4 py-3">
                        {{ $item->tanggal_kembali ? date('d-m-Y', strtotime($item->tanggal_kembali)) : '-' }}
                    </td>
                    <td class="px-4 py-3">
                        @if($item->status == 'dipinjam')
                            <span class="bg-yellow-100 text-yellow-600 px-2 py-1 rounded text-xs">
                                Dipinjam
                            </span>
                        @else
                            <span class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                Kembali
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">
                        Data tidak tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection
