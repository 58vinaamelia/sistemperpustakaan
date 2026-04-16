@extends('layouts.petugas.app')

@section('title', 'Tolak Peminjaman')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Alasan Penolakan Peminjaman</h4>
        <a href="{{ route('petugas.peminjaman.index') }}" class="btn btn-secondary">Batal</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('petugas.peminjaman.tolak', $pinjam->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Anggota</label>
                    <input type="text" class="form-control" value="{{ $pinjam->user->name ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" value="{{ $pinjam->buku->judul ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Alasan Penolakan</label>
                    <textarea name="alasan_ditolak" class="form-control" rows="4" required>{{ old('alasan_ditolak') }}</textarea>
                </div>

                <button type="submit" class="btn btn-danger">Tolak Peminjaman</button>
            </form>
        </div>
    </div>
</div>
@endsection
