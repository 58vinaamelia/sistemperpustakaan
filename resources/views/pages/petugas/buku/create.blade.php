@extends('layouts.petugas.app')

@section('content')

<div class="container mt-4 mb-5">

    <div class="card p-4 shadow-sm" style="background:#f5f6f8; border-radius:12px;">

        <!-- ERROR VALIDATION -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- FOTO -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Foto</label>
                <input type="file" name="foto" class="form-control">
            </div>

            <!-- JUDUL -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Judul Buku</label>
                <input type="text" name="judul" class="form-control" value="{{ old('judul') }}">
            </div>

            <!-- PENGARANG -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang') }}">
            </div>

            <!-- PENERBIT -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit') }}">
            </div>

            <!-- Tahun terbit -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Terbit</label>
                <input type="number" name="tahun" class="form-control" value="{{ old('tahun') }}" placeholder="Contoh: 2024">
            </div>

            <!-- STOK -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" class="form-control" value="{{ old('stok') }}">
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi') }}</textarea>
            </div>

            <!-- BUTTON -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn text-white px-4" style="background:#4e63c9;">
                    Create
                </button>

                <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary px-4">
                    Cancel
                </a>
            </div>

        </form>

    </div>

</div>

@endsection
