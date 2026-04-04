@extends('layouts.kepala.app')

@section('content')

<div class="container py-5"> {{-- kasih jarak atas & bawah --}}

    <div class="bg-white p-5 rounded shadow-sm mx-auto" style="max-width: 900px;">

        <h4 class="mb-4 text-center">Detail Buku</h4>

        <div class="row align-items-start">

            <!-- FOTO -->
            <div class="col-md-4 text-center mb-4 mb-md-0">
                @if($buku->foto)
                    <img src="{{ asset('storage/'.$buku->foto) }}"
                         class="img-fluid rounded shadow-sm"
                         style="max-height:300px;">
                @else
                    <img src="{{ asset('images/no-image.png') }}"
                         class="img-fluid rounded shadow-sm">
                @endif
            </div>

            <!-- DETAIL -->
            <div class="col-md-8">

                <div class="mb-2">
                    <strong>Judul:</strong> {{ $buku->judul }}
                </div>

                <div class="mb-2">
                    <strong>Pengarang:</strong> {{ $buku->pengarang }}
                </div>

                <div class="mb-2">
                    <strong>Penerbit:</strong> {{ $buku->penerbit }}
                </div>

                <div class="mb-2">
                    <strong>Tahun Terbit:</strong> {{ $buku->tahun }}
                </div>

                <div class="mb-2">
                    <strong>Stok:</strong> {{ $buku->stok }}
                </div>

                <div class="mb-2">
                    <strong>Status:</strong>
                    @if($buku->stok > 0)
                        <span class="text-success">Tersedia</span>
                    @else
                        <span class="text-danger">Habis</span>
                    @endif
                </div>

                <div class="mb-3">
                    <strong>Deskripsi:</strong><br>
                    {{ $buku->deskripsi ?? '-' }}
                </div>

                <!-- BUTTON -->
                <a href="{{ route('kepala.buku.index') }}"
                   class="btn btn-secondary mt-3">
                    ← Kembali
                </a>

            </div>

        </div>

    </div>

</div>

@endsection
