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
                                    <input type="text" id="kode_barang" name="kode_barang" placeholder="Kode Barang"
                                        value="{{ old('kode_barang', $stok->kode_barang) }}" />
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
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_pembelian">Tanggal Pembelian</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_pembelian"
                                            placeholder="Pilih tanggal"
                                            value="{{ old('tanggal_pembelian', $stok->tanggal_pembelian ? \Carbon\Carbon::parse($stok->tanggal_pembelian)->toDateString() : '') }}" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pt_pembeban">PT Pembeban</label>
                                    <select id="select" name="pt_pembeban">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="PT Armindo Langgeng Sejahtera"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Armindo Langgeng Sejahtera' ? 'selected' : '' }}>
                                            PT Armindo Langgeng Sejahtera</option>
                                        <option value="PT Bumi Hardana Sakti"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Bumi Hardana Sakti' ? 'selected' : '' }}>
                                            PT Bumi Hardana Sakti</option>
                                        <option value="PT Cipta Arta Hadikara"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Cipta Arta Hadikara' ? 'selected' : '' }}>
                                            PT Cipta Arta Hadikara</option>
                                        <option value="PT Global Sekuriti Indonesia"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Global Sekuriti Indonesia' ? 'selected' : '' }}>
                                            PT Global Sekuriti Indonesia</option>
                                        <option value="PT Mitrel Berkat Utama"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Mitrel Berkat Utama' ? 'selected' : '' }}>
                                            PT Mitrel Berkat Utama</option>
                                        <option value="PT Mulia Indonesia Muda"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Mulia Indonesia Muda' ? 'selected' : '' }}>
                                            PT Mulia Indonesia Muda</option>
                                        <option value="PT Sinar Perdana Teknologi"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Sinar Perdana Teknologi' ? 'selected' : '' }}>
                                            PT Sinar Perdana Teknologi</option>
                                        <option value="PT Sada Usaha Niaga"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Sada Usaha Niaga' ? 'selected' : '' }}>
                                            PT Sada Usaha Niaga</option>
                                        <option value="PT Turangga Pranadita"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Turangga Pranadita' ? 'selected' : '' }}>
                                            PT Turangga Pranadita</option>
                                        <option value="PT Wecanindo Global Jaya"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Wecanindo Global Jaya' ? 'selected' : '' }}>
                                            PT Wecanindo Global Jaya</option>
                                        <option value="PT Sinar Digital Teknologi"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Sinar Digital Teknologi' ? 'selected' : '' }}>
                                            PT Sinar Digital Teknologi</option>
                                        <option value="PT Dwireka Cakra Buana"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Dwireka Cakra Buana' ? 'selected' : '' }}>
                                            PT Dwireka Cakra Buana</option>
                                        <option value="PT Anagata Arsa Utama"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Anagata Arsa Utama' ? 'selected' : '' }}>
                                            PT Anagata Arsa Utama</option>
                                        <option value="PT Kawan Usaha Sejahtera"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Kawan Usaha Sejahtera' ? 'selected' : '' }}>
                                            PT Kawan Usaha Sejahtera</option>
                                        <option value="PT Jaya Selaras Mutu"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Jaya Selaras Mutu' ? 'selected' : '' }}>
                                            PT Jaya Selaras Mutu</option>
                                        <option value="PT Nawa Sena Utama"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Nawa Sena Utama' ? 'selected' : '' }}>
                                            PT Nawa Sena Utama</option>
                                        <option value="PT Dapur Pulau Rasa"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'PT Dapur Pulau Rasa' ? 'selected' : '' }}>
                                            PT Dapur Pulau Rasa</option>
                                        <option value="Lainnya"
                                            {{ old('pt_pembeban', $stok->pt_pembeban) == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                    @error('pt_pembeban')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="satuan">Satuan</label>
                                    <select id="select" name="satuan">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="Unit"
                                            {{ old('satuan', $stok->satuan) == 'Unit' ? 'selected' : '' }}>Unit</option>
                                        <option value="Pcs"
                                            {{ old('satuan', $stok->satuan) == 'Pcs' ? 'selected' : '' }}>Pcs</option>
                                        <option value="Box"
                                            {{ old('satuan', $stok->satuan) == 'Box' ? 'selected' : '' }}>Box</option>
                                        <option value="Lainnya"
                                            {{ old('satuan', $stok->satuan) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">

                    <div class="row">
                        <div class="col-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="input_stok">Stok</label>
                                    <input type="number" id="input_stok" name="stok_saat_ini"
                                        value="{{ $stok->stok_saat_ini }}" />
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
                                    <input type="text" id="input_harga" class="input-currency"
                                        value="{{ number_format($stok->harga_satuan, 0, ',', '.') }}" />
                                    <input type="hidden" id="harga_satuan_hidden" name="harga_satuan"
                                        value="{{ $stok->harga_satuan }}">
                                    @error('harga_satuan')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="harga">Harga Total</label>
                                    <input type="text" id="harga" class="input-currency" readonly />
                                    <input type="hidden" id="harga_total_hidden" name="harga_total">
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
@endsection

@push('scripts')
    <script src="{{ asset('js/stok-total-harga.js') }}"></script>
@endpush
