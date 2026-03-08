{{-- @php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Stok')
        ->first();
@endphp --}}
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
                            <img src="images/icon-success.png" alt="sukses" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text">
                                <p>{!! session('success') !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Transaksi</h3>
                <p>Halaman untuk data <strong>Riwayat Transaksi Stok</strong></p>

                <div class="row mb-2">
                    <div class="col-4 col-md-2 order-1">
                        {{-- @if ($perm && $perm->tambah)
                            <a href="{{ route('stok.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif --}}
                    </div>
                    <div class="col-8 col-md-5 order-2 ms-auto">
                        <form method="GET" action="#" class="d-flex justify-content-end align-items-center">
                            <div class="dx-form-wrapper w-50 me-2">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik di sini..." aria-label="Search" value="{{ request('search') }}">
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
                                    <th scope="col" class="align-middle">Stok Awal / Stok saat itu</th>
                                    <th scope="col" class="align-middle">Tanggal</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->kode_transaksi }}</td>
                                        <td>{{ $item->stokBarang->nama_barang }}</td>
                                        <td><strong>{{ $item->nama_user }}</strong> {{ $item->departemen }} </td>
                                        <td><strong>{{ $item->jumlah }}</strong> {{ $item->stokBarang->satuan }}
                                        </td>
                                        <td>
                                            <span
                                                class="dx-badge dx-no-cursor {{ $item->status == 'dipinjamkan' ? 'dx-badge-warning' : ($item->status == 'diberikan' ? 'dx-badge-success' : 'dx-badge-danger') }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td><small class="text-muted">{{ $item->stok_snapshot }}</small></td>
                                        <td>{{ $item->tanggal_transaksi->format('d-m-Y H:i') }}</td>
                                        <td>
                                            {{-- @if ($perm && $perm->ubah) --}}
                                            <a href="#" class="dx-badge dx-badge-primary">Ubah</a>
                                            {{-- @endif --}}
                                            {{-- @if ($perm && $perm->hapus) --}}
                                            <a href="#deleteStokModal" data-bs-toggle="modal"
                                                data-bs-target="#deleteStokModal" class="dx-badge dx-badge-danger">Hapus</a>
                                            {{-- @endif --}}
                                            {{-- @include('stok_barang.partials.delete-modal-stok', [
                                                'stok' => $stok,
                                            ]) --}}
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
                                    {{-- <strong>{{ $transaksis->firstItem() }} - {{ $transaksis->lastItem() }}</strong>
                                    dari <strong>{{ $transaksis->total() }}</strong>  --}}
                                    data</small>
                            </div>

                            {{-- {{ $transaksis->links('stok_barang.partials.pagination') }} --}}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
