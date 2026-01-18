<?php include 'includes/header.php'; ?>

    <!-- Hero Section -->
    <section class="page-hero" style="background-image: url('assets/2.png');">
        <div class="page-hero-content">
            <h1 class="page-title">Get in Touch</h1>
            <div class="breadcrumb">Home / <span>Contact</span></div>
        </div>
    </section>

    <?php if (isset($_GET['msg'])): ?>
        <div style="max-width: 1000px; margin: 2rem auto; padding: 1rem 2rem; background: #d4edda; color: #155724; border-radius: 4px; text-align: center;">
            <?php echo htmlspecialchars($_GET['msg']); ?>
        </div>
    <?php endif; ?>

    <section style="padding: 5rem 2rem; max-width: 1000px; margin: 0 auto;">
        <h2 class="section-title" style="display:none;">Contact Us</h2>
        
        <div class="contact-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
            
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p style="margin-bottom: 2rem; color: #666;">Have a question about our products? We'd love to hear from you.</p>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-map-marker-alt" style="color: var(--secondary-color); width: 25px;"></i> Address:</strong><br>
                    Ziggy Natural (Pvt) Ltd<br>128/B, Main Street<br>Urubokka, Sri Lanka
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-phone" style="color: var(--secondary-color); width: 25px;"></i> Phone:</strong><br>
                    +94 77 499 5669
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-envelope" style="color: var(--secondary-color); width: 25px;"></i> Email:</strong><br>
                    hello@ziggynatural.com
                </div>
            </div>

            <div class="contact-form">
                <form action="admin/actions.php" method="POST">
                    <input type="hidden" name="action" value="submit_contact">
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Name</label>
                        <input type="text" name="name" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email</label>
                        <input type="email" name="email" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px;" required>
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Message</label>
                        <textarea name="message" class="form-control" rows="5" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;" required></textarea>
                    </div>
                    <button type="submit" class="btn" style="width: 100%;">Send Message</button>
                </form>
            </div>
            
        </div>
    </section>

    <!-- Mobile responsiveness fix for grid -->
    <style>
        @media (max-width: 768px) {
            .contact-container { grid-template-columns: 1fr !important; gap: 2rem !important; }
        }
    </style>

<?php include 'includes/footer.php'; ?>
