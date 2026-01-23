<?php require_once 'config.php'; ?>
<?php include 'includes/header.php'; ?>

<section class="section container" style="text-align: center; padding: 4rem 1rem;">
    <div style="background: white; padding: 3rem; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto;">
        <i class="fas fa-check-circle" style="font-size: 4rem; color: #2ecc71; margin-bottom: 1rem;"></i>
        <h1 style="margin-bottom: 1rem;">Order Placed Successfully!</h1>
        <p>Thank you for your order. Your order ID is #<?php echo htmlspecialchars($_GET['id']); ?>.</p>
        <p>We will contact you shortly.</p>
        
        <a href="products" class="btn btn-gold" style="margin-top: 2rem;">Continue Shopping</a>
    </div>
</section>

<script>
    // Clear Cart
    document.addEventListener('DOMContentLoaded', () => {
        Cart.clear();
    });
</script>

<?php include 'includes/footer.php'; ?>
