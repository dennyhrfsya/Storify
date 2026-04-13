$(document).ready(function () {
    const inputJumlah = $('#jumlah_input');
    const pesanError = $('#error-js-jumlah');
    const selectStatus = $('#select');
    const displayMaxText = $('#display-max');
    const notifKembali = $('#notif-kembali');

    function sinkronisasiMaksimal() {
        // Ambil data dari atribut dengan fallback jika NaN
        const stokDb = parseInt(inputJumlah.attr('data-stok-asal')) || 0;
        const jumlahDb = parseInt(inputJumlah.attr('data-jumlah-asal')) || 0;
        // Gunakan toLowerCase agar perbandingan string aman
        const statusDbAsli = (inputJumlah.attr('data-status-asal') || "").toLowerCase();

        const statusBaru = selectStatus.val() ? selectStatus.val().toLowerCase() : "";
        let maxKalkulasi;

        // 1. Logika Anti-Bocor (Kunci di angka 10)
        if (statusDbAsli === 'dibatalkan') {
            maxKalkulasi = stokDb;
        } else {
            maxKalkulasi = stokDb + jumlahDb;
        }

        inputJumlah.attr('max', maxKalkulasi);
        displayMaxText.text(maxKalkulasi);

        // 2. Logika Tampilan Input berdasarkan status yang dipilih di dropdown
        if (statusBaru === 'dibatalkan') {
            // Jika aslinya sudah batal, tampilkan 0. Jika baru mau dibatalkan, biarkan jumlah aslinya.
            const nilaiBatal = (statusDbAsli === 'dibatalkan') ? 0 : jumlahDb;
            inputJumlah.val(nilaiBatal);

            inputJumlah.prop('readonly', true).addClass('dx-input-disable');
            pesanError.hide();
            inputJumlah.removeClass('dx-input-invalid');
        } else {
            // Jika status Aktif (Dipinjamkan/Diberikan)
            inputJumlah.prop('readonly', false).removeClass('dx-input-disable');

            // Jika transisi dari batal (0) ke aktif, set minimal 1
            if (inputJumlah.val() == 0) {
                inputJumlah.val(1);
            }
        }
    }

    // Event saat dropdown ganti
    selectStatus.on('change', function () {
        sinkronisasiMaksimal();
    });

    // Validasi Input
    inputJumlah.on('input', function () {
        // Jangan jalankan validasi jika input sedang dikunci (readonly)
        if ($(this).prop('readonly')) return;

        const maxVal = parseInt($(this).attr('max'));
        let inputVal = parseInt($(this).val());

        if (inputVal > maxVal) {
            pesanError.text('Jumlah melebihi stok! Maksimal pengambilan adalah ' + maxVal).show();
            $(this).addClass('dx-input-invalid').val(maxVal);

            setTimeout(() => {
                pesanError.fadeOut();
                $(this).removeClass('dx-input-invalid');
            }, 3000);
        } else if (inputVal < 1 && selectStatus.val() !== 'dibatalkan') {
            // Mencegah input minus atau nol saat status aktif
            $(this).val(1);
        } else {
            pesanError.hide();
            $(this).removeClass('dx-input-invalid');
        }
    });

    // Inisialisasi saat load halaman
    sinkronisasiMaksimal();
});
