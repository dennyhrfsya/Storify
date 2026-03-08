@extends('layouts.admin')
@section('title', 'Aset - Tambah')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Tambah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Aset</span>
                </h5>

                <form method="POST" action="{{ route('aset.simpan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-lg-4">
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
                        <div class="col-12 col-lg-5">
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
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kategori">Kategori</label>
                                    <select id="select" name="kategori">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="Laptop">Laptop</option>
                                        <option value="Monitor">Monitor</option>
                                        <option value="Server">Server</option>
                                        <option value="Printer">Printer</option>
                                        <option value="Keyboard">Keyboard</option>
                                        <option value="PC Desktop">PC Desktop</option>
                                        <option value="CCTV">CCTV</option>
                                        <option value="Proyektor">Proyektor</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="Hardisk">Hardisk</option>
                                        <option value="Modem">Modem</option>
                                        <option value="Router">Router</option>
                                        <option value="Access Point">Access Point</option>
                                        <option value="Switch">Switch</option>
                                        <option value="Range Extender">Range Extender</option>
                                        <option value="Webcam">Webcam</option>
                                        <option value="Speaker">Speaker</option>
                                        <option value="Paper Shredder">Paper Shredder</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                    @error('kategori')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="merk">Merk</label>
                                    <input type="text" id="merk" name="merk" placeholder="Merk" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="nomor_seri">Nomor Seri</label>
                                    <input type="text" id="nomor_seri" name="nomor_seri" placeholder="Nomor Seri"
                                        value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="row">
                                    <div class="col-6 col-lg-6">
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
                                    <div class="col-6 col-lg-6">
                                        <div class="dx-form-group">
                                            <label for="tanggal_garansi">Tanggal Garansi</label>
                                            <div class="dx-input-wrapper">
                                                <input type="date" id="tanggal" name="tanggal_garansi"
                                                    placeholder="Pilih tanggal" />
                                                <span class="dx-icon">
                                                    <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                        class="dx-h-6 dx-ml-4"></a>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 col-lg-2">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kuantitas">Quantity</label>
                                    <input type="number" id="kuantitas" name="kuantitas" value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" id="harga" class="input-currency" />
                                    <input type="hidden" id="harga_aset_hidden" name="harga">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pt_pembeban">PT Pembeban</label>
                                    <select id="select" name="pt_pembeban">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="PT Armindo Langgeng Sejahtera">PT Armindo Langgeng Sejahtera
                                        </option>
                                        <option value="PT Bumi Hardana Sakti">PT Bumi Hardana Sakti</option>
                                        <option value="PT Cipta Arta Hadikara">PT Cipta Arta Hadikara</option>
                                        <option value="PT Global Sekuriti Indonesia">PT Global Sekuriti Indonesia</option>
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
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="user_aset">User</label>
                                    <input type="text" id="user_aset" name="user_aset" placeholder="Nama User"
                                        value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi" placeholder="Lokasi barang"
                                        value="" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <select id="select" name="kondisi">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="baik">Baik</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                    @error('kondisi')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="status">Status</label>
                                    <select id="select" name="status">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="tersedia">Tersedia</option>
                                        <option value="dipinjam">Dipinjam</option>
                                    </select>
                                    @error('status')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="dx-form-control m-0">
                                <div class="dx-form-group">
                                    <label for="bukti_tanda_terima">Bukti Tanda Terima</label>
                                    <input type="file" id="fileinput" name="bukti_tanda_terima"
                                        accept=".jpg,.jpeg,.png,.pdf" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10 text-center">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary">Simpan</button>
                            <a href="{{ route('aset.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
