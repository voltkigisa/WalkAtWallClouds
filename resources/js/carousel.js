
document.addEventListener('DOMContentLoaded', () => {
    const carousel = document.getElementById('carousel');
    let index = 0;
    const totalSlides = 4;

    function showSlide(n) {
        index = n;
        if (index >= totalSlides) index = 0;
        if (index < 0) index = totalSlides - 1;
        
        if (carousel) {
            carousel.style.transform = `translateX(-${index * 100}%)`;
        }
    }

    // Tempelkan ke window agar bisa diakses onclick di HTML
    window.prevSlide = () => showSlide(index - 1);
    window.nextSlide = () => showSlide(index + 1);

    setInterval(() => {
        window.nextSlide();
    }, 5000);
});