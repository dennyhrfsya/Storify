@extends('layouts.admin')
@section('title', 'Aset - Ubah')

@section('content')
    <div class="container-fluid">

        <div class="row mx-auto">
            <div class="col">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Ubah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Aset</span>
                </h5>

                <form method="POST" action="{{ route('aset.update', $aset->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" id="kode_barang" name="kode_barang" placeholder="Kode Barang"
                                        value="{{ old('kode_barang', $aset->kode_barang) }}" />
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
                                        value="{{ old('nama_barang', $aset->nama_barang) }}" />
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
                                        <option value="Laptop"
                                            {{ old('kategori', $aset->kategori) == 'Laptop' ? 'selected' : '' }}>Laptop
                                        </option>
                                        <option value="Monitor"
                                            {{ old('kategori', $aset->kategori) == 'Monitor' ? 'selected' : '' }}>Monitor
                                        </option>
                                        <option value="Server"
                                            {{ old('kategori', $aset->kategori) == 'Server' ? 'selected' : '' }}>Server
                                        </option>
                                        <option value="Printer"
                                            {{ old('kategori', $aset->kategori) == 'Printer' ? 'selected' : '' }}>Printer
                                        </option>
                                        <option value="Keyboard"
                                            {{ old('kategori', $aset->kategori) == 'Keyboard' ? 'selected' : '' }}>Keyboard
                                        </option>
                                        <option value="PC Desktop"
                                            {{ old('kategori', $aset->kategori) == 'PC Desktop' ? 'selected' : '' }}>PC
                                            Desktop</option>
                                        <option value="CCTV"
                                            {{ old('kategori', $aset->kategori) == 'CCTV' ? 'selected' : '' }}>CCTV
                                        </option>
                                        <option value="Proyektor"
                                            {{ old('kategori', $aset->kategori) == 'Proyektor' ? 'selected' : '' }}>
                                            Proyektor
                                        </option>
                                        <option value="Scanner"
                                            {{ old('kategori', $aset->kategori) == 'Scanner' ? 'selected' : '' }}>Scanner
                                        </option>
                                        <option value="Hardisk"
                                            {{ old('kategori', $aset->kategori) == 'Hardisk' ? 'selected' : '' }}>Hardisk
                                        </option>
                                        <option value="Modem"
                                            {{ old('kategori', $aset->kategori) == 'Modem' ? 'selected' : '' }}>Modem
                                        </option>
                                        <option value="Router"
                                            {{ old('kategori', $aset->kategori) == 'Router' ? 'selected' : '' }}>Router
                                        </option>
                                        <option value="Access Point"
                                            {{ old('kategori', $aset->kategori) == 'Access Point' ? 'selected' : '' }}>
                                            Access Point</option>
                                        <option value="Switch"
                                            {{ old('kategori', $aset->kategori) == 'Switch' ? 'selected' : '' }}>Switch
                                        </option>
                                        <option value="Range Extender"
                                            {{ old('kategori', $aset->kategori) == 'Range Extender' ? 'selected' : '' }}>
                                            Range
                                            Extender</option>
                                        <option value="Webcam"
                                            {{ old('kategori', $aset->kategori) == 'Webcam' ? 'selected' : '' }}>Webcam
                                        </option>
                                        <option value="Speaker"
                                            {{ old('kategori', $aset->kategori) == 'Speaker' ? 'selected' : '' }}>Speaker
                                        </option>
                                        <option value="Paper Shredder"
                                            {{ old('kategori', $aset->kategori) == 'Paper Shredder' ? 'selected' : '' }}>
                                            Paper Shredder
                                        </option>
                                        <option value="Lainnya"
                                            {{ old('kategori', $aset->kategori) == 'Lainnya' ? 'selected' : '' }}>Lainnya
                                        </option>
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
                                    <input type="text" id="merk" name="merk" placeholder="Merk"
                                        value="{{ old('merk', $aset->merk) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="nomor_seri">Nomor Seri</label>
                                    <input type="text" id="nomor_seri" name="nomor_seri" placeholder="Nomor Seri"
                                        value="{{ old('nomor_seri', $aset->nomor_seri) }}" />
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
                                                    value="{{ old('tanggal_pembelian', $aset->tanggal_pembelian ? \Carbon\Carbon::parse($aset->tanggal_pembelian)->toDateString() : '') }}"
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
                                                    value="{{ old('tanggal_garansi', $aset->tanggal_garansi ? \Carbon\Carbon::parse($aset->tanggal_garansi)->toDateString() : '') }}"
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
                                    <input type="number" id="kuantitas" name="kuantitas"
                                        value="{{ old('kuantitas', $aset->kuantitas) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="harga">Harga</label>
                                    <input type="text" id="harga" class="input-currency"
                                        value="{{ number_format($aset->harga, 0, ',', '.') }}" />
                                    <input type="hidden" id="harga_aset_hidden" name="harga"
                                        value="{{ $aset->harga }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pt_pembeban">PT Pembeban</label>
                                    <select id="select" name="pt_pembeban">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="PT Armindo Langgeng Sejahtera"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Armindo Langgeng Sejahtera' ? 'selected' : '' }}>
                                            PT Armindo Langgeng Sejahtera</option>
                                        <option value="PT Bumi Hardana Sakti"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Bumi Hardana Sakti' ? 'selected' : '' }}>
                                            PT Bumi Hardana Sakti</option>
                                        <option value="PT Cipta Arta Hadikara"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Cipta Arta Hadikara' ? 'selected' : '' }}>
                                            PT Cipta Arta Hadikara</option>
                                        <option value="PT Global Sekuriti Indonesia"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Global Sekuriti Indonesia' ? 'selected' : '' }}>
                                            PT Global Sekuriti Indonesia</option>
                                        <option value="PT Mitrel Berkat Utama"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Mitrel Berkat Utama' ? 'selected' : '' }}>
                                            PT Mitrel Berkat Utama</option>
                                        <option value="PT Mulia Indonesia Muda"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Mulia Indonesia Muda' ? 'selected' : '' }}>
                                            PT Mulia Indonesia Muda</option>
                                        <option value="PT Sinar Perdana Teknologi"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Sinar Perdana Teknologi' ? 'selected' : '' }}>
                                            PT Sinar Perdana Teknologi</option>
                                        <option value="PT Sada Usaha Niaga"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Sada Usaha Niaga' ? 'selected' : '' }}>
                                            PT Sada Usaha Niaga</option>
                                        <option value="PT Turangga Pranadita"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Turangga Pranadita' ? 'selected' : '' }}>
                                            PT Turangga Pranadita</option>
                                        <option value="PT Wecanindo Global Jaya"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Wecanindo Global Jaya' ? 'selected' : '' }}>
                                            PT Wecanindo Global Jaya</option>
                                        <option value="PT Sinar Digital Teknologi"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Sinar Digital Teknologi' ? 'selected' : '' }}>
                                            PT Sinar Digital Teknologi</option>
                                        <option value="PT Dwireka Cakra Buana"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Dwireka Cakra Buana' ? 'selected' : '' }}>
                                            PT Dwireka Cakra Buana</option>
                                        <option value="PT Anagata Arsa Utama"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Anagata Arsa Utama' ? 'selected' : '' }}>
                                            PT Anagata Arsa Utama</option>
                                        <option value="PT Kawan Usaha Sejahtera"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Kawan Usaha Sejahtera' ? 'selected' : '' }}>
                                            PT Kawan Usaha Sejahtera</option>
                                        <option value="PT Jaya Selaras Mutu"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Jaya Selaras Mutu' ? 'selected' : '' }}>
                                            PT Jaya Selaras Mutu</option>
                                        <option value="PT Nawa Sena Utama"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Nawa Sena Utama' ? 'selected' : '' }}>
                                            PT Nawa Sena Utama</option>
                                        <option value="PT Dapur Pulau Rasa"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'PT Dapur Pulau Rasa' ? 'selected' : '' }}>
                                            PT Dapur Pulau Rasa</option>
                                        <option value="Lainnya"
                                            {{ old('pt_pembeban', $aset->pt_pembeban) == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="user_aset">User</label>
                                    <input type="text" id="user_aset" name="user_aset" placeholder="Nama User"
                                        value="{{ old('user_aset', $aset->user_aset) }}" />
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
                                        value="{{ old('lokasi', $aset->lokasi) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kondisi">Kondisi</label>
                                    <select id="select" name="kondisi">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="baik"
                                            {{ old('kondisi', $aset->kondisi) == 'baik' ? 'selected' : '' }}>Baik</option>
                                        <option value="rusak"
                                            {{ old('kondisi', $aset->kondisi) == 'rusak' ? 'selected' : '' }}>Rusak
                                        </option>
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
                                        <option value="tersedia"
                                            {{ old('status', $aset->status) == 'tersedia' ? 'selected' : '' }}>Tersedia
                                        </option>
                                        <option value="dipinjam"
                                            {{ old('status', $aset->status) == 'dipinjam' ? 'selected' : '' }}>Dipinjam
                                        </option>
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
                                    <label for="bukti_tanda_terima" class="form-label">Bukti Tanda Terima</label>

                                    @if ($aset->bukti_tanda_terima)
                                        <div class="mb-2">
                                            <img src="{{ asset('storage/' . $aset->bukti_tanda_terima) }}"
                                                alt="Bukti Tanda Terima" class="img-thumbnail" style="max-width: 200px;">
                                        </div>
                                    @endif

                                    <input type="file" id="fileinput" name="bukti_tanda_terima"
                                        accept=".jpg,.jpeg,.png,.pdf" />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-8">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="Keterangan">Keterangan</label>
                                    <textarea name="keterangan" id="keterangan">{{ old('keterangan', $aset->keterangan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" class="dx-btn dx-btn-primary">Update</button>
                            <a href="{{ route('aset.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
