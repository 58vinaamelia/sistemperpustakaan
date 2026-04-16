@extends('layouts.petugas.app')

@section('title', 'Kembalikan Buku')

@section('content')

<div class="container my-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Form Pengembalian Buku</h4>
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

            <form action="{{ route('petugas.peminjaman.kembalikan', $pinjam->id) }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nama Pemohon</label>
                    <input type="text" class="form-control" value="{{ $pinjam->user->name ?? '-' }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Judul Buku</label>
                    <input type="text" class="form-control" value="{{ $pinjam->buku->judul ?? '-' }}" readonly>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Pinjam</label>
                        <input type="text" class="form-control" value="{{ $pinjam->tanggal_pinjam ? \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('Y-m-d') : '-' }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Jatuh Tempo</label>
                        <input type="text" class="form-control" value="{{ $pinjam->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('Y-m-d') : '-' }}" readonly>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Kembali</label>
                        <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="form-control" value="{{ old('tanggal_kembali', now()->toDateString()) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Kondisi Buku</label>
                        <select name="kondisi_buku" id="kondisi_buku" class="form-select" required>
                            <option value="baik" {{ old('kondisi_buku') == 'baik' ? 'selected' : '' }}>Baik</option>
                            <option value="rusak" {{ old('kondisi_buku') == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            <option value="hilang" {{ old('kondisi_buku') == 'hilang' ? 'selected' : '' }}>Hilang</option>
                        </select>
                    </div>
                </div>

                <div class="mt-4">
                    <label class="form-label">Estimasi Denda</label>
                    <input type="text" id="denda_display" class="form-control" value="Rp 0" readonly>
                </div>

                <button type="submit" class="btn btn-primary mt-4">Simpan Pengembalian</button>
            </form>
        </div>
    </div>
</div>

<script>
    const dueDate = new Date('{{ $pinjam->tanggal_jatuh_tempo ? \Carbon\Carbon::parse($pinjam->tanggal_jatuh_tempo)->format('Y-m-d') : now()->toDateString() }}');
    const kondisiSelect = document.getElementById('kondisi_buku');
    const tanggalKembaliInput = document.getElementById('tanggal_kembali');
    const dendaDisplay = document.getElementById('denda_display');

    function formatRupiah(value) {
        return 'Rp ' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function updateDenda() {
        const selectedDate = new Date(tanggalKembaliInput.value);
        let denda = 0;

        if (selectedDate > dueDate) {
            const diff = Math.ceil((selectedDate - dueDate) / (1000 * 60 * 60 * 24));
            denda += diff * 1000;
        }

        if (kondisiSelect.value === 'rusak') {
            denda += 20000;
        }

        if (kondisiSelect.value === 'hilang') {
            denda += 50000;
        }

        dendaDisplay.value = formatRupiah(denda);
    }

    kondisiSelect.addEventListener('change', updateDenda);
    tanggalKembaliInput.addEventListener('change', updateDenda);

    updateDenda();
</script>

@endsection
