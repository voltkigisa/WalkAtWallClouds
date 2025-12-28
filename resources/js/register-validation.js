
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirm = document.getElementById('password_confirmation');
        const errorMsg = document.getElementById('password-error');
        const submitBtn = document.querySelector('button[type="submit"]');

        function validatePassword() {
            if (confirm.value === '') {
                errorMsg.classList.add('hidden');
                submitBtn.disabled = false;
            } else if (password.value !== confirm.value) {
                errorMsg.classList.remove('hidden');
                confirm.classList.add('border-red-500');
                submitBtn.disabled = true; // Matikan tombol jika beda
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            } else {
                errorMsg.classList.add('hidden');
                confirm.classList.remove('border-red-500');
                confirm.classList.add('border-green-500');
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
        }

        password.addEventListener('keyup', validatePassword);
        confirm.addEventListener('keyup', validatePassword);
    });
