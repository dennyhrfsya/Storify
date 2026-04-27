@extends('layouts.admin')
@section('title', 'Stok Barang - Tambah')

@section('content')
    <div class="container">

        <div class="row mx-auto justify-content-center">
            <div class="col-12 col-lg-6">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Tambah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Stok Barang</span>
                </h5>

                <form method="POST" action="{{ route('stok.simpan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" id="kode_barang" class="dx-font-bold dx-input-disable"
                                        value="{{ $kodeStokOtomatis }}" readonly />
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
                                        value="{{ old('nama_barang') }}" autofocus />
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
                                            value="{{ old('tanggal_pembelian') }}" placeholder="Pilih tanggal" />
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

                                        $oldPT = old('pt_pembeban');

                                        $isLainnya =
                                            $oldPT == 'Lainnya' ||
                                            (!empty($oldPT) && !in_array($oldPT, $pilihanPTPembeban));
                                    @endphp

                                    <select class="select2-js js-select-single" name="pt_pembeban">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanPTPembeban as $pt)
                                            <option value="{{ $pt }}" {{ $oldPT == $pt ? 'selected' : '' }}>
                                                {{ $pt }}
                                            </option>
                                        @endforeach
                                        <option value="Lainnya" {{ $isLainnya ? 'selected' : '' }}>Lainnya</option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isLainnya ? '' : 'display: none;' }}">
                                        <input type="text" name="pt_pembeban_lainnya" class="dx-input js-input-lainnya"
                                            value="{{ !in_array($oldPT, $pilihanPTPembeban) ? $oldPT : '' }}"
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

                                        $oldSatuan = old('satuan');

                                        $isLainnya =
                                            $oldSatuan == 'Lainnya' ||
                                            (!empty($oldSatuan) && !in_array($oldSatuan, $pilihanSatuan));
                                    @endphp

                                    <select class="select2-js js-select-single" name="satuan">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanSatuan as $st)
                                            <option value="{{ $st }}" {{ $oldSatuan == $st ? 'selected' : '' }}>
                                                {{ $st }}
                                            </option>
                                        @endforeach
                                        <option value="Lainnya" {{ $isLainnya ? 'selected' : '' }}>Lainnya</option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isLainnya ? '' : 'display: none;' }}">
                                        <input type="text" name="satuan_lainnya" class="dx-input js-input-lainnya"
                                            value="{{ !in_array($oldSatuan, $pilihanSatuan) ? $oldSatuan : '' }}"
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

                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="input_stok">Stok</label>
                                    <input type="number" id="input_stok" name="stok_saat_ini" />
                                    @error('stok')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="input_harga">Harga Satuan</label>
                                    <input type="text" id="input_harga" class="input-currency" />
                                    <input type="hidden" id="harga_satuan_hidden" name="harga_satuan">
                                    @error('harga_satuan')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="harga">Harga Total</label>
                                    <input type="text" id="harga" class="input-currency dx-input-disable"
                                        readonly />
                                    <input type="hidden" id="harga_total_hidden" name="harga_total">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10 text-center">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary">Simpan</button>
                            <a href="{{ route('stok.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/tambah-stok-total-harga.js') }}"></script>
        <script src="{{ asset('js/single-select.js') }}"></script>
    @endpush
@endsection
