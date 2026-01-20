<?php
require_once 'config.php';
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section with Slider -->
<section class="hero-slider-section">
    <div class="hero-slider">
        <!-- Slide 1 -->
        <div class="hero-slide active" style="background-image: url('assets/customers/1.JPG');">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <span class="hero-subtitle">Premium Ceylon Collection</span>
                <h1>Sip the Essence of <br>Nature's Purest</h1>
                <p>Experience the finest hand-picked organic tea and artisan coffee blends.</p>
                <a href="products" class="btn btn-gold">Explore Collection</a>
            </div>
        </div>
        <!-- Slide 2 -->
        <div class="hero-slide" style="background-image: url('assets/1.PNG');">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <span class="hero-subtitle">Artisan Roasted Coffee</span>
                <h1>Awaken Your <br>Senses Today</h1>
                <p>Rich, aromatic, and bold coffee blends for the perfect morning ritual.</p>
                <a href="products" class="btn btn-gold">Shop Coffee</a>
            </div>
        </div>
        <!-- Slide 3 -->
        <div class="hero-slide" style="background-image: url('assets/3.JPG');">
            <div class="hero-overlay"></div>
            <div class="hero-content">
                <span class="hero-subtitle">Wellness & Harmony</span>
                <h1>Discover the Art <br>of Fine Living</h1>
                <p>Curated gift sets and herbal blends to soothe your soul.</p>
                <a href="products" class="btn btn-gold">View Gifts</a>
            </div>
        </div>
    </div>
</section>

<!-- Collections Highlight -->
<section class="collections-section">
    <div class="section-header text-center">
        <img src="assets/img/leaf-icon.svg" alt="" class="leaf-icon" style="width: 30px; margin-bottom: 10px;">
        <!-- Placeholder icon -->
        <h2 class="serif">Our Collections</h2>
        <p class="section-desc">Handpicked from the lush hills of Sri Lanka</p>
    </div>

    <div class="collections-grid container">
        <!-- Card 1 -->
        <div class="collection-card">
            <div class="collection-img">
                <img src="assets/4.png" alt="Tea Collection">
                <div class="card-overlay">
                    <a href="products" class="btn-arrow">➔</a>
                </div>
            </div>
            <div class="collection-info">
                <h3>Premium Tea</h3>
                <p>Pure Ceylon Black, Green & Herbal Teas</p>
                <a href="products" class="link-gold">Shop Now</a>
            </div>
        </div>

        <!-- Card 2 -->
        <div class="collection-card">
            <div class="collection-img">
                <img src="assets/6.png" alt="Coffee Collection">
                <div class="card-overlay">
                    <a href="products" class="btn-arrow">➔</a>
                </div>
            </div>
            <div class="collection-info">
                <h3>Artisan Coffee</h3>
                <p>Rich Arabica & Robusta Blends</p>
                <a href="products" class="link-gold">Shop Now</a>
            </div>
        </div>

        <!-- Card 3 -->
        <div class="collection-card">
            <div class="collection-img">
                <img src="assets/5.png" alt="Spices & Gifts">
                <div class="card-overlay">
                    <a href="products" class="btn-arrow">➔</a>
                </div>
            </div>
            <div class="collection-info">
                <h3>Gifts & Spices</h3>
                <p>Curated Sets & Authentic Spices</p>
                <a href="products" class="link-gold">Shop Now</a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container stats-grid">
        <div class="stat-item">
            <h2 class="serif counter" data-target="70" data-suffix="+">0</h2>
            <p>Premium Varieties</p>
        </div>
        <div class="stat-item">
            <h2 class="serif counter" data-target="100" data-suffix="%">0</h2>
            <p>Organic Certified</p>
        </div>
        <div class="stat-item">
            <h2 class="serif counter" data-target="14" data-suffix="M+">0</h2>
            <p>Cups Served</p>
        </div>
        <div class="stat-item">
            <h2 class="serif counter" data-target="50" data-suffix="+">0</h2>
            <p>Global Awards</p>
        </div>
    </div>
</section>

<!-- Certifications -->
<section class="certifications-section">
    <div class="container">
        <p class="text-center mb-4 uppercase-track">We take pride in our quality certifications</p>
        <div class="cert-grid">
            <img src="assets/SLS 143.png" alt="SLS Certified" class="cert-img">
            <img src="assets/Outlook-ntivxsha.png" alt="Quality Certified" class="cert-img">
            <!-- Keeping placeholders for others if needed, or removing them to focus on real ones. 
                 Since user only provided 2, I will display these 2 prominently. -->
        </div>
    </div>
</section>

<!-- Features / Why Choose Us -->
<section class="features-section bg-cream">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <div class="icon-box">🌿</div>
                <h3>100% Natural</h3>
                <p>Sourced directly from certified organic plantations without artificial additives.</p>
            </div>
            <div class="feature-item">
                <div class="icon-box">✨</div>
                <h3>Premium Quality</h3>
                <p>Hand-picked leaves and beans ensuring the finest aroma and taste.</p>
            </div>
            <div class="feature-item">
                <div class="icon-box">🌍</div>
                <h3>Eco-Friendly</h3>
                <p>Sustainable farming and biodegradable packaging for a better planet.</p>
            </div>
        </div>
    </div>
</section>

<!-- Team / Story Section -->
<section class="story-section">
    <div class="container">
        <div class="story-content text-center">
            <h2 class="serif">The Heart Behind the Brew</h2>
            <p class="story-text">
                Ziggy Natural was born from a passion for the pristine hills of Ceylon.
                Our team represents generations of tea and coffee artisans dedicated to bringing
                you the authentic taste of nature.
            </p>
            <div class="team-img-wrapper">
                <img src="assets/7.png" alt="Our Team" class="team-img">
            </div>
            <a href="about" class="btn btn-dark mt-4">Read Our Story</a>
        </div>
    </div>
</section>

<!-- Bottom CTA -->
<section class="cta-section" style="background-image: url('assets/customers/bbb.jpg');">
    <div class="cta-overlay"></div>
    <div class="container relative z-10 text-center text-white">
        <h2 class="serif mb-2">Elevate Your Daily Ritual</h2>
        <p class="mb-4">Join our community of tea and coffee lovers today.</p>
        <a href="products" class="btn btn-gold">Shop Collection</a>
    </div>
</section>

<script src="assets/js/slider.js"></script>
<script src="assets/js/count-up.js"></script>
<?php include 'includes/footer.php'; ?>