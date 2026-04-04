@extends('layouts.kepala.app')

@section('title', 'Data Petugas')

@section('content')

<div class="p-6 mt-6"> {{-- 🔥 kasih jarak dari atas --}}

    <div class="bg-white p-6 rounded-xl shadow-sm">

        {{-- HEADER --}}
        <div class="flex justify-between items-center mb-5">
            <h4 class="text-lg font-bold text-gray-800">Data Petugas</h4>

            <a href="{{ route('kepala.petugas.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Petugas
            </a>
        </div>

        {{-- NOTIFIKASI --}}
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- TABLE --}}
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-300 text-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-4 py-2 w-12">No</th>
                        <th class="border px-4 py-2">Nama</th>
                        <th class="border px-4 py-2">Email</th>
                        <th class="border px-4 py-2 w-40">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($petugas as $item)
                        <tr class="text-center hover:bg-gray-50 transition">
                            <td class="border px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="border px-4 py-2 text-left">{{ $item->name }}</td>
                            <td class="border px-4 py-2 text-left">{{ $item->email }}</td>
                            <td class="border px-4 py-2">

                                <div class="flex justify-center">

                                    {{-- HAPUS --}}
                                    <form action="{{ route('kepala.petugas.destroy', $item->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin hapus petugas ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg shadow transition">
                                            Hapus
                                        </button>
                                    </form>

                                </div>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border px-4 py-4 text-center text-gray-500">
                                Belum ada data petugas
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>

</div>

@endsection
