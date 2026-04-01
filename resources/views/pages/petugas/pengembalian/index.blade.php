@extends('layouts.petugas.app')

@section('title', 'Data Pengembalian')

@section('content')

<div class="p-6">

    <h1 class="text-2xl font-bold mb-4">Data Pengembalian</h1>

    <div class="bg-white shadow rounded-lg overflow-x-auto">

        <table class="min-w-full text-sm text-left">
            <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-6 py-3">No</th>
                    <th class="px-6 py-3">Nama Anggota</th>
                    <th class="px-6 py-3">Judul Buku</th>
                    <th class="px-6 py-3">Tanggal Pinjam</th>
                    <th class="px-6 py-3">Tanggal Kembali</th>
                    <th class="px-6 py-3">Status</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">
                @forelse($pengembalians as $item)
                <tr class="border-b">
                    <td class="px-6 py-3">{{ $loop->iteration }}</td>

                    <td class="px-6 py-3">
                        {{ $item->user->name ?? '-' }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $item->buku->judul ?? '-' }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $item->peminjaman->tanggal_pinjam ?? '-' }}
                    </td>

                    <td class="px-6 py-3">
                        {{ $item->tanggal_kembali }}
                    </td>

                    <td class="px-6 py-3">
                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                            Dikembalikan
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        Data kosong
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection
