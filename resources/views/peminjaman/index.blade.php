@php
    $permPeminjaman = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Peminjaman')
        ->first();
    $permPengembalian = \App\Models\Permission::where('role', Auth::user()->role)
        ->where('module', 'Pengembalian')
        ->first();
@endphp
@extends('layouts.admin')
@section('title', 'Peminjaman')

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
                @elseif (session('error'))
                    <div id="welcomeNotice" class="dx-notice dx-notice-warning">
                        <h3 class="dx-notice-title">Peringatan !</h3>
                        <div class="dx-notice-icon">
                            <img src="{{ asset('images/icon-warning.png') }}" alt="Peringatan" class="img-fluid">
                        </div>
                        <div class="row dx-notice-body">
                            <div class="dx-notice-body-text" style="--padding-right:calc(10rem + 3rem);">
                                <p>{!! session('error') !!}</p>
                            </div>
                        </div>
                    </div>
                @endif

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Peminjaman</h3>
                <p>Halaman untuk data <strong>Peminjaman Aset</strong></p>

                <div class="row gap-2">
                    <div class="col-12 col-md-5 order-1">
                        @if ($permPeminjaman && $permPeminjaman->tambah)
                            <a href="{{ route('peminjaman.tambah') }}"class="dx-btn dx-btn-primary">Tambah</a>
                        @endif
                    </div>
                    <div class="col-12 col-md-5 order-2 ms-auto">
                        <form method="GET" action="{{ route('peminjaman.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik kode pinjam, barang, atau PT..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('peminjaman.index') }}"
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
                                    <th scope="col" class="align-middle dx-sortable">Kode Pinjam</th>
                                    <th scope="col" class="align-middle dx-sortable">Aset</th>
                                    <th scope="col" class="align-middle">Peminjam (User)</th>
                                    <th scope="col" class="align-middle">PT User</th>
                                    <th scope="col" class="align-middle">Tanggal Serah Terima</th>
                                    <th scope="col" class="align-middle">Status</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($peminjamans as $peminjaman)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td><span
                                                class="dx-text-biru dx-font-bold">{{ $peminjaman->kode_peminjaman }}</span>
                                        </td>
                                        <td>
                                            <strong>{{ $peminjaman->aset->nama_barang }}</strong><br>
                                            <small>{{ $peminjaman->aset->kode_barang }}</small>
                                        </td>
                                        <td><strong class="d-block">{{ $peminjaman->user_aset }}</strong>
                                            @php
                                                $suffix = 'th';
                                                if (
                                                    $peminjaman->urutan_pemakaian % 100 < 11 ||
                                                    $peminjaman->urutan_pemakaian % 100 > 13
                                                ) {
                                                    switch ($peminjaman->urutan_pemakaian % 10) {
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

                                            @if ($peminjaman->status == 'dibatalkan')
                                                <small class="dx-text-merah">
                                                    Canceled
                                                </small>
                                            @elseif ($peminjaman->urutan_pemakaian)
                                                <small>
                                                    {{ $peminjaman->urutan_pemakaian }}{{ $suffix }} usage
                                                </small>
                                            @else
                                                <small>No record</small>
                                            @endif
                                        </td>
                                        <td>{{ $peminjaman->pt_user }}</td>
                                        <td>{{ $peminjaman->tanggal_peminjaman ? $peminjaman->tanggal_peminjaman->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            @if ($peminjaman->status == 'dipinjam')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-primary">
                                                    Delivered</span>
                                            @elseif ($peminjaman->status == 'dibatalkan')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-danger">
                                                    Canceled</span>
                                            @elseif($peminjaman->status == 'permanen')
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-warning">
                                                    Permanent</span>
                                            @else
                                                <span class="dx-badge dx-no-cursor dx-badge-outline-success">
                                                    Returned</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('peminjaman.detail', $peminjaman->kode_peminjaman) }}"
                                                class="dx-badge dx-badge-info">Detail</a>
                                            @if ($permPengembalian->all && $permPengembalian->tambah)
                                                @if ($peminjaman->status == 'dipinjam' || $peminjaman->status == 'permanen')
                                                    <a href="#" class="dx-badge dx-badge-primary btn-kembali me-1"
                                                        data-bs-toggle="modal" data-bs-target="#modalPengembalian"
                                                        data-id="{{ $peminjaman->id }}"
                                                        data-kode="{{ $peminjaman->kode_peminjaman }}"
                                                        data-barang="{{ $peminjaman->aset->nama_barang }}"
                                                        data-kondisi="{{ $peminjaman->aset->kondisi }}">
                                                        Returned
                                                    </a>
                                                    <a href="#" class="dx-badge dx-badge-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deletePeminjamanModal{{ $peminjaman->id }}">Canceled</a>
                                                @else
                                                    <a href="#" class="dx-badge dx-no-cursor dx-badge-success"
                                                        disabled>Completed
                                                    </a>
                                                @endif
                                            @endif
                                            @include('peminjaman.partials.delete-modal-pembatalan')
                                            @include('peminjaman.partials.modal-pengembalian')
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">
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
                                    <strong>{{ $peminjamans->firstItem() }} - {{ $peminjamans->lastItem() }}</strong>
                                    dari <strong>{{ $peminjamans->total() }}</strong>
                                    data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small>
                            </div>

                            {{ $peminjamans->links('peminjaman.partials.pagination') }}

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/pengembalian.js') }}"></script>
    @endpush
@endsection
