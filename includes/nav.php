<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/../config.php';

// If this is an admin page, do not render the main site navigation bar at all
if (isset($isAdminPage) && $isAdminPage === true) {
    return;
}
?>
<!-- Header & Navigation Bar -->
<header class="header-site">
    <div class="container">
        <nav class="nav-bar" aria-label="Main Navigation">
            <!-- Brand Logo Image -->
            <a href="index" class="brand-logo-wrap" title="<?php echo SITE_NAME; ?>">
                <img src="assets/images/logo.png" alt="<?php echo SITE_NAME; ?>" style="height: 55px; width: auto; display: block;">
            </a>

            <!-- Desktop Nav Links -->
            <ul class="nav-links">
                <li><a href="index" class="nav-link <?php echo is_active_page('index'); ?>">Home</a></li>
                <li><a href="about" class="nav-link <?php echo is_active_page('about'); ?>">About Us</a></li>
                <li><a href="accommodation" class="nav-link <?php echo is_active_page('accommodation'); ?>">Accommodation</a></li>
                <li><a href="tours" class="nav-link <?php echo is_active_page('tours'); ?>">Tours</a></li>
                <li><a href="service" class="nav-link <?php echo is_active_page('service'); ?>">Services</a></li>
                <li><a href="gallery" class="nav-link <?php echo is_active_page('gallery'); ?>">Gallery</a></li>
                <li><a href="review" class="nav-link <?php echo is_active_page('review'); ?>">Reviews</a></li>
                <li><a href="contact" class="nav-link <?php echo is_active_page('contact'); ?>">Contact</a></li>
                <?php if (isset($_SESSION['admin_logged_in'])): ?>
                    <li><a href="admin" class="nav-link <?php echo is_active_page('admin'); ?>" style="color: var(--color-gold); font-weight: 700;">Dashboard</a></li>
                    <li><a href="login?action=logout" class="btn-logout-nav">Logout</a></li>
                <?php endif; ?>
            </ul>

            <!-- Header Action CTA -->
            <div class="nav-actions">
                <!-- Mobile Hamburger Button -->
                <button class="menu-toggle" aria-label="Toggle Navigation Menu" aria-expanded="false">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                </button>
            </div>
        </nav>
    </div>

    <!-- Mobile Drawer Menu -->
    <div class="mobile-nav">
        <ul class="mobile-nav-links">
            <li><a href="index" class="mobile-nav-link <?php echo is_active_page('index'); ?>">Home <span>&rarr;</span></a></li>
            <li><a href="about" class="mobile-nav-link <?php echo is_active_page('about'); ?>">About Us <span>&rarr;</span></a></li>
            <li><a href="accommodation" class="mobile-nav-link <?php echo is_active_page('accommodation'); ?>">Accommodation <span>&rarr;</span></a></li>
            <li><a href="tours" class="mobile-nav-link <?php echo is_active_page('tours'); ?>">Tours <span>&rarr;</span></a></li>
            <li><a href="service" class="mobile-nav-link <?php echo is_active_page('service'); ?>">Services <span>&rarr;</span></a></li>
            <li><a href="gallery" class="mobile-nav-link <?php echo is_active_page('gallery'); ?>">Gallery <span>&rarr;</span></a></li>
            <li><a href="review" class="mobile-nav-link <?php echo is_active_page('review'); ?>">Reviews <span>&rarr;</span></a></li>
            <li><a href="contact" class="mobile-nav-link <?php echo is_active_page('contact'); ?>">Contact <span>&rarr;</span></a></li>
            <?php if (isset($_SESSION['admin_logged_in'])): ?>
                <li><a href="admin" class="mobile-nav-link <?php echo is_active_page('admin'); ?>" style="color: var(--color-gold); font-weight: 700;">Dashboard <span>&rarr;</span></a></li>
                <li><a href="login?action=logout" class="btn-logout-nav" style="display: flex; width: 100%; text-align: center; justify-content: center; margin-top: 0.5rem;">Logout</a></li>
            <?php endif; ?>
        </ul>
        <a href="<?php echo get_whatsapp_url('Hi Kelum, I am interested in visiting Hidden Lanka!'); ?>" class="btn btn-whatsapp" style="width: 100%; text-align: center; justify-content: center;" target="_blank" rel="noopener">
            WhatsApp Direct Chat
        </a>
    </div>
</header>
