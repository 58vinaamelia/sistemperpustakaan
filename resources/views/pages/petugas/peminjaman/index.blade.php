@extends('layouts.petugas.app')

@section('title', 'Data Peminjaman')

@section('content')

<div class="bg-white p-5 rounded-xl shadow-sm">

    <h4 class="text-lg font-bold mb-4">Konfirmasi Peminjaman</h4>

    {{-- NOTIFIKASI --}}
    @if(session('success'))
        <div style="margin-bottom:10px; padding:10px; background:#d4edda; color:#155724; border-radius:5px;">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="w-full text-sm text-center border border-gray-200">

            {{-- HEADER --}}
            <thead style="background:#f1f1f1;">
                <tr>
                    <th class="py-3 px-2">Nama</th>
                    <th class="px-2">Judul Buku</th>
                    <th class="px-2">Tanggal Pinjam</th>
                    <th class="px-2">Tanggal Jatuh Tempo</th>
                    <th class="px-2">Status</th>
                    <th class="px-2">Aksi</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody>

            @forelse($peminjaman as $item)
                @php
                    // 🔥 FIX UTAMA DI SINI
                    $status = strtolower(trim($item->status ?? 'pending'));

                    // 🔥 kalau kosong tetap dianggap pending
                    if ($status == '' || is_null($item->status)) {
                        $status = 'pending';
                    }
                @endphp

                <tr>

                    <td class="py-3">{{ $item->user->name ?? '-' }}</td>
                    <td>{{ $item->buku->judul ?? '-' }}</td>
                    <td>{{ $item->tanggal_pinjam }}</td>
                    <td>{{ $item->tanggal_jatuh_tempo }}</td>

                    {{-- STATUS --}}
                    <td>
                        @if($status == 'pending')
                            <span style="background:orange; color:white; padding:5px 10px; border-radius:5px;">
                                Pending
                            </span>

                        @elseif($status == 'dipinjam')
                            <span style="background:green; color:white; padding:5px 10px; border-radius:5px;">
                                Dipinjam
                            </span>

                        @elseif($status == 'ditolak')
                            <span style="background:red; color:white; padding:5px 10px; border-radius:5px;">
                                Ditolak
                            </span>

                        @elseif($status == 'selesai')
                            <span style="background:blue; color:white; padding:5px 10px; border-radius:5px;">
                                Selesai
                            </span>

                        @elseif($status == 'telat')
                            <span style="background:black; color:white; padding:5px 10px; border-radius:5px;">
                                Telat
                            </span>
                        @endif
                    </td>

                    {{-- AKSI --}}
                    <td>
    @if($status == 'pending')
        <form action="{{ route('petugas.peminjaman.konfirmasi', $item->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:#16a34a; color:white; padding:6px 12px; border:none; border-radius:6px;">
                ✔ Konfirmasi
            </button>
        </form>
        <form action="{{ route('petugas.peminjaman.tolak', $item->id) }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" style="background:#dc2626; color:white; padding:6px 12px; border:none; border-radius:6px;">
                ✖ Tolak
            </button>
        </form>
    @else
        <span style="color:gray; font-style:italic;">Sudah diproses</span>
    @endif
</td>

                </tr>

            @empty
                <tr>
                    <td colspan="6">Tidak ada data peminjaman</td>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>

    <div style="margin-top:15px;">
        {{ $peminjaman->links() }}
    </div>

</div>

@endsection
