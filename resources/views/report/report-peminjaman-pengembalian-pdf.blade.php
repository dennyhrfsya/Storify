<!DOCTYPE html>
<html>

<head>
    <title>Laporan Peminjaman & Pengembalian</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Calibri', 'Candara', 'Segoe UI', 'Optima', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 10px 5px;
            text-align: center;
            text-transform: capitalize;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 8px 5px;
            vertical-align: middle;
        }

        .dx-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .dx-header h2 {
            margin-bottom: 5px;
            color: #2c3e50;
            font-family: 'Calibri', sans-serif;
        }

        .dx-text-pinjam {
            color: #0652dd;
            font-weight: bold;
        }

        .dx-text-kembali {
            color: #e02424;
            font-weight: bold;
        }

        .dx-text-hijau {
            color: #32ba7c;
            font-weight: bold;
        }

        .dx-text-merah {
            color: #e02424;
            font-weight: bold;
        }

        .dx-badge-outline {
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: bold;
            display: inline-block;
            background-color: transparent;
            text-transform: none;
            line-height: 1;
        }

        .dx-outline-success {
            border: 1px solid #32ba7c;
            color: #32ba7c;
        }

        .dx-outline-warning {
            border: 1px solid #f1c40f;
            color: #f1c40f;
        }

        .dx-outline-danger {
            border: 1px solid #e02424;
            color: #e02424;
        }

        .dx-outline-secondary {
            border: 1px solid #266ef4;
            color: #266ef4;
        }

        .dx-text-muted {
            color: #535353;
            font-style: italic;
        }

        /* Footer Style */
        footer {
            position: fixed;
            bottom: -30px;
            /* Jarak dari bawah halaman */
            right: 0px;
            /* Jarak dari kanan halaman */
            height: 50px;
            text-align: right;
        }

        .dx-logo-footer {
            width: 100px;
            /* Sesuaikan ukuran logo */
            opacity: 0.7;
            /* Membuat logo sedikit transparan agar elegan */
        }

        /* Tambahkan margin bawah pada body agar konten tabel tidak tertutup footer */
        body {
            margin-bottom: 50px;
        }
    </style>
</head>

<body>

    <div class="dx-header">
        <h2>LAPORAN PEMINJAMAN & PENGEMBALIAN ASET</h2>
        <p>Periode: {{ $dari_tanggal ?? '-' }} s/d {{ $sampai_tanggal ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th>Kode Pinjam / Kembali</th>
                <th>Kode / Nama Barang</th>
                <th>User</th>
                <th>PT</th>
                <th>Dept / Lokasi</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
                <th align="center">Status</th>
                <th align="center">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportPeminjamanPengembalian as $rpp)
                <tr>
                    <td align="center">{{ $loop->iteration }}</td>
                    <td>
                        <span class="dx-text-pinjam">{{ $rpp->kode_peminjaman }}</span><br>
                        @if ($rpp->pengembalian)
                            <small class="dx-text-kembali">{{ $rpp->pengembalian->kode_pengembalian }}</small>
                        @else
                            <small class="dx-text-muted">-</small>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $rpp->aset->kode_barang ?? '-' }}</strong><br>
                        {{ $rpp->aset->nama_barang ?? '-' }}
                    </td>
                    <td>{{ $rpp->user_aset ?? '-' }}</td>
                    <td>{{ $rpp->pt_user ?? '-' }}</td>
                    <td>
                        {{ $rpp->departemen ?? '-' }}<br>
                        {{ $rpp->lokasi ?? '-' }}
                    </td>
                    <td>{{ $rpp->tanggal_peminjaman->format('d-m-Y') }}</td>
                    <td>
                        {{ $rpp->pengembalian?->tanggal_pengembalian ? $rpp->pengembalian->tanggal_pengembalian->format('d-m-Y') : '-' }}
                    </td>
                    <td align="center">
                        @php
                            $statusRaw = strtolower($rpp->status);

                            $dxBadgeClass = match ($statusRaw) {
                                'dikembalikan' => 'dx-outline-success',
                                'dipinjam' => 'dx-outline-warning',
                                'permanen' => 'dx-outline-danger',
                                default => 'dx-outline-secondary',
                            };
                        @endphp

                        <span class="dx-badge-outline {{ $dxBadgeClass }}">
                            {{ ucfirst(strtolower($rpp->status)) }}
                        </span>
                    </td>

                    <td align="center">
                        @if ($rpp->pengembalian)
                            @php
                                $kondisi = strtolower($rpp->pengembalian->kondisi_pengembalian);
                            @endphp
                            <span class="{{ $kondisi == 'baik' ? 'dx-text-hijau' : 'dx-text-merah' }}">
                                {{ ucfirst($kondisi) }}
                            </span>
                        @else
                            <span class="dx-text-muted">-</span>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
