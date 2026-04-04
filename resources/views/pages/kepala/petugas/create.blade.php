@extends('layouts.kepala.app')

@section('title', 'Tambah Petugas')

@section('content')

<div class="min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-2xl bg-white p-6 rounded-xl shadow-sm">

        {{-- HEADER --}}
        <div class="mb-6 text-center">
            <h2 class="text-xl font-bold text-gray-800">Tambah Petugas</h2>
            <p class="text-sm text-gray-500">Isi data petugas baru</p>
        </div>

        {{-- ERROR --}}
        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc ml-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('kepala.petugas.store') }}" method="POST">
            @csrf

            {{-- NAMA --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Nama</label>
                <input type="text" name="name"
                    value="{{ old('name') }}"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan nama">
            </div>

            {{-- EMAIL --}}
            <div class="mb-4">
                <label class="block mb-1 font-medium text-gray-700">Email</label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Masukkan email">
            </div>

            {{-- PASSWORD --}}
            <div class="mb-6">
                <label class="block mb-1 font-medium text-gray-700">Password</label>
                <input type="password" name="password"
                    class="w-full border border-gray-300 p-2 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    placeholder="Minimal 6 karakter">
            </div>

            {{-- BUTTON --}}
            <div class="flex justify-between items-center">
                <a href="{{ route('kepala.petugas.index') }}"
                   class="text-gray-600 hover:text-gray-800">
                    ← Kembali
                </a>

                <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                    Simpan
                </button>
            </div>

        </form>

    </div>

</div>

@endsection
