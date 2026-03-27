document.addEventListener('DOMContentLoaded', () => {
    // Sticky Header
    const header = document.querySelector('header');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 50) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Scroll Reveal Animation with Intersection Observer
    const revealElements = document.querySelectorAll('.reveal, .reveal-left, .reveal-right');
    
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                if (entry.target.classList.contains('reveal-left')) {
                    entry.target.classList.add('reveal-visible-left');
                } else if (entry.target.classList.contains('reveal-right')) {
                    entry.target.classList.add('reveal-visible-right');
                } else {
                    entry.target.classList.add('reveal-visible');
                }
                revealObserver.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.15,
        rootMargin: '0px 0px -50px 0px'
    });

    revealElements.forEach(el => revealObserver.observe(el));

    // Mobile Menu Toggle
    const mobileMenu = document.querySelector('#mobile-menu');
    const navMenu = document.querySelector('#nav-menu');

    mobileMenu.addEventListener('click', () => {
        header.classList.toggle('active');
        mobileMenu.classList.toggle('active');
        navMenu.classList.toggle('active');
        document.body.classList.toggle('no-scroll'); // Prevent scroll when menu is open
    });

    // Close menu when a link is clicked
    document.querySelectorAll('#nav-menu a').forEach(link => {
        link.addEventListener('click', () => {
            header.classList.remove('active');
            mobileMenu.classList.remove('active');
            navMenu.classList.remove('active');
            document.body.classList.remove('no-scroll');
        });
    });

    console.log("Ziggy Natural Loaded");
});
