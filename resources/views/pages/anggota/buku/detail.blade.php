@extends('layouts.app')

@section('content')

<h2 class="fw-bold mb-4">Detail Buku</h2>

<div style="background:#e9e9e9; padding:30px; display:flex; gap:40px;">

    <!-- BAGIAN KIRI -->
    <div style="text-align:center;">

        <img src="{{ asset('storage/'.$buku->foto) }}" style="width:180px;">

        <!-- TOMBOL -->
        <div class="mt-3 d-flex gap-2 justify-content-center">

            @if($dipinjam)
                <button class="btn btn-warning" disabled>
                    Sedang Dipinjam
                </button>

            @elseif($buku->stok > 0)
                <a href="/anggota/buku/{{ $buku->id }}/pinjam" class="btn btn-success">
                    Pinjam
                </a>

            @else
                <button class="btn btn-danger" disabled>
                    Stok Habis
                </button>
            @endif

            <a href="/anggota/buku" class="btn btn-secondary">
                Cancel
            </a>

        </div>

    </div>

    <!-- BAGIAN KANAN -->
    <div>

        <p><b>Judul:</b> {{ $buku->judul }}</p>
        <p><b>Pengarang:</b> {{ $buku->pengarang }}</p>
        <p><b>Penerbit:</b> {{ $buku->penerbit }}</p>
        <p><b>Tahun Terbit:</b> {{ $buku->tahun }}</p>
        <p><b>Stok:</b> {{ $buku->stok }}</p>

        <!-- STATUS -->
        <p>
            <b>Status:</b>

            @if($dipinjam)
                <span class="text-warning">Sedang Dipinjam</span>

            @elseif($buku->stok == 0)
                <span class="text-danger">Habis</span>

            @else
                <span class="text-success">Tersedia</span>
            @endif
        </p>

        <p class="mt-3"><b>Deskripsi</b></p>
        <p>{{ $buku->deskripsi }}</p>

    </div>

</div>

@endsection
