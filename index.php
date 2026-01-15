<?php
require_once 'config.php';
// Only showing 3 featured products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC LIMIT 3");
$products = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

    <section class="hero">
        <div class="hero-content">
            <h1>Sip the Essence of Nature</h1>
            <p>Hand-picked organic tea and artisan coffee blends for your daily ritual.</p>
            <a href="products.php" class="btn">Explore Collection</a>
        </div>
    </section>

    <section class="products-section">
        <h2 class="section-title">New Arrivals</h2>
        
        <div class="grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <div class="product-img-wrapper">
                            <?php 
                                $imgSrc = !empty($product['image']) ? $product['image'] : 'https://placehold.co/600x400/EEE/31343C?text=Ziggy+Product'; 
                            ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img">
                        </div>
                        <div class="product-details">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-desc"><?php echo htmlspecialchars(substr($product['description'], 0, 80)) . '...'; ?></p>
                            <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1;">No products available yet. Check back soon!</p>
            <?php endif; ?>
        </div>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="products.php" class="btn">View All Products</a>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
