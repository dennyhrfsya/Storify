<!DOCTYPE html>
<html>

<head>
    <title>Laporan Transaksi Barang</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Calibri', 'Candara', 'Segoe UI', 'Optima', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
        }

        .dx-header {
            text-align: center;
            margin-bottom: 25px;
        }

        .dx-header h2 {
            margin: 0;
            color: #2c3e50;
            text-transform: uppercase;
            font-family: 'Calibri', sans-serif;
        }

        .dx-header p {
            margin: 5px 0;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 4px;
            text-align: center;
        }

        td {
            border: 1px solid #dee2e6;
            padding: 6px 4px;
            vertical-align: middle;
        }

        .text-center {
            text-align: center;
        }

        .badge {
            padding: 3px 7px;
            border-radius: 4px;
            color: #ffffff;
            /* Teks Putih */
            font-weight: bold;
            font-size: 9px;
            display: inline-block;
        }

        .bg-batal {
            background-color: #e02424;
        }

        .bg-beri {
            background-color: #32ba7c;
        }

        .bg-pinjam {
            background-color: #f1c40f;
        }

        .bg-default {
            background-color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="dx-header">
        <h2>LAPORAN TRANSAKSI BARANG</h2>
        <p>Periode: {{ $dari_tanggal ?? '-' }} s/d {{ $sampai_tanggal ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="3%">No</th>
                <th width="15%">Kode Transaksi</th>
                <th>Nama Barang</th>
                <th width="12%">User</th>
                <th width="12%">Departemen</th>
                <th width="10%">Tanggal</th>
                <th width="10%">Status</th>
                <th width="8%">Stok Awal</th>
                <th width="8%">Keluar</th>
                <th width="8%">Stok Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportTransaksis as $rt)
                @php
                    $status = strtolower($rt->status);

                    $badgeClass = match ($status) {
                        'dibatalkan' => 'bg-batal',
                        'diberikan' => 'bg-beri',
                        'dipinjamkan' => 'bg-pinjam',
                        default => 'bg-default',
                    };
                @endphp
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $rt->kode_transaksi }}</td>
                    <td>{{ $rt->stokBarang->nama_barang }}</td>
                    <td>{{ $rt->nama_user }}</td>
                    <td>{{ $rt->departemen }}</td>
                    <td class="text-center">{{ date('d-m-Y', strtotime($rt->tanggal_transaksi)) }}</td>
                    <td class="text-center">
                        <span class="badge {{ $badgeClass }}">
                            {{ ucfirst($status) }}
                        </span>
                    </td>
                    <td class="text-center">{{ $rt->stok_awal ?? 0 }}</td>
                    <td class="text-center">{{ $rt->jumlah }}</td>
                    <td class="text-center">{{ $rt->stok_akhir ?? 0 }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
