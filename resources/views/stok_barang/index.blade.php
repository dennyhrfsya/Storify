@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Stok')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Stok Barang')

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

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Stok Barang</h3>
                <p>Halaman untuk data <strong>Stok</strong></p>

                <div class="row gap-2">
                    <div class="col-12 col-md-5 order-1">
                        @if ($perm && $perm->tambah)
                            <a href="{{ route('stok.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                    </div>
                    <div class="col-12 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('stok.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik kode atau nama barang..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('stok.index') }}"
                                    class="dx-btn dx-btn-primary dx-src-btn text-decoration-none">Reset</a>
                            @endif
                        </form>
                    </div>
                </div>

                <div class="dx-table">
                    <div class="table-responsive">
                        <table class="table dx-batch-table">
                            <thead>
                                <tr>
                                    <th scope="col" class="align-middle">No</th>
                                    <th scope="col" class="align-middle dx-sortable">Kode Barang</th>
                                    <th scope="col" class="align-middle dx-sortable">Nama Barang</th>
                                    <th scope="col" class="align-middle">Tanggal Pembelian</th>
                                    <th scope="col" class="align-middle">PT Pembeban</th>
                                    <th scope="col" class="align-middle">Satuan</th>
                                    <th scope="col" class="align-middle">Stok</th>
                                    <th scope="col" class="align-middle">Harga Satuan</th>
                                    <th scope="col" class="align-middle">Harga Total</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($stoks as $stok)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $stok->kode_barang }}</td>
                                        <td>{{ $stok->nama_barang }}</td>
                                        <td>{{ $stok->tanggal_pembelian ? $stok->tanggal_pembelian->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>{{ $stok->pt_pembeban }}</td>
                                        <td>{{ $stok->satuan }}</td>
                                        <td>
                                            @if ($stok->stok_saat_ini <= 5)
                                                <span class="dx-badge dx-no-cursor dx-badge-warning">Low :
                                                    {{ $stok->stok_saat_ini }}</span>
                                            @else
                                                <span
                                                    class="dx-badge dx-no-cursor dx-badge-success">{{ $stok->stok_saat_ini }}</span>
                                            @endif
                                        </td>
                                        <td>Rp {{ number_format($stok->harga_satuan, 0, ',', '.') }}</td>
                                        <td>Rp {{ number_format($stok->harga_total, 0, ',', '.') }}</td>
                                        <td>
                                            @if ($perm && $perm->ubah)
                                                <a href="{{ route('stok.ubah', $stok->id) }}"
                                                    class="dx-badge dx-badge-primary">Ubah</a>
                                            @endif
                                            @if ($perm && $perm->hapus)
                                                <a href="#deleteStokModal{{ $stok->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteStokModal{{ $stok->id }}"
                                                    class="dx-badge dx-badge-danger">Hapus</a>
                                            @endif
                                            @include('stok_barang.partials.delete-modal-stok', [
                                                'stok' => $stok,
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10">
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
                                    <strong>{{ $stoks->firstItem() }} - {{ $stoks->lastItem() }}</strong>
                                    dari <strong>{{ $stoks->total() }}</strong> data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small>
                            </div>

                            {{ $stoks->links('stok_barang.partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
