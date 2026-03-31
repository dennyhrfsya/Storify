@extends('layouts.admin')
@section('title', 'Pengembalian - Detail')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Detail
                    <span class="dx-text-kuning dx-font-bold dx-text-2xl">Pengembalian</span>
                </h5>

                <div class="row justify-content-center">
                    <div class="col-md-8">

                        <div>
                            <h2 class="dx-font-bold mb-2">{{ $pengembalian->peminjaman->aset->kode_barang }}</h2>
                            <p class="dx-text-xl dx-font-regular dx-font-semi-bold mb-3">
                                {{ $pengembalian->peminjaman->aset->nama_barang }}
                            </p>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kode Kembali</span>
                                    <strong>{{ $pengembalian->kode_pengembalian }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Peminjam</span>
                                    <strong>{{ $pengembalian->peminjaman->user_aset ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">PT User</span>
                                    <strong>{{ $pengembalian->peminjaman->pt_user }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Kembali</span>
                                    <strong>{{ $pengembalian->tanggal_pengembalian ? $pengembalian->tanggal_pengembalian->format('d-m-Y') : '-' }}
                                    </strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Departemen</span>
                                    <strong>{{ $pengembalian->peminjaman->departemen ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Lokasi</span>
                                    <strong>{{ $pengembalian->peminjaman->lokasi ?? '-' }}</strong>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kondisi Kembali</span>
                                    <span
                                        class="dx-font-bold {{ $pengembalian->kondisi_pengembalian == 'baik' ? 'dx-text-hijau' : 'dx-text-merah' }}">
                                        {{ ucfirst($pengembalian->kondisi_pengembalian) }}
                                    </span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Catatan</span>
                                    <strong>{{ $pengembalian->catatan ?? '-' }}</strong>
                                </div>
                                <div class="col-12 mb-2">
                                    <div class="mb-2">
                                        <span class="d-block">Bukti Kembali</span>

                                        @if ($pengembalian->foto_pengembalian)
                                            @php
                                                $extension = strtolower(
                                                    pathinfo($pengembalian->foto_pengembalian, PATHINFO_EXTENSION),
                                                );
                                            @endphp

                                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <div class="mt-2">
                                                    <a href="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
                                                        target="_blank">
                                                        <img src="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
                                                            alt="Upload Bukti Aset" class="img-thumbnail mb-2"
                                                            style="max-width: 300px; cursor: pointer;"
                                                            title="Klik untuk memperbesar">
                                                    </a>
                                                </div>
                                            @elseif ($extension === 'pdf')
                                                <small class="dx-text-xs dx-font-bold dx-text-abu-abu-gelap">Dokumen
                                                    PDF</small>
                                                <a href="{{ asset('storage/' . $pengembalian->foto_pengembalian) }}"
                                                    target="_blank" class="dx-badge dx-badge-danger">
                                                    Lihat Dokumen PDF
                                                </a>
                                            @endif
                                        @else
                                            <span class="dx-text-merah dx-text-sm">Tidak ada
                                                bukti</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 text-center mb-2">
                                    <a href="{{ route('pengembalian.index') }}" class="dx-btn dx-btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
