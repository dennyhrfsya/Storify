@extends('layouts.admin')
@section('title', 'Transaksi - Tambah')

@section('content')
    <div class="container">

        <div class="row mx-auto justify-content-center">
            <div class="col-12 col-lg-6">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Tambah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Transaksi</span>
                </h5>

                <form method="POST" action="{{ route('transaksi.simpan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_transaksi">Kode Transaksi</label>
                                    <input type="text" class="dx-font-bold dx-input-disable"
                                        value="{{ $kodeTrOtomatis }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="stok_barang_id">Pilih Barang</label>
                                    <select name="stok_barang_id" id="stok_barang_id"
                                        class="select2-js js-select-single dx-input-disable">
                                        <option value="">Pilih Barang...</option>
                                        @foreach ($stokBarang as $stok)
                                            <option value="{{ $stok->id }}" data-stok="{{ $stok->stok_saat_ini }}">
                                                {{ $stok->nama_barang }} (Sisa : {{ $stok->stok_saat_ini }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('stok_barang_id')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label>Stok Awal (Sistem)</label>
                                    <input type="text" id="stok_awal_display" class="dx-input-disable" readonly
                                        placeholder="Pilih barang dahulu...">
                                    <input type="hidden" name="stok_awal" id="stok_awal_hidden">

                                    <small id="error-stok-awal" class="dx-text-merah dx-text-xs mt-1" style="display:none;">
                                        Data stok awal belum terisi. Silakan pilih barang.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="jumlah_input">Jumlah Yang Diambil</label>
                                    <input type="number" name="jumlah" id="jumlah_input" min="1">
                                    <p id="error-js-jumlah" class="dx-text-merah dx-text-xs" style="display: none;"></p>
                                    @error('jumlah')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_transaksi"
                                            value="{{ old('tanggal_transaksi') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                    @error('tanggal_transaksi')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="nama_user">Nama User</label>
                                    <input type="text" id="nama_user" name="nama_user">
                                    @error('nama_user')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="departemen">Departemen</label>
                                    <input type="text" id="departemen" name="departemen">
                                    @error('departemen')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="status">Status</label>
                                    <select id="select" name="status">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="dipinjamkan">Dipinjamkan</option>
                                        <option value="diberikan">Diberikan (Habis Pakai)</option>
                                    </select>
                                    @error('status')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control m-0">
                                <div class="dx-form-group">
                                    <label for="bukti_transaksi">Upload Bukti Transaksi</label>
                                    <input type="file" id="bukti_transaksi" name="bukti_transaksi"
                                        accept=".jpg,.jpeg,.png,.pdf" />
                                    <div class="dx-text-xs dx-text-abu-abu-gelap dx-py-1">
                                        Format: JPG, PNG (Maks 10MB) atau PDF (Maks 2MB).
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10 text-center">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary">Simpan</button>
                            <a href="{{ route('transaksi.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/tambah-transaksi.js') }}"></script>
        <script src="{{ asset('js/single-select.js') }}"></script>
    @endpush
@endsection
