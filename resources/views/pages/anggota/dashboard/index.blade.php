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

<!-- CARD SUMMARY -->
<div style="display:flex; gap:20px; margin-bottom:20px; flex-wrap:wrap;">

    <!-- Card 1 -->
    <div style="flex:1; min-width:250px; background:#f9fafb; padding:20px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:flex; align-items:center; gap:15px;">

        <div style="background:#dbeafe; padding:12px; border-radius:50%; font-size:20px;">
            📘
        </div>

        <div>
            <div style="font-size:14px; color:#6b7280;">
                Total Buku Dipinjam
            </div>
            <div style="font-size:24px; font-weight:bold;">
                {{ $totalDipinjam }}
            </div>
        </div>
    </div>

    <!-- Card 2 -->
    <div style="flex:1; min-width:250px; background:#f9fafb; padding:20px; border-radius:12px; box-shadow:0 2px 6px rgba(0,0,0,0.1); display:flex; align-items:center; gap:15px;">

        <div style="background:#dbeafe; padding:12px; border-radius:50%; font-size:20px;">
            📗
        </div>

        <div>
            <div style="font-size:14px; color:#6b7280;">
                Total Dikembalikan
            </div>
            <div style="font-size:24px; font-weight:bold;">
                {{ $totalDikembalikan }}
            </div>
        </div>
    </div>

</div>


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
