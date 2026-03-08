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
                                    <input type="text" id="kode_barang" name="kode_barang" placeholder="Kode Barang"
                                        value="" />
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
                                        value="" />
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
                                            placeholder="Pilih tanggal" />
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
                                        <option value="PT Armindo Langgeng Sejahtera">PT Armindo Langgeng Sejahtera
                                        </option>
                                        <option value="PT Bumi Hardana Sakti">PT Bumi Hardana Sakti</option>
                                        <option value="PT Cipta Arta Hadikara">PT Cipta Arta Hadikara</option>
                                        <option value="PT Global Sekuriti Indonesia">PT Global Sekuriti Indonesia
                                        </option>
                                        <option value="PT Mitrel Berkat Utama">PT Mitrel Berkat Utama</option>
                                        <option value="PT Mulia Indonesia Muda">PT Mulia Indonesia Muda</option>
                                        <option value="PT Sinar Perdana Teknologi">PT Sinar Perdana Teknologi</option>
                                        <option value="PT Sada Usaha Niaga">PT Sada Usaha Niaga</option>
                                        <option value="PT Turangga Pranadita">PT Turangga Pranadita</option>
                                        <option value="PT Wecanindo Global Jaya">PT Wecanindo Global Jaya</option>
                                        <option value="PT Sinar Digital Teknologi">PT Sinar Digital Teknologi</option>
                                        <option value="PT Dwireka Cakra Buana">PT Dwireka Cakra Buana</option>
                                        <option value="PT Anagata Arsa Utama">PT Anagata Arsa Utama</option>
                                        <option value="PT Kawan Usaha Sejahtera">PT Kawan Usaha Sejahtera</option>
                                        <option value="PT Jaya Selaras Mutu">PT Jaya Selaras Mutu</option>
                                        <option value="PT Nawa Sena Utama">PT Nawa Sena Utama</option>
                                        <option value="PT Dapur Pulau Rasa">PT Dapur Pulau Rasa</option>
                                        <option value="Lainnya">Lainnya</option>
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
                                        <option value="Unit">Unit</option>
                                        <option value="Pcs">Pcs</option>
                                        <option value="Box">Box</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
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
                                    <input type="number" id="input_stok" name="stok_saat_ini" value="" />
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
                            <button type="submit" class="dx-btn dx-btn-primary">Simpan</button>
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
