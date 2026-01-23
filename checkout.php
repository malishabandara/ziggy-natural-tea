<?php
require_once 'config.php';
?>
<?php include 'includes/header.php'; ?>

<!-- Hero Section -->
<section class="page-hero" style="background-image: url('assets/customers/1.JPG'); position: relative; height: 200px; display: flex; align-items: center; justify-content: center; background-size: cover; background-position: center;">
    <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: rgba(0,0,0,0.6);"></div>
    <div class="page-hero-content" style="position: relative; z-index: 2; text-align: center; color: white;">
        <h1 class="page-title" style="font-size: 2.5rem; margin-bottom: 0.5rem; font-family: 'Playfair Display', serif;">Checkout</h1>
    </div>
</section>

<section class="section container" style="padding: 4rem 1rem;">
    <form action="process_order.php" method="POST" enctype="multipart/form-data" id="checkoutForm">
        <input type="hidden" name="cart_data" id="cartData">
        
        <div class="checkout-layout">
            <!-- Left Column: Details & Payment -->
            <div class="checkout-main">
                
                <!-- Shipping Details Card -->
                <div class="checkout-card">
                    <div class="card-header">
                        <div class="step-icon">1</div>
                        <h2>Shipping Details</h2>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group full">
                            <label>Full Name</label>
                            <input type="text" name="name" placeholder="John Doe" required>
                        </div>
                        
                        <div class="form-group full">
                            <label>Phone Number</label>
                            <input type="tel" name="phone" placeholder="077 123 4567" required>
                        </div>
                        
                        <div class="form-group full">
                            <label>Delivery Address</label>
                            <textarea name="address" rows="3" placeholder="No. 123, Street Name, City" required></textarea>
                        </div>
                    </div>
                </div>

                <!-- Payment Method Card -->
                <div class="checkout-card">
                    <div class="card-header">
                        <div class="step-icon">2</div>
                        <h2>Payment Method</h2>
                    </div>
                    
                    <div class="payment-selection">
                        <label class="payment-option-card active" id="cod-card">
                            <input type="radio" name="payment_method" id="cod" value="cod" checked>
                            <div class="payment-icon">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="payment-info">
                                <h3>Cash on Delivery</h3>
                                <p>Pay with cash upon delivery.</p>
                            </div>
                            <div class="check-circle"><i class="fas fa-check"></i></div>
                        </label>
                        
                        <label class="payment-option-card" id="bank-card">
                            <input type="radio" name="payment_method" id="bank" value="bank_transfer">
                            <div class="payment-icon">
                                <i class="fas fa-university"></i>
                            </div>
                            <div class="payment-info">
                                <h3>Bank Transfer</h3>
                                <p>Transfer to our bank account.</p>
                            </div>
                            <div class="check-circle"><i class="fas fa-check"></i></div>
                        </label>
                    </div>

                    <!-- Bank Details Section -->
                    <div id="bank-details" class="bank-details-box">
                        <div class="bank-info">
                            <h4><i class="fas fa-info-circle"></i> Bank Account Details</h4>
                            <div class="bank-grid">
                                <div><strong>Bank:</strong> BOC Bank</div>
                                <div><strong>Branch:</strong> Dickwella</div>
                                <div><strong>Account Name:</strong> Ziggy Natural</div>
                                <div><strong>Account No:</strong> 94375027</div>
                            </div>
                        </div>
                        
                        <div class="upload-section">
                            <label><i class="fas fa-cloud-upload-alt"></i> Upload Payment Receipt</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="receipt" accept="image/*" id="receiptFile">
                                <span class="file-name">No file chosen</span>
                            </div>
                            <small>Please upload a clear screenshot of the transaction.</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Order Summary -->
            <div class="checkout-sidebar">
                <div class="order-summary-card">
                    <h3>Your Order</h3>
                    <div id="order-items-list" class="order-list">
                        <!-- Injected JS -->
                    </div>
                    
                    <div class="summary-divider"></div>
                    
                    <div class="summary-total-row">
                        <span>Total</span>
                        <span id="checkout-total">LKR 0.00</span>
                    </div>

                    <button type="submit" class="btn btn-gold btn-block place-order-btn">
                        Place Order
                    </button>
                    
                    <div class="support-text">
                        <p>Need help? <a href="contact">Contact Us</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>

<style>
    /* Styles */
    @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Lato:wght@300;400;700&display=swap');

    body {
        font-family: 'Lato', sans-serif;
        background-color: #f4f7f6;
    }

    .checkout-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2.5rem;
        max-width: 1200px;
        margin: 0 auto;
    }

    .checkout-card, .order-summary-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.05);
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .card-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        padding-bottom: 1rem;
    }

    .step-icon {
        width: 35px;
        height: 35px;
        background: #2c3e50;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 1rem;
    }

    .checkout-card h2 {
        font-family: 'Playfair Display', serif;
        margin: 0;
        font-size: 1.5rem;
        color: #2c3e50;
    }

    /* Form Styles */
    .form-group {
        margin-bottom: 1.2rem;
    }
    
    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #34495e;
    }

    .form-group input, .form-group textarea {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #dfe6e9;
        border-radius: 6px;
        transition: border-color 0.2s;
        font-family: inherit;
        box-sizing: border-box; /* Fix sizing */
    }

    .form-group input:focus, .form-group textarea:focus {
        border-color: #e67e22;
        outline: none;
    }

    /* Payment Styles */
    .payment-selection {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .payment-option-card {
        display: flex;
        align-items: center;
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        position: relative;
    }

    .payment-option-card:hover {
        border-color: #dcdcdc;
    }

    .payment-option-card.active {
        border-color: #e67e22;
        background-color: #fffaf5;
    }

    .payment-option-card input {
        display: none;
    }

    .payment-icon {
        font-size: 1.5rem;
        color: #7f8c8d;
        margin-right: 1rem;
        width: 40px;
        text-align: center;
    }

    .payment-option-card.active .payment-icon {
        color: #e67e22;
    }

    .payment-info h3 {
        margin: 0 0 0.2rem;
        font-size: 1rem;
        color: #2c3e50;
    }

    .payment-info p {
        margin: 0;
        font-size: 0.85rem;
        color: #7f8c8d;
    }

    .check-circle {
        margin-left: auto;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        border: 2px solid #ddd;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.7rem;
    }

    .payment-option-card.active .check-circle {
        background-color: #e67e22;
        border-color: #e67e22;
    }

    /* Bank Details */
    .bank-details-box {
        margin-top: 1.5rem;
        background: #f8f9fa;
        border: 1px dashed #bdc3c7;
        padding: 1.5rem;
        border-radius: 8px;
        display: none;
    }

    .bank-info h4 {
        margin-top: 0;
        color: #2c3e50;
        margin-bottom: 1rem;
    }

    .bank-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0.5rem;
        font-size: 0.9rem;
        color: #34495e;
        margin-bottom: 1.5rem;
    }

    .file-input-wrapper {
        position: relative;
        overflow: hidden;
        display: inline-block;
        width: 100%;
    }
    
    .file-input-wrapper input[type=file] {
        display: block;
        margin-top: 0.5rem;
    }

    /* Sidebar Summary */
    .order-summary-card h3 {
        margin-top: 0;
        font-family: 'Playfair Display', serif;
        border-bottom: 2px solid #e67e22;
        display: inline-block;
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
    }

    .order-list-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
        font-size: 0.95rem;
    }
    
    .order-list-item span:first-child {
        color: #2c3e50;
        font-weight: 600;
    }

    .summary-divider {
        height: 1px;
        background: #eee;
        margin: 1.5rem 0;
    }

    .summary-total-row {
        display: flex;
        justify-content: space-between;
        font-size: 1.3rem;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 2rem;
    }

    .place-order-btn {
        width: 100%;
        padding: 1rem;
        font-size: 1.1rem;
        font-weight: bold;
        letter-spacing: 1px;
        background: #e67e22;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
    }

    .place-order-btn:hover {
        background: #d35400;
    }

    .support-text {
        text-align: center;
        margin-top: 1.5rem;
        font-size: 0.9rem;
        color: #95a5a6;
    }
    
    .support-text a {
        color: #2c3e50;
        text-decoration: underline;
    }

    @media (max-width: 900px) {
        .checkout-layout {
            grid-template-columns: 1fr;
        }
        .checkout-sidebar {
            order: -1; /* Show summary on top on mobile, or bottom? usually bottom or collapsible. Let's keep normal flow or make it stick on bottom. */
            order: 2;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const items = Cart.getItems();
    if (items.length === 0) {
        window.location.href = 'cart';
        return;
    }

    // Populate hidden input
    document.getElementById('cartData').value = JSON.stringify(items);

    // Render Summary
    const list = document.getElementById('order-items-list');
    let total = 0;
    items.forEach(item => {
        const itemTotal = item.price * item.quantity;
        total += itemTotal;
        const div = document.createElement('div');
        div.className = 'order-list-item';
        div.innerHTML = `<span>${item.name} <span style="color:#7f8c8d; font-weight:normal;">x ${item.quantity}</span></span> <span>LKR ${itemTotal.toLocaleString(undefined, {minimumFractionDigits: 2})}</span>`;
        list.appendChild(div);
    });
    document.getElementById('checkout-total').innerText = 'LKR ' + total.toLocaleString(undefined, {minimumFractionDigits: 2});

    // Toggle Payment & Style
    const codRadio = document.getElementById('cod');
    const bankRadio = document.getElementById('bank');
    const codCard = document.getElementById('cod-card');
    const bankCard = document.getElementById('bank-card');
    
    const bankDetails = document.getElementById('bank-details');
    const receiptInput = document.getElementById('receiptFile');

    function togglePayment() {
        if (bankRadio.checked) {
            bankDetails.style.display = 'block';
            receiptInput.setAttribute('required', 'required');
            bankCard.classList.add('active');
            codCard.classList.remove('active');
        } else {
            bankDetails.style.display = 'none';
            receiptInput.removeAttribute('required');
            codCard.classList.add('active');
            bankCard.classList.remove('active');
        }
    }

    codRadio.addEventListener('change', togglePayment);
    bankRadio.addEventListener('change', togglePayment);
    
    // File input name update (optional polish)
    receiptInput.addEventListener('change', function(e) {
        const fileName = e.target.files[0] ? e.target.files[0].name : 'No file chosen';
        document.querySelector('.file-name').textContent = fileName;
    });
});
</script>

<?php include 'includes/footer.php'; ?>
