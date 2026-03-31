@extends('layouts.admin')
@section('title', 'Pengembalian')

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

                <h3 class="dx-table-title dx-with-border dx-table-text-left">Pengembalian</h3>
                <p>Halaman untuk data <strong>Pengembalian Aset</strong></p>

                <div class="row gap-2">
                    <div class="col-12 col-md-5 ms-auto">
                        <form method="GET" action="{{ route('pengembalian.index') }}"
                            class="d-flex justify-content-end align-items-center gap-2">
                            <div class="dx-form-wrapper w-100">
                                <input type="text" class="dx-form-input-src" name="search"
                                    placeholder="Ketik kode kembali atau barang..." aria-label="Search"
                                    value="{{ request('search') }}">
                            </div>
                            <button type="submit" class="dx-btn dx-btn-secondary dx-src-btn">
                                Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('pengembalian.index') }}"
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
                                    <th scope="col" class="align-middle dx-sortable">Kode Kembali</th>
                                    <th scope="col" class="align-middle dx-sortable">Aset</th>
                                    <th scope="col" class="align-middle">Peminjam (User)</th>
                                    <th scope="col" class="align-middle">PT User</th>
                                    <th scope="col" class="align-middle">Kondisi Saat Kembali</th>
                                    <th scope="col" class="align-middle">Tanggal Kembali</th>
                                    <th scope="col" class="align-middle">Bukti</th>
                                    <th scope="col" class="align-middle">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengembalians as $pengembalian)
                                    <tr>
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $pengembalian->kode_pengembalian }}</td>
                                        <td>
                                            <strong>{{ $pengembalian->peminjaman->aset->nama_barang }}</strong><br>
                                            <small>{{ $pengembalian->peminjaman->aset->kode_barang }}</small>
                                        </td>
                                        <td>{{ $pengembalian->peminjaman->user_aset }}</td>
                                        <td>{{ $pengembalian->peminjaman->pt_user }}</td>
                                        <td>{{ \Carbon\Carbon::parse($pengembalian->tanggal_pengembalian)->format('d-m-Y') }}
                                        </td>
                                        <td>
                                            @if ($pengembalian->kondisi_pengembalian == 'baik')
                                                <span class="dx-font-bold dx-text-hijau">Baik</span>
                                            @else
                                                <span class="dx-font-bold dx-text-merah">Rusak</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($pengembalian->foto_pengembalian)
                                                @php
                                                    $ext = pathinfo(
                                                        $pengembalian->foto_pengembalian,
                                                        PATHINFO_EXTENSION,
                                                    );
                                                @endphp

                                                @if ($ext == 'pdf')
                                                    <a href="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
                                                        target="_blank" class="dx-text-sm dx-text-merah">
                                                        <i class="bi bi-file-earmark"></i> PDF
                                                    </a>
                                                @else
                                                    <a href="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
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
                                            <a href="{{ route('pengembalian.detail', $pengembalian->kode_pengembalian) }}"
                                                class="dx-badge dx-badge-info">Detail</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">
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
                                    <strong>{{ $pengembalians->firstItem() }} - {{ $pengembalians->lastItem() }}</strong>
                                    dari <strong>{{ $pengembalians->total() }}</strong>
                                    data</small>
                                <small style="letter-spacing: 0.5px">
                                    @if (request('search'))
                                        (Hasil cari: "{{ request('search') }}")
                                    @endif
                                </small>
                            </div>

                            {{ $pengembalians->links('pengembalian.partials.pagination') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
