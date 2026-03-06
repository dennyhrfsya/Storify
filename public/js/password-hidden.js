//* Block Scope
const setupPasswordToggle = (inputId, iconId) => {
   const input = document.getElementById(inputId);
   const icon = document.getElementById(iconId);

   if (!input || !icon) return; // Guard clause jika elemen tidak ditemukan

   icon.onclick = () => {
      const isPassword = input.type === 'password';

      // Toggle tipe input
      input.type = isPassword ? 'text' : 'password';

      // Toggle gambar icon
      icon.setAttribute('src', isPassword ? 'images/eye-slash.svg' : 'images/eye.svg');

      // Toggle class (menggunakan classList.toggle lebih ringkas)
      input.classList.toggle('form-group', isPassword);
   };
};

// Panggil fungsi untuk masing-masing input
setupPasswordToggle('password-current', 'icon-current-password');
setupPasswordToggle('password-new', 'icon-new-password');