<!DOCTYPE html>
<html>
<head>
    <title>Laporan</title>
    <style>
        body { font-family: Arial; }
        h2 { text-align: center; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
            text-align: center;
        }
        th {
            background: #eee;
        }
    </style>
</head>
<body onload="window.print()">

<h2>LAPORAN PEMINJAMAN & PENGEMBALIAN</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Anggota</th>
            <th>Buku</th>
            <th>Tgl Pinjam</th>
            <th>Jatuh Tempo</th>
            <th>Tgl Kembali</th>
            <th>Denda</th>
            <th>Status</th>
            <th>Kondisi</th>
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $i => $item)
        @php
            $kondisi = strtolower(trim($item->kondisi_buku ?? ''));

            $jatuhTempo = $item->tanggal_pinjam
                ? strtotime($item->tanggal_pinjam . ' +7 days')
                : null;

            $tanggalCek = $item->tanggal_kembali_real
                ? strtotime($item->tanggal_kembali_real)
                : time();

            $isTerlambat = $jatuhTempo && $tanggalCek > $jatuhTempo;

            $statusLabel = '-';
            if ($item->status_pengembalian == 'diterima') {
                $statusLabel = 'Selesai';
            } elseif ($item->status_pengembalian == 'menunggu') {
                $statusLabel = 'Menunggu';
            } elseif ($item->status_pengembalian == 'ditolak') {
                $statusLabel = 'Ditolak';
            } elseif ($item->status == 'dipinjam') {
                $statusLabel = 'Dipinjam';
            } elseif ($item->status == 'dihapus') {
                $statusLabel = 'Dihapus';
            } elseif ($item->status == 'telat' || $isTerlambat) {
                $statusLabel = 'Terlambat';
            } else {
                $statusLabel = 'Dikembalikan';
            }
        @endphp

        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $item->user->name ?? '-' }}</td>
            <td>{{ $item->buku->judul ?? '-' }}</td>

            <td>
                {{ $item->tanggal_pinjam ? date('d M Y', strtotime($item->tanggal_pinjam)) : '-' }}
            </td>

            <td>
                {{ $jatuhTempo ? date('d M Y', $jatuhTempo) : '-' }}
            </td>

            <td>
                {{ $item->tanggal_kembali_real ? date('d M Y', strtotime($item->tanggal_kembali_real)) : '-' }}
            </td>

            {{-- 🔥 DENDA --}}
            <td>
                @if($item->denda_real > 0)
                    Rp {{ number_format($item->denda_real, 0, ',', '.') }}
                @else
                    -
                @endif
            </td>

            <td>{{ $statusLabel }}</td>
            <td>
                @if($kondisi == 'baik')
                    Baik
                @elseif($kondisi == 'rusak')
                    Rusak
                @elseif($kondisi == 'hilang')
                    Hilang
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
