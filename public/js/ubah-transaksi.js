$(document).ready(function () {
    const inputJumlah = $('#jumlah_input');
    const pesanError = $('#error-js-jumlah');

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


// $(document).ready(function () {
//     const inputJumlah = $('#jumlah_input');
//     const pesanError = $('#error-js-jumlah');
//     let timer;

//     inputJumlah.on('input', function () {
//         const max = parseInt($(this).attr('max'));
//         const val = parseInt($(this).val());

//         clearTimeout(timer); // Hapus timer sebelumnya

//         if (val > max) {
//             $(this).val(max);
//             pesanError.text('Jumlah melebihi stok! Maksimal pengambilan adalah ' + max).show();
//             $(this).css('border-bottom', '2px solid #ef4444');

//             timer = setTimeout(() => {
//                 pesanError.fadeOut();
//                 $(this).css('border-bottom', '1px solid #0652dd');
//             }, 3000);
//         } else {
//             pesanError.hide();
//             $(this).css('border-bottom', '1px solid #0652dd');
//         }
//     });
// });
