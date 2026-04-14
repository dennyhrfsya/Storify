@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Report Peminjaman Pengembalian')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Report Peminjaman & Pengembalian')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                @error('sampai_tanggal')
                    <div id="welcomeNotice" class="dx-notice dx-notice-error">
                        <div class="dx-notice-title">Gagal !</div>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-danger.png') }}" alt="Gagal" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text">
                                <p class="dx-text-merah dx-text-sm dx-margin-bottom-0">{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                @enderror

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Report</h3>
                <p>Halaman untuk data <strong>Riwayat Peminjaman dan Pengembalian</strong></p>

                <form action="{{ route('report.peminjaman-pengembalian') }}" method="GET">
                    <div class="row d-flex justify-content-center align-items-center">
                        <div class="col-auto col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pencarian">Pencarian</label>
                                    <input type="text" id="pencarian" name="search" value="{{ request('search') }}"
                                        placeholder="Ketik kode, aset, user, atau PT...">
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="start_date">Dari Tanggal</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="dari_tanggal"
                                            value="{{ request('dari_tanggal') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="end_date">Sampai Tanggal</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="sampai_tanggal"
                                            value="{{ request('sampai_tanggal') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="d-flex gap-2">
                                <button type="submit" class="dx-btn dx-btn-primary">Filter</button>
                                <a href="{{ route('report.peminjaman-pengembalian') }}" class="dx-btn dx-btn-secondary">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                </form>

                @if ($reportPeminjamanPengembalian->isEmpty())
                    <div class="dx-table">
                        <div class="table-responsive">
                            <table class="table dx-batch-table">
                                <tbody>
                                    <tr>
                                        <td colspan="9">
                                            <div class="dx-empty-batch text-center">
                                                <div class="dx-empty-batch-image">
                                                    <img src="{{ asset('images/bg-laporan.svg') }}" alt="empty-batch"
                                                        class="img-fluid d-inline w-25">
                                                </div>
                                                <h5 class="dx-empty-batch-title">Silahkan pilih rentang tanggal dan klik
                                                    tombol
                                                </h5>
                                                <p class="dx-empty-batch-content">Untuk menampilkan data laporan!</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @else
                    <div class="row mt-4">
                        <div class="col-12 d-flex gap-2">
                            <a href="{{ route('report.peminjaman-pengembalian.pdf', request()->all()) }}"
                                class="dx-btn dx-btn-danger">PDF</a>
                            <a href="{{ route('report.peminjaman-pengembalian.export', request()->all()) }}"
                                class="dx-btn dx-btn-success">Excel</a>
                        </div>
                    </div>

                    <div class="dx-table">
                        <div class="table-responsive">
                            <table class="table dx-batch-table">
                                <thead>
                                    <tr>
                                        <th scope="col" class="align-middle">No</th>
                                        <th scope="col" class="align-middle dx-sortable">Kode Pinjam / Kembali</th>
                                        <th scope="col" class="align-middle dx-sortable">Aset</th>
                                        <th scope="col" class="align-middle">Peminjam</th>
                                        <th scope="col" class="align-middle">Dept / <br> Lokasi</th>
                                        <th scope="col" class="align-middle">Tgl Pinjam / <br> Serah Terima</th>
                                        <th scope="col" class="align-middle">Tgl Kembali</th>
                                        <th scope="col" class="align-middle">Status</th>
                                        <th scope="col" class="align-middle">Kondisi Kembali</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reportPeminjamanPengembalian as $rpp)
                                        <tr>
                                            <td>
                                                {{ $loop->iteration + ($reportPeminjamanPengembalian->currentPage() - 1) * $reportPeminjamanPengembalian->perPage() }}
                                            </td>
                                            <td>
                                                <div class="dx-font-bold dx-text-biru">{{ $rpp->kode_peminjaman }}</div>
                                                <small
                                                    class="dx-font-bold {{ $rpp->pengembalian ? 'dx-text-merah' : 'text-muted' }}">
                                                    {{ $rpp->pengembalian?->kode_pengembalian ?? '-' }}
                                                </small>
                                            </td>
                                            <td>
                                                <strong>{{ $rpp->aset->kode_barang ?? '-' }}</strong><br>
                                                {{ $rpp->aset->nama_barang ?? 'Aset Tidak Ditemukan' }}
                                            </td>
                                            <td><strong>{{ $rpp->user_aset ?? '-' }}</strong><br>
                                                {{ $rpp->pt_user ?? '-' }}
                                            </td>
                                            <td>
                                                {{ $rpp->departemen ?? '-' }}<br>
                                                <small class="text-muted dx-font-italic">{{ $rpp->lokasi ?? '-' }}</small>
                                            </td>
                                            <td>
                                                {{ $rpp->tanggal_peminjaman ? \Carbon\Carbon::parse($rpp->tanggal_peminjaman)->format('d-m-Y') : '-' }}
                                            </td>
                                            <td>
                                                @if ($rpp->pengembalian)
                                                    {{ \Carbon\Carbon::parse($rpp->pengembalian->tanggal_pengembalian)->format('d-m-Y') }}
                                                @else
                                                    <span class="text-muted dx-font-light">-</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $status = strtolower($rpp->status);
                                                    $badge = match ($status) {
                                                        'dikembalikan' => 'dx-badge-outline-success',
                                                        'permanen' => 'dx-badge-outline-danger',
                                                        'dipinjam' => 'dx-badge-outline-warning',
                                                        default => 'dx-badge-outline-secondary',
                                                    };
                                                    $label = match ($status) {
                                                        'dikembalikan' => 'Returned',
                                                        'permanen' => 'Permanent',
                                                        'dipinjam' => 'Delivered',
                                                        default => ucfirst($status),
                                                    };
                                                @endphp
                                                <span
                                                    class="dx-badge dx-no-cursor {{ $badge }}">{{ $label }}</span>
                                            </td>
                                            <td class="align-middle">
                                                @if ($rpp->pengembalian)
                                                    @php
                                                        $kondisi = strtolower($rpp->pengembalian->kondisi_pengembalian);
                                                        $colorClass =
                                                            $kondisi == 'baik' ? 'dx-text-hijau' : 'dx-text-merah';
                                                    @endphp

                                                    <small class="{{ $colorClass }}">
                                                        <strong>{{ ucfirst($rpp->pengembalian->kondisi_pengembalian) }}</strong>
                                                    </small>
                                                    <br>
                                                    <small
                                                        class="text-muted dx-font-italic">{{ $rpp->pengembalian->catatan ?? '' }}</small>
                                                @else
                                                    <small class="text-muted">-</small>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center px-2">
                                <div class="dx-pagination-info dx-text-abu-abu-gelap">
                                    @if (request('dari_tanggal') && request('sampai_tanggal'))
                                        <small style="letter-spacing: 0.5px;">Menampilkan laporan dari
                                            <strong>{{ date('d M Y', strtotime(request('dari_tanggal'))) }}</strong>
                                            sampai
                                            <strong>{{ date('d M Y', strtotime(request('sampai_tanggal'))) }}</strong></small>
                                    @endif
                                </div>
                                {{ $reportPeminjamanPengembalian->links('report.partials.pagination') }}
                            </div>
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
