function searchHandler() {
    return {
        showSearch: false,
        search: '',
        isLoading: false,
        results: [],
        
        async fetchResults() {
            // Validasi: Jangan cari jika input kurang dari 2 karakter
            if (this.search.length < 2) {
                this.results = [];
                return;
            }

            this.isLoading = true; // Aktifkan loading state

            try {
                // Proses AJAX Fetch ke Backend
                const response = await fetch(`/api/search?q=${encodeURIComponent(this.search)}`);
                
                // Mengambil data dalam format JSON
                const data = await response.json();
                
                // Masukkan data hasil ke variabel results untuk dirender oleh Alpine
                this.results = data; 
            } catch (error) {
                console.error('Search error:', error);
            } finally {
                this.isLoading = false; // Matikan loading state
            }
        }
    }
}