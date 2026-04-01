@extends('layouts.petugas.app')

@section('content')

<div class="bg-white p-5 rounded shadow-sm">

    <h4 class="mb-4">Detail Buku</h4>

    <div class="row">

        <!-- FOTO -->
        <div class="col-md-4 text-center">
            @if($buku->foto)
                <img src="{{ asset('storage/'.$buku->foto) }}"
                     class="img-fluid rounded mb-3" style="max-height:300px;">
            @else
                <img src="{{ asset('images/no-image.png') }}"
                     class="img-fluid rounded mb-3">
            @endif
        </div>

        <!-- DETAIL -->
        <div class="col-md-8">

            <p><strong>Judul:</strong> {{ $buku->judul }}</p>
            <p><strong>Pengarang:</strong> {{ $buku->pengarang }}</p>
            <p><strong>Penerbit:</strong> {{ $buku->penerbit }}</p>
            <p><strong>Tahun Terbit:</strong> {{ $buku->tahun }}</p>
            <p><strong>Stok:</strong> {{ $buku->stok }}</p>

            <p><strong>Status:</strong>
                @if($buku->stok > 0)
                    <span class="text-success">Tersedia</span>
                @else
                    <span class="text-danger">Habis</span>
                @endif
            </p>

            <p><strong>Deskripsi:</strong><br>
                {{ $buku->deskripsi ?? '-' }}
            </p>

            <!-- BUTTON -->
            <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary">Kembali</a>

        </div>

    </div>

</div>

@endsection
