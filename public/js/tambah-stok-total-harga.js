document.addEventListener('DOMContentLoaded', () => {
    // Definisi Elemen
    const inputStok = document.getElementById('input_stok');
    const displayHargaSatuan = document.getElementById('input_harga');
    const hiddenHargaSatuan = document.getElementById('harga_satuan_hidden');
    const displayHargaTotal = document.getElementById('harga');
    const hiddenHargaTotal = document.getElementById('harga_total_hidden');

    const formatRupiah = (angka) => new Intl.NumberFormat('id-ID').format(angka);

    const kalkulasiTotalAset = () => {
        // Ambil dari hidden field karena itu yang berisi angka murni dari DB (saat edit)
        const stok = parseFloat(inputStok.value) || 0;
        const hargaSatuan = parseFloat(hiddenHargaSatuan.value) || 0;
        const total = stok * hargaSatuan;

        displayHargaTotal.value = formatRupiah(total);
        hiddenHargaTotal.value = total;
    };

    // Event Listener Harga Satuan
    displayHargaSatuan.addEventListener('keyup', (e) => {
        let value = e.target.value.replace(/[^0-9]/g, '');
        hiddenHargaSatuan.value = value;
        e.target.value = value ? formatRupiah(value) : '';
        kalkulasiTotalAset();
    });

    // Event Listener Stok
    inputStok.addEventListener('input', kalkulasiTotalAset);

    // --- PEMANGGILAN AWAL ---
    // Panggil di sini agar saat halaman EDIT dibuka, Harga Total langsung terisi
    kalkulasiTotalAset();
});
