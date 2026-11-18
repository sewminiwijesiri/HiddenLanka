<?php
/**
 * Hidden Lanka - Site Configuration
 * Central configuration file for site constants, business info, and helper functions.
 */

define('SITE_NAME', 'Hidden Lanka');
define('SITE_TAGLINE', 'Villa Stay, Local Flavors & Island Adventures');
define('OWNER_NAME', 'P H C Kelum');
define('LOCATION', 'Sri Lanka');
define('MAPS_URL', 'https://maps.app.goo.gl/KBzo1JkyCCJR2QMb7');

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hidden_lanka_db');

// Contact Info
define('PHONE_LANDLINE', '041 225 3500');
define('PHONE_MOBILE', '077 070 9899');
define('PHONE_LANDLINE_RAW', '0412253500');
define('PHONE_MOBILE_RAW', '0770709899');
define('WHATSAPP_NUMBER', '077 070 9899');
define('WHATSAPP_BASE_URL', 'https://wa.me/94770709899');
define('EMAIL_ADDRESS', 'Hiddenlankatour@gmail.com');

/**
 * Generate a custom WhatsApp link with pre-filled text
 */
function get_whatsapp_url($message = '') {
    if (empty($message)) {
        return WHATSAPP_BASE_URL;
    }
    return WHATSAPP_BASE_URL . '?text=' . urlencode($message);
}

/**
 * Helper to determine active page state in navbar
 */
function is_active_page($page_file) {
    $current = basename($_SERVER['PHP_SELF'], '.php');
    return ($current === basename($page_file, '.php')) ? 'active' : '';
}
?>
