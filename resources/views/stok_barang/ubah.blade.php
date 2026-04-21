@extends('layouts.admin')
@section('title', 'Stok Barang - Ubah')

@section('content')
    <div class="container">

        <div class="row mx-auto justify-content-center">
            <div class="col-12 col-lg-6">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Ubah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Stok Barang</span>
                </h5>

                <form method="POST" action="{{ route('stok.update', $stok->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" class="dx-font-bold dx-input-disable" id="kode_barang"
                                        name="kode_barang" value="{{ old('kode_barang', $stok->kode_barang) }}" readonly />
                                    @error('kode_barang')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="nama_barang">Nama Barang</label>
                                    <input type="text" id="nama_barang" name="nama_barang" placeholder="Nama Barang"
                                        value="{{ old('nama_barang', $stok->nama_barang) }}" />
                                    @error('nama_barang')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_pembelian"
                                            placeholder="Pilih tanggal"
                                            value="{{ old('tanggal_pembelian', \Carbon\Carbon::parse($stok->tanggal_pembelian)->format('Y-m-d')) }}" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pt_pembeban">PT Pembeban</label>
                                    @php
                                        // Daftar PT standar yang kamu miliki
                                        $pilihanPTPembeban = [
                                            'PT Armindo Langgeng Sejahtera',
                                            'PT Bumi Hardana Sakti',
                                            'PT Cipta Arta Hadikara',
                                            'PT Global Sekuriti Indonesia',
                                            'PT Mitrel Berkat Utama',
                                            'PT Mulia Indonesia Muda',
                                            'PT Sinar Perdana Teknologi',
                                            'PT Sada Usaha Niaga',
                                            'PT Turangga Pranadita',
                                            'PT Wecanindo Global Jaya',
                                            'PT Sinar Digital Teknologi',
                                            'PT Dwireka Cakra Buana',
                                            'PT Anagata Arsa Utama',
                                            'PT Kawan Usaha Sejahtera',
                                            'PT Jaya Selaras Mutu',
                                            'PT Nawa Sena Utama',
                                            'PT Dapur Pulau Rasa',
                                            'PT Berkat Usaha Teknologi',
                                            'PT Niaga Bersama Indonesia',
                                            'PT Niaga Megah Abadi',
                                            'PT Mustika Duta Mas',
                                            'PT Tambang Nikel Permai',
                                            'PT Helizona',
                                            'PT Artha Mas Sadhenna',
                                            'PT Sekurindo Prima Jaya',
                                        ];

                                        $nilaiDbPT = old('pt_pembeban', $stok->pt_pembeban);
                                        // Cek apakah data di DB adalah hasil input manual (tidak ada di daftar standar)
                                        $isPTLainnya = !empty($nilaiDbPT) && !in_array($nilaiDbPT, $pilihanPTPembeban);
                                    @endphp

                                    <select id="select_pt" name="pt_pembeban" class="select2-js js-select-single">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanPTPembeban as $pt)
                                            <option value="{{ $pt }}" {{ $nilaiDbPT == $pt ? 'selected' : '' }}>
                                                {{ $pt }}
                                            </option>
                                        @endforeach

                                        <option value="Lainnya"
                                            {{ $isPTLainnya || $nilaiDbPT == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isPTLainnya || $nilaiDbPT == 'Lainnya' ? '' : 'display:none' }}">
                                        <input type="text" name="pt_pembeban_lainnya" class="js-input-lainnya"
                                            value="{{ $isPTLainnya ? $nilaiDbPT : '' }}"
                                            placeholder="Masukkan Nama PT lainnya...">
                                    </div>

                                    @error('pt_pembeban')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="satuan">Satuan</label>
                                    @php
                                        $pilihanSatuan = ['Unit', 'Pieces', 'Box', 'Set', 'Meter', 'Roll', 'Pack'];

                                        $nilaiDbSatuan = old('satuan', $stok->satuan);
                                        $isSatuanLainnya =
                                            !empty($nilaiDbSatuan) && !in_array($nilaiDbSatuan, $pilihanSatuan);
                                    @endphp

                                    <select id="select_satuan" name="satuan" class="select2-js js-select-single">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanSatuan as $st)
                                            <option value="{{ $st }}"
                                                {{ $nilaiDbSatuan == $st ? 'selected' : '' }}>
                                                {{ $st }}
                                            </option>
                                        @endforeach

                                        <option value="Lainnya"
                                            {{ $isSatuanLainnya || $nilaiDbSatuan == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isSatuanLainnya || $nilaiDbSatuan == 'Lainnya' ? '' : 'display:none' }}">
                                        <input type="text" name="satuan_lainnya" class="js-input-lainnya"
                                            value="{{ $isSatuanLainnya ? $nilaiDbSatuan : '' }}"
                                            placeholder="Masukkan Satuan lainnya...">
                                    </div>

                                    @error('satuan')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    @php
                        $sudahAdaTransaksi = $stok->transaksi->count() > 0;
                    @endphp
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="input_stok">Stok</label>
                                    <input type="number" id="input_stok" name="stok_saat_ini"
                                        value="{{ $stok->stok_saat_ini }}" {{ $sudahAdaTransaksi ? 'readonly' : '' }}
                                        class="{{ $sudahAdaTransaksi ? 'dx-input-disable' : '' }}" />
                                    @error('stok')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                    @if ($sudahAdaTransaksi)
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">
                                            * Stok terkunci karena sudah ada riwayat transaksi.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="input_harga">Harga Satuan</label>
                                    <input type="text" id="input_harga"
                                        class="input-currency {{ $sudahAdaTransaksi ? 'dx-input-disable' : '' }}"
                                        value="{{ number_format($stok->harga_satuan, 0, ',', '.') }}"
                                        {{ $sudahAdaTransaksi ? 'readonly' : '' }} />
                                    <input type="hidden" id="harga_satuan_hidden" name="harga_satuan"
                                        value="{{ $stok->harga_satuan }}">
                                    @error('harga_satuan')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                    @if ($sudahAdaTransaksi)
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">
                                            * Harga satuan terkunci karena sudah ada riwayat transaksi.
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="harga">Harga Total</label>
                                    <input type="text" id="harga" class="input-currency dx-input-disable"
                                        readonly />
                                    <input type="hidden" id="harga_total_hidden" name="harga_total"
                                        value="{{ $stok->harga_total }}">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10 text-center">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary">Update</button>
                            <a href="{{ route('stok.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/ubah-stok-total-harga.js') }}"></script>
        <script src="{{ asset('js/single-select.js') }}"></script>
    @endpush
@endsection
