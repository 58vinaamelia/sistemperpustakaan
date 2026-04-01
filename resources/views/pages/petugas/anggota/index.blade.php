@extends('layouts.petugas.app')

@section('title', 'Data Anggota')

@section('content')
<div class="bg-white p-5 rounded-xl shadow-sm">
    <h4 class="text-lg font-bold mb-4">Data Anggota</h4>

    {{-- Notifikasi --}}
    @if(session('info'))
        <div class="mb-4 p-3 bg-yellow-100 text-yellow-800 rounded">
            {{ session('info') }}
        </div>
    @endif

    <table class="table-auto w-full border border-gray-300">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-4 py-2">No</th>
                <th class="border px-4 py-2">Nama</th>
                <th class="border px-4 py-2">Email</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($anggota as $item)
                <tr>
                    <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                    <td class="border px-4 py-2">{{ $item->nama }}</td>
                    <td class="border px-4 py-2">{{ $item->email }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center border px-4 py-2">Belum ada data anggota</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
