@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div style="background:#f5f5f5; padding:20px; border-radius:10px;">

        <h4 style="font-weight:600; margin-bottom:15px;">
            Data Peminjaman Buku
        </h4>

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
                @forelse ($peminjaman as $item)
                <tr style="border-bottom:1px solid #d1d5db;">
                    <td style="padding:12px 16px;">{{ $item->user->name ?? '-' }}</td>
                    <td style="padding:12px 16px;">{{ $item->buku->judul ?? '-' }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_pinjam }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_jatuh_tempo }}</td>
                    <td style="padding:12px 16px;">
                        @php
                            $status = strtolower($item->status ?? 'pending');
                        @endphp

                        @if($status == 'dipinjam')
                            <span style="background:#22c55e; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Dipinjam
                            </span>
                        @elseif($status == 'dikembalikan' || $status == 'selesai')
                            <span style="background:#3b82f6; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Dikembalikan
                            </span>
                        @elseif($status == 'telat')
                            <span style="background:#ef4444; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Terlambat
                            </span>
                        @elseif($status == 'ditolak')
                            <span style="background:#6b7280; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Ditolak
                            </span>
                        @else
                            <span style="background:#facc15; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Pending
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

    </div>

</div>

@endsection
