<?php
require_once 'config.php';
// Show all products
$stmt = $pdo->query("SELECT p.*, c.name as category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY c.sort_order ASC, p.sort_order ASC, p.created_at DESC");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories for tabs
try {
    $catStmt = $pdo->query("SELECT * FROM categories ORDER BY sort_order ASC, name ASC");
    $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $categories = []; // Fallback
}
?>
<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="page-hero" style="background-image: url('assets/customers/1.JPG');">
        <div class="page-hero-content">
            <h1 class="page-title">Our Premium Collection</h1>
            <div class="breadcrumb">Home / <span>Products</span></div>
        </div>
    </section>

    <style>
        .product-card {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-decoration: none; /* Ensure link style doesn't mess up card */
            color: inherit;
            display: block; /* Make anchor behave like block */
        }
        
        /* Ensure normal link behavior doesn't apply to text inside card */
        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        .product-img-wrapper .product-img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            z-index: 1;
            transition: opacity 0.6s ease-in-out, transform 0.5s ease;
            object-fit: contain;
            padding: 15px;
            background-color: #fff;
        }
        .product-img-wrapper .product-img.active {
            opacity: 1;
            z-index: 2;
        }
        .product-img-wrapper:hover .product-img.active {
            transform: scale(1.05);
        }
        .slide-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0,0,0,0.3);
            color: white;
            border: none;
            cursor: pointer;
            padding: 8px 12px;
            font-size: 18px;
            z-index: 10;
            border-radius: 4px;
            display: none;
            user-select: none;
        }
        .product-img-wrapper:hover .slide-arrow {
            display: block;
        }
        .slide-arrow:hover {
            background: rgba(0,0,0,0.6);
        }
        .prev-arrow { left: 10px; }
        .next-arrow { right: 10px; }
        
        @media (max-width: 768px) {
            .slide-arrow {
                padding: 4px 8px;
                font-size: 14px;
                background: rgba(0,0,0,0.4); 
            }
            .prev-arrow { left: 5px; }
            .next-arrow { right: 5px; }

            /* Mobile Category Dropdown Styles */
            .category-tabs { display: none !important; }
            .mobile-category-container { display: block !important; }
        }

        .mobile-category-container {
            display: none;
            margin-bottom: 2rem;
            padding: 0 0.5rem;
        }

        /* Mobile Category Grid Styles */
        .mobile-category-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Two in a row */
            gap: 0.5rem;
        }

        .mobile-cat-item {
            padding: 0.6rem 0.4rem;
            font-size: 10px; /* Very small text */
            text-align: center;
            background-color: #f4f6f7;
            border-radius: 6px;
            cursor: pointer;
            color: var(--primary-color);
            transition: all 0.2s ease;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 36px;
            line-height: 1.2;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border: 1px solid #eee;
        }

        .mobile-cat-item:active {
            transform: scale(0.98);
        }

        .mobile-cat-item.active {
            background-color: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
    </style>
    <section class="products-section">
        <div class="category-tabs">
            <button class="tab-btn active" data-tab="all">All</button>
            <?php foreach ($categories as $cat): ?>
                <button class="tab-btn" data-tab="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></button>
            <?php endforeach; ?>
        </div>

        <div class="mobile-category-container">
            <div class="mobile-category-grid">
                <div class="mobile-cat-item active" data-tab="all">All Categories</div>
                <?php foreach ($categories as $cat): ?>
                    <div class="mobile-cat-item" data-tab="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></div>
                <?php endforeach; ?>
            </div>
        </div>
        
        <div class="grid" id="products-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <?php 
                        $catId = $product['category_id'] ?? '0'; 
                    ?>
                    <a href="product_details?id=<?php echo $product['id']; ?>" class="product-card" data-category="<?php echo $catId; ?>">
                        <div class="product-img-wrapper">
                            <?php 
                                $stock = $product['stock'];
                                if ($stock == 0) {
                                    $stockClass = 'stock-out';
                                    $stockText = 'Out of Stock';
                                } elseif ($stock <= 10) {
                                    $stockClass = 'stock-limited';
                                    $stockText = 'Limited Stock';
                                } else {
                                    $stockClass = 'stock-available';
                                    $stockText = 'Available';
                                }
                            ?>
                            <span class="stock-badge <?php echo $stockClass; ?>"><?php echo $stockText; ?></span>
                            <?php 
                                $productImages = [];
                                if (!empty($product['image'])) $productImages[] = $product['image'];
                                if (isset($product['image2']) && !empty($product['image2'])) $productImages[] = $product['image2'];
                                if (isset($product['image3']) && !empty($product['image3'])) $productImages[] = $product['image3'];
                                
                                if (empty($productImages)) {
                                    $productImages[] = 'https://placehold.co/600x400/EEE/31343C?text=Ziggy+Product';
                                }
                            ?>
                            <?php foreach($productImages as $key => $img): ?>
                                <img src="<?php echo htmlspecialchars($img); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>" 
                                     class="product-img <?php echo $key === 0 ? 'active' : ''; ?>"
                                     >
                            <?php endforeach; ?>
                             <?php if (count($productImages) > 1): ?>
                                <button class="slide-arrow prev-arrow" onclick="changeSlide(event, this, -1)">&#10094;</button>
                                <button class="slide-arrow next-arrow" onclick="changeSlide(event, this, 1)">&#10095;</button>
                                <div class="slider-dots" style="position: absolute; bottom: 10px; left: 0; right: 0; text-align: center; z-index: 5;">
                                    <?php foreach($productImages as $key => $img): ?>
                                        <span class="dot" style="height: 6px; width: 6px; background-color: <?php echo $key === 0 ? '#fff' : 'rgba(255,255,255,0.5)'; ?>; border-radius: 50%; display: inline-block; margin: 0 3px; transition: background-color 0.3s;"></span>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="product-details">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <!-- Description Removed per Request -->
                            <!-- Price Removed per Request -->
                            <span class="btn" style="display: block; text-align: center; margin-top: 1rem; width: 100%; font-size: 0.9rem;">View Details</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1; color: #777;">No products available.</p>
            <?php endif; ?>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tabs Logic
            const tabs = document.querySelectorAll('.tab-btn');
            const products = document.querySelectorAll('.product-card');
            const mobileGridItems = document.querySelectorAll('.mobile-cat-item');

            function filterProducts(category) {
                products.forEach(product => {
                    if (category === 'all' || product.getAttribute('data-category') === category) {
                        product.style.display = ''; 
                    } else {
                        product.style.display = 'none';
                    }
                });
            }

            function setActiveState(category) {
                // Update Desktop Tabs
                tabs.forEach(t => {
                    if (t.getAttribute('data-tab') === category) t.classList.add('active');
                    else t.classList.remove('active');
                });

                // Update Mobile Grid Items
                mobileGridItems.forEach(item => {
                    if (item.getAttribute('data-tab') === category) item.classList.add('active');
                    else item.classList.remove('active');
                });
            }

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const category = tab.getAttribute('data-tab');
                    setActiveState(category);
                    filterProducts(category);
                });
            });

            // Mobile Grid Logic
            mobileGridItems.forEach(item => {
                item.addEventListener('click', () => {
                    const category = item.getAttribute('data-tab');
                    setActiveState(category);
                    filterProducts(category);
                });
            });
        });

        // Manual Slide Control
        function changeSlide(event, btn, direction) {
            event.preventDefault(); // Prevent navigating to product page
            event.stopPropagation();
            
            const wrapper = btn.closest('.product-img-wrapper');
            const images = wrapper.querySelectorAll('img.product-img');
            const dots = wrapper.querySelectorAll('.dot');
            
            if (images.length <= 1) return;
            
            let currentIndex = 0;
            images.forEach((img, index) => {
                if(img.classList.contains('active')) currentIndex = index;
            });
            
            // Remove current active
            images[currentIndex].classList.remove('active');
            if(dots[currentIndex]) dots[currentIndex].style.backgroundColor = 'rgba(255,255,255,0.5)';
            
            // Calculate new index
            let newIndex = currentIndex + direction;
            if (newIndex >= images.length) newIndex = 0;
            if (newIndex < 0) newIndex = images.length - 1;
            
            // Set new active
            images[newIndex].classList.add('active');
            if(dots[newIndex]) dots[newIndex].style.backgroundColor = '#fff';
        }
    </script>
<?php include 'includes/footer.php'; ?>
