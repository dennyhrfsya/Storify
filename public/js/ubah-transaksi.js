$(document).ready(function () {
    const inputJumlah = $('#jumlah_input');
    const pesanError = $('#error-js-jumlah');
    const selectStatus = $('#select');
    const displayMaxText = $('#display-max');

    function sinkronisasiMaksimal() {
        const stokDb = parseInt(inputJumlah.attr('data-stok-asal'));
        const jumlahDb = parseInt(inputJumlah.attr('data-jumlah-asal'));
        const statusDb = inputJumlah.attr('data-status-asal');

        const statusBaru = selectStatus.val();
        let maxKalkulasi;

        // 1. Logika Anti-Bocor (Angka 15)
        if (statusDb === 'dibatalkan') {
            maxKalkulasi = stokDb;
        } else {
            maxKalkulasi = stokDb + jumlahDb;
        }

        inputJumlah.attr('max', maxKalkulasi);
        displayMaxText.text(maxKalkulasi);

        // 2. Logika Status Dibatalkan
        if (statusBaru === 'dibatalkan') {
            // Paksa nilai kembali ke angka asli (5) jika user iseng input lain (7)
            inputJumlah.val(jumlahDb);

            // Ubah tipe ke text dan kunci input
            inputJumlah.attr('type', 'text').prop('readonly', true);

            // Tambahkan class disable (Menghapus manual CSS)
            inputJumlah.addClass('dx-input-disable');

            // Sembunyikan pesan error karena nilai sudah dipaksa benar
            pesanError.hide();
            inputJumlah.removeClass('dx-input-invalid');
        } else {
            // Jika status Aktif, buka kunci dan hapus class disable
            inputJumlah.attr('type', 'number').prop('readonly', false);
            inputJumlah.removeClass('dx-input-disable');
        }

        inputJumlah.trigger('input');
    }

    // Event saat dropdown ganti
    selectStatus.on('change', function () {
        sinkronisasiMaksimal();
    });

    // Validasi Input
    inputJumlah.on('input', function () {
        if ($(this).prop('readonly')) return;

        const maxVal = parseInt($(this).attr('max'));
        const inputVal = parseInt($(this).val());

        if (inputVal > maxVal) {
            pesanError.text('Jumlah melebihi stok! Maksimal pengambilan adalah ' + maxVal).show();
            $(this).addClass('dx-input-invalid').val(maxVal);

            setTimeout(() => {
                pesanError.fadeOut();
                $(this).removeClass('dx-input-invalid');
            }, 3000);
        } else {
            pesanError.hide();
            $(this).removeClass('dx-input-invalid');
        }
    });

    // Inisialisasi saat load halaman
    sinkronisasiMaksimal();
});
