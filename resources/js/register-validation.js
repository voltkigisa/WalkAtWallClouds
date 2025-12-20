document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('form');
    const nameInput = document.getElementById('name');
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirmation');
    const submitBtn = document.querySelector('button[type="submit"]');

    // Fungsi untuk mengubah style input jika valid/invalid
    const setValidationStyle = (input, isValid) => {
        if (isValid) {
            input.classList.remove('border-red-500', 'focus:ring-red-500');
            input.classList.add('border-green-500', 'focus:ring-green-500');
        } else {
            input.classList.remove('border-green-500', 'focus:ring-green-500');
            input.classList.add('border-red-500', 'focus:ring-red-500');
        }
    };

    // 1. Validasi Nama (Minimal 3 karakter)
    nameInput.addEventListener('input', () => {
        setValidationStyle(nameInput, nameInput.value.length >= 3);
    });

    // 2. Validasi Email (Format Email)
    emailInput.addEventListener('input', () => {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        setValidationStyle(emailInput, emailRegex.test(emailInput.value));
    });

    // 3. Validasi Password (Minimal 8 karakter)
    passwordInput.addEventListener('input', () => {
        setValidationStyle(passwordInput, passwordInput.value.length >= 8);
        // Cek ulang konfirmasi jika password utama diubah
        setValidationStyle(confirmInput, confirmInput.value === passwordInput.value && confirmInput.value !== "");
    });

    // 4. Validasi Konfirmasi Password (Harus Sama)
    confirmInput.addEventListener('input', () => {
        const isMatch = confirmInput.value === passwordInput.value && confirmInput.value !== "";
        setValidationStyle(confirmInput, isMatch);
    });

    // Prevent Submit jika ada yang salah
    form.addEventListener('submit', function (e) {
        if (passwordInput.value !== confirmInput.value) {
            e.preventDefault();
            alert('Password and Confirm Password do not match!');
        }
    });
});