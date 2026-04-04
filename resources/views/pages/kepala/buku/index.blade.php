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
<form action="{{ route('petugas.buku.index') }}" method="GET">
    <div class="mb-4" style="max-width:400px;">
        <div class="input-group">
            <span class="input-group-text border-0 bg-light">🔍</span>
            <input type="text" name="search" value="{{ request('search') }}"
                class="form-control border-0 bg-light" placeholder="Cari buku..."
                onkeydown="if(event.key==='Enter'){this.form.submit()}">
        </div>
    </div>
</form>

<!-- CARDS -->
<div class="d-flex flex-wrap justify-content-start gap-4">

    @forelse ($buku as $item)
        <div class="text-center shadow rounded p-3"
             style="background:#f5f5f5; width:170px; transition:0.3s;"
             onmouseover="this.style.transform='scale(1.05)'"
             onmouseout="this.style.transform='scale(1)'">

            <!-- FOTO -->
            <div class="d-flex justify-content-center mb-2">
                <img src="{{ $item->foto ? asset('storage/'.$item->foto) : asset('images/no-image.png') }}"
                    style="width:130px; height:180px; object-fit:cover; border-radius:6px;">
            </div>

            <!-- JUDUL -->
            <h6 class="mb-1 text-truncate" style="font-size:13px; max-width:130px;">
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

            <!-- BUTTON DETAIL SAJA -->
            <a href="{{ route('kepala.buku.show', $item->id) }}"
               class="btn btn-sm text-white"
               style="background:#4e63c9; width:100%;">
                Detail
            </a>

        </div>

    @empty
        <p class="text-muted">Buku tidak ditemukan 😢</p>
    @endforelse

</div>

@endsection
