// resources/js/navbar.js

// 1. Logic untuk Search (Alpine.js)
// Menggunakan alpine:init agar Alpine pasti mengenali fungsi ini sebelum merender HTML
document.addEventListener('alpine:init', () => {
    console.log('Alpine.js initialized - searchHandler registered');
    
    window.searchHandler = function() {
        console.log('searchHandler function called');
        return {
            showSearch: false,
            search: '',
            isLoading: false,
            results: [],
            
            init() {
                console.log('searchHandler component initialized');
            },
            
            async fetchResults() {
                console.log('fetchResults called, search term:', this.search);
                
                if (this.search.length < 1) {
                    this.results = [];
                    return;
                }
                this.isLoading = true;
                try {
                    // Check if we're in admin or public page
                    const isAdmin = window.location.pathname.includes('/admin') || 
                                    document.querySelector('[data-admin-search]');
                    
                    // Admin uses /admin/search, no public search anymore
                    if (!isAdmin) {
                        console.log('Not in admin page, search disabled');
                        this.results = [];
                        this.isLoading = false;
                        return;
                    }
                    
                    const apiUrl = `/admin/search?q=${encodeURIComponent(this.search)}`;
                    
                    console.log('Search URL:', apiUrl);
                    console.log('Is Admin:', isAdmin);
                    
                    const response = await fetch(apiUrl);
                    console.log('Response status:', response.status);
                    
                    if (!response.ok) {
                        const errorText = await response.text();
                        console.error('Response error:', errorText);
                        throw new Error('Network response was not ok');
                    }
                    
                    const data = await response.json();
                    console.log('Search results:', data);
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