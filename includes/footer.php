<?php
require_once __DIR__ . '/../config.php';

// If this is an admin page, do not render the main site footer or floating badges
if (isset($isAdminPage) && $isAdminPage === true) {
    echo '<!-- Client Javascript -->';
    echo '<script src="assets/js/script.js"></script>';
    echo '</body>';
    echo '</html>';
    return;
}
?>
<!-- Site Footer -->
<footer class="footer-site">
    <div class="container">
        <div class="footer-grid">
            <!-- Brand Info Column -->
            <div class="footer-brand">
                <a href="index" class="brand-logo-wrap">
                    <img src="assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" style="height: 55px; width: auto; display: block;">
                </a>
                <p>
                    Experience authentic Sri Lankan hospitality in Sri Lanka. Villa accommodations, homemade rice & curry, guided island tours, self-drive rentals, and full mechanical workshop support.
                </p>
            </div>

            <!-- Navigation Links -->
            <div>
                <h4 class="footer-title">Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index">Home</a></li>
                    <li><a href="about">About Us</a></li>
                    <li><a href="accommodation">Villa Rooms</a></li>
                    <li><a href="tours">Guided Tours</a></li>
                    <li><a href="service">Services</a></li>
                    <li><a href="review">Guest Reviews</a></li>
                    <li><a href="contact">Contact Us</a></li>
                </ul>
            </div>

            <!-- Services Summary -->
            <div>
                <h4 class="footer-title">Our Services</h4>
                <ul class="footer-links">
                    <li><a href="service#food">Home-Cooked Food</a></li>
                    <li><a href="service#tours">Guided Island Tours</a></li>
                    <li><a href="service#rentals">Tuk Tuk & Bike Rental</a></li>
                    <li><a href="service#repairs">Workshop & Repairs</a></li>
                    <li><a href="service#weddings">Traditional Weddings</a></li>
                </ul>
            </div>

            <!-- Contact Information -->
            <div>
                <h4 class="footer-title">Contact & Location</h4>
                <ul class="footer-contact-list">
                    <li class="footer-contact-item">
                        <svg viewBox="0 0 24 24"><path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/></svg>
                        <span><strong>Location:</strong> <a href="<?php echo MAPS_URL; ?>" target="_blank" rel="noopener" style="color: var(--color-gold); text-decoration: underline;"><?php echo LOCATION; ?></a></span>
                    </li>
                    <li class="footer-contact-item">
                        <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/></svg>
                        <span><strong>Host:</strong> <?php echo OWNER_NAME; ?></span>
                    </li>
                    <li class="footer-contact-item">
                        <svg viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        <span>
                            <a href="tel:<?php echo PHONE_LANDLINE_RAW; ?>" style="color: var(--color-gold);"><?php echo PHONE_LANDLINE; ?></a> / 
                            <a href="tel:<?php echo PHONE_MOBILE_RAW; ?>" style="color: var(--color-gold);"><?php echo PHONE_MOBILE; ?></a>
                        </span>
                    </li>
                    <li class="footer-contact-item">
                        <svg viewBox="0 0 24 24"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        <span><a href="mailto:<?php echo EMAIL_ADDRESS; ?>" style="color: var(--color-white);"><?php echo EMAIL_ADDRESS; ?></a></span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?>. All rights reserved. Managed by <?php echo OWNER_NAME; ?>.</p>
            <p>
                Designed for Travelers & Explorers in Sri Lanka.
                <a href="login" title="Admin Portal" style="margin-left: 8px; color: rgba(255,255,255,0.3); display: inline-flex; align-items: center; vertical-align: middle; transition: var(--transition-fast);" onmouseover="this.style.color='var(--color-gold)'" onmouseout="this.style.color='rgba(255,255,255,0.3)'">
                    <svg viewBox="0 0 24 24" width="14" height="14" fill="currentColor"><path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zm-6 9c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2zm3.1-9H8.9V6c0-1.71 1.39-3.1 3.1-3.1 1.71 0 3.1 1.39 3.1 3.1v2z"/></svg>
                </a>
            </p>
        </div>
    </div>
</footer>

<!-- Floating Review Badge (Site-wide) -->
<a href="review#write-review" 
   class="floating-review" 
   title="Write a Review">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
        <path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
    </svg>
</a>

<!-- Floating WhatsApp Badge (Site-wide) -->
<a href="<?php echo get_whatsapp_url('Hi Kelum! I want to inquire about Hidden Lanka.'); ?>" 
   class="floating-whatsapp" 
   target="_blank" 
   rel="noopener" 
   title="Chat with host on WhatsApp">
    <svg viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.33 5.001l-1.414 5.16 5.283-1.385c1.464.798 3.118 1.218 4.79 1.219h.004c5.505 0 9.988-4.478 9.989-9.985 0-2.668-1.037-5.176-2.924-7.062-1.886-1.887-4.394-2.932-7.068-2.932zm0 1.666c4.587 0 8.322 3.733 8.323 8.318 0 2.23-.867 4.327-2.446 5.904-1.579 1.577-3.676 2.444-5.908 2.444h-.003c-1.446 0-2.868-.378-4.113-1.093l-.295-.17-3.055.801.815-2.978-.187-.298c-.787-1.253-1.203-2.705-1.203-4.187 0-4.585 3.735-8.319 8.322-8.319zm4.567 11.455c-.252-.126-1.488-.734-1.719-.818-.231-.084-.399-.126-.567.126-.168.252-.651.818-.798.986-.147.168-.294.189-.546.063-.252-.126-1.064-.392-2.027-1.251-.749-.668-1.255-1.493-1.402-1.745-.147-.252-.016-.388.11-.513.113-.113.252-.294.378-.441.126-.147.168-.252.252-.42.084-.168.042-.315-.021-.441-.063-.126-.567-1.365-.777-1.869-.205-.492-.413-.425-.567-.433l-.483-.008c-.168 0-.441.063-.672.315-.231.252-.882.861-.882 2.100s.903 2.436 1.029 2.604c.126.168 1.777 2.713 4.305 3.804.602.26 1.072.415 1.439.531.605.192 1.156.165 1.592.1.486-.072 1.488-.609 1.698-1.197.21-.588.21-1.092.147-1.197-.063-.105-.231-.168-.483-.294z"/></svg>
</a>

<!-- Client Javascript -->
<script src="assets/js/script.js"></script>
</body>
</html>
