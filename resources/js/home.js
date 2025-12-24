Swal.fire({
    title: 'WELCOME BACK!',
    text: '{{ session("success") }}',
    icon: 'success',
    iconColor: '#6366f1', // Warna Indigo Tailwind
    background: 'rgba(17, 24, 39, 0.8)', // Transparan
    backdrop: `
        rgba(0,0,123,0.1)
        url("https://media.giphy.com/media/v1.Y2lkPTc5MGI3NjExNHJueGZ3bmZ3bmZ3bmZ3bmZ3bmZ3bmZ3bmZ3bmZ3bmZ3bmZ3JmVwPXYxX2ludGVybmFsX2dpZl9ieV9pZ")
        left top
        no-repeat
    `, // Opsional: Efek partikel di background luar
    color: '#fff',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    showClass: {
        popup: 'animate__animated animate__fadeInDown' // Animasi masuk
    },
    hideClass: {
        popup: 'animate__animated animate__fadeOutUp' // Animasi keluar
    },
    customClass: {
        popup: 'border border-indigo-500/30 rounded-3xl backdrop-blur-xl',
        title: 'text-2xl font-black italic tracking-tighter uppercase',
        timerProgressBar: 'bg-indigo-500',
    }
});