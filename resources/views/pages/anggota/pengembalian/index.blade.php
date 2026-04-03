@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- HEADER + BUTTON -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">Data Pengembalian Buku</h3>
        <a href="{{ route('anggota.pengembalian.create') }}" class="btn btn-primary"> + Mengembalikan Buku </a>
    </div>

    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-bordered mb-0">
                <thead style="background-color: #f1f1f1;">
                    <tr class="text-center">
                        <th>Nama</th>
                        <th>Judul Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Tanggal Jatuh Tempo</th>
                        <th>Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pengembalian as $data)
                        <tr class="text-center align-middle">
                            <td>{{ $data->nama }}</td>
                            <td>{{ $data->buku->judul ?? '-' }}</td>
                            <td>{{ $data->tanggal_pinjam }}</td>
                            <td>{{ $data->tanggal_kembali }}</td>
                            <td>{{ $data->tanggal_jatuh_tempo }}</td>
                            <td>Rp {{ number_format($data->denda, 0, ',', '.') }}</td>
                            <td>
                                @if($data->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu Konfirmasi</span>
                                @elseif($data->status == 'Selesai')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($data->status == 'Ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">{{ $data->status }}</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
