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
            
        </tr>
    </thead>
    <tbody>
        @foreach($peminjaman as $i => $item)
        @php
            // 🔥 JATUH TEMPO (7 hari)
            $jatuhTempo = $item->tanggal_pinjam
                ? strtotime($item->tanggal_pinjam . ' +7 days')
                : null;

            // 🔥 tanggal pembanding
            $tanggalCek = $item->tanggal_kembali
                ? strtotime($item->tanggal_kembali)
                : time();

            // 🔥 cek terlambat
            $isTerlambat = $jatuhTempo && $tanggalCek > $jatuhTempo;

            // 🔥 hitung denda
            $denda = 0;
            if ($isTerlambat) {
                $hariTelat = floor(($tanggalCek - $jatuhTempo) / (60 * 60 * 24));
                $denda = $hariTelat * 1000;
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
                {{ $item->tanggal_kembali ? date('d M Y', strtotime($item->tanggal_kembali)) : '-' }}
            </td>

            {{-- 🔥 DENDA --}}
            <td>
                @if($denda > 0)
                    Rp {{ number_format($denda, 0, ',', '.') }}
                @else
                    -
                @endif
            </td>

            <td>
                @if($isTerlambat)
                    Terlambat
                @elseif($item->status == 'dipinjam')
                    Dipinjam
                @else
                    Dikembalikan
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>
