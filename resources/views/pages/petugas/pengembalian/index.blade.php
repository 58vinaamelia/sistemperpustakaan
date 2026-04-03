@extends('layouts.petugas.app')

@section('title', 'Data Pengembalian')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Data Pengembalian Buku</h3>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-light text-center">
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Buku</th>
                <th>Tanggal Kembali</th>
                <th>Denda</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody class="text-center">
            @forelse($data as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $item->user->name ?? 'User tidak ditemukan' }}</td>
                <td>{{ $item->buku->judul ?? 'Buku tidak ditemukan' }}</td>
                <td>{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d-m-Y') }}</td>
                <td>Rp {{ number_format($item->denda, 0, ',', '.') }}</td>

                {{-- STATUS --}}
                <td>
                    @if($item->status == 'menunggu')
                        <span class="badge bg-warning text-dark">Menunggu</span>

                    @elseif($item->status == 'diterima')
                        <span class="badge bg-success">Dikembalikan</span>

                    @elseif($item->status == 'ditolak')
                        <span class="badge bg-danger">Ditolak</span>

                    @else
                        <span class="badge bg-secondary">-</span>
                    @endif
                </td>

                {{-- AKSI --}}
                <td>
                    @if($item->status == 'menunggu')
                        <div class="d-flex justify-content-center gap-2">

                            {{-- TERIMA --}}
                            <form action="{{ route('petugas.pengembalian.terima', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin konfirmasi pengembalian ini?')">
                                @csrf
                                <button type="submit" class="btn btn-success btn-sm">Terima</button>
                            </form>

                            {{-- TOLAK --}}
                            <form action="{{ route('petugas.pengembalian.tolak', $item->id) }}" method="POST"
                                onsubmit="return confirm('Yakin tolak pengembalian ini?')">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                            </form>

                        </div>
                    @else
                        <span class="text-success fw-bold">Selesai</span>
                    @endif

                    {{-- DELETE --}}
                    <form action="{{ route('petugas.pengembalian.delete', $item->id) }}" method="POST" class="mt-2"
                        onsubmit="return confirm('Yakin hapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-dark btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">Tidak ada data pengembalian</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
