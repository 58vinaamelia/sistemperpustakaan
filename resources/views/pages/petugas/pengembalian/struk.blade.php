@extends('layouts.petugas.app')

@section('title', 'Struk Pengembalian')

@section('content')

<div class="container mt-4">

    <div class="card p-4 shadow struk-area" style="max-width:500px; margin:auto;">

        <h4 class="text-center mb-3">Struk Pengembalian Buku</h4>

        <hr>

        <p><strong>Nama:</strong> {{ $nama }}</p>

        <p><strong>Judul Buku:</strong> {{ $judul }}</p>

        <p><strong>Tanggal Pinjam:</strong>
            {{ \Carbon\Carbon::parse($tanggal_pinjam)->format('d-m-Y') }}
        </p>

        <p><strong>Tanggal Kembali:</strong>
            {{ \Carbon\Carbon::parse($tanggal_kembali)->format('d-m-Y') }}
        </p>

        <p><strong>Denda:</strong>
            Rp {{ number_format($denda, 0, ',', '.') }}
        </p>

        <hr>

        <p class="text-center text-success fw-bold">
            Status: {{ $status }}
        </p>

        <p class="text-center">Terima kasih 🙏</p>

        {{-- ✅ TOMBOL --}}
        <div class="text-center mt-3 no-print">
            <button onclick="window.print()" class="btn btn-primary">
                🖨️ Print Struk
            </button>

            <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-secondary">
                Kembali
            </a>
        </div>

    </div>

</div>

{{-- ✅ CSS PRINT (INI YANG PALING PENTING) --}}
<style>
@media print {

    body * {
        visibility: hidden;
    }

    .struk-area, .struk-area * {
        visibility: visible;
    }

    .struk-area {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
    }

    .no-print {
        display: none;
    }
}
</style>

@endsection
