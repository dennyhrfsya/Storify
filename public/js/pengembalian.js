/**
 * Asset Return Handler - Combined Block Scoped Version
 * Menggabungkan fitur: Auto-open saat error, Reset saat tutup, dan Auto-fill dari tombol.
 */
{
    const initPengembalianAsset = () => {
        const modalEl = document.getElementById('modalPengembalian');
        if (!modalEl) return;

        const inputId = modalEl.querySelector('#input_id_peminjaman');
        const textInfo = modalEl.querySelector('#text_info_barang');

        // --- 1. LOGIKA AUTO-FILL (Saat tombol "Kembalikan" diklik) ---
        modalEl.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;

            // Cek jika modal dipicu oleh tombol, bukan dipicu manual lewat JS (Auto-open error)
            if (button) {
                const { id, kode, barang } = button.dataset;

                if (inputId) inputId.value = id;
                if (textInfo) {
                    textInfo.innerHTML = `Anda akan mengembalikan: <strong>${barang}</strong> <br>
                                          <small class="text-muted">Kode Pinjam: ${kode}</small>`;
                }
            }
        });

        // --- 2. LOGIKA AUTO-OPEN (Saat terjadi error validasi Laravel) ---
        const { errors, oldId } = modalEl.dataset;
        if (errors === 'true') {
            const myModal = window.bootstrap.Modal.getOrCreateInstance(modalEl);
            myModal.show();

            // Jika ada data lama (saat revisi), tampilkan pesan error di dalam modal
            if (oldId && inputId) {
                inputId.value = oldId;
                if (textInfo) {
                    textInfo.innerHTML = `<span class="dx-text-merah">Gagal menyimpan. Silakan periksa kembali input Anda.</span>`;
                }
            }
        }

        // --- 3. LOGIKA RESET & PEMBERSIHAN (Saat modal ditutup) ---
        modalEl.addEventListener('hidden.bs.modal', function () {
            const form = this.querySelector('form');
            if (form) form.reset();

            // Reset manual elemen yang tidak terkena reset() form
            if (inputId) inputId.value = '';
            if (textInfo) textInfo.innerHTML = '';

            // Sembunyikan semua pesan error validasi (Laravel @error)
            document.querySelectorAll('.dx-text-merah').forEach(el => {
                el.style.display = 'none';
            });
        });
    };

    // Jalankan inisialisasi saat DOM siap
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initPengembalianAsset);
    } else {
        initPengembalianAsset();
    }
}
