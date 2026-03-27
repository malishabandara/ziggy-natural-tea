<?php
require_once 'config.php';

// Fetch hero slides
$stmt = $pdo->query("SELECT * FROM hero_slides ORDER BY order_index ASC");
$heroSlides = $stmt->fetchAll();

// Fetch collection cards
try {
    $cardsStmt = $pdo->query("SELECT * FROM collection_cards ORDER BY sort_order ASC");
    $collectionCards = $cardsStmt->fetchAll();
} catch (Exception $e) {
    $collectionCards = [];
}

?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section with Slider -->
<section class="hero-slider-section">
    <div class="hero-slider">
        <?php if (!empty($heroSlides)): ?>
            <?php foreach ($heroSlides as $index => $slide): ?>
                <div class="hero-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                    <div class="hero-bg" style="background-image: url('<?php echo htmlspecialchars($slide['image_path']); ?>');"></div>
                    <div class="hero-overlay"></div>
                    <div class="hero-content">
                        <?php if ($slide['subtitle']): ?>
                            <span class="hero-subtitle"><?php echo htmlspecialchars($slide['subtitle']); ?></span>
                        <?php endif; ?>
                        <h1><?php echo $slide['title']; ?></h1>
                        <?php if ($slide['description']): ?>
                            <p><?php echo htmlspecialchars($slide['description']); ?></p>
                        <?php endif; ?>
                        <?php if ($slide['button_text']): ?>
                            <a href="<?php echo htmlspecialchars($slide['button_link']); ?>" class="btn btn-gold"><?php echo htmlspecialchars($slide['button_text']); ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Slide 1 -->
            <div class="hero-slide active">
                <div class="hero-bg" style="background-image: url('assets/customers/1.JPG');"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <span class="hero-subtitle">Premium Ceylon Collection</span>
                    <h1>Sip the Essence of <br>Nature's Purest</h1>
                    <p>Experience the finest hand-picked organic tea and artisan coffee blends.</p>
                    <a href="products" class="btn btn-gold">Explore Collection</a>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="hero-slide">
                <div class="hero-bg" style="background-image: url('assets/1.PNG');"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <span class="hero-subtitle">Artisan Roasted Coffee</span>
                    <h1>Awaken Your <br>Senses Today</h1>
                    <p>Rich, aromatic, and bold coffee blends for the perfect morning ritual.</p>
                    <a href="products" class="btn btn-gold">Shop Coffee</a>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="hero-slide">
                <div class="hero-bg" style="background-image: url('assets/3.JPG');"></div>
                <div class="hero-overlay"></div>
                <div class="hero-content">
                    <span class="hero-subtitle">Wellness & Harmony</span>
                    <h1>Discover the Art <br>of Fine Living</h1>
                    <p>Curated gift sets and herbal blends to soothe your soul.</p>
                    <a href="products" class="btn btn-gold">View Gifts</a>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Collections Highlight -->
<section class="collections-section">
    <div class="section-header text-center reveal">
        <!-- Placeholder icon removed -->
        <h2 class="serif">Our Collections</h2>
        <p class="section-desc">Handpicked from the lush hills of Sri Lanka</p>
    </div>

    <div class="collections-grid container reveal">
        <?php if (!empty($collectionCards)): ?>
            <?php foreach ($collectionCards as $card): ?>
                <a href="<?php echo htmlspecialchars($card['link']); ?>" class="collection-card">
                    <div class="collection-img">
                        <img src="<?php echo htmlspecialchars($card['image_path']); ?>" alt="<?php echo htmlspecialchars($card['title']); ?>">
                        <div class="card-overlay">
                            <span class="btn-arrow">➔</span>
                        </div>
                    </div>
                    <div class="collection-info">
                        <h3><?php echo htmlspecialchars($card['title']); ?></h3>
                        <p><?php echo htmlspecialchars($card['subtitle']); ?></p>
                        <span class="link-gold">Shop Now</span>
                    </div>
                </a>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Fallback Static Cards if DB is empty -->
            <!-- Fallback Static Cards if DB is empty -->
            <a href="products" class="collection-card">
                <div class="collection-img">
                    <img src="assets/4.png" alt="Tea Collection">
                    <div class="card-overlay">
                        <span class="btn-arrow">➔</span>
                    </div>
                </div>
                <div class="collection-info">
                    <h3>Premium Tea</h3>
                    <p>Pure Ceylon Black, Green & Herbal Teas</p>
                    <span class="link-gold">Shop Now</span>
                </div>
            </a>

            <a href="products" class="collection-card">
                <div class="collection-img">
                    <img src="assets/6.png" alt="Coffee Collection">
                    <div class="card-overlay">
                        <span class="btn-arrow">➔</span>
                    </div>
                </div>
                <div class="collection-info">
                    <h3>Artisan Coffee</h3>
                    <p>Rich Arabica & Robusta Blends</p>
                    <span class="link-gold">Shop Now</span>
                </div>
            </a>

            <a href="products" class="collection-card">
                <div class="collection-img">
                    <img src="assets/5.png" alt="Spices & Gifts">
                    <div class="card-overlay">
                        <span class="btn-arrow">➔</span>
                    </div>
                </div>
                <div class="collection-info">
                    <h3>Gifts & Spices</h3>
                    <p>Curated Sets & Authentic Spices</p>
                    <span class="link-gold">Shop Now</span>
                </div>
            </a>
        <?php endif; ?>
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section">
    <div class="container stats-grid reveal">
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
<section class="certifications-section reveal">
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

<!-- Premium Features Section -->
<section class="premium-features-narrative">
    <div class="container">
        <!-- Feature Block 1 (Image Right) -->
        <div class="feature-narrative-block reverse reveal-right">
            <div class="feature-narrative-image">
                <img src="assets/uploads/01.png" alt="100% Natural" class="main-feature-img">
                <img src="assets/11.png" alt="Pure Decor" class="corner-decor decor-tr">
                <img src="assets/12.png" alt="Pure Decor" class="corner-decor decor-bl">
            </div>
            <div class="feature-narrative-content">
                <span class="feature-tag">PURE SOURCE</span>
                <h3 class="serif">100% Natural</h3>
                <p>
                    Experience nature in its purest form. Our tea leaves and coffee beans are sourced directly from 
                    certified organic plantations, ensuring no artificial additives.
                </p>
                <div class="extra-text">
                    <p>
                        Every sip is a tribute to the earth's natural bounty, preserved with the utmost care from soil to cup.
                    </p>
                </div>
                <button class="read-more-btn" onclick="toggleText(this)">Read More</button>
            </div>
        </div>

        <!-- Feature Block 2 (Image Left) -->
        <div class="feature-narrative-block reveal-left">
            <div class="feature-narrative-image">
                <img src="assets/uploads/02.png" alt="Premium Quality" class="main-feature-img">
                <img src="assets/11.png" alt="Quality Decor" class="corner-decor decor-tr">
                <img src="assets/12.png" alt="Quality Decor" class="corner-decor decor-bl">
            </div>
            <div class="feature-narrative-content">
                <span class="feature-tag">EXCELLENCE</span>
                <h3 class="serif">Premium Quality</h3>
                <p>
                    Quality is not just a standard; it's our promise. We hand-pick only the finest, most tender leaves 
                    and premium beans.
                </p>
                <div class="extra-text">
                    <p>
                        Our artisans use time-honored techniques combined with modern precision to craft the perfect blend for your ritual.
                    </p>
                </div>
                <button class="read-more-btn" onclick="toggleText(this)">Read More</button>
            </div>
        </div>

        <!-- Feature Block 3 (Image Right) -->
        <div class="feature-narrative-block reverse reveal-right">
            <div class="feature-narrative-image">
                <img src="assets/uploads/03.png" alt="Eco-Friendly" class="main-feature-img">
                <img src="assets/11.png" alt="Eco Decor" class="corner-decor decor-tr">
                <img src="assets/12.png" alt="Eco Decor" class="corner-decor decor-bl">
            </div>
            <div class="feature-narrative-content">
                <span class="feature-tag">SUSTAINABILITY</span>
                <h3 class="serif">Eco-Friendly</h3>
                <p>
                    Our commitment to nature goes beyond organic farming. We utilize sustainable practices and 
                    biodegradable packaging.
                </p>
                <div class="extra-text">
                    <p>
                        By choosing Ziggy Natural, you're not just choosing a premium brew; you're supporting a greener, 
                        more sustainable future for generations to come.
                    </p>
                </div>
                <button class="read-more-btn" onclick="toggleText(this)">Read More</button>
            </div>
        </div>
    </div>
</section>

<script>
function toggleText(btn) {
    const parent = btn.parentElement;
    const extraText = parent.querySelector('.extra-text');
    if (extraText.style.display === 'block') {
        extraText.style.display = 'none';
        btn.textContent = 'Read More';
    } else {
        extraText.style.display = 'block';
        btn.textContent = 'Read Less';
    }
}
</script>

<!-- Team / Story Section -->
<section class="story-section reveal">
    <div class="container">
        <div class="story-content text-center">
            <h2 class="serif">The Heart Behind the Brew</h2>
            <p class="story-text">
                Ziggy Natural was born from a passion for the pristine hills of Ceylon.
                Our team represents generations of tea and coffee artisans dedicated to bringing
                you the authentic taste of nature.
            </p>
            <div class="team-img-wrapper">
                <img src="assets/7.jpeg" alt="Our Team" class="team-img">
            </div>
            <a href="about" class="btn btn-dark mt-4">Read Our Story</a>
        </div>
    </div>
</section>

<!-- Bottom CTA -->
<section class="cta-section reveal" style="background-image: url('assets/customers/bbb.jpg');">
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