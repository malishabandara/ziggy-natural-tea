document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.hero-slide');
    if (slides.length === 0) return;

    let currentSlide = 0;
    const intervalTime = 5000; // 5 seconds

    function nextSlide() {
        slides[currentSlide].classList.remove('active');
        currentSlide = (currentSlide + 1) % slides.length;
        slides[currentSlide].classList.add('active');
    }

    setInterval(nextSlide, intervalTime);
});
