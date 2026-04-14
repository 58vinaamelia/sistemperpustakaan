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

            <!-- JUDUL BUKU -->
            <div class="mb-3">
                <label class="form-label">Judul Buku</label>

                <select name="buku_id" class="form-control" required>
                    <option value="" disabled selected>Pilih buku</option>
                    @foreach($peminjaman as $item)
                        <option value="{{ $item->buku_id }}">
                            {{ $item->buku->judul }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- TANGGAL PINJAM -->
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" id="tanggal_pinjam" class="form-control"
                       value="{{ $peminjaman[0]->tanggal_pinjam }}" readonly>
            </div>

            <!-- JATUH TEMPO -->
            <div class="mb-3">
                <label class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" id="tanggal_jatuh_tempo" class="form-control"
                       value="{{ $peminjaman[0]->tanggal_jatuh_tempo }}" readonly>
            </div>

            <!-- TANGGAL KEMBALI -->
            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                       class="form-control"
                       min="{{ $peminjaman[0]->tanggal_pinjam }}"  <!-- 🔥 BATAS MIN -->
                       required>
            </div>

            <!-- KONDISI -->
            <div class="mb-3">
                <label class="form-label">Kondisi Buku</label>
                <select name="kondisi_buku" id="kondisi_buku" class="form-control" required>
                    <option value="baik">Baik</option>
                    <option value="rusak">Rusak</option>
                    <option value="hilang">Hilang</option>
                </select>
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
function hitungDenda() {

    let kembaliInput = document.getElementById('tanggal_kembali');
    let kembali = new Date(kembaliInput.value);

    let tempo = new Date(document.getElementById('tanggal_jatuh_tempo').value);
    let pinjam = new Date(document.getElementById('tanggal_pinjam').value);
    let kondisi = document.getElementById('kondisi_buku').value;

    let denda = 0;

    // 🔥 VALIDASI: tidak boleh sebelum tanggal pinjam
    if (kembali < pinjam) {
        alert("Tanggal kembali tidak boleh sebelum tanggal pinjam!");
        kembaliInput.value = "";
        document.getElementById('denda').value = "";
        return;
    }

    // telat
    if (kembali > tempo) {
        let selisih = (kembali - tempo) / (1000 * 60 * 60 * 24);
        denda += selisih * 5000;
    }

    // kondisi
    if (kondisi == 'rusak') {
        denda += 20000;
    }

    if (kondisi == 'hilang') {
        denda += 50000;
    }

    document.getElementById('denda').value = denda;
}

document.getElementById('tanggal_kembali').addEventListener('change', hitungDenda);
document.getElementById('kondisi_buku').addEventListener('change', hitungDenda);
</script>

@endsection
