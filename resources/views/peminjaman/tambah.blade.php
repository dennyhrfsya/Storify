@extends('layouts.admin')
@section('title', 'Peminjaman - Tambah')

@section('content')
    <div class="container">

        <div class="row mx-auto justify-content-center">

            <div class="col-12 col-lg-6">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Tambah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Peminjaman</span>
                </h5>

                <form method="POST" action="{{ route('peminjaman.simpan') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-4">
                        @if (session('error'))
                            <div class="dx-notice dx-notice-warning">
                                <h3 class="dx-notice-title">Peringatan !</h3>
                                <div class="row dx-notice-body">
                                    <p>{!! session('error') !!}</p>

                                    @if (str_contains(session('error'), 'RUSAK'))
                                        <input type="hidden" name="konfirmasi_rusak" value="1">
                                    @endif
                                </div>
                            </div>
                        @endif
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_transaksi">Kode Peminjaman</label>
                                    <input type="text" class="dx-font-bold dx-input-disable" name="kode_peminjaman"
                                        value="{{ $kodePinjamOtomatis }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_peminjaman">Tanggal Peminjaman</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_peminjaman"
                                            value="{{ old('tanggal_peminjaman') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                    @error('tanggal_peminjaman')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="user_aset">Nama User</label>
                                    <input type="text" id="user_aset" name="user_aset" value="{{ old('user_aset') }}"
                                        placeholder="Nama User">
                                    @error('user_aset')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="pt_user">PT User</label>
                                    @php
                                        // Daftar PT yang sama dengan PT Pembeban
                                        $pilihanPTUser = [
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
                                        ];

                                        $oldPTUser = old('pt_user');
                                        // Cek jika user sebelumnya memilih 'Lainnya' atau mengetik manual saat validasi gagal
                                        $isPTUserLainnya =
                                            $oldPTUser == 'Lainnya' ||
                                            (!empty($oldPTUser) && !in_array($oldPTUser, $pilihanPTUser));
                                    @endphp

                                    <select id="select_pt_user" name="pt_user" class="select2-js js-select-single">
                                        <option value="">Pilih Opsi...</option>
                                        @foreach ($pilihanPTUser as $pt)
                                            <option value="{{ $pt }}" {{ $oldPTUser == $pt ? 'selected' : '' }}>
                                                {{ $pt }}
                                            </option>
                                        @endforeach

                                        <option value="Lainnya" {{ $isPTUserLainnya ? 'selected' : '' }}>
                                            Lainnya
                                        </option>
                                    </select>

                                    <div class="js-container-lainnya mt-2"
                                        style="{{ $isPTUserLainnya ? '' : 'display:none' }}">
                                        <input type="text" name="pt_user_lainnya" class="js-input-lainnya"
                                            value="{{ !in_array($oldPTUser, $pilihanPTUser) ? $oldPTUser : '' }}"
                                            placeholder="Masukkan Nama PT lainnya...">
                                    </div>

                                    @error('pt_user')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="departemen">Departemen</label>
                                    <input type="text" id="departemen" name="departemen" value="{{ old('departemen') }}"
                                        placeholder="Departemen">
                                    @error('departemen')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="lokasi">Lokasi</label>
                                    <input type="text" id="lokasi" name="lokasi" value="{{ old('lokasi') }}"
                                        placeholder="Lokasi barang">
                                    @error('lokasi')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="id_aset">Pilih Aset (Tersedia)</label>
                                    <select class="select2-js js-select-single" name="id_aset" id="id_aset">
                                        <option value="">Pilih Barang...</option>
                                        @foreach ($asets as $aset)
                                            <option value="{{ $aset->id }}"
                                                {{ old('id_aset') == $aset->id ? 'selected' : '' }}>
                                                [{{ $aset->kode_barang }}] {{ $aset->nama_barang }} -
                                                {{ $aset->kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_aset')
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
                                        <option value="dipinjam" {{ old('status') == 'dipinjam' ? 'selected' : '' }}>
                                            Dipinjam</option>
                                        <option value="permanen" {{ old('status') == 'permanen' ? 'selected' : '' }}>
                                            Permanen</option>
                                    </select>
                                    @error('status')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="foto_peminjaman">Foto / Bukti Pinjam</label>
                                    <input type="file" id="foto_peminjaman" name="foto_peminjaman"
                                        accept=".jpg,.jpeg,.png,.pdf">
                                    <div class="dx-text-xs dx-text-abu-abu-gelap dx-py-1">
                                        Format: JPG, PNG (Maks 10MB) atau PDF (Maks 2MB).
                                    </div>
                                    @error('foto_peminjaman')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-10 text-center">
                        <div class="col d-flex gap-2 justify-content-center">
                            <button type="submit" id="btn-submit-pmj" class="dx-btn dx-btn-primary"
                                {{ session('error') && str_contains(session('error'), 'RUSAK') ? 'disabled' : '' }}>Simpan</button>
                            <a href="{{ route('peminjaman.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/single-select.js') }}"></script>
    @endpush
@endsection
