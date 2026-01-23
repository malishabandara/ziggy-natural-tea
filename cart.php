<?php
require_once 'config.php';
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="page-hero" style="background-image: url('assets/customers/1.JPG'); position: relative; height: 250px; display: flex; align-items: center; justify-content: center; background-size: cover; background-position: center;">
    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.5);"></div>
    <div class="page-hero-content" style="position: relative; z-index: 2; text-align: center; color: white;">
        <h1 class="page-title" style="font-size: 3rem; margin-bottom: 0.5rem; font-family: 'Playfair Display', serif;">Your Cart</h1>
        <div class="breadcrumb" style="font-size: 1rem; opacity: 0.9;">Home / <span>Shopping Cart</span></div>
    </div>
</section>

<section class="section container" style="padding: 4rem 1rem;">
    <div id="cart-container" class="cart-wrapper">
        
        <!-- Empty Cart Message -->
        <div id="empty-cart-msg" style="display:none; text-align:center; padding: 4rem 2rem; background: white; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.05);">
            <i class="fas fa-shopping-basket" style="font-size: 4rem; color: #ddd; margin-bottom: 1.5rem;"></i>
            <h3 style="color: #2c3e50; font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 1rem;">Your cart is empty</h3>
            <p style="color: #7f8c8d; margin-bottom: 2rem;">It looks like you haven't added any premium teas or coffees yet.</p>
            <a href="products" class="btn btn-gold" style="padding: 1rem 2.5rem; border-radius: 50px; text-transform: uppercase; letter-spacing: 1px; font-size: 0.9rem;">Start Shopping</a>
        </div>

        <!-- Cart Content -->
        <div class="cart-content-grid" id="cart-content-grid">
            
            <div class="cart-items-column">
                <div class="cart-header">
                    <span>Product</span>
                    <span class="text-right">Total</span>
                </div>
                <div id="cart-items-body" class="cart-items-list">
                    <!-- Items injected by JS -->
                </div>
            </div>

            <div class="cart-summary-column">
                <div class="cart-summary-card">
                    <h3>Order Summary</h3>
                    
                    <div class="summary-row">
                        <span>Subtotal</span>
                        <span id="cart-subtotal">LKR 0.00</span>
                    </div>
                    <div class="summary-row">
                        <span>Shipping</span>
                        <span style="font-size: 0.9rem; color: #7f8c8d;">Calculated at checkout</span>
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-row total">
                        <span>Total</span>
                        <span id="cart-total">LKR 0.00</span>
                    </div>
                    
                    <a href="checkout" class="btn btn-gold btn-block checkout-btn">
                        Proceed to Checkout <i class="fas fa-arrow-right" style="margin-left: 8px;"></i>
                    </a>
                    
                    <div class="secure-badge">
                        <i class="fas fa-lock"></i> Secure Checkout
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<style>
    /* Google Fonts */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap');

    body {
        font-family: 'Lato', sans-serif;
        background-color: #fcfcfc;
    }

    .cart-wrapper {
        max-width: 1200px;
        margin: 0 auto;
    }

    .cart-content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 3rem;
    }

    .cart-header {
        display: flex;
        justify-content: space-between;
        padding-bottom: 1rem;
        border-bottom: 2px solid #eee;
        color: #95a5a6;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.85rem;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
    }

    .cart-item {
        display: flex;
        align-items: center;
        background: white;
        padding: 1.5rem;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        box-shadow: 0 5px 20px rgba(0,0,0,0.03);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .cart-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    }

    .cart-item-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 8px;
        margin-right: 1.5rem;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-title {
        font-family: 'Playfair Display', serif;
        font-size: 1.2rem;
        color: #2c3e50;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }

    .cart-item-price {
        color: #7f8c8d;
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .cart-actions {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
    }

    .qty-control {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        border-radius: 6px;
        padding: 2px;
        margin-right: 1.5rem;
    }

    .qty-btn {
        background: none;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        color: #2c3e50;
        transition: color 0.2s;
    }

    .qty-btn:hover {
        color: #e67e22;
    }

    .qty-input {
        width: 40px;
        text-align: center;
        border: none;
        background: transparent;
        font-weight: bold;
        color: #2c3e50;
        -moz-appearance: textfield;
    }
    .qty-input::-webkit-outer-spin-button,
    .qty-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .remove-link {
        color: #e74c3c;
        cursor: pointer;
        font-size: 0.85rem;
        text-decoration: underline;
        opacity: 0.8;
        background: none;
        border: none;
    }

    .remove-link:hover {
        opacity: 1;
    }

    .item-total {
        font-size: 1.1rem;
        font-weight: bold;
        color: #2c3e50;
        min-width: 100px;
        text-align: right;
    }

    /* Summary Card */
    .cart-summary-card {
        background: white;
        padding: 2.5rem;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0,0,0,0.08);
        position: sticky;
        top: 100px;
    }

    .cart-summary-card h3 {
        font-family: 'Playfair Display', serif;
        margin-top: 0;
        margin-bottom: 2rem;
        font-size: 1.5rem;
        color: #2c3e50;
        border-left: 4px solid #e67e22;
        padding-left: 1rem;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        color: #34495e;
    }

    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 1.5rem 0;
    }

    .summary-row.total {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 2rem;
    }

    .checkout-btn {
        padding: 1rem;
        border-radius: 8px;
        font-weight: 600;
        letter-spacing: 0.5px;
        transition: transform 0.2s, box-shadow 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #e67e22; /* Use secondary color or gold */
        color: white;
        text-decoration: none;
    }

    .checkout-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(230, 126, 34, 0.3);
        background-color: #d35400;
    }
    
    .secure-badge {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.8rem;
        color: #95a5a6;
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 0.5rem;
    }

    @media (max-width: 768px) {
        .cart-content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
        
        .cart-header {
            display: none; /* Hide desktop header */
        }
        
        .cart-item {
            flex-direction: row; /* Keep row but wrap if needed, or row with stack */
            flex-wrap: wrap;
            padding: 1rem;
            align-items: flex-start;
        }
        
        .cart-item-img {
            width: 80px;
            height: 80px;
            margin-right: 1rem;
            margin-bottom: 0;
        }

        .cart-item-info {
            display: flex;
            flex-direction: column;
            width: calc(100% - 100px); /* Remaining space */
        }
        
        .cart-item-title {
            font-size: 1.1rem;
        }

        .cart-actions {
            margin-top: 0.5rem;
            justify-content: space-between;
            width: 100%;
        }
        
        .qty-control {
            margin-right: 0;
            padding: 0;
        }
        
        .qty-btn {
            padding: 5px 8px;
        }
        
        .item-total {
            width: 100%;
            text-align: left;
            margin-top: 0.5rem;
            font-size: 1rem;
            color: #e67e22;
        }

        /* Sticky Bottom Checkout for Mobile */
        .cart-summary-card {
            padding: 1.5rem;
        }
        
        .checkout-btn {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            border-radius: 0;
            padding: 1.2rem;
            z-index: 1000;
            box-shadow: 0 -4px 10px rgba(0,0,0,0.1);
            font-size: 1.1rem;
        }
        
        /* Add padding to body so content isn't hidden behind sticky button */
        body {
            padding-bottom: 80px; 
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    renderCart();

    function renderCart() {
        const items = Cart.getItems();
        const container = document.getElementById('cart-items-body');
        const emptyMsg = document.getElementById('empty-cart-msg');
        const contentGrid = document.getElementById('cart-content-grid');
        
        container.innerHTML = '';
        
        if (items.length === 0) {
            emptyMsg.style.display = 'block';
            contentGrid.style.display = 'none';
            return;
        }
        
        emptyMsg.style.display = 'none';
        contentGrid.style.display = 'grid'; // Restore grid
        
        let subtotal = 0;
        
        items.forEach(item => {
            const total = item.price * item.quantity;
            subtotal += total;
            
            const div = document.createElement('div');
            div.className = 'cart-item';
            div.innerHTML = `
                <img src="${item.image}" alt="${item.name}" class="cart-item-img">
                <div class="cart-item-info">
                    <div class="cart-item-title">${item.name}</div>
                    <div class="cart-item-price">LKR ${Math.floor(item.price).toLocaleString()}</div>
                    <div class="cart-actions">
                        <div class="qty-control">
                            <button class="qty-btn" onclick="updateItemQty('${item.id}', -1)">-</button>
                            <input type="number" value="${item.quantity}" class="qty-input" readonly>
                            <button class="qty-btn" onclick="updateItemQty('${item.id}', 1)">+</button>
                        </div>
                        <button class="remove-link" onclick="removeItem('${item.id}')">Remove</button>
                    </div>
                </div>
                <div class="item-total">
                    LKR ${total.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                </div>
            `;
            container.appendChild(div);
        });
        
        const formattedTotal = 'LKR ' + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('cart-subtotal').innerText = formattedTotal;
        document.getElementById('cart-total').innerText = formattedTotal;
    }
    
    // Make functions global for inline onclick
    window.updateItemQty = function(id, change) {
        const items = Cart.getItems();
        const item = items.find(i => i.id == id);
        if(item) {
            const newQty = parseInt(item.quantity) + change;
            if(newQty > 0) {
                Cart.updateItem(id, newQty);
                renderCart();
            }
        }
    };
    
    window.removeItem = function(id) {
        // if(confirm('Remove this item?')) {
            Cart.removeItem(id);
            renderCart();
        // }
    };
});
</script>

<?php include 'includes/footer.php'; ?>
