@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div style="background:#f5f5f5; padding:20px; border-radius:10px;">

        <h4 style="font-weight:600; margin-bottom:15px;">
            Riwayat Peminjaman
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
                    <th style="text-align:left; padding:12px 16px;">ALASAN</th>
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
                            $status = strtolower(trim($item->status ?? ''));
                        @endphp

                        @if($status == 'dipinjam')
                            <span style="background:#22c55e; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Dipinjam
                            </span>

                        @elseif($status == 'selesai')
                            <span style="background:#3b82f6; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Dikembalikan
                            </span>

                        @elseif($status == 'menunggu')
                            <span style="background:#facc15; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Menunggu
                            </span>

                        @elseif($status == 'pending')
                            <span style="background:#facc15; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                pending
                            </span>

                        @elseif($status == 'ditolak')
                            <span style="background:#6b7280; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Ditolak
                            </span>

                        @elseif($status == 'telat')
                            <span style="background:#ef4444; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                Terlambat
                            </span>

                        @else
                            <!-- 🔥 tampilkan status asli biar gak nyangkut -->
                            <span style="background:#6b7280; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">
                                {{ ucfirst($item->status) }}
                            </span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;">
                        @if($status == 'ditolak' && trim($item->alasan_ditolak))
                            {{ $item->alasan_ditolak }}
                        @else
                            -
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:16px;">
                        Tidak ada data peminjaman
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

    <div style="background:#f5f5f5; padding:20px; border-radius:10px; margin-top:24px;">

        <h4 style="font-weight:600; margin-bottom:15px;">
            Riwayat Pengembalian
        </h4>

        <table class="w-full text-sm border-collapse">

            <thead style="background:#dadee0; color:#676e79;">
                <tr>
                    <th style="text-align:left; padding:12px 16px;">NAMA</th>
                    <th style="text-align:left; padding:12px 16px;">JUDUL BUKU</th>
                    <th style="text-align:left; padding:12px 16px;">TANGGAL PINJAM</th>
                    <th style="text-align:left; padding:12px 16px;">TANGGAL KEMBALI</th>
                    <th style="text-align:left; padding:12px 16px;">DENDA</th>
                    <th style="text-align:left; padding:12px 16px;">STATUS</th>
                    <th style="text-align:left; padding:12px 16px;">KONDISI</th>
                </tr>
            </thead>

            <tbody style="background:#ffffff;">
                @forelse ($pengembalian as $item)
                <tr style="border-bottom:1px solid #d1d5db;">
                    <td style="padding:12px 16px;">{{ $item->user->name ?? '-' }}</td>
                    <td style="padding:12px 16px;">{{ $item->buku->judul ?? '-' }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_pinjam }}</td>
                    <td style="padding:12px 16px;">{{ $item->tanggal_kembali }}</td>
                    <td style="padding:12px 16px;">Rp {{ number_format($item->denda ?? 0, 0, ',', '.') }}</td>
                    <td style="padding:12px 16px;">
                        @php $status = strtolower(trim($item->status ?? '')); @endphp
                        @if($status == 'menunggu')
                            <span style="background:#facc15; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Menunggu</span>
                        @elseif($status == 'diterima')
                            <span style="background:#3b82f6; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Diterima</span>
                        @elseif($status == 'ditolak')
                            <span style="background:#ef4444; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Ditolak</span>
                        @else
                            <span style="background:#6b7280; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">{{ ucfirst($item->status) }}</span>
                        @endif
                    </td>
                    <td style="padding:12px 16px;">
                        @php $kondisi = strtolower(trim($item->kondisi_buku ?? '')); @endphp
                        @if($kondisi == 'baik')
                            <span style="background:#22c55e; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Baik</span>
                        @elseif($kondisi == 'rusak')
                            <span style="background:#f59e0b; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Rusak</span>
                        @elseif($kondisi == 'hilang')
                            <span style="background:#ef4444; color:white; padding:4px 10px; border-radius:6px; font-size:12px;">Hilang</span>
                        @else
                            <span style="color:#6b7280;">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center; padding:16px;">Tidak ada riwayat pengembalian</td>
                </tr>
                @endforelse
            </tbody>

        </table>

    </div>

</div>

@endsection
