// resources/js/navbar.js

// 1. Logic untuk Search (Alpine.js)
// Menggunakan alpine:init agar Alpine pasti mengenali fungsi ini sebelum merender HTML
document.addEventListener('alpine:init', () => {
    window.searchHandler = function() {
        return {
            showSearch: false,
            search: '',
            isLoading: false,
            results: [],
            
            async fetchResults() {
                if (this.search.length < 2) {
                    this.results = [];
                    return;
                }
                this.isLoading = true;
                try {
                    const response = await fetch(`/api/search?q=${encodeURIComponent(this.search)}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();
                    this.results = data; 
                } catch (error) {
                    console.error('Search error:', error);
                    this.results = [];
                } finally {
                    this.isLoading = false;
                }
            }
        }
    }
});

// 2. Logic untuk Mobile Menu (Vanilla JS)
document.addEventListener('DOMContentLoaded', function () {
    const menuBtn = document.getElementById('menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    if (menuBtn && mobileMenu) {
        menuBtn.addEventListener('click', function (e) {
            e.preventDefault();
            mobileMenu.classList.toggle('hidden');
            const isOpened = !mobileMenu.classList.contains('hidden');
            if (isOpened && menuIcon) {
                menuIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6 18L18 6M6 6l12 12" />`;
            } else if (menuIcon) {
                menuIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />`;
            }
        });
    }
});