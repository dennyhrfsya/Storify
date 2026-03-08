@extends('layouts.admin')
@section('title', 'Aset - Detail')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Detail <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Aset</span>
                </h5>

                <div class="row justify-content-center">
                    <div class="col-md-10">

                        <div>
                            <h2 class="dx-font-bold mb-2">{{ $aset->kode_barang }}</h2>
                            <p class="dx-text-xl dx-font-regular dx-font-semi-bold mb-3">{{ $aset->nama_barang }}</p>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kategori <strong>{{ $aset->kategori }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Nomor Seri <strong>{{ $aset->nomor_seri }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Pembelian
                                        <strong>{{ $aset->tanggal_pembelian ? $aset->tanggal_pembelian->format('d-m-Y') : '-' }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Tanggal Garansi
                                        <strong>{{ $aset->tanggal_garansi ? $aset->tanggal_garansi->format('d-m-Y') : '-' }}
                                        </strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Status Garansi <strong>
                                            <span
                                                class="dx-badge dx-no-cursor
                                                @if ($aset->garansi_status === 'Garansi sudah habis') dx-badge-danger
                                                @elseif($aset->garansi_status === 'Masa tenggang garansi') dx-badge-warning
                                                @else dx-badge-success @endif">
                                                {{ $aset->garansi_status }}
                                                @if ($aset->garansi_sisa)
                                                    ({{ $aset->garansi_sisa }})
                                                @endif
                                            </span>
                                        </strong>
                                    </span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Quantity <strong>
                                            {{ $aset->kuantitas }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Harga <strong>Rp.
                                            {{ number_format($aset->harga, 0, ',', '.') }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">PT Pembeban <strong>{{ $aset->pt_pembeban }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">User <strong>{{ $aset->user_aset }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Lokasi <strong>{{ $aset->lokasi }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Kondisi <strong>{{ ucfirst($aset->kondisi) }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <span class="d-block">Status <strong>{{ ucfirst($aset->status) }}</strong></span>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="mb-2">
                                        <span class="d-block">Keterangan <strong>{{ $aset->keterangan }}</strong></span>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <div class="mb-2">
                                        <span class="d-block">Bukti Tanda Terima</span>
                                        @if ($aset->bukti_tanda_terima)
                                            <div class="mt-2">
                                                <img src="{{ asset('storage/' . $aset->bukti_tanda_terima) }}"
                                                    alt="Bukti Tanda Terima" class="img-thumbnail mb-2"
                                                    style="max-width: 300px;">
                                            </div>
                                        @else
                                            <span class="text-muted">Tidak ada bukti</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <a href="{{ route('aset.index', $aset->id) }}"
                                        class="dx-btn dx-btn-primary">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
