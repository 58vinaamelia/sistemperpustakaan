@extends('layouts.app')

@section('content')

<div class="container mt-4 mb-5">

    <h3 class="fw-bold mb-4">Form Pengembalian Buku</h3>

    <div style="background:#d9d9d9; padding:30px; border-radius:10px;">

        {{-- ERROR --}}
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

    <div class="position-relative">

        <select name="buku_id"
                class="form-control pe-5"
                size="1"
                onfocus="this.size=5;"
                onblur="this.size=1;"
                onchange="this.size=1; this.blur();"
                required>

            <option value="" disabled selected>Pilih buku yang dikembalikan</option>

            @foreach($peminjaman as $item)
                <option value="{{ $item->buku_id }}">
                    {{ $item->buku->judul }}
                    (Pinjam: {{ \Carbon\Carbon::parse($item->tanggal_pinjam)->format('d/m/Y') }})
                </option>
            @endforeach

        </select>

        <!-- ICON -->
        <span style="
            position:absolute;
            right:15px;
            top:50%;
            transform:translateY(-50%);
            pointer-events:none;
            font-size:14px;
        ">
            ▼
        </span>

    </div>
</div>

            <!-- TANGGAL PINJAM -->
            <div class="mb-3">
                <label class="form-label">Tanggal Pinjam</label>
                <input type="date" class="form-control"
                       value="{{ $peminjaman[0]->tanggal_pinjam }}" readonly>
            </div>

            <!-- TANGGAL JATUH TEMPO -->
            <div class="mb-3">
                <label class="form-label">Tanggal Jatuh Tempo</label>
                <input type="date" id="tanggal_jatuh_tempo" class="form-control"
                       value="{{ $peminjaman[0]->tanggal_jatuh_tempo }}" readonly>
            </div>

            <!-- ✅ TANGGAL KEMBALI (SUDAH DIPERBAIKI) -->
            <div class="mb-3">
                <label class="form-label">Tanggal Kembali</label>
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                       class="form-control"
                       min="{{ $peminjaman[0]->tanggal_pinjam }}"
                       required>
            </div>

            <!-- DENDA -->
            <div class="mb-3">
                <label class="form-label">Jumlah Denda</label>
                <input type="number" name="denda" id="denda" class="form-control" readonly>
            </div>

            <!-- BUTTON -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    Mengembalikan
                </button>

                <a href="{{ route('anggota.pengembalian.index') }}" class="btn btn-secondary">
                    Cancel
                </a>
            </div>

        </form>

        @endif

    </div>

</div>

<!-- SCRIPT (TETAP PUNYA KAMU, TIDAK DIUBAH) -->
<script>
document.getElementById('tanggal_kembali')?.addEventListener('change', function () {
    let kembali = new Date(this.value);
    let tempo = new Date(document.getElementById('tanggal_jatuh_tempo').value);

    let denda = 0;
    if (kembali > tempo) {
        let selisih = (kembali - tempo) / (1000 * 60 * 60 * 24);
        denda = selisih * 1000;
    }

    document.getElementById('denda').value = denda;
});
</script>

@endsection
