@extends('layouts.petugas.app')

@section('content')

<div class="bg-white p-5 rounded shadow-sm">

    <h4 class="mb-4">Edit Buku</h4>

    <!-- ERROR VALIDATION -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('petugas.buku.update', $buku->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- JUDUL -->
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $buku->judul) }}">
        </div>

        <!-- PENGARANG -->
        <div class="mb-3">
            <label>Pengarang</label>
            <input type="text" name="pengarang" class="form-control" value="{{ old('pengarang', $buku->pengarang) }}">
        </div>

        <!-- PENERBIT -->
        <div class="mb-3">
            <label>Penerbit</label>
            <input type="text" name="penerbit" class="form-control" value="{{ old('penerbit', $buku->penerbit) }}">
        </div>

        <!-- TAHUN TERBIT (WAJIB) -->
        <div class="mb-3">
            <label>Tahun Terbit</label>
            <input type="number" name="tahun_terbit" class="form-control"
                   value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
        </div>

        <!-- STOK -->
        <div class="mb-3">
            <label>Stok</label>
            <input type="number" name="stok" class="form-control" value="{{ old('stok', $buku->stok) }}">
        </div>

        <!-- DESKRIPSI -->
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control" rows="3">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
        </div>

        <!-- FOTO -->
        <div class="mb-3">
            <label>Foto</label><br>

            @if($buku->foto)
                <img src="{{ asset('storage/'.$buku->foto) }}" width="100" class="mb-2 rounded">
            @else
                <img src="{{ asset('images/no-image.png') }}" width="100" class="mb-2">
            @endif

            <input type="file" name="foto" class="form-control">
        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('petugas.buku.index') }}" class="btn btn-secondary">Kembali</a>

    </form>

</div>

@endsection
