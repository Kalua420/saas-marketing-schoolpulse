    <?php
    // Get site settings from database if not already loaded
    if (!isset($site_name)) {
        $site_name = get_setting($pdo, 'site_name', 'SchoolPulse');
    }
    if (!isset($contact_email)) {
        $contact_email = get_setting($pdo, 'contact_email', 'hello@schoolpulse.in');
    }
    if (!isset($contact_phone)) {
        $contact_phone = get_setting($pdo, 'contact_phone', '+91 98765 43210');
    }
    if (!isset($address)) {
        $address = get_setting($pdo, 'address', 'India');
    }
    $site_tagline = get_setting($pdo, 'site_tagline', 'The Complete School Management System');
    ?>
    <footer class="footer">
        <div class="container">

            <div class="footer-grid">

                <!-- Brand -->
                <div class="footer-brand">
                    <span class="footer-brand-name"><?php echo htmlspecialchars($site_name); ?></span>
                    <p class="footer-brand-desc">India's leading school management system designed to bring modern administrative solutions to educational institutions. Streamlining operations from admissions to alumni.</p>
                    <div class="footer-social">
                        <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>

                <!-- Product -->
                <div class="footer-col">
                    <h4>Product</h4>
                    <ul>
                        <li><a href="features.php">Features</a></li>
                        <li><a href="pricing.php">Pricing</a></li>
                        <li><a href="#">Roadmap</a></li>
                        <li><a href="features.php">School Management</a></li>
                        <li><a href="demo.php" class="footer-highlight">Request Demo</a></li>
                    </ul>
                </div>

                <!-- Company -->
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="contact.php">Contact</a></li>
                        <li><a href="privacy.php">Privacy Policy</a></li>
                        <li><a href="terms.php">Terms of Service</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="footer-col">
                    <h4>Contact Us</h4>
                    <div class="footer-contact-list">
                        <div class="footer-contact-item">
                            <i class="fas fa-envelope"></i>
                            <span><?php echo htmlspecialchars($contact_email); ?></span>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-phone"></i>
                            <div>
                                <div><?php echo htmlspecialchars($contact_phone); ?></div>
                                <div class="footer-whatsapp">
                                    <i class="fas fa-check-circle"></i>
                                    WhatsApp Support Active
                                </div>
                            </div>
                        </div>
                        <div class="footer-contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span><?php echo nl2br(htmlspecialchars($address)); ?></span>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- Office image strip -->
        <div class="footer-image-strip">
            <div class="footer-image-strip-bg">
                <i class="fas fa-building"></i>
                <i class="fas fa-graduation-cap"></i>
                <i class="fas fa-school"></i>
                <i class="fas fa-laptop"></i>
                <i class="fas fa-users"></i>
            </div>
            <div class="footer-strip-fade"></div>
        </div>

        <!-- Bottom bar -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-inner">
                    <p>© <?php echo date('Y'); ?> <?php echo htmlspecialchars($site_name); ?>. All rights reserved. Providing modern administrative solutions for Indian education.</p>
                    <div class="footer-bottom-badges">
                        <span class="footer-bottom-badge">
                            <i class="fas fa-shield-alt"></i> ISO 27001 Certified
                        </span>
                        <span class="footer-bottom-badge">
                            <i class="fas fa-cloud"></i> GDPR Compliant
                        </span>
                    </div>
                </div>
            </div>
        </div>

    </footer>

    <script src="assets/js/main.js"></script>
</body>
</html>