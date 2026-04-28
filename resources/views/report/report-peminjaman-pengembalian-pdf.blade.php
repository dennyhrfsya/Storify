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

        .d-block {
            display: block;
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

        .dx-outline-primary {
            border: 1px solid #0652dd;
            color: #0652dd;
        }

        .dx-outline-secondary {
            border: 1px solid #535353;
            color: #535353;
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
                <th>Tgl Pinjam / Serah Terima</th>
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
                        <strong class="d-block">{{ $rpp->aset->kode_barang ?? '-' }}</strong>
                        <span class="d-block">{{ $rpp->aset->nama_barang ?? '-' }}</span>
                        @php
                            $suffix = 'th';
                            if ($rpp->urutan_pemakaian % 100 < 11 || $rpp->urutan_pemakaian % 100 > 13) {
                                switch ($rpp->urutan_pemakaian % 10) {
                                    case 1:
                                        $suffix = 'st';
                                        break;
                                    case 2:
                                        $suffix = 'nd';
                                        break;
                                    case 3:
                                        $suffix = 'rd';
                                        break;
                                }
                            }
                        @endphp

                        @if ($rpp->status == 'dibatalkan')
                            <small class="dx-text-merah">
                                Canceled
                            </small>
                        @elseif ($rpp->urutan_pemakaian)
                            <small>
                                {{ $rpp->urutan_pemakaian }}{{ $suffix }} usage
                            </small>
                        @else
                            <small>No record</small>
                        @endif
                    </td>
                    <td>{{ $rpp->user_aset ?? '-' }}</td>
                    <td>{{ $rpp->pt_user ?? '-' }}</td>
                    <td>
                        <span class="d-block">{{ $rpp->departemen ?? '-' }}</span>
                        {{ $rpp->lokasi ?? '-' }}
                    </td>
                    <td>{{ $rpp->tanggal_peminjaman->format('d-m-Y') }}</td>
                    <td>
                        {{ $rpp->pengembalian?->tanggal_pengembalian ? $rpp->pengembalian->tanggal_pengembalian->format('d-m-Y') : '-' }}
                    </td>
                    <td align="center">
                        @php
                            $status = strtolower($rpp->status);

                            $dxBadgeClass = match ($status) {
                                'dipinjam' => 'dx-outline-primary',
                                'dikembalikan' => 'dx-outline-success',
                                'dibatalkan' => 'dx-outline-danger',
                                'permanen' => 'dx-outline-warning',
                                default => 'dx-outline-secondary',
                            };
                            $label = match ($status) {
                                'dipinjam' => 'Delivered',
                                'dikembalikan' => 'Returned',
                                'dibatalkan' => 'Canceled',
                                'permanen' => 'Permanent',
                                default => ucfirst($status),
                            };
                        @endphp

                        <span class="dx-badge-outline {{ $dxBadgeClass }}">
                            {{ $label }}
                        </span>
                    </td>

                    <td align="center">
                        @if ($rpp->pengembalian)
                            @php
                                $kondisi = strtolower($rpp->pengembalian->kondisi_pengembalian);
                            @endphp
                            <span class="{{ $kondisi == 'baik' ? 'dx-text-hijau' : 'dx-text-merah' }} d-block">
                                {{ ucfirst($kondisi) }}
                            </span>
                            @php
                                $catatan = $rpp->pengembalian->catatan;
                            @endphp
                            <small>{{ $catatan }}</small>
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
