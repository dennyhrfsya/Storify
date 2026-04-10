$(document).ready(function () {
    const selectBarang = $('.select2-js');
    const pesanError = $('#error-js-jumlah');
    const inputJumlah = $('#jumlah_input');

    // Update Stok saat barang dipilih
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

    // Validasi saat user mengetik (Opsional: mencegah user mengetik angka lebih besar)
    inputJumlah.on('input', function () {
        const max = parseInt($(this).attr('max'));
        const val = parseInt($(this).val());

        if (val > max) {
            // 1. Tampilkan pesan di bawah input (Gaya Laravel)
            pesanError.text('Jumlah melebihi stok! Maksimal pengambilan adalah ' + max).show();

            // 2. Tandai input dengan border merah
            $(this).addClass('dx-input-invalid');

            // 3. Opsional: Paksa balik ke angka maksimal
            $(this).val(max);

            // Sembunyikan pesan setelah 3 detik (opsional)
            setTimeout(() => {
                pesanError.fadeOut();
                $(this).css('border', '');
            }, 3000);

        } else {
            // Sembunyikan jika angka sudah benar
            pesanError.hide();
            $(this).css('border', '');
        }
    });
});
