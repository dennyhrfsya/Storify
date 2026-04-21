document.addEventListener('DOMContentLoaded', () => {
    // Inisialisasi "Dari Tanggal"
    const fpDari = flatpickr("#dari_tanggal", {
        disableMobile: true,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        altInputClass: "flatpicker-input active",
        onChange: (selectedDates, dateStr) => {
            // Update batas minimal "Sampai Tanggal"
            fpSampai.set('minDate', dateStr);
        }
    });

    // Inisialisasi "Sampai Tanggal"
    const fpSampai = flatpickr("#sampai_tanggal", {
        disableMobile: true,
        dateFormat: "Y-m-d",
        altInput: true,
        altFormat: "d-m-Y",
        altInputClass: "flatpicker-input active",
        onChange: (selectedDates, dateStr) => {
            // Update batas maksimal "Dari Tanggal"
            fpDari.set('maxDate', dateStr);
        }
    });
}
);
