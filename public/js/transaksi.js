$(document).ready(function () {
    const selectBarang = $('.select2-js');

    selectBarang.on('change', function (e) {
        const selectedOption = $(this).find(':selected');
        const stok = selectedOption.data('stok');
        $('#stok_awal_display').val(stok ? stok : '');
        $('#stok_awal_hidden').val(stok ? stok : '');

        const jumlahInput = $('#jumlah_input');
        if (stok) {
            jumlahInput.attr('max', stok);
        } else {
            jumlahInput.removeAttr('max');
        }
    });
});

