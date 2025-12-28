// resources/js/navbar.js

// 1. Logic untuk Search (Alpine.js)
// Menggunakan alpine:init agar Alpine pasti mengenali fungsi ini sebelum merender HTML
document.addEventListener('alpine:init', () => {
    // endpoint: '/search' for public, '/admin/search' for admin
    window.searchHandler = function(endpoint = '/search') {
        return {
            endpoint,
            showSearch: false,
            search: '',
            // Public filters
            location: '',
            date: '',
            type: '', // events | artists | tickets
            // Admin filters
            status: '',
            date_from: '',
            date_to: '',
            isLoading: false,
            results: [],

            async fetchResults() {
                // Minimal trigger threshold
                if (this.search.trim().length < 2) {
                    this.results = [];
                    return;
                }
                this.isLoading = true;
                try {
                    const params = new URLSearchParams();
                    params.set('q', this.search.trim());
                    // Public
                    if (this.location) params.set('location', this.location);
                    if (this.date) params.set('date', this.date);
                    if (this.type) params.set('type', this.type);
                    // Admin
                    if (this.status) params.set('status', this.status);
                    if (this.date_from) params.set('date_from', this.date_from);
                    if (this.date_to) params.set('date_to', this.date_to);

                    const response = await fetch(`${this.endpoint}?${params.toString()}`);
                    if (!response.ok) throw new Error('Network response was not ok');
                    const data = await response.json();

                    // Normalize various payloads into a single flat list for UI
                    const flat = [];
                    const pushItems = (arr, category, mapper) => {
                        if (!Array.isArray(arr)) return;
                        arr.forEach(item => {
                            const mapped = mapper ? mapper(item) : item;
                            flat.push({
                                id: mapped.id ?? item.id,
                                title: mapped.title ?? item.title ?? item.name ?? item.code ?? 'Item',
                                category,
                                url: mapped.url ?? '#',
                                image: mapped.image ?? null
                            });
                        });
                    };

                    // Public landing: events, artists, tickets(optional)
                    if (data.events || data.artists || data.tickets) {
                        pushItems(data.events || [], 'Event', (e) => ({
                            id: e.id,
                            title: e.title,
                            url: '/#ticket'
                        }));
                        pushItems(data.artists || [], 'Artist', (a) => ({
                            id: a.id,
                            title: a.name,
                            url: '/#guest-star'
                        }));
                        pushItems(data.tickets || [], 'Ticket', (t) => ({
                            id: t.id,
                            title: t.ticket_code || t.code || 'Ticket',
                            url: '/my-tickets'
                        }));
                    }

                    // Admin dashboard: users, tickets, payments
                    if (data.users || data.tickets || data.payments) {
                        pushItems(data.users || [], 'User', (u) => ({
                            id: u.id,
                            title: u.name,
                            url: `/users/${u.id}`
                        }));
                        pushItems(data.tickets || [], 'Ticket', (t) => ({
                            id: t.id,
                            title: t.ticket_code || t.code || 'Ticket',
                            url: `/tickets/${t.id}`
                        }));
                        pushItems(data.payments || [], 'Payment', (p) => ({
                            id: p.id,
                            title: p.invoice || `Payment #${p.id}`,
                            url: `/payments/${p.id}`
                        }));
                    }

                    // If API already returns flat array
                    if (Array.isArray(data)) {
                        data.forEach(item => flat.push(item));
                    }

                    this.results = flat;
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