<?php
require_once 'config.php';
// Show all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>
<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="page-hero" style="background-image: url('assets/customers/1.JPG');">
        <div class="page-hero-content">
            <h1 class="page-title">Our Premium Collection</h1>
            <div class="breadcrumb">Home / <span>Products</span></div>
        </div>
    </section>

    <section class="products-section">
        <div class="category-tabs">
            <button class="tab-btn active" data-tab="all">All</button>
            <button class="tab-btn" data-tab="Ceylon Tea Collection">Ceylon Tea</button>
            <button class="tab-btn" data-tab="Ceylon Coffee Collection">Ceylon Coffee</button>
            <button class="tab-btn" data-tab="Gift Collection">Gift Collection</button>
        </div>
        
        <div class="grid" id="products-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
                    <?php 
                        $category = $product['category'] ?? 'Ceylon Tea Collection'; 
                    ?>
                    <div class="product-card" data-category="<?php echo htmlspecialchars($category); ?>">
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
                                $imgSrc = !empty($product['image']) ? $product['image'] : 'https://placehold.co/600x400/EEE/31343C?text=Ziggy+Product'; 
                            ?>
                            <img src="<?php echo htmlspecialchars($imgSrc); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" class="product-img">
                        </div>
                        <div class="product-details">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                            <p class="product-desc"><?php echo htmlspecialchars($product['description']); ?></p>
                            <div class="product-price">LKR <?php echo number_format($product['price'], 2); ?></div>
                            <button class="btn" style="margin-top: 1rem; width: 100%; font-size: 0.9rem;">Add to Cart</button>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="text-align:center; width:100%; grid-column: 1/-1; color: #777;">No products available.</p>
            <?php endif; ?>
        </div>
    </section>

    <!-- Order Popup Modal -->
    <div id="orderModal" class="modal-overlay">
        <div class="product-modal">
            <span class="close-btn">&times;</span>
            <div class="modal-left">
                <img id="modalImg" src="" alt="Product Image">
            </div>
            <div class="modal-right">
                <h2 id="modalTitle">Product Name</h2>
                <div class="price-tag" id="modalPrice">LKR 0.00</div>
                <div class="unit-text">per unit</div>
                
                <div class="qty-section">
                    <label>Quantity</label>
                    <div class="qty-selector">
                        <button class="qty-btn" id="decreaseQty">-</button>
                        <input type="number" id="qtyInput" value="1" min="1" readonly>
                        <button class="qty-btn" id="increaseQty">+</button>
                    </div>
                </div>
                
                <div class="total-section">
                    <span>Total Amount:</span>
                    <span id="modalTotal">LKR 0.00</span>
                </div>
                
                <button id="confirmOrderBtn" class="confirm-btn">Confirm Order via WhatsApp</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Tabs Logic
            const tabs = document.querySelectorAll('.tab-btn');
            const products = document.querySelectorAll('.product-card');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');
                    const category = tab.getAttribute('data-tab');
                    products.forEach(product => {
                        if (category === 'all' || product.getAttribute('data-category') === category) {
                            product.style.display = ''; 
                        } else {
                            product.style.display = 'none';
                        }
                    });
                });
            });

            // Modal Logic
            const modal = document.getElementById('orderModal');
            const closeBtn = document.querySelector('.close-btn');
            const modalImg = document.getElementById('modalImg');
            const modalTitle = document.getElementById('modalTitle');
            const modalPrice = document.getElementById('modalPrice');
            const modalTotal = document.getElementById('modalTotal');
            const qtyInput = document.getElementById('qtyInput');
            const increaseQty = document.getElementById('increaseQty');
            const decreaseQty = document.getElementById('decreaseQty');
            const confirmBtn = document.getElementById('confirmOrderBtn');

            let currentPrice = 0;

            // Open Modal
            document.querySelectorAll('.btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    if(e.target.closest('.product-card')) {
                        const card = e.target.closest('.product-card');
                        const img = card.querySelector('.product-img').src;
                        const title = card.querySelector('.product-name').innerText;
                        const priceText = card.querySelector('.product-price').innerText.replace('LKR', '').trim().replace(',', '');
                        
                        currentPrice = parseFloat(priceText);
                        
                        modalImg.src = img;
                        modalTitle.innerText = title;
                        modalPrice.innerText = 'LKR ' + currentPrice.toFixed(2);
                        
                        qtyInput.value = 1;
                        updateTotal();
                        
                        modal.style.display = 'flex';
                    }
                });
            });

            // Close Modal
            closeBtn.addEventListener('click', () => {
                modal.style.display = 'none';
            });

            window.addEventListener('click', (e) => {
                if (e.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Quantity Logic
            increaseQty.addEventListener('click', () => {
                qtyInput.value = parseInt(qtyInput.value) + 1;
                updateTotal();
            });

            decreaseQty.addEventListener('click', () => {
                if (parseInt(qtyInput.value) > 1) {
                    qtyInput.value = parseInt(qtyInput.value) - 1;
                    updateTotal();
                }
            });

            function updateTotal() {
                const total = currentPrice * parseInt(qtyInput.value);
                modalTotal.innerText = 'LKR ' + total.toFixed(2);
            }

            // Confirm Order (WhatsApp)
            confirmBtn.addEventListener('click', () => {
                const qty = qtyInput.value;
                const total = modalTotal.innerText;
                const product = modalTitle.innerText;
                
                const message = `Hello, I would like to order ${product}. Quantity: ${qty}. Total Price: ${total}.`;
                const whatsappUrl = `https://wa.me/94774995669?text=${encodeURIComponent(message)}`;
                
                window.open(whatsappUrl, '_blank');
                modal.style.display = 'none';
            });
        });
    </script>
<?php include 'includes/footer.php'; ?>
