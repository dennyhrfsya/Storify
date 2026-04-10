@extends('layouts.admin')
@section('title', 'Transaksi - Ubah')

@section('content')
    <div class="container">

        <div class="row mx-auto justify-content-center">
            <div class="col-12 col-lg-6">

                <h5 class="dx-text-lg dx-text-biru dx-mb-10 text-center">Ubah <span
                        class="dx-text-kuning dx-font-bold dx-text-2xl">Transaksi</span>
                </h5>

                <form method="POST" action="{{ route('transaksi.update', $transaksi->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kode_transaksi">Kode Transaksi</label>
                                    <input type="text" class="dx-font-bold dx-input-disable" name="kode_transaksi"
                                        value="{{ old('kode_transaksi', $transaksi->kode_transaksi) }}" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="stok_barang_id">Nama Barang</label>
                                    <div class="dx-input-wrapper">
                                        <input type="text" class="dx-input-disable"
                                            value="{{ $transaksi->stokBarang->nama_barang }} (Sisa Stok: {{ $transaksi->stokBarang->stok_saat_ini }})"
                                            readonly>

                                        <input type="hidden" name="stok_barang_id"
                                            value="{{ $transaksi->stok_barang_id }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="jumlah_input">Jumlah Yang Diambil</label>
                                    <input type="number" name="jumlah" id="jumlah_input" min="1"
                                        max="{{ $transaksi->stokBarang->stok_saat_ini + $transaksi->jumlah }}"
                                        value="{{ old('jumlah', $transaksi->jumlah) }}">
                                    <small class="dx-text-abu">Maksimal :
                                        {{ $transaksi->stokBarang->stok_saat_ini + $transaksi->jumlah }}</small>
                                    <p id="error-js-jumlah" class="dx-text-merah dx-text-xs" style="display: none;"></p>
                                    @error('jumlah')
                                        <p class="dx-text-merah dx-text-xs">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_transaksi">Tanggal Transaksi</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_transaksi"
                                            placeholder="Pilih tanggal"
                                            value="{{ old('tanggal_transaksi', \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('Y-m-d')) }}" />
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
                                    <input type="text" name="nama_user"
                                        value="{{ old('nama_user', $transaksi->nama_user) }}">
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
                                    <input type="text" name="departemen"
                                        value="{{ old('departemen', $transaksi->departemen) }}">
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
                                        <option value="dipinjamkan"
                                            {{ old('status', $transaksi->status) == 'dipinjamkan' ? 'selected' : '' }}>
                                            Dipinjamkan
                                        </option>
                                        <option value="diberikan"
                                            {{ old('status', $transaksi->status) == 'diberikan' ? 'selected' : '' }}>
                                            Diberikan
                                        </option>
                                        <option value="dibatalkan"
                                            {{ old('status', $transaksi->status) == 'dibatalkan' ? 'selected' : '' }}>
                                            Dibatalkan
                                        </option>
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
                                    <label for="bukti_transaksi">Upload Bukti Transaksi</label>

                                    @if ($transaksi->bukti_transaksi)
                                        @php
                                            $extension = strtolower(
                                                pathinfo($transaksi->bukti_transaksi, PATHINFO_EXTENSION),
                                            );
                                        @endphp

                                        <div class="mb-3">
                                            @if (in_array($extension, ['jpg', 'jpeg', 'png']))
                                                <a href="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
                                                        alt="Bukti Transaksi" class="img-thumbnail"
                                                        style="max-width: 300px; cursor: pointer;"
                                                        title="Klik untuk memperbesar">
                                                </a>
                                            @elseif ($extension === 'pdf')
                                                <small class="dx-text-xs dx-font-bold dx-text-abu-abu-gelap">Dokumen
                                                    PDF</small>
                                                <a href="{{ asset('storage/' . $transaksi->bukti_transaksi) }}"
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
                            <button type="submit" class="dx-btn dx-btn-primary">Update</button>
                            <a href="{{ route('transaksi.index') }}" class="dx-btn dx-btn-secondary">Batal</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="{{ asset('js/ubah-transaksi.js') }}"></script>
    @endpush
@endsection
