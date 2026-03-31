@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Transaksi')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Transaksi')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                @if (session('success'))
                    <div id="welcomeNotice" class="dx-notice dx-notice-success">
                        <div class="dx-notice-title">Sukses !</div>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-success.png') }}" alt="Sukses" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text">
                                <p>{!! session('success') !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Transaksi</h3>
                <p>Halaman untuk data <strong>Transaksi</strong></p>

                <div class="row mb-2">
                    <div class="col-4 col-md-2 order-1">
                        @if ($perm && $perm->tambah)
                            <a href="{{ route('transaksi.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                    </div>
                    <div class="col-8 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('transaksi.index') }}"
                            class="d-flex justify-content-end align-items-center">
                            <div class="dx-form-wrapper w-50 me-2">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik kode, nama barang, atau status..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                        </form>
                    </div>
                </div>

                <div class="dx-table">
                    <div class="table-responsive">
                        <table class="table dx-batch-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle">Kode Transaksi</th>
                                    <th scope="col" class="align-middle dx-sortable">Nama Barang</th>
                                    <th scope="col" class="align-middle dx-sortable">User</th>
                                    <th scope="col" class="align-middle">Jumlah</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Stok Awal</th>
                                    <th scope="col" class="align-middle">Stok Akhir</th>
                                    <th scope="col" class="align-middle">Tanggal Transaksi</th>
                                    <th scope="col" class="align-middle">Bukti</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksis as $transaksi)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi->kode_transaksi }}</td>
                                        <td>{{ $transaksi->stokBarang->nama_barang }}</td>
                                        <td><strong>{{ $transaksi->nama_user }}</strong><br>
                                            {{ $transaksi->departemen }} </td>
                                        <td><strong>{{ $transaksi->jumlah }}</strong> {{ $transaksi->stokBarang->satuan }}
                                        </td>
                                        <td>
                                            @php
                                                $badgeClass = match (Str::lower($transaksi->status)) {
                                                    'dipinjamkan' => 'dx-badge-warning',
                                                    'diberikan' => 'dx-badge-success',
                                                    default => 'dx-badge-danger',
                                                };
                                            @endphp

                                            <span class="dx-badge dx-no-cursor {{ $badgeClass }}">
                                                {{ ucfirst($transaksi->status) }}
                                            </span>
                                        </td>
                                        <td><small class="text-muted">{{ $transaksi->stok_awal }}</small></td>
                                        <td><small class="text-muted">{{ $transaksi->stok_akhir }}</small></td>
                                        <td>{{ $transaksi->tanggal_transaksi ? $transaksi->tanggal_transaksi->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($transaksi->bukti_transaksi)
                                                @php
                                                    $ext = pathinfo($transaksi->bukti_transaksi, PATHINFO_EXTENSION);
                                                @endphp

                                                @if ($ext == 'pdf')
                                                    <a href="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
                                                        target="_blank" class="dx-text-sm dx-text-merah">
                                                        <i class="bi bi-file-earmark"></i> PDF
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
                                                            class="rounded-sm object-fit-cover dx-shadow"
                                                            style="width: 40px; height:40px; cursor:pointer;"
                                                            title="Klik untuk memperbesar">
                                                    </a>
                                                @endif
                                            @else
                                                <span>Tidak ada bukti</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($perm && $perm->ubah)
                                                <a href="{{ route('transaksi.ubah', $transaksi->id) }}"
                                                    class="dx-badge dx-badge-primary">Ubah</a>
                                            @endif
                                            @if ($perm && $perm->hapus)
                                                <a href="#deleteTransaksiModal{{ $transaksi->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteTransaksiModal{{ $transaksi->id }}"
                                                    class="dx-badge dx-badge-danger">Hapus</a>
                                            @endif
                                            @include('transaksi.partials.delete-modal-transaksi', [
                                                'transaksi' => $transaksi,
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="17">
                                            <div class="dx-empty-batch text-center">
                                                <div class="dx-empty-batch-image">
                                                    <img src="{{ asset('images/speech-bubble.png') }}" alt="empty-batch"
                                                        class="img-fluid d-inline">
                                                </div>
                                                <h5 class="dx-empty-batch-title">Data tidak ditemukan
                                                </h5>
                                                <p class="dx-empty-batch-content">Untuk keterangan lebih
                                                    lanjut, silahkan baca <a href="#" target="_blank">Link
                                                        ini.</a></p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        <div class="dx-pagination-wrapper d-flex justify-content-between align-items-center px-2">
                            <div class="dx-pagination-info dx-text-abu-abu-gelap">
                                <small style="letter-spacing: 0.5px;">Menampilkan
                                    <strong>{{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }}</strong>
                                    dari <strong>{{ $transaksis->total() }}</strong>
                                    data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small>
                            </div>

                            {{ $transaksis->links('transaksi.partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
