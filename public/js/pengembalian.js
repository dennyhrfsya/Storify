document.addEventListener('DOMContentLoaded', () => {
    const modalReturn = document.querySelector('#modalPengembalian');

    if (modalReturn) {
        // Event ini terpicu saat tombol "Kembalikan" diklik (sebelum modal muncul)
        modalReturn.addEventListener('show.bs.modal', (event) => {
            // 1. Ambil tombol yang diklik (Trigger)
            const button = event.relatedTarget;

            // 2. Destructuring data dari dataset tombol (data-id, data-kode, dst)
            const { id, kode, barang } = button.dataset;

            // 3. DEBUGGING: Cek di Console Browser (F12)
            // console.group("DEBUG: Modal Pengembalian");
            // console.log("ID Peminjaman :", id);
            // console.log("Kode Barang   :", kode);
            // console.log("Nama Barang   :", barang);
            // console.groupEnd();

            // 4. Seleksi elemen di dalam modal
            const inputId = modalReturn.querySelector('#input_id_peminjaman');
            const infoText = modalReturn.querySelector('#text_info_barang');
            const form = modalReturn.querySelector('form');

            // 5. Masukkan ID ke input hidden agar terkirim ke Controller
            if (inputId) {
                inputId.value = id;
                // console.log("Input Hidden Value Terisi:", inputId.value);
            }

            // 6. Update teks informasi di Modal
            if (infoText) {
                infoText.innerHTML = `Anda akan mengembalikan : <strong>${barang}</strong> <br> <small class="text-muted">Kode Pinjam : ${kode}</small>`;
            }

            // 7. Reset Form (Pembersihan input dari klik sebelumnya)
            if (form) {
                const fileInput = form.querySelector('input[type="file"]');
                const textArea = form.querySelector('textarea');
                // Kita tidak mereset inputId karena baru saja kita isi di atas
                if (fileInput) fileInput.value = '';
                if (textArea) textArea.value = '';
            }
        });
    }
});
