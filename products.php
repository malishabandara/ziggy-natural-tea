<?php
require_once 'config.php';
// Show all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

    <div style="height: 100px;"></div> <!-- Spacer for fixed header -->

    <section class="products-section">
        <h2 class="section-title">Our Complete Collection</h2>
        
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
                            <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="product-price">$<?php echo number_format($product['price'], 2); ?></div>
                            <button class="btn" style="margin-top: 1rem; width: 100%; font-size: 0.9rem;">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1;">No products available yet. Check back soon!</p>
            <?php endif; ?>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
