@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <!-- HEADER -->


    <!-- CARD -->
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered mb-0">
                <thead style="background-color: #f1f1f1;">
                    <tr class="text-center">
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

                            <td>{{ $data->buku->judul ?? '-' }}</td>

                            <td>{{ optional(\Carbon\Carbon::parse($data->tanggal_pinjam))->format('d-m-Y') ?? '-' }}</td>

                            <td>{{ optional(\Carbon\Carbon::parse($data->tanggal_kembali))->format('d-m-Y') ?? '-' }}</td>

                            <td>{{ optional(\Carbon\Carbon::parse($data->tanggal_jatuh_tempo))->format('d-m-Y') ?? '-' }}</td>

                            <td>
                                Rp {{ number_format($data->denda ?? 0, 0, ',', '.') }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @if($data->status == 'diterima')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($data->status == 'menunggu')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($data->status == 'ditolak')
                                    <span class="badge bg-danger">Ditolak</span>
                                @else
                                    <span class="badge bg-secondary">-</span>
                                @endif
                            </td>

                            {{-- KONDISI BUKU --}}
                            <td>
                                @if($data->kondisi_buku == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($data->kondisi_buku == 'rusak')
                                    <span class="badge bg-warning text-dark">Rusak</span>
                                @elseif($data->kondisi_buku == 'hilang')
                                    <span class="badge bg-danger">Hilang</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">
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
