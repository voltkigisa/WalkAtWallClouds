// Menunggu sampai seluruh DOM dimuat agar tidak error saat mencari ID
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('loginForm');

    if (loginForm) {
        loginForm.addEventListener('submit', function(e) {
            const account = document.getElementById('Account').value;
            const pass = document.getElementById('password').value;

            // Validasi kolom kosong
            if (!account || !pass) {
                e.preventDefault(); // Menghentikan pengiriman form
                alert('⚠️ Mohon isi semua kolom!');
            }
        });
    }
});

