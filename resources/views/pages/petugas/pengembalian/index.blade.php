@extends('layouts.petugas.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Data Pengembalian Buku</h3>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light text-center">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Buku</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Status Pengembalian</th>
                <th>Kondisi Buku</th> {{-- ✅ FIX --}}
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->user->name ?? '-' }}</td>

                <td>{{ $item->buku->judul ?? '-' }}</td>

                <td>
                    {{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}
                </td>

                <td>
                    Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}
                </td>

                {{-- ✅ STATUS --}}
                <td>
                    @if($item->status == 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>

                    @elseif($item->status == 'diterima')
                        <span class="badge bg-success">Selesai</span>

                    @elseif($item->status == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>

                    @else
                        <span class="badge bg-secondary">-</span>
                    @endif
                </td>

                {{-- ✅ KONDISI BUKU (INI YANG DIPERBAIKI) --}}
                <td>
                    @if($item->kondisi_buku == 'baik')
                        <span class="badge bg-success">Baik</span>

                    @elseif($item->kondisi_buku == 'rusak')
                        <span class="badge bg-warning text-dark">Rusak</span>

                    @elseif($item->kondisi_buku == 'hilang')
                        <span class="badge bg-danger">Hilang</span>

                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>

                {{-- ✅ AKSI --}}
                <td>

                    {{-- MENUNGGU --}}
                    @if($item->status == 'menunggu')
                        <div class="d-flex justify-content-center gap-2">

                            <form action="{{ route('petugas.pengembalian.terima', $item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-success btn-sm">Terima</button>
                            </form>

                            <form action="{{ route('petugas.pengembalian.tolak', $item->id) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">Tolak</button>
                            </form>

                        </div>
                    @endif

                    {{-- SELESAI --}}
                    @if($item->status == 'diterima')
                        <div class="d-flex flex-column align-items-center gap-2">

                            <span class="text-success fw-bold">Selesai</span>

                            <a href="{{ route('petugas.pengembalian.struk', $item->id) }}"
                               class="btn btn-primary btn-sm">
                                Lihat Struk
                            </a>
                        </div>
                    @endif

                    {{-- DELETE --}}
                    <form action="{{ route('petugas.pengembalian.delete', $item->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-dark btn-sm">Hapus</button>
                    </form>

                </td>
            </tr>

            @empty
            <tr>
                <td colspan="8" class="text-muted">Tidak ada data</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
