<?php include 'includes/header.php'; ?>

    <div style="height: 100px;"></div>

    <section style="padding: 5rem 2rem; max-width: 1000px; margin: 0 auto;">
        <h2 class="section-title">Contact Us</h2>
        
        <div class="contact-container" style="display: grid; grid-template-columns: 1fr 1fr; gap: 4rem;">
            
            <div class="contact-info">
                <h3>Get in Touch</h3>
                <p style="margin-bottom: 2rem; color: #666;">Have a question about our products? We'd love to hear from you.</p>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-map-marker-alt" style="color: var(--secondary-color); width: 25px;"></i> Address:</strong><br>
                    123 Green Leaf Avenue,<br>Tea Valley, CA 90210
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-phone" style="color: var(--secondary-color); width: 25px;"></i> Phone:</strong><br>
                    (555) 123-4567
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <strong><i class="fas fa-envelope" style="color: var(--secondary-color); width: 25px;"></i> Email:</strong><br>
                    hello@ziggynatural.com
                </div>
            </div>

            <div class="contact-form">
                <form>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Name</label>
                        <input type="text" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Email</label>
                        <input type="email" class="form-control" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px;">
                    </div>
                    <div class="form-group" style="margin-bottom: 1.5rem;">
                        <label style="display: block; margin-bottom: 0.5rem; font-weight: bold;">Message</label>
                        <textarea class="form-control" rows="5" style="width: 100%; padding: 1rem; border: 1px solid #ddd; border-radius: 4px; font-family: inherit;"></textarea>
                    </div>
                    <button type="button" class="btn" style="width: 100%;">Send Message</button>
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
