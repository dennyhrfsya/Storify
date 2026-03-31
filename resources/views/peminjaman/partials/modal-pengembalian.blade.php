<div class="modal fade" id="modalPengembalian" tabindex="-1" role="dialog" aria-modal="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{ route('peminjaman.pengembalian.simpan') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="id_peminjaman" id="input_id_peminjaman">
                <div class="modal-body">
                    <div class="dx-modal-exit" role="button" tabindex="0" data-bs-dismiss="modal" aria-label="Close">
                        <svg width="18" height="18" viewBox="0 0 52 52" fill="#2880CE"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M26 0C11.664 0 0 11.663 0 26C0 40.337 11.664 52 26 52C40.336 52 52 40.337 52 26C52 11.663 40.336 0 26 0ZM26 50C12.767 50 2 39.233 2 26C2 12.767 12.767 2 26 2C39.233 2 50 12.767 50 26C50 39.233 39.233 50 26 50Z">
                            </path>
                            <path
                                d="M35.707 16.293C35.316 15.902 34.684 15.902 34.293 16.293L26 24.586L17.707 16.293C17.316 15.902 16.684 15.902 16.293 16.293C15.902 16.684 15.902 17.316 16.293 17.707L24.586 26L16.293 34.293C15.902 34.684 15.902 35.316 16.293 35.707C16.488 35.902 16.744 36 17 36C17.256 36 17.512 35.902 17.707 35.707L26 27.414L34.293 35.707C34.488 35.902 34.744 36 35 36C35.256 36 35.512 35.902 35.707 35.707C36.098 35.316 36.098 34.684 35.707 34.293L27.414 26L35.707 17.707C36.098 17.316 36.098 16.684 35.707 16.293Z">
                            </path>
                        </svg>
                    </div>

                    <h6 class="dx-modal-title">Pengembalian Aset</h6>
                    <p class="text-center text-muted small mb-4" id="text_info_barang"></p>

                    <div class="dx-modal-body-input">
                        <div class="dx-modal-form-input mx-auto">

                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="tanggal_pengembalian">Tanggal Pengembalian</label>
                                    <div class="dx-input-wrapper">
                                        <input type="date" id="tanggal" name="tanggal_pengembalian"
                                            value="{{ old('tanggal_pengembalian') }}" placeholder="Pilih tanggal" />
                                        <span class="dx-icon">
                                            <img src="{{ asset('images/icon-calendar.svg') }}" alt="ava calendar"
                                                class="dx-h-6 dx-ml-4"></a>
                                        </span>
                                    </div>
                                    @error('tanggal_pengembalian')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="foto_pengembalian">Foto / Bukti Kembali</label>
                                    <input type="file" id="fileinput" name="foto_pengembalian"
                                        accept=".jpg,.jpeg,.png,.pdf" />
                                    <div class="dx-text-xs dx-text-abu-abu-gelap dx-py-1">
                                        Format yang didukung: JPG, PNG, PDF. Maksimal 2MB.
                                    </div>
                                    @error('foto_pengembalian')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="kondisi_pengembalian">Kondisi Barang</label>
                                    <select id="select" name="kondisi_pengembalian">
                                        <option value="">Pilih Opsi...</option>
                                        <option value="baik">Baik</option>
                                        <option value="rusak">Rusak</option>
                                    </select>
                                    @error('kondisi_pengembalian')
                                        <p class="dx-text-merah dx-text-xs dx-margin-bottom-0">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="dx-form-control-full">
                                <div class="dx-form-group">
                                    <label for="catatan">Catatan</label>
                                    <textarea name="catatan" id="catatan"></textarea>
                                </div>
                            </div>

                        </div>

                        <div class="dx-modal-footer">
                            <button type="button" class="dx-btn dx-btn-secondary"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="dx-btn dx-btn-primary">Kembalikan</button>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
