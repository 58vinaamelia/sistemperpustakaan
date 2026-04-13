@extends('layouts.app')

@section('content')

<h2 class="fw-bold mb-4">Form Peminjaman Buku</h2>

@if(session('error'))
<div style="background:#fee2e2;color:#991b1b;padding:12px;border-radius:8px;margin-bottom:15px;">
    ❌ {{ session('error') }}
</div>
@endif

@if(session('success'))
<div style="background:#dcfce7;color:#166534;padding:12px;border-radius:8px;margin-bottom:15px;">
    ✅ {{ session('success') }}
</div>
@endif

<div style="background:#d9d9d9; padding:35px; border-radius:10px;">

<form action="{{ route('anggota.buku.pinjam.store', $buku->id) }}" method="POST">
    @csrf

    <input type="hidden" name="buku_id" value="{{ $buku->id }}">

    <!-- NAMA -->
    <div class="mb-3">
        <label>Nama</label>
        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
    </div>

    <!-- JUDUL -->
    <div class="mb-3">
        <label>Judul Buku</label>
        <input type="text" class="form-control" value="{{ $buku->judul }}" readonly>
    </div>

    <!-- TANGGAL -->
    <div class="mb-3">
        <label>Tanggal Pinjam</label>
        <input type="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
    </div>

    <div class="mb-4">
        <label>Jatuh Tempo</label>
        <input type="date" class="form-control" value="{{ date('Y-m-d', strtotime('+7 days')) }}" readonly>
    </div>

    <!-- CEK JUMLAH PINJAM USER -->
    @php
        $jumlahPinjam = \App\Models\Anggota\Pinjambuku::where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->count();
    @endphp

    <div class="d-flex gap-2">

        @if($jumlahPinjam >= 3)
            <button type="button" class="btn btn-secondary" disabled>
                Maksimal 3 Buku
            </button>

        @elseif($buku->stok <= 0)
            <button type="button" class="btn btn-secondary" disabled>
                Stok Habis
            </button>

        @else
            <button type="submit" class="btn btn-primary">
                Pinjam Buku
            </button>
        @endif

        <a href="{{ route('anggota.buku.index') }}" class="btn btn-light">
            Cancel
        </a>

    </div>

</form>

</div>

@endsection
