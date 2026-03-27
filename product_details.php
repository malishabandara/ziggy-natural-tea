<?php
require_once 'config.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details
$stmt = $pdo->prepare("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header("Location: products");
    exit;
}

// Fetch variations
$vStmt = $pdo->prepare("SELECT * FROM product_variations WHERE product_id = ? ORDER BY price ASC");
$vStmt->execute([$id]);
$variations = $vStmt->fetchAll(PDO::FETCH_ASSOC);

// Prepare images
$images = [];
if (!empty($product['image'])) $images[] = $product['image'];
if (!empty($product['image2'])) $images[] = $product['image2'];
if (!empty($product['image3'])) $images[] = $product['image3'];

// Fallback image
if (empty($images)) {
    $images[] = 'https://placehold.co/600x600/EEE/31343C?text=Ziggy+Product';
}

$pageTitle = $product['name'];
include 'includes/header.php';
?>

<!-- Minimal Header Offset -->
<div style="margin-top: 100px;"></div>

<!-- Breadcrumb -->
<div class="container mb-4">
    <div class="breadcrumb" style="color: #666; font-size: 0.9rem;">
        <a href="index" style="color: #888; text-decoration: none;">Home</a> / 
        <a href="products" style="color: #888; text-decoration: none;">Shop</a> / 
        <span style="color: var(--primary-color); font-weight: 600;"><?php echo htmlspecialchars($product['name']); ?></span>
    </div>
</div>




<!-- Inquiry Form Section (Premium Design) -->
<section id="inquiry-form-section" class="inquiry-section">
    <div class="container">
        <div class="inquiry-header text-center mb-5">
            <h2 class="inquiry-main-title">INQUIRY FORM</h2>
            <p class="inquiry-subtitle">Hi, We thank you for having visited our website, pls tick below, to help us understand how we could be of service to you.</p>
        </div>

        <div class="inquiry-grid">
            <!-- Left side: Product Image & Info -->
            <div class="inquiry-left">
                <div class="inquiry-product-image mb-4">
                    <div class="pdp-slider-container">
                        <?php foreach($images as $index => $imgUrl): ?>
                        <div class="pdp-slide <?php echo $index === 0 ? 'active' : ''; ?>">
                            <img src="<?php echo htmlspecialchars($imgUrl); ?>" alt="Product View" class="floating-img">
                        </div>
                        <?php endforeach; ?>
                        
                        <?php if(count($images) > 1): ?>
                        <button class="pdp-nav prev" onclick="changePDPSlide(-1)">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <button class="pdp-nav next" onclick="changePDPSlide(1)">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                        <div class="pdp-dots">
                            <?php foreach($images as $index => $imgUrl): ?>
                            <span class="dot <?php echo $index === 0 ? 'active' : ''; ?>" onclick="currentPDPSlide(<?php echo $index; ?>)"></span>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="brand-info">
                    <h1 class="product-page-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                    <div class="product-description-wrapper" id="descWrapper">
                        <div class="product-page-desc" id="pdpDesc"><?php echo nl2br(htmlspecialchars($product['description'])); ?></div>
                        <div class="desc-fade" id="descFade"></div>
                    </div>
                    <button type="button" id="readMoreBtn" class="read-more-btn" onclick="toggleDescription()">Read More</button>
                    
                    <div class="brand-mission-box">
                        <p class="brand-mission">Ziggy Natural promotes a lifestyle of wellbeing & sustainability while also uplifting lives of rural farming communities.</p>
                    </div>
                </div>
            </div>

            <!-- Right side: Form -->
            <div class="inquiry-right">
                <form id="inquiryForm" onsubmit="submitInquiry(event)" class="premium-form">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    
                    <div class="form-step">
                        <label class="step-label">1. I'm a</label>
                        <div class="radio-group">
                            <label class="radio-container">
                                <input type="radio" name="user_type" value="Individual Buyer" checked>
                                <span class="radio-checkmark"></span>
                                Individual Buyer
                            </label>
                            <label class="radio-container">
                                <input type="radio" name="user_type" value="Wholesaler">
                                <span class="radio-checkmark"></span>
                                Wholesaler
                            </label>
                            <label class="radio-container">
                                <input type="radio" name="user_type" value="Retailer">
                                <span class="radio-checkmark"></span>
                                Retailer
                            </label>
                        </div>
                    </div>

                    <div class="form-step">
                        <label class="step-label">2. I am from</label>
                        <div class="radio-group">
                            <label class="radio-container">
                                <input type="radio" name="location" value="Sri Lanka" checked onclick="toggleCountry(false)">
                                <span class="radio-checkmark"></span>
                                Sri Lanka
                            </label>
                            <label class="radio-container">
                                <input type="radio" name="location" value="Overseas" onclick="toggleCountry(true)">
                                <span class="radio-checkmark"></span>
                                Overseas
                            </label>
                        </div>
                    </div>

                    <div class="form-step" id="countryGroup" style="display: none;">
                        <label class="step-label">3. If overseas please state which country</label>
                        <input type="text" name="country" placeholder="Enter country name" class="premium-input">
                    </div>

                    <div class="form-step">
                        <label class="step-label">4. Your Contact Number*</label>
                        <span class="hint">With Country Code Eg: +94</span>
                        <input type="tel" name="phone" required placeholder="Enter contact number" class="premium-input">
                    </div>

                    <div class="form-step">
                        <label class="step-label">First name & Last Name</label>
                        <input type="text" name="name" required placeholder="Enter your full name" class="premium-input">
                    </div>

                    <div class="form-step">
                        <label class="step-label">Email address</label>
                        <input type="email" name="email" required placeholder="Enter your email" class="premium-input">
                    </div>

                    <div class="form-step">
                        <label class="step-label">6. Please Indicate any other questions or your comments in the box below</label>
                        <textarea name="comments" placeholder="Type your message here..." class="premium-textarea"></textarea>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="btn-send-inquiry" id="submitInquiryBtn">
                            Send my question
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="inquiry-footer-nav mt-5">
            <div class="footer-nav-left">
                <a href="products" class="btn-back-shop">
                    <span class="btn-tag"><i class="fas fa-shopping-bag"></i> SHOP</span>
                    BACK TO SHOP
                </a>
            </div>
            <div class="footer-nav-center">
                <div class="quality-badge-wrapper">
                    <i class="fas fa-certificate quality-icon"></i>
                    <div class="quality-content">
                        <span class="quality-label">PURITY & EXCELLENCE</span>
                        <p class="quality-text">QUALITY, NEVER SECOND BEST...!</p>
                    </div>
                </div>
            </div>
            <div class="footer-nav-right">
                <h3 class="thank-you-text">THANK YOU</h3>
            </div>
        </div>
    </div>
</section>

<!-- Related Products -->
<?php
    $relatedStmt = $pdo->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 4");
    $relatedProducts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
    if($relatedProducts):
?>
<section class="related-products-section bg-cream">
    <div class="container">
        <h3 class="serif text-center mb-4">You May Also Like</h3>
        <div class="grid">
             <?php foreach ($relatedProducts as $rp): ?>
                <a href="product_details?id=<?php echo $rp['id']; ?>" class="product-card-link-wrapper">
                    <div class="related-product-card">
                        <div class="related-img-wrapper">
                             <img src="<?php echo htmlspecialchars(!empty($rp['image']) ? $rp['image'] : 'https://placehold.co/600x400'); ?>" 
                                  alt="<?php echo htmlspecialchars($rp['name']); ?>">
                        </div>
                        <div class="related-details">
                            <h4 class="related-name"><?php echo htmlspecialchars($rp['name']); ?></h4>
                        </div>
                    </div>
                </a>
             <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>


<script>
    function toggleCountry(show) {
        const group = document.getElementById('countryGroup');
        if (group) {
            group.style.display = show ? 'block' : 'none';
        }
    }

    function submitInquiry(event) {
        event.preventDefault();
        
        const btn = document.getElementById('submitInquiryBtn');
        if (!btn) return;
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Sending...';

        const formData = new FormData(event.target);

        fetch('process_inquiry.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                event.target.reset();
                toggleCountry(false);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerText = originalText;
        });
    }

    function toggleDescription() {
        const wrapper = document.getElementById('descWrapper');
        const btn = document.getElementById('readMoreBtn');
        const fade = document.getElementById('descFade');
        
        if (wrapper.classList.contains('expanded')) {
            wrapper.classList.remove('expanded');
            btn.innerText = 'Read More';
            fade.style.display = 'block';
            // Scroll back slightly if it jumped far
            wrapper.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        } else {
            wrapper.classList.add('expanded');
            btn.innerText = 'Read Less';
            fade.style.display = 'none';
        }
    }

    // Initialize description height check
    document.addEventListener('DOMContentLoaded', () => {
        const desc = document.getElementById('pdpDesc');
        const btn = document.getElementById('readMoreBtn');
        const fade = document.getElementById('descFade');
        
        if (desc.scrollHeight <= 300) {
            btn.style.display = 'none';
            fade.style.display = 'none';
            document.getElementById('descWrapper').style.maxHeight = 'none';
        }
    });

    let pdpSlideIndex = 0;
    function changePDPSlide(n) {
        showPDPSlides(pdpSlideIndex += n);
    }
    function currentPDPSlide(n) {
        showPDPSlides(pdpSlideIndex = n);
    }
    function showPDPSlides(n) {
        let slides = document.querySelectorAll(".pdp-slide");
        let dots = document.querySelectorAll(".pdp-dots .dot");
        if (n >= slides.length) pdpSlideIndex = 0;
        if (n < 0) pdpSlideIndex = slides.length - 1;
        slides.forEach(s => s.classList.remove("active"));
        dots.forEach(d => d.classList.remove("active"));
        slides[pdpSlideIndex].classList.add("active");
        if (dots.length > 0) dots[pdpSlideIndex].classList.add("active");
    }

</script>

<style>
/* Inquiry Section Styles */
.inquiry-section {
    padding: 80px 0;
    background-color: #fff;
    font-family: 'Lato', sans-serif;
}

.inquiry-main-title {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 10px;
    letter-spacing: -1px;
}

.inquiry-subtitle {
    color: #666;
    font-size: 1.1rem;
    max-width: 800px;
    margin: 0 auto;
}

.inquiry-grid {
    display: grid;
    grid-template-columns: 1fr 1.2fr;
    gap: 60px;
    margin-top: 50px;
    align-items: start;
}

.brand-info .product-page-title {
    font-size: 2rem;
    font-family: 'Playfair Display', serif;
    color: var(--primary-color);
    margin-bottom: 15px;
    line-height: 1.2;
    font-weight: 700;
}

.product-description-wrapper {
    position: relative;
    max-height: 300px;
    overflow: hidden;
    transition: max-height 0.6s cubic-bezier(0.4, 0, 0.2, 1);
}

.product-description-wrapper.expanded {
    max-height: 5000px;
}

.desc-fade {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    height: 80px;
    background: linear-gradient(transparent, #fff);
    pointer-events: none;
    z-index: 2;
}

.product-page-desc {
    font-size: 0.95rem;
    line-height: 1.7;
    color: #555;
    padding-bottom: 10px;
}

.read-more-btn {
    background: none;
    border: none;
    color: var(--secondary-color);
    font-weight: 700;
    font-size: 0.9rem;
    cursor: pointer;
    padding: 10px 0;
    margin-bottom: 20px;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: color 0.3s;
}

.read-more-btn:hover {
    color: var(--primary-color);
}

.brand-mission-box {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px dashed #eee;
}

.brand-mission {
    font-size: 0.85rem;
    color: #999;
    font-style: italic;
    line-height: 1.5;
}

.inquiry-product-image {
    background: #f9f9f9;
    padding: 0; /* Changed for slider */
    border-radius: 20px;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 500px;
    overflow: hidden;
    position: relative;
    border: 1px solid #f0f0f0;
}

.pdp-slider-container {
    width: 100%;
    height: 100%;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
}

.pdp-slide {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    transition: opacity 1s cubic-bezier(0.165, 0.84, 0.44, 1);
    display: flex;
    align-items: center;
    justify-content: center;
    background: #fff;
    padding: 40px;
}

.pdp-slide.active {
    opacity: 1;
    z-index: 1;
}

.floating-img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: drop-shadow(0 20px 40px rgba(0,0,0,0.1));
}

.pdp-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255, 255, 255, 0.8);
    border: 1px solid #eee;
    width: 45px;
    height: 45px;
    border-radius: 50%;
    cursor: pointer;
    z-index: 10;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    transition: all 0.3s;
    box-shadow: 0 4px 10px rgba(0,0,0,0.05);
}

.pdp-nav:hover {
    background: white;
    box-shadow: 0 8px 20px rgba(0,0,0,0.1);
}

.pdp-nav.prev { left: 15px; }
.pdp-nav.next { right: 15px; }

.pdp-dots {
    position: absolute;
    bottom: 20px;
    display: flex;
    gap: 8px;
    z-index: 10;
}

.dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background: #ddd;
    cursor: pointer;
    transition: all 0.3s;
}

.dot.active {
    background: var(--secondary-color);
    width: 25px;
    border-radius: 10px;
}

/* Premium Form Styles */
.form-step {
    margin-bottom: 30px;
}

.step-label {
    display: block;
    font-size: 1.1rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #333;
}

.hint {
    display: block;
    font-size: 0.85rem;
    color: #888;
    margin-top: -10px;
    margin-bottom: 10px;
}

.radio-group {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
}

.radio-container {
    display: flex;
    align-items: center;
    position: relative;
    padding-left: 35px;
    cursor: pointer;
    font-size: 1rem;
    user-select: none;
    color: #555;
    transition: color 0.3s;
}

.radio-container:hover {
    color: #000;
}

.radio-container input {
    position: absolute;
    opacity: 0;
    cursor: pointer;
}

.radio-checkmark {
    position: absolute;
    top: 50%;
    left: 0;
    transform: translateY(-50%);
    height: 22px;
    width: 22px;
    background-color: #fff;
    border: 2px solid #ddd;
    border-radius: 50%;
    transition: all 0.3s;
}

.radio-container:hover input ~ .radio-checkmark {
    border-color: #bbb;
}

.radio-container input:checked ~ .radio-checkmark {
    background-color: #fff;
    border-color: #000;
}

.radio-checkmark:after {
    content: "";
    position: absolute;
    display: none;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #000;
}

.radio-container input:checked ~ .radio-checkmark:after {
    display: block;
}

.premium-input, .premium-textarea {
    width: 100%;
    padding: 15px 20px;
    border: 1px solid #ddd;
    border-radius: 8px;
    font-size: 1rem;
    transition: all 0.3s;
    background: #fafafa;
}

.premium-input:focus, .premium-textarea:focus {
    outline: none;
    border-color: #000;
    background: #fff;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.premium-textarea {
    height: 120px;
    resize: none;
}

.btn-send-inquiry {
    background: #000;
    color: #fff;
    padding: 18px 40px;
    border: none;
    border-radius: 8px;
    font-weight: 700;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s;
    width: fit-content;
}

.btn-send-inquiry:hover {
    background: #333;
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

/* Footer Nav */
.inquiry-footer-nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid #eee;
    padding-top: 40px;
    margin-top: 60px;
}

.btn-back-shop {
    display: flex;
    flex-direction: column;
    text-decoration: none;
    color: #27ae60;
    font-weight: 900;
    font-size: 1.5rem;
    line-height: 1;
}

.btn-tag {
    background: var(--secondary-color); /* Thematic Tea Green */
    color: #fff;
    padding: 8px 20px;
    border-radius: 6px; /* Modern square-rounded shape */
    font-size: 0.75rem;
    font-weight: 700;
    width: fit-content;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px rgba(140, 158, 94, 0.2);
    display: flex;
    align-items: center;
    gap: 8px;
    letter-spacing: 1px;
}

.btn-tag i {
    font-size: 0.8rem;
    color: #fff;
}

.quality-badge-wrapper {
    display: flex;
    align-items: center;
    gap: 15px;
    padding: 12px 25px;
    border: 1px solid #f1f1f1;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
    transition: var(--transition);
}

.quality-badge-wrapper:hover {
    box-shadow: 0 8px 25px rgba(140, 158, 94, 0.1);
    transform: translateY(-2px);
    border-color: #eee;
}

.quality-icon {
    font-size: 1.8rem;
    color: var(--accent-color);
}

.quality-content {
    display: flex;
    flex-direction: column;
    text-align: left;
}

.quality-label {
    font-size: 0.65rem;
    font-weight: 700;
    letter-spacing: 2px;
    color: var(--secondary-color);
    text-transform: uppercase;
    line-height: 1;
    margin-bottom: 4px;
}

.quality-text {
    font-weight: 900;
    font-size: 1rem;
    color: var(--primary-color);
    margin: 0;
    letter-spacing: 0.5px;
}

.thank-you-text {
    color: #8C9E5E;
    font-weight: 900;
    font-size: 2.2rem;
    margin: 0;
}

@media (max-width: 991px) {
    .inquiry-grid {
        grid-template-columns: 1fr;
        gap: 40px;
    }
    .inquiry-footer-nav {
        flex-direction: column;
        text-align: center;
        gap: 30px;
    }
    .footer-nav-left {
        display: flex;
        justify-content: center;
    }
    .btn-back-shop {
        align-items: center;
    }
}
/* Related Products Redesign */
.related-products-section {
    background-color: #fbfbfb;
    padding: 80px 0;
}

.related-products-section .grid {
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
}

.product-card-link-wrapper {
    text-decoration: none;
    color: inherit;
}

.related-product-card {
    background: #fff;
    border-radius: 12px;
    padding: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    box-shadow: 0 4px 15px rgba(0,0,0,0.02);
}

.related-product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.06);
    border-color: #eee;
}

.related-img-wrapper {
    height: 180px;
    margin-bottom: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f9f9f9;
    border-radius: 8px;
    overflow: hidden;
}

.related-img-wrapper img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    transition: transform 0.5s ease;
}

.related-product-card:hover .related-img-wrapper img {
    transform: scale(1.05);
}

.related-name {
    font-family: 'Playfair Display', serif;
    font-size: 1.05rem;
    color: #333;
    font-weight: 700;
}

@media (max-width: 991px) {
    .related-products-section .grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 575px) {
    .related-products-section .grid {
        grid-template-columns: 1fr;
    }
}
</style>
