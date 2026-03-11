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

<section class="product-detail-section mb-4">
    <div class="container">
        <div class="product-detail-grid">
            
            <!-- Left Column: Images -->
            <div class="product-gallery">
                <div class="main-image-container">
                    <img id="mainImage" src="<?php echo htmlspecialchars($images[0]); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                </div>
                <?php if (count($images) > 1): ?>
                    <div class="thumbnail-list">
                        <?php foreach($images as $index => $img): ?>
                            <div class="thumbnail-item <?php echo $index === 0 ? 'active' : ''; ?>" onclick="changeMainImage('<?php echo htmlspecialchars($img); ?>', this)">
                                <img src="<?php echo htmlspecialchars($img); ?>" alt="Thumbnail">
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Right Column: Details & Order Form -->
            <div class="product-info-col">
                <h1 class="pdp-title"><?php echo htmlspecialchars($product['name']); ?></h1>
                
                <div class="pdp-meta">
                    <span class="pdp-category"><?php echo htmlspecialchars($product['category_name'] ?? 'General'); ?></span>
                    <?php if($product['stock'] > 0): ?>
                        <span class="stock-status in-stock">In Stock</span>
                    <?php else: ?>
                        <span class="stock-status out-stock">Out of Stock</span>
                    <?php endif; ?>
                </div>

                <hr class="pdp-divider">

                <!-- Description -->
                <div class="pdp-description">
                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                </div>

                <!-- Order Button -->
                <div class="order-button-container" style="margin-top: 2rem;">
                    <button type="button" class="btn-direct-order" onclick="openOrderModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="9" cy="21" r="1"></circle>
                            <circle cx="20" cy="21" r="1"></circle>
                            <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                        </svg>
                        Order
                    </button>
                </div>

                

            </div>
        </div>
    </div>
</section>

<!-- Related Products (Simple placeholder logic for now, randomize 3 items) -->
<?php
    $relatedStmt = $pdo->query("SELECT * FROM products WHERE id != $id ORDER BY RAND() LIMIT 3");
    $relatedProducts = $relatedStmt->fetchAll(PDO::FETCH_ASSOC);
    if($relatedProducts):
?>
<section class="related-products-section bg-cream">
    <div class="container">
        <h3 class="serif text-center mb-4">You May Also Like</h3>
        <div class="grid">
             <?php foreach ($relatedProducts as $rp): ?>
                <a href="product_details?id=<?php echo $rp['id']; ?>" class="product-card-link-wrapper" style="text-decoration: none; color: inherit;">
                    <div class="product-card">
                        <div class="product-img-wrapper" style="height: 200px;">
                             <img src="<?php echo htmlspecialchars(!empty($rp['image']) ? $rp['image'] : 'https://placehold.co/600x400'); ?>" 
                                  class="product-img active" alt="<?php echo htmlspecialchars($rp['name']); ?>">
                        </div>
                        <div class="product-details text-center">
                            <h3 class="product-name" style="font-size: 1.1rem;"><?php echo htmlspecialchars($rp['name']); ?></h3>
                            
                        </div>
                    </div>
                </a>
             <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- Order Modal -->
<div id="orderModal" class="modal-overlay">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Order <?php echo htmlspecialchars($product['name']); ?></h3>
            <button class="close-btn" onclick="closeOrderModal()">&times;</button>
        </div>
        <form id="orderForm" onsubmit="submitOrder(event)">
            <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
            
            <div class="form-group">
                <label for="order_name">Full Name</label>
                <input type="text" id="order_name" name="name" required placeholder="Enter your full name">
            </div>
            
            <div class="form-group">
                <label for="order_phone">Phone Number</label>
                <input type="tel" id="order_phone" name="phone" required placeholder="Enter your phone number">
            </div>
            
            <div class="form-group">
                <label for="order_address">Delivery Address</label>
                <textarea id="order_address" name="address" required placeholder="Enter your full address"></textarea>
            </div>
            
            <div class="form-group">
                <label for="order_quantity">Quantity</label>
                <div class="quantity-picker">
                    <button type="button" onclick="adjustOrderQty(-1)">-</button>
                    <input type="number" id="order_quantity" name="quantity" value="1" min="1" onchange="validateQty(this)">
                    <button type="button" onclick="adjustOrderQty(1)">+</button>
                </div>
            </div>
            
            <div style="margin-bottom: 25px;"></div>
            
            <button type="submit" class="cta-button" id="submitOrderBtn">Confirm Order</button>
        </form>
    </div>
</div>

<script>
    // Product Data
    const basePrice = <?php echo !empty($variations) ? $variations[0]['price'] : $product['price']; ?>;
    const productId = <?php echo $product['id']; ?>;
    const productName = "<?php echo htmlspecialchars($product['name']); ?>";
    const baseImage = "<?php echo htmlspecialchars($images[0]); ?>";
    
    // Elements (may be missing in some layouts)
    const qtyInput = document.getElementById('qtyInput');
    const displayPrice = document.getElementById('displayPrice');
    const finalTotal = document.getElementById('finalTotal');
    const variationSelect = document.getElementById('variationSelect');
    
    // State
    let currentPrice = basePrice;
    
    // Init logic if variations exist
    if(variationSelect) {
        currentPrice = parseFloat(variationSelect.options[variationSelect.selectedIndex].getAttribute('data-price'));
        if (typeof updateCalculation === 'function') updateCalculation();
        
        variationSelect.addEventListener('change', function() {
            currentPrice = parseFloat(this.options[this.selectedIndex].getAttribute('data-price'));
            if (displayPrice) displayPrice.innerText = 'LKR ' + currentPrice.toLocaleString('en-US', {minimumFractionDigits: 2});
            if (typeof updateCalculation === 'function') updateCalculation();
        });
    }

    function updateQty(change) {
        if (!qtyInput) return;
        let newVal = parseInt(qtyInput.value) + change;
        if(newVal < 1) newVal = 1;
        qtyInput.value = newVal;
        updateCalculation();
    }

    function updateCalculation() {
        if (!qtyInput || !finalTotal) return;
        let total = currentPrice * parseInt(qtyInput.value);
        finalTotal.innerText = 'LKR ' + total.toLocaleString('en-US', {minimumFractionDigits: 2});
    }

    // Image Gallery
    window.changeMainImage = function(src, thumbnail) {
        const mainImg = document.getElementById('mainImage');
        if (mainImg) mainImg.src = src;
        document.querySelectorAll('.thumbnail-item').forEach(el => el.classList.remove('active'));
        if (thumbnail) thumbnail.classList.add('active');
    }


    // Modal Logic
    const orderModal = document.getElementById('orderModal');
    const orderQtyInput = document.getElementById('order_quantity');
    const modalTotalAmount = document.getElementById('modalTotalAmount');
    const productPriceValue = <?php echo (float)$product['price']; ?>;

    function openOrderModal() {
        if (orderModal) {
            orderModal.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }
    }

    function closeOrderModal() {
        if (orderModal) {
            orderModal.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    function adjustOrderQty(change) {
        if (!orderQtyInput) return;
        let current = parseInt(orderQtyInput.value) || 1;
        let next = current + change;
        if (next < 1) next = 1;
        orderQtyInput.value = next;
    }

    function validateQty(input) {
        let val = parseInt(input.value);
        if (isNaN(val) || val < 1) {
            input.value = 1;
        }
    }

    function submitOrder(event) {
        event.preventDefault();
        
        const btn = document.getElementById('submitOrderBtn');
        if (!btn) return;
        const originalText = btn.innerText;
        btn.disabled = true;
        btn.innerText = 'Processing...';

        const formData = new FormData(event.target);

        fetch('process_direct_order.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                window.location.reload();
            } else {
                alert(data.message);
                btn.disabled = false;
                btn.innerText = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            btn.disabled = false;
            btn.innerText = originalText;
        });
    }

    // Close modal on outside click
    window.onclick = function(event) {
        if (event.target == orderModal) {
            closeOrderModal();
        }
    }

</script>

<style>
/* Scoped styles for PDP */
.product-detail-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    margin-top: 2rem;
}

/* Gallery */
.main-image-container {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.main-image-container img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
}

.thumbnail-list {
    display: flex;
    gap: 1rem;
    overflow-x: auto;
}

.thumbnail-item {
    width: 80px;
    height: 80px;
    border: 2px solid #eee;
    border-radius: 8px;
    cursor: pointer;
    overflow: hidden;
    opacity: 0.7;
    transition: all 0.3s;
}

.thumbnail-item.active {
    border-color: var(--secondary-color);
    opacity: 1;
}

.thumbnail-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Info Column */
.pdp-title {
    font-size: 2.5rem;
    font-family: 'Playfair Display', serif;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
    line-height: 1.2;
}

.pdp-meta {
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 0.9rem;
}

.pdp-category {
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #999;
}

.stock-status {
    padding: 2px 8px;
    border-radius: 4px;
    font-weight: bold;
    font-size: 0.8rem;
}
.in-stock { color: #27ae60; background: rgba(39, 174, 96, 0.1); }
.out-stock { color: #c0392b; background: rgba(192, 57, 43, 0.1); }

.pdp-price {
    font-size: 2rem;
    color: var(--secondary-color);
    font-weight: 700;
}

.pdp-divider {
    border: none;
    border-top: 1px solid #eee;
    margin: 1.5rem 0;
}

.pdp-description {
    color: #555;
    line-height: 1.8;
    margin-bottom: 2rem;
}

/* Order Box */
.order-controls-box {
    background: #fdfbf7;
    padding: 2rem;
    border-radius: 12px;
    border: 1px solid #efe8d8;
}

.control-group {
    margin-bottom: 1.5rem;
}

.control-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 700;
    color: var(--primary-color);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.form-select {
    width: 100%;
    padding: 10px;
    border-radius: 6px;
    border: 1px solid #ddd;
    font-size: 1rem;
    background: #fff;
}

.qty-wrapper {
    display: flex;
    align-items: center;
    background: #fff;
    width: fit-content;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.qty-control {
    background: none;
    border: none;
    width: 40px;
    height: 40px;
    font-size: 1.2rem;
    color: #555;
    cursor: pointer;
}

.qty-control:hover { background: #f5f5f5; }

#qtyInput {
    border: none;
    width: 80px;
    height: 45px;
    text-align: center;
    font-weight: 800;
    font-size: 1.5rem;
    color: var(--primary-color);
    background: white;
    -moz-appearance: textfield;
}

#qtyInput::-webkit-outer-spin-button,
#qtyInput::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.total-display-n {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    font-weight: 700;
    font-size: 1.2rem;
    color: var(--primary-color);
    border-top: 1px dashed #ddd;
    padding-top: 1rem;
}


/* Responsive */
@media (max-width: 900px) {
    .product-detail-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .main-image-container {
        height: 350px;
    }
    .action-buttons {
        grid-template-columns: 1fr;
    }
}

.btn-direct-order {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
    background-color: var(--primary-color, #2c3e50);
    color: white;
    padding: 14px 40px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: bold;
    font-size: 1.1rem;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: none;
    cursor: pointer;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    width: 100%;
    max-width: 300px;
}

.btn-direct-order:hover {
    background-color: var(--secondary-color, #e67e22);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.btn-direct-order svg {
    width: 20px;
    height: 20px;
}

/* Modal Styling */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.6);
    backdrop-filter: blur(5px);
    z-index: 9999;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.modal-content {
    background: white;
    padding: 30px;
    border-radius: 20px;
    width: 100%;
    max-width: 500px;
    max-height: 90vh;
    overflow-y: auto;
    box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    position: relative;
    animation: modalAppear 0.4s ease-out;
}

@keyframes modalAppear {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.modal-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #eee;
}

.modal-header h3 {
    margin: 0;
    color: var(--primary-color);
    font-size: 1.5rem;
}

.close-btn {
    background: none;
    border: none;
    font-size: 2rem;
    cursor: pointer;
    color: #999;
    line-height: 1;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #444;
}

.form-group input, .form-group textarea {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #edeff2;
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s;
}

.form-group input:focus, .form-group textarea:focus {
    border-color: var(--secondary-color);
    outline: none;
}

.form-group textarea {
    height: 100px;
    resize: none;
}

.quantity-picker {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #f8f9fa;
    padding: 5px;
    border-radius: 12px;
    width: fit-content;
}

.quantity-picker button {
    width: 45px;
    height: 45px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 10px;
    font-size: 1.5rem;
    font-weight: bold;
    cursor: pointer;
    box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
}

.quantity-picker button:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.quantity-picker input {
    width: 80px;
    height: 45px;
    text-align: center;
    border: 2px solid #edeff2;
    background: white;
    border-radius: 8px;
    font-weight: 800;
    font-size: 1.5rem;
    color: var(--primary-color);
    transition: all 0.3s;
    -moz-appearance: textfield;
}

.quantity-picker input::-webkit-outer-spin-button,
.quantity-picker input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

.quantity-picker input:focus {
    border-color: var(--secondary-color);
    outline: none;
}

.order-summary {
    background: #fdfbf7;
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 25px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
}

.summary-row.total {
    border-top: 1px dashed #ddd;
    margin-top: 10px;
    padding-top: 10px;
    font-weight: bold;
    font-size: 1.2rem;
    color: var(--primary-color);
}

.cta-button {
    width: 100%;
    padding: 16px;
    background: #27ae60;
    color: white;
    border: none;
    border-radius: 50px;
    font-weight: bold;
    font-size: 1.1rem;
    cursor: pointer;
    transition: background 0.3s;
}

.cta-button:hover {
    background: #219150;
}

.cta-button:disabled {
    background: #ccc;
    cursor: not-allowed;
}
</style>
