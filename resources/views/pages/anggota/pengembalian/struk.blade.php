@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="card p-4" style="max-width:500px; margin:auto;">
        <h4 class="text-center mb-3">Struk Pengembalian Buku</h4>

        <hr>

        <p><strong>Nama:</strong> {{ $nama }}</p>
        <p><strong>Judul Buku:</strong> {{ $judul }}</p>
        <p><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($tanggal_pinjam)->format('d-m-Y') }}</p>
        <p><strong>Tanggal Kembali:</strong> {{ \Carbon\Carbon::parse($tanggal_kembali)->format('d-m-Y') }}</p>
        <p><strong>Denda:</strong> Rp {{ number_format($denda,0,',','.') }}</p>

        <hr>

        <p class="text-center">Terima kasih 🙏</p>

        
            {{-- TOMBOL KEMBALI --}}
            <a href="{{ route('anggota.pengembalian.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

</div>

@endsection
