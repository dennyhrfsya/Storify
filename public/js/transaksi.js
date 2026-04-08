$(document).ready(function () {
    const selectBarang = $('.select2-js');
    const inputJumlah = $('#jumlah_input');
    const form = $('#form-tambah-transaksi'); // Sesuaikan dengan ID di Blade (tadi di Blade id-nya form-tambah-transaksi)

    // 1. Update Stok saat barang dipilih
    selectBarang.on('change', function () {
        const selectedOption = $(this).find(':selected');
        const stok = selectedOption.data('stok');

        // Isi field display dan hidden
        $('#stok_awal_display').val(stok !== undefined ? stok : '');
        $('#stok_awal_hidden').val(stok !== undefined ? stok : '');

        // Set atribut max pada input jumlah secara dinamis
        if (stok) {
            inputJumlah.attr('max', stok);
            inputJumlah.attr('placeholder', 'Maksimal : ' + stok);
            $('#error-stok-awal').hide();
        } else {
            inputJumlah.removeAttr('max');
            inputJumlah.attr('placeholder', '');
        }
    });

    // 2. Validasi saat Submit
    form.on('submit', function (e) {
        const stokAwal = parseInt($('#stok_awal_hidden').val());
        const jumlahInput = parseInt(inputJumlah.val());

        // Validasi A: Apakah barang sudah dipilih?
        if (!stokAwal && stokAwal !== 0) {
            $('#error-stok-awal').text('Silakan pilih barang terlebih dahulu!').show();
            e.preventDefault();
            scrollKeElement($('#stok_awal_display'));
            return;
        }

        // Validasi B: Apakah jumlah melebihi stok?
        if (jumlahInput > stokAwal) {
            alert('Gagal! Jumlah yang diambil (' + jumlahInput + ') melebihi stok yang tersedia (' + stokAwal + ').');
            inputJumlah.addClass('is-invalid'); // Tambahkan class error jika ada
            e.preventDefault();
            scrollKeElement(inputJumlah);
            return;
        }
    });

    // Fungsi pembantu untuk scroll
    function scrollKeElement(element) {
        $('html, body').animate({
            scrollTop: element.offset().top - 150
        }, 500);
    }
});
