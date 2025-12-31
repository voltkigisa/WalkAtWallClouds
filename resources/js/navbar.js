// resources/js/navbar.js

// Global search handler function - defined immediately
window.searchHandler = function() {
    return {
        showSearch: false,
        search: '',
        isLoading: false,
        results: [],
        
        init() {
            console.log('[Search] Component initialized');
            // Log environment info for debugging
            console.log('[Search] Current URL:', window.location.href);
            console.log('[Search] Is Admin:', this.isAdminPage());
        },
        
        isAdminPage() {
            return window.location.pathname.includes('/admin') || 
                   document.querySelector('[data-admin-search]') !== null;
        },
        
        async fetchResults() {
            console.log('[Search] Fetching results for:', this.search);
                
            if (this.search.length < 1) {
                this.results = [];
                return;
            }
            
            this.isLoading = true;
            
            try {
                // Check if we're in admin page
                if (!this.isAdminPage()) {
                    console.warn('[Search] Not in admin page, search disabled');
                    this.results = [];
                    this.isLoading = false;
                    return;
                }
                
                // Build API URL
                const baseUrl = window.location.origin;
                const apiUrl = `${baseUrl}/admin/search?q=${encodeURIComponent(this.search)}`;
                
                console.log('[Search] API URL:', apiUrl);
                
                // Get CSRF token from meta tag or cookie
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                                document.querySelector('input[name="_token"]')?.value ||
                                '';
                
                const headers = {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                };
                
                if (csrfToken) {
                    headers['X-CSRF-TOKEN'] = csrfToken;
                }
                
                const response = await fetch(apiUrl, {
                    method: 'GET',
                    headers: headers,
                    credentials: 'same-origin',
                    cache: 'no-cache'
                });
                
                console.log('[Search] Response status:', response.status);
                
                if (!response.ok) {
                    const errorText = await response.text();
                    console.error('[Search] Error response:', errorText);
                    
                    if (response.status === 401 || response.status === 419) {
                        console.error('[Search] Authentication error - session expired?');
                    } else if (response.status === 500) {
                        console.error('[Search] Server error - check Laravel logs');
                    }
                    
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                console.log('[Search] Results received:', data.length, 'items');
                this.results = data; 
            } catch (error) {
                console.error('[Search] Error:', error);
                console.error('[Search] Error details:', {
                    message: error.message,
                    stack: error.stack
                });
                this.results = [];
            } finally {
                this.isLoading = false;
            }
        }
    };
};

// Log when script is loaded
console.log('[Search] navbar.js loaded successfully');

// Alpine.js event listener for debugging
document.addEventListener('alpine:init', () => {
    console.log('[Search] Alpine.js initialized');
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