document.addEventListener('DOMContentLoaded', () => {
    const inputStok = document.getElementById('input_stok');
    const displayHargaSatuan = document.getElementById('input_harga');
    const hiddenHargaSatuan = document.getElementById('harga_satuan_hidden');
    const displayHargaTotal = document.getElementById('harga');
    const hiddenHargaTotal = document.getElementById('harga_total_hidden');

    const formatRupiah = (angka) => new Intl.NumberFormat('id-ID').format(angka);

    const kalkulasiTotalAset = (isManualUpdate = false) => {
        if (inputStok.hasAttribute('readonly') && isManualUpdate) {
            return;
        }

        const stok = parseFloat(inputStok.value) || 0;
        const hargaSatuan = parseFloat(hiddenHargaSatuan.value) || 0;
        const currentTotal = parseFloat(hiddenHargaTotal.value) || 0;

        let total;
        if (isManualUpdate) {
            total = stok * hargaSatuan;
        } else {
            total = currentTotal;
        }

        displayHargaTotal.value = formatRupiah(total);
        hiddenHargaTotal.value = total;
    };

    displayHargaSatuan.addEventListener('keyup', (e) => {
        if (displayHargaSatuan.hasAttribute('readonly')) return;

        let value = e.target.value.replace(/[^0-9]/g, '');
        hiddenHargaSatuan.value = value;
        e.target.value = value ? formatRupiah(value) : '';
        kalkulasiTotalAset(true);
    });

    inputStok.addEventListener('input', () => {
        if (inputStok.hasAttribute('readonly')) return;
        kalkulasiTotalAset(true);
    });

    displayHargaTotal.value = formatRupiah(hiddenHargaTotal.value || 0);
});
