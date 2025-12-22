document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (menuBtn && mobileMenu) {
        console.log("Navbar JS: Berhasil mendeteksi tombol dan menu."); // Cek di Inspect Console

        menuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            console.log("Navbar JS: Tombol diklik!");

            // Toggle Class Hidden
            mobileMenu.classList.toggle('hidden');

            // Cek apakah menu sedang tampil atau tidak
            const isOpened = !mobileMenu.classList.contains('hidden');

            if (isOpened) {
                // Ganti ke Icon X
                menuIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />`;
            } else {
                // Balik ke Icon Hamburger
                menuIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />`;
            }
        });

        // Tutup menu saat link diklik
        const links = mobileMenu.querySelectorAll('a');
        links.forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
                menuIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />`;
            });
        });
    } else {
        console.error("Navbar JS: Tombol menu-btn atau mobile-menu tidak ditemukan di HTML!");
    }
});