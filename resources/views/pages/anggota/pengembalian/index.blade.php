@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold m-0">Data Pengembalian Buku</h3>
        <a href="{{ route('anggota.pengembalian.create') }}" class="btn btn-primary">
            + Mengembalikan Buku
        </a>
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
                        <th>Jatuh Tempo</th>
                        <th>Denda</th>
                        <th>Status Pengembalian</th>
                        <th>Kondisi Buku</th>
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

                            <td>
                                Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($data->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>

                                @elseif($data->status == 'diterima')
                                    <span class="badge bg-success">Selesai</span>

                                @elseif($data->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>

                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>

                            {{-- 🔥 KONDISI BUKU (FIX DI SINI) --}}
                            <td>
                                @if($data->kondisi_buku)
                                    <span class="badge bg-info text-dark">
                                        {{ ucfirst($data->kondisi_buku) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">
                                Tidak ada data
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
