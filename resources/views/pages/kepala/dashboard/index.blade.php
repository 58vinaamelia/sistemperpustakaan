@extends('layouts.kepala.app')

@section('title', 'Dashboard Kepala')

@section('content')

<div class="mt-8 px-6">

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        {{-- Total Anggota --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Anggota</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalAnggota }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-orange-100 text-orange-500">
                <i class="ti ti-users text-xl"></i>
            </div>
        </div>

        {{-- Total Buku --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Buku</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalBuku }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-blue-100 text-blue-500">
                <i class="ti ti-book text-xl"></i>
            </div>
        </div>

        {{-- Total Peminjaman --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Total Peminjaman</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $totalPeminjaman }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-green-100 text-green-500">
                <i class="ti ti-repeat text-xl"></i>
            </div>
        </div>

        {{-- Peminjaman Terlambat --}}
        <div class="bg-white p-5 rounded-xl shadow flex items-center justify-between">
            <div>
                <p class="text-sm text-gray-500">Peminjaman Terlambat</p>
                <h2 class="text-2xl font-bold text-gray-800 mt-1">{{ $peminjamanTerlambat }}</h2>
            </div>
            <div class="w-12 h-12 flex items-center justify-center rounded-full bg-red-100 text-red-500">
                <i class="ti ti-alert-circle text-xl"></i>
            </div>
        </div>

    </div>

</div>

@endsection
