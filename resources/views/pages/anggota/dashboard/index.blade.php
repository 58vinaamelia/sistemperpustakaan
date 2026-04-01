@extends('layouts.app')

@section('content')

<!-- SEARCH -->
<form method="GET" action="{{ route('anggota.dashboard.index') }}" class="mt-4 mb-3">
    <input type="text"
           name="search"
           value="{{ request('search') }}"
           placeholder="Cari buku yang dipinjam..."
           class="w-full px-4 py-2 border rounded-md focus:outline-none">
</form>

<!-- TABEL -->
<table class="w-full text-sm border-collapse">

    <!-- HEADER -->
    <thead style="background:#dadee0; color:#676e79;">
        <tr>
            <th style="text-align:left; padding:12px 16px;">NAMA</th>
            <th style="text-align:left; padding:12px 16px;">JUDUL BUKU</th>
            <th style="text-align:left; padding:12px 16px;">TANGGAL PINJAM</th>
            <th style="text-align:left; padding:12px 16px;">TANGGAL JATUH TEMPO</th>
            <th style="text-align:left; padding:12px 16px;">STATUS</th>
        </tr>
    </thead>

    <!-- BODY -->
    <tbody style="background:#ffffff;">
        @forelse ($peminjaman as $data)
        <tr style="border-bottom:1px solid #d1d5db;">
            <td style="padding:12px 16px;">{{ $data->user->name ?? '-' }}</td>
            <td style="padding:12px 16px;">{{ $data->buku->judul ?? '-' }}</td>
            <td style="padding:12px 16px;">{{ $data->tanggal_pinjam }}</td>
            <td style="padding:12px 16px;">{{ $data->tanggal_jatuh_tempo }}</td>
            <td style="padding:12px 16px;">
                @php
                    $status = strtolower(trim(str_replace('"', '', $data->status ?? '')));
                @endphp

                @if($status == 'dipinjam')
                    <span style="background:#22c55e; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                        Dipinjam
                    </span>
                @elseif($status == 'dikembalikan')
                    <span style="background:#2263c5; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                        Dikembalikan
                    </span>
                @elseif($status == 'terlambat')
                    <span style="background:#ef4444; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                        Terlambat
                    </span>
                @else
                    <span style="background:#6b7280; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                        {{ $status ?: 'Proses' }}
                    </span>
                @endif
            </td>
        </tr>

        @empty
        <tr>
            <td colspan="5" style="text-align:center; padding:16px;">
                Tidak ada data peminjaman
            </td>
        </tr>
        @endforelse
    </tbody>

</table>

@endsection
