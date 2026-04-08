@extends('layouts.kepala.app')

@section('content')

<!-- NOTIFIKASI -->
@if(session('success'))
    <div class="alert alert-success mt-2">
        {{ session('success') }}
    </div>
@endif

<!-- HEADER -->
<div class="d-flex justify-content-between align-items-center mt-3 mb-4">
    <h4 class="fw-bold m-0">Katalog Buku</h4>
</div>

<!-- SEARCH -->
<form action="{{ route('kepala.buku.index') }}" method="GET">
    <div class="mb-4" style="max-width:400px;">
        <div class="input-group">
            <span class="input-group-text border-0 bg-light">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control border-0 bg-light" placeholder="Cari buku..."
                onkeydown="if(event.key==='Enter'){this.form.submit()}">
        </div>
    </div>
</form>

<!-- 🔥 GRID -->
<div class="row">

    @forelse ($buku as $item)
        <div class="col-md-2 col-sm-4 col-6 mb-4"> {{-- 6 per baris desktop --}}

            <div class="text-center shadow rounded p-3 h-100"
                 style="background:#f5f5f5; transition:0.3s;"
                 onmouseover="this.style.transform='scale(1.05)'"
                 onmouseout="this.style.transform='scale(1)'">

                <!-- FOTO -->
                <div class="d-flex justify-content-center mb-2">
                    <img src="{{ $item->foto ? asset('storage/'.$item->foto) : asset('images/no-image.png') }}"
                        style="width:100%; max-width:120px; height:170px; object-fit:cover; border-radius:6px;">
                </div>

                <!-- JUDUL -->
                <h6 class="mb-1 text-truncate" style="font-size:13px;">
                    {{ $item->judul }}
                </h6>

                <!-- STOK -->
                <p class="mb-1" style="font-size:12px;">
                    Stok: <strong>{{ $item->stok }}</strong>
                </p>

                <!-- STATUS -->
                <p class="mb-2" style="font-size:12px;">
                    @if($item->stok > 0)
                        <span class="text-success">Tersedia</span>
                    @else
                        <span class="text-danger">Habis</span>
                    @endif
                </p>

                <!-- DETAIL -->
                <a href="{{ route('kepala.buku.show', $item->id) }}"
                   class="btn btn-sm text-white"
                   style="background:#4e63c9; width:100%;">
                    Detail
                </a>

            </div>

        </div>
    @empty
        <p class="text-muted">Buku tidak ditemukan 😢</p>
    @endforelse

</div>

<!-- 🔥 LIHAT SEMUA -->
<div class="mt-4 text-center">

    @if(!request('lihat_semua'))
        <a href="{{ route('kepala.buku.index', [
                'lihat_semua' => 1,
                'search' => request('search')
            ]) }}"
           class="btn btn-primary">
            Lihat Semua
        </a>
    @else
        <a href="{{ route('kepala.buku.index', [
                'search' => request('search')
            ]) }}"
           class="btn btn-secondary">
            Tampilkan Lebih Sedikit
        </a>
    @endif

</div>

@endsection
