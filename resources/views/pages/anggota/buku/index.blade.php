@extends('layouts.app')

@section('content')

<h4 class="fw-bold mb-4">Daftar Buku</h4>

<!-- SEARCH -->
<form action="{{ route('anggota.buku.index') }}" method="GET">
    <div class="mb-4">
        <div class="input-group">
            <span class="input-group-text border-0 bg-light">🔍</span>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   class="form-control border-0 bg-light"
                   placeholder="Cari buku..."
                   onkeydown="if(event.key==='Enter'){this.form.submit()}">
        </div>
    </div>
</form>

<!-- CARDS -->
<div class="d-flex flex-wrap justify-content-start gap-2">

    @forelse ($buku as $item)
        <div class="text-center shadow rounded p-3"
             style="background:#f5f5f5; width:160px;">

            <!-- FOTO -->
            <div class="d-flex justify-content-center mb-2">
                <img src="{{ $item->foto
                    ? asset('storage/'.$item->foto)
                    : 'https://via.placeholder.com/150x200' }}"
                     style="width:130px; height:180px; object-fit:cover; border-radius:6px;">
            </div>

            <!-- JUDUL -->
            <h6 class="mb-1" style="font-size:13px;">
                {{ $item->judul }}
            </h6>

            <!-- STATUS (FIX) -->
            @if($item->sedang_dipinjam)
                <span class="badge bg-danger mb-2">Sedang Dipinjam</span>
            @else
                <span class="badge bg-success mb-2">Tersedia</span>
            @endif

            <!-- BUTTON -->
            <a href="{{ route('anggota.buku.detail', $item->id) }}"
               class="btn btn-sm text-white"
               style="background:#4e63c9;">
               Detail
            </a>

        </div>
    @empty
        <p class="text-muted">Buku tidak ditemukan 😢</p>
    @endforelse

</div>

@endsection
