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
                    <div class="row mb-4">
                        <div class="col-12 col-lg-4">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_barang">Kode Barang</label>
                                    <input type="text" class="dx-input-disable" id="kode_barang" name="kode_barang"
                                        placeholder="Kode Barang"
                                        value="TRD/SLP73/IT/.../{{ $tahun }}/{{ $nextNumber }}" readonly />
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

                                        $nilaiKategori = old('kategori', $aset->kategori ?? '');

                                        $isKategoriLainnya =
                                            !empty($nilaiKategori) && !in_array($nilaiKategori, $daftarKategori);
                                    @endphp

                                    <select class="select2-js js-select-single" name="kategori" id="kategori">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($daftarKategori as $kat)
                                            <option value="{{ $kat }}"
                                                {{ $nilaiKategori == $kat ? 'selected' : '' }}>
                                                {{ $kat }}
                                            </option>
                                        @endforeach
                                        <option value="Lainnya"
                                            {{ $isKategoriLainnya || $nilaiKategori == 'Lainnya' ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isKategoriLainnya || $nilaiKategori == 'Lainnya' ? '' : 'display: none;' }}">
                                        <input type="text" name="kategori_lainnya" class="dx-input js-input-lainnya"
                                            value="{{ $isKategoriLainnya ? $nilaiKategori : '' }}"
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
                                                    value="{{ old('tanggal_pembelian') }}" placeholder="Pilih tanggal" />
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
                                                    value="{{ old('tanggal_garansi') }}" placeholder="Pilih tanggal" />
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
                                        <input type="text" name="pt_pembeban_lainnya"
                                            class="dx-input js-input-lainnya"
                                            value="{{ !in_array($oldPT, $pilihanPTPembeban) ? $oldPT : '' }}"
                                            placeholder="Masukkan Nama PT lainnya...">
                                    </div>

                                    @error('pt_pembeban')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="grade_barang">Grade Barang</label>
                                    <select id="select" name="grade_barang">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="baru">Baru</option>
                                        <option value="bekas">Bekas</option>
                                    </select>
                                    @error('grade_barang')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-2">
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
                                    <label for="user_aset">User</label>
                                    <input type="text" class="dx-input-disable" id="user_aset" name="user_aset"
                                        placeholder="Nama User" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="departemen">Departemen</label>
                                    <input type="text" class="dx-input-disable" id="departemen" name="departemen"
                                        placeholder="Departemen" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" class="dx-input-disable" id="lokasi" name="lokasi"
                                        placeholder="Lokasi barang" readonly />
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-3">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="status">Status</label>
                                    <select id="select" name="status">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="tersedia">Available</option>
                                        <option value="tertunda">Pending</option>
                                    </select>
                                    @error('status')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="dx-form-control m-0">
                                <div class="dx-form-group">
                                    <label for="upload_bukti_aset">Upload Bukti Aset</label>
                                    <input type="file" id="upload_bukti_aset" name="upload_bukti_aset"
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
                                    <label for="keterangan">Keterangan</label>
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
    @push('scripts')
        <script src="{{ asset('js/single-select.js') }}"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Ambil elemen
                const selectKategori = $('#kategori'); // Gunakan JQuery jika pakai Select2
                const kodeInput = document.getElementById('kode_barang');

                // Fungsi untuk update kode
                function updateKodeBarang(kategori) {
                    // 1. Mapping Singkatan Lengkap
                    const mapping = {
                        'Laptop': 'LP',
                        'Monitor': 'MTR',
                        'Server': 'SVR',
                        'Printer': 'PRT',
                        'Keyboard': 'KYB',
                        'PC Desktop': 'PC',
                        'CCTV': 'CTV',
                        'Proyektor': 'PROJ',
                        'Scanner': 'SCN',
                        'Hardisk': 'HDD',
                        'Modem': 'MDM',
                        'Router': 'RTR',
                        'Access Point': 'AP',
                        'Switch': 'SWT',
                        'Range Extender': 'EXT',
                        'Webcam': 'CAM',
                        'Speaker': 'SPK',
                        'Paper Shredder': 'SHR',
                        'Lainnya': 'ETC'
                    };

                    // 2. Ambil inisial (Fallback: 3 huruf pertama)
                    let inisial = mapping[kategori] || (kategori ? kategori.substring(0, 3).toUpperCase() : '...');

                    // 3. Susun Ulang Kode Barang
                    const tahun = "{{ $tahun }}";
                    const nomorUrut = "{{ $nextNumber }}";

                    kodeInput.value = `TRD/SLP73/IT/${inisial}/${tahun}/${nomorUrut}`;
                }

                // Jika menggunakan Select2, kita harus gunakan event 'select2:select' atau 'change' via JQuery
                if (selectKategori.hasClass('select2-js') || selectKategori.hasClass('js-select-single')) {
                    selectKategori.on('change', function(e) {
                        updateKodeBarang(this.value);
                    });
                } else {
                    // Fallback untuk select standar
                    document.getElementById('kategori').addEventListener('change', function() {
                        updateKodeBarang(this.value);
                    });
                }

                // Jalankan sekali saat halaman dimuat (jika ada nilai 'old' dari Laravel)
                if (selectKategori.val()) {
                    updateKodeBarang(selectKategori.val());
                }
            });
        </script>
    @endpush
@endsection
