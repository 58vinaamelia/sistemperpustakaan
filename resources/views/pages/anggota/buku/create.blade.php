@extends('layouts.app')

@section('content')

<h2 class="fw-bold mb-4">Form Peminjaman Buku</h2>

<div style="background:#d9d9d9; padding:35px; border-radius:10px;">

<form action="{{ route('anggota.buku.pinjam.store', $buku->id) }}" method="POST">
    @csrf

    <!-- NAMA (readonly) -->
    <div class="mb-3">
        <label class="form-label">Nama</label>
        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
    </div>

    <!-- JUDUL BUKU (readonly) -->
    <div class="mb-3">
        <label class="form-label">Judul Buku</label>
        <input type="text" class="form-control" value="{{ $buku->judul }}" readonly>
    </div>

    <!-- TANGGAL PINJAM -->
    <div class="mb-3">
        <label class="form-label">Tanggal Pinjam</label>
        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
    </div>

    <!-- TANGGAL JATUH TEMPO -->
    <div class="mb-4">
        <label class="form-label">Tanggal Jatuh Tempo</label>
        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" readonly>
    </div>

    <!-- TOMBOL -->
    <div class="d-flex gap-2">
        <button type="submit" class="btn text-white" style="background:#4e63c9; width:150px;">
            Meminjam
        </button>

        <a href="{{ route('anggota.buku.index') }}" class="btn" style="background:#bfbfbf; width:150px;">
            Cancel
        </a>
    </div>

</form>

</div>

@endsection
