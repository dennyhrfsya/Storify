@php
    $perm = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Inventory')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Aset')

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

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Aset</h3>
                <p>Halaman untuk data <strong>Aset</strong></p>

                <div class="row mb-2">
                    <div class="col-4 col-md-2 order-1">
                        @if ($perm && $perm->tambah)
                            <a href="{{ route('aset.tambah') }}" class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                    </div>
                    <div class="col-8 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('aset.index') }}"
                            class="d-flex justify-content-end align-items-center">
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
                                    <th scope="col" class="align-middle dx-sortable">Kode Barang</th>
                                    <th scope="col" class="align-middle dx-sortable">Nama Barang</th>
                                    <th scope="col" class="align-middle">Kategori</th>
                                    <th scope="col" class="align-middle">Tanggal Pembelian</th>
                                    <th scope="col" class="align-middle">PT Pembeban</th>
                                    <th scope="col" class="align-middle">Nama User</th>
                                    <th scope="col" class="align-middle">Kondisi</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($asets as $aset)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><a href="{{ route('aset.detail', $aset->id) }}"
                                                class="dx-text-biru dx-font-bold">{{ $aset->kode_barang }}</a></td>
                                        <td>{{ $aset->nama_barang }}</td>
                                        <td>{{ $aset->kategori }}</td>
                                        <td>{{ $aset->tanggal_pembelian ? $aset->tanggal_pembelian->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>{{ $aset->pt_pembeban }}</td>
                                        <td>{{ $aset->user_aset }}</td>
                                        <td>{{ ucfirst($aset->kondisi) }}</td>
                                        <td>{{ ucfirst($aset->status) }}</td>
                                        <td>
                                            @if ($perm && $perm->ubah)
                                                <a href="{{ route('aset.ubah', $aset->id) }}"
                                                    class="dx-badge dx-badge-primary">Ubah</a>
                                            @endif
                                            @if ($perm && $perm->hapus)
                                                <a href="#deleteAsetModal{{ $aset->id }}" data-bs-toggle="modal"
                                                    data-bs-target="#deleteAsetModal{{ $aset->id }}"
                                                    class="dx-badge dx-badge-danger">Hapus</a>
                                            @endif
                                            @include('aset.partials.delete_modal_aset', ['aset' => $aset])
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
                                    <strong>{{ $asets->firstItem() }} - {{ $asets->lastItem() }}</strong>
                                    dari <strong>{{ $asets->total() }}</strong> data</small>
                            </div>

                            {{ $asets->links('aset.partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
