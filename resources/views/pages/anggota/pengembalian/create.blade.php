@extends('layouts.app')

@section('content')

<div class="container mt-4 mb-5">

    <h3 class="fw-bold mb-4">Form Pengembalian Buku</h3>

    <div style="background:#d9d9d9; padding:30px; border-radius:10px;">

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        @if($peminjaman->isEmpty())
            <div class="alert alert-warning">
                Tidak ada buku yang sedang dipinjam
            </div>
        @else

        <form action="{{ route('anggota.pengembalian.store') }}" method="POST">
            @csrf

            <!-- NAMA -->
            <div class="mb-3">
                <label class="form-label">Nama</label>
                <input type="text" class="form-control"
                       value="{{ Auth::user()->name }}" readonly>
            </div>

            <!-- 🔥 JUDUL BUKU (FIX ICON DROPDOWN) -->
            <div class="mb-3">
                <label class="form-label">Judul Buku</label>

                <div style="position:relative;">
                    <select name="buku_id" id="buku_id" class="form-control pe-5" required
                            style="appearance:none; -webkit-appearance:none;">
                        <option value="" disabled selected>Pilih buku</option>
                        @foreach($peminjaman as $item)
                            <option value="{{ $item->buku_id }}"
                                    data-pinjam="{{ $item->tanggal_pinjam }}"
                                    data-tempo="{{ $item->tanggal_jatuh_tempo }}">
                                {{ $item->buku->judul }}
                            </option>
                        @endforeach
                    </select>

                    <!-- ICON -->
                    <span style="position:absolute; right:15px; top:50%; transform:translateY(-50%); pointer-events:none;">
                        ▼
                    </span>
                </div>

                <input type="hidden" name="tanggal_pinjam" id="tanggal_pinjam"
                       value="{{ $peminjaman->first()?->tanggal_pinjam ?? '' }}">
                <input type="hidden" name="tanggal_jatuh_tempo" id="tanggal_jatuh_tempo"
                       value="{{ $peminjaman->first()?->tanggal_jatuh_tempo ?? '' }}">
            </div>

            <!-- TANGGAL KEMBALI -->
            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                    class="form-control"
                    min="{{ date('Y-m-d') }}" required>
            </div>

            <!-- 🔥 KONDISI BUKU (FIX ICON DROPDOWN) -->
            <div class="mb-3">
                <label class="form-label">Kondisi Buku</label>

                <div style="position:relative;">
                    <select name="kondisi_buku" id="kondisi_buku"
                            class="form-control pe-5"
                            required
                            style="appearance:none; -webkit-appearance:none;">
                        <option value="baik">Baik</option>
                        <option value="rusak">Rusak</option>
                        <option value="hilang">Hilang</option>
                    </select>

                    <!-- ICON -->
                    <span style="position:absolute; right:15px; top:50%; transform:translateY(-50%); pointer-events:none;">
                        ▼
                    </span>
                </div>
            </div>

            <!-- DENDA -->
            <div class="mb-3">
                <label class="form-label">Jumlah Denda</label>
                <input type="number" name="denda" id="denda" class="form-control" readonly>
            </div>

            <!-- BUTTON -->
            <button type="submit" class="btn btn-primary">Kembalikan</button>

        </form>

        @endif

    </div>

</div>

<script>
function updateTanggalPeminjaman() {
    const select = document.getElementById('buku_id');
    const option = select.options[select.selectedIndex];
    const pinjamInput = document.getElementById('tanggal_pinjam');
    const tempoInput = document.getElementById('tanggal_jatuh_tempo');

    if (!option || !option.value) {
        pinjamInput.value = '';
        tempoInput.value = '';
        document.getElementById('denda').value = '';
        return;
    }

    pinjamInput.value = option.dataset.pinjam || '';
    tempoInput.value = option.dataset.tempo || '';
    hitungDenda();
}

function hitungDenda() {
    const kembaliInput = document.getElementById('tanggal_kembali');
    const kembali = new Date(kembaliInput.value);

    const tempo = new Date(document.getElementById('tanggal_jatuh_tempo').value);
    const pinjam = new Date(document.getElementById('tanggal_pinjam').value);
    const kondisi = document.getElementById('kondisi_buku').value;

    const dendaInput = document.getElementById('denda');

    if (!kembaliInput.value || !pinjam || !tempo) {
        dendaInput.value = '';
        return;
    }

    let denda = 0;

    if (kembali < pinjam) {
        alert('Tanggal kembali tidak boleh sebelum tanggal pinjam!');
        kembaliInput.value = '';
        dendaInput.value = '';
        return;
    }

    if (kembali > tempo) {
        const selisih = Math.ceil((kembali - tempo) / (1000 * 60 * 60 * 24));
        denda += selisih * 5000;
    }

    if (kondisi === 'rusak') {
        denda += 20000;
    }

    if (kondisi === 'hilang') {
        denda += 50000;
    }

    dendaInput.value = denda;
}

document.getElementById('buku_id').addEventListener('change', updateTanggalPeminjaman);
document.getElementById('tanggal_kembali').addEventListener('change', hitungDenda);
document.getElementById('kondisi_buku').addEventListener('change', hitungDenda);

document.addEventListener('DOMContentLoaded', function () {
    updateTanggalPeminjaman();
});
</script>

@endsection
