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

    {{-- Tabel Anggota --}}
    <div class="overflow-x-auto w-full">
        <table class="w-full border border-gray-300 divide-y divide-gray-200 min-w-[600px]">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-gray-700">No</th>
                    <th class="px-4 py-2 text-left text-gray-700">Nama</th>
                    <th class="px-4 py-2 text-left text-gray-700">Email</th>
                    <th class="px-4 py-2 text-left text-gray-700">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($anggota as $item)
                    <tr>
                        <td class="px-4 py-2">{{ $loop->iteration }}</td>
                        <td class="px-4 py-2">{{ $item->nama }}</td>
                        <td class="px-4 py-2">{{ $item->email }}</td>
                        <td class="px-4 py-2">
                            <form action="{{ route('petugas.anggota.destroy', $item->id) }}" method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus anggota ini?')" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded shadow">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center px-4 py-2 text-gray-500">
                            Belum ada data anggota
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
