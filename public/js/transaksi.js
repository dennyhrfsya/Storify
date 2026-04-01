$(document).ready(function () {
    const selectBarang = $('.select2-js');
    const form = $('form'); // Pastikan selektor form sesuai dengan di Blade kamu

    // 1. Reset validasi dan Update Stok saat barang dipilih
    selectBarang.on('change', function () {
        const selectedOption = $(this).find(':selected');
        const stok = selectedOption.data('stok');

        // Isi field display dan hidden
        $('#stok_awal_display').val(stok ? stok : '');
        $('#stok_awal_hidden').val(stok ? stok : '');

        // Sembunyikan pesan error jika stok sudah terisi (barang dipilih)
        if (stok) {
            $('#error-stok-awal').hide();
        }
    });

    // 2. Validasi saat Submit
    form.on('submit', function (e) {
        const stokAwal = $('#stok_awal_hidden').val();

        // Jika stok_awal kosong (berarti barang belum dipilih)
        if (!stokAwal || stokAwal === "") {
            // Tampilkan pesan error teks saja
            $('#error-stok-awal').show();

            // Gagalkan submit
            e.preventDefault();

            // Scroll halus ke arah input agar user sadar ada yang kurang
            $('html, body').animate({
                scrollTop: $('#stok_awal_display').offset().top - 150
            }, 500);
        }
    });
});
