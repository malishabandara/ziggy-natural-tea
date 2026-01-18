<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="page-hero" style="background-image: url('assets/3.JPG');">
        <div class="page-hero-content">
            <h1 class="page-title">Our Story</h1>
            <div class="breadcrumb">Home / <span>About Us</span></div>
        </div>
    </section>

    <!-- Story Introduction -->
    <section class="about-intro">
        <div class="container">
            <div class="about-intro-content">
                <p class="intro-subtitle">WHEN A PASSION BECOMES</p>
                <h2 class="intro-title serif">DISCOVER THE STORY</h2>
                <p class="intro-text">
                    LOREM IPSUM DOLOR SIT AMET, CONSECTETUR ADIPISCING ELIT, SED DO EIUSMOD TEMPOR INCIDIDUNT UT LABORE ET DOLORE MAGNA ALIQUA. UT ENIM AD MINIM VENIAM, QUIS NOSTRUD EXERCITATION ULLAMCO LABORIS.
                </p>
                <a href="#story" class="link-gold">READ OUR STORY →</a>
            </div>
        </div>
    </section>

    <!-- Story Content with Images -->
    <section class="about-story" id="story">
        <div class="container">
            <!-- Story Block 1 -->
            <div class="story-block">
                <div class="story-image">
                    <img src="assets/customers/2.JPG" alt="Our Beginning">
                </div>
                <div class="story-content">
                    <h3>Our Beginning</h3>
                    <p>
                        Welcome to Ziggy Natural, where passion meets purity. Born from a love for the finest tea leaves and coffee beans, 
                        our journey began in the lush hills where nature's best secrets are kept.
                    </p>
                    <p>
                        We believe that a great cup of tea or coffee is more than just a beverage; it's a moment of tranquility in a chaotic world.
                    </p>
                </div>
            </div>

            <!-- Story Block 2 (Reversed) -->
            <div class="story-block reverse">
                <div class="story-image">
                    <img src="assets/customers/3.JPG" alt="Our Process">
                </div>
                <div class="story-content">
                    <h3>Our Commitment</h3>
                    <p>
                        That's why we source only organic, ethically grown ingredients that are good for you and good for the planet. 
                        Our dedicated team travels the globe to bring you unique blends that tantalize your taste buds.
                    </p>
                    <p>
                        From the misty peaks to your cup, we ensure quality in every sip. Every product is carefully selected and tested 
                        to meet our high standards of excellence.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- World Map Section -->
    <section class="about-map">
        <div class="container text-center">
            <p class="map-subtitle">CAN'T HIDE WHERE</p>
            <h2 class="map-title serif">WE ARE FROM</h2>
            <div class="map-container">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/83/Equirectangular_projection_SW.jpg" alt="World Map" class="world-map">
                <div class="map-marker" style="top: 60%; left: 58%;">
                    <div class="marker-dot"></div>
                    <div class="marker-label">Sri Lanka</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Products Showcase -->
    <section class="about-products">
        <div class="container">
            <h2 class="text-center serif" style="margin-bottom: 3rem;">OUR COLLECTIONS</h2>
            <div class="products-showcase">
                <div class="product-showcase-card">
                    <div class="product-showcase-image">
                        <img src="assets/3.JPG" alt="Premium Tea">
                    </div>
                    <div class="product-showcase-content">
                        <h3>PREMIUM TEA</h3>
                        <p>Hand-picked Ceylon tea from the finest plantations, offering rich flavors and aromatic blends.</p>
                        <a href="products.php" class="btn-dark">EXPLORE →</a>
                    </div>
                </div>
                <div class="product-showcase-card">
                    <div class="product-showcase-image">
                        <img src="assets/6.png" alt="Artisan Coffee">
                    </div>
                    <div class="product-showcase-content">
                        <h3>ARTISAN COFFEE</h3>
                        <p>Carefully roasted coffee beans delivering bold and smooth flavors in every cup.</p>
                        <a href="products.php" class="btn-dark">EXPLORE →</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact CTA -->
    <section class="about-contact-cta">
        <div class="container">
            <div class="contact-cta-content">
                <img src="assets/customers/4.JPG" alt="Contact Us" class="cta-image">
                <div class="cta-text">
                    <h2 class="serif">CONTACT US TODAY</h2>
                    <p>Have questions about our products? We'd love to hear from you.</p>
                    <a href="contact.php" class="btn btn-gold">GET IN TOUCH</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section -->
    <section class="about-values">
        <div class="container">
            <div class="values-grid">
                <div class="value-item">
                    <h4>QUALITY</h4>
                    <p>We never compromise on the quality of our products. Every batch is tested and approved.</p>
                </div>
                <div class="value-item">
                    <h4>SUSTAINABILITY</h4>
                    <p>Our commitment to the environment drives every decision we make in our sourcing process.</p>
                </div>
                <div class="value-item">
                    <h4>TRADITION</h4>
                    <p>We honor traditional methods while embracing innovation to bring you the best products.</p>
                </div>
                <div class="value-item">
                    <h4>COMMUNITY</h4>
                    <p>We support local farmers and communities, ensuring fair trade and ethical practices.</p>
                </div>
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
