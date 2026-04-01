@extends('layouts.petugas.app')

@section('content')

<div class="container mt-4 mb-5"> <!-- tambah mb-5 biar ada jarak ke footer -->

    <div class="card p-4 shadow-sm" style="background:#f5f6f8; border-radius:12px;">

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
                <input type="text" name="judul" class="form-control" placeholder="Masukkan judul buku">
            </div>

            <!-- PENGARANG -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Pengarang</label>
                <input type="text" name="pengarang" class="form-control" placeholder="Masukkan pengarang">
            </div>

            <!-- PENERBIT -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Penerbit</label>
                <input type="text" name="penerbit" class="form-control" placeholder="Masukkan penerbit">
            </div>

            <!-- TAHUN TERBIT -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Tahun Terbit</label>
                <input type="number" name="tahun_terbit" class="form-control" placeholder="Contoh: 2024">
            </div>

            <!-- STOK -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Stok</label>
                <input type="number" name="stok" class="form-control" placeholder="Masukkan jumlah stok">
            </div>

            <!-- DESKRIPSI -->
            <div class="mb-3">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="deskripsi" class="form-control" rows="3" placeholder="Masukkan deskripsi"></textarea>
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
