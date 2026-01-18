
document.addEventListener('DOMContentLoaded', () => {
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // The lower the slower

    const animateCounters = (entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const updateCount = () => {
                    const target = +counter.getAttribute('data-target');
                    const count = +counter.innerText.replace(/[^\d]/g, ''); // Get just number 

                    // Lower increment to count slower
                    const inc = target / speed;

                    if (count < target) {
                        // Add inc to count and output in counter
                        counter.innerText = Math.ceil(count + inc);
                        // Call function every ms
                        setTimeout(updateCount, 15);
                    } else {
                        counter.innerText = target;
                        // Append suffix if exists
                        const suffix = counter.getAttribute('data-suffix');
                        if (suffix) {
                            counter.innerText += suffix;
                        }
                    }
                };

                updateCount();
                observer.unobserve(counter); // Only run once
            }
        });
    };

    const observer = new IntersectionObserver(animateCounters, {
        threshold: 0.5 // Trigger when 50% visible
    });

    counters.forEach(counter => {
        observer.observe(counter);
    });
});
