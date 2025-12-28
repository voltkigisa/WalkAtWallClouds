document.addEventListener('DOMContentLoaded', function() {
    
    // Handler untuk tombol Plus dan Minus
    document.addEventListener('click', function(e) {
        // Cari elemen yang diklik berdasarkan data-action
        const action = e.target.closest('[data-action]');
        if (!action) return;

        const targetId = action.getAttribute('data-target');
        const input = document.getElementById(targetId);
        if (!input) return;

        const currentValue = parseInt(input.value) || 1;
        const max = parseInt(input.getAttribute('max'));
        const min = parseInt(input.getAttribute('min')) || 1;

        if (action.getAttribute('data-action') === 'increment') {
            if (currentValue < max) {
                input.value = currentValue + 1;
            }
        } else if (action.getAttribute('data-action') === 'decrement') {
            if (currentValue > min) {
                input.value = currentValue - 1;
            }
        }
    });

    // Validasi input manual jika user mengetik angka langsung
    document.querySelectorAll('.ticket-qty').forEach(input => {
        input.addEventListener('change', function() {
            const max = parseInt(this.getAttribute('max'));
            const min = parseInt(this.getAttribute('min')) || 1;
            let val = parseInt(this.value);

            if (isNaN(val) || val < min) this.value = min;
            if (val > max) this.value = max;
        });
    });
});