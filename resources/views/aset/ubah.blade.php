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
                    <div class="row mb-4">
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
                                    @php
                                        $daftarKategori = [
                                            'Laptop',
                                            'Monitor',
                                            'Server',
                                            'Printer',
                                            'Keyboard',
                                            'PC Desktop',
                                            'CCTV',
                                            'Proyektor',
                                            'Scanner',
                                            'Hardisk',
                                            'Modem',
                                            'Router',
                                            'Access Point',
                                            'Switch',
                                            'Range Extender',
                                            'Webcam',
                                            'Speaker',
                                            'Paper Shredder',
                                        ];

                                        $nilaiDb = old('kategori', $aset->kategori);
                                        $isLainnya = !empty($nilaiDb) && !in_array($nilaiDb, $daftarKategori);
                                    @endphp

                                    <select id="select" name="kategori" class="select2-js js-select-single">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($daftarKategori as $item)
                                            <option value="{{ $item }}" {{ $nilaiDb == $item ? 'selected' : '' }}>
                                                {{ $item }}
                                            </option>
                                        @endforeach

                                        <option value="Lainnya" {{ $isLainnya || $nilaiDb == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isLainnya || $nilaiDb == 'Lainnya' ? '' : 'display:none' }}">
                                        <input type="text" name="kategori_lainnya" class="js-input-lainnya"
                                            value="{{ $isLainnya ? $nilaiDb : '' }}"
                                            placeholder="Masukkan kategori lainnya...">
                                    </div>

                                    @error('kategori')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
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
                                                    value="{{ old('tanggal_pembelian', \Carbon\Carbon::parse($aset->tanggal_pembelian)->format('Y-m-d')) }}"
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
                                                    value="{{ old('tanggal_garansi', \Carbon\Carbon::parse($aset->tanggal_garansi)->format('Y-m-d')) }}"
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

                                        $nilaiDbPT = old('pt_pembeban', $aset->pt_pembeban);
                                        // Cek apakah data di DB adalah hasil input manual (tidak ada di daftar standar)
                                        $isPTLainnya = !empty($nilaiDbPT) && !in_array($nilaiDbPT, $pilihanPTPembeban);
                                    @endphp

                                    <select id="select_pt" name="pt_pembeban" class="select2-js js-select-single">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanPTPembeban as $pt)
                                            <option value="{{ $pt }}"
                                                {{ $nilaiDbPT == $pt ? 'selected' : '' }}>
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
                        <div class="col-12 col-lg-2">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="grade_barang">Grade Barang</label>
                                    <select id="select" name="grade_barang">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="baru"
                                            {{ old('grade_barang', $aset->grade_barang) == 'baru' ? 'selected' : '' }}>Baru
                                        </option>
                                        <option value="bekas"
                                            {{ old('grade_barang', $aset->grade_barang) == 'bekas' ? 'selected' : '' }}>
                                            Bekas</option>
                                    </select>
                                    @error('grade_barang')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
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
                                    <label for="user_aset">User</label>
                                    <input type="text" class="dx-input-disable" id="user_aset" name="user_aset"
                                        placeholder="Nama User" value="{{ old('user_aset', $aset->user_aset) }}"
                                        readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="departemen">Departemen</label>
                                    <input type="text" class="dx-input-disable" id="departemen" name="departemen"
                                        placeholder="Departemen" value="{{ old('departemen', $aset->departemen) }}"
                                        readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="dx-input-disable" id="lokasi" name="lokasi"
                                        placeholder="Lokasi barang" value="{{ old('lokasi', $aset->lokasi) }}"
                                        readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="status">Status</label>
                                    <div id="statusWrapper" style="cursor: help;">
                                        <select id="select" class="dx-select-disable" readonly tabindex="-1">
                                            <option value="tersedia" {{ $aset->status == 'tersedia' ? 'selected' : '' }}>
                                                Available</option>
                                            <option value="dipinjam" {{ $aset->status == 'dipinjam' ? 'selected' : '' }}>
                                                Delivered</option>
                                            <option value="permanen" {{ $aset->status == 'permanen' ? 'selected' : '' }}>
                                                Permanent</option>
                                        </select>
                                    </div>

                                    <input type="hidden" name="status" value="{{ $aset->status }}">

                                    <div id="msg-lock" class="dx-text-merah dx-text-xs dx-margin-bottom-0"
                                        style="display: none;">
                                        <i class="bi bi-lock"></i> Kolom Terkunci. Hubungi Admin untuk perubahan.
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="dx-form-control m-0">
                                <div class="dx-form-group">
                                    <label for="upload_bukti_aset">Upload Bukti Aset</label>

                                    @if ($aset->upload_bukti_aset)
                                        @php
                                            $extension = strtolower(
                                                pathinfo($aset->upload_bukti_aset, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        <div class="mb-3">
                                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ asset('storage/' . $aset->upload_bukti_aset) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/' . $aset->upload_bukti_aset) }}"
                                                        alt="Bukti Aset" class="img-thumbnail"
                                                        style="max-width: 300px; cursor: pointer;"
                                                        title="Klik untuk memperbesar">
                                                </a>
                                            @elseif ($extension === 'pdf')
                                                <small class="dx-text-xs dx-font-bold dx-text-abu-abu-gelap">Dokumen
                                                    PDF</small>
                                                <a href="{{ asset('storage/' . $aset->upload_bukti_aset) }}"
                                                    target="_blank" class="dx-badge dx-badge-danger">
                                                    Lihat Dokumen PDF
                                                </a>
                                            @endif
                                        </div>
                                    @else
                                        <span class="dx-text-merah dx-text-sm">Tidak ada
                                            bukti</span>
                                    @endif

                                    {{-- Input File Baru --}}
                                    <input type="file" id="fileinput" name="upload_bukti_aset"
                                        accept=".jpg,.jpeg,.png,.pdf" />

                                    <div class="dx-text-xs dx-text-abu-abu-gelap dx-py-1">
                                        Format: JPG, PNG (Maks 10MB) atau PDF (Maks 2MB).
                                    </div>
                                    @error('upload_bukti_aset')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
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
    @push('scripts')
        <script src="{{ asset('js/ubah-aset.js') }}"></script>
        <script src="{{ asset('js/single-select.js') }}"></script>
    @endpush
@endsection
