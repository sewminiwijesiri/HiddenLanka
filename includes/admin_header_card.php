<?php
/**
 * Shared Admin Welcome / Header Card
 * Rendered at the top of the main content column in all admin dashboard views.
 */

// Determine welcome banner texts dynamically based on page
$current_filename = basename($_SERVER['PHP_SELF']);

$banner_badge = "Overview Dashboard";
$banner_title = "Welcome Back, " . htmlspecialchars($_SESSION['admin_username'] ?? 'Admin');
$banner_desc = "Here is a summary of the site status and active systems.";

if ($current_filename === 'admin_tours.php') {
    $banner_badge = "Tours Configuration";
    $banner_title = "Manage Guided Tours";
    $banner_desc = "Add, edit, update, or remove coastal and inland tour packages.";
} elseif ($current_filename === 'admin_tours_add.php') {
    $banner_badge = "Tours Creation";
    $banner_title = "Add New Tour Package";
    $banner_desc = "Create a new guided tour listing with custom photos and routes.";
} elseif ($current_filename === 'admin_accommodation.php') {
    $banner_badge = "Accommodation Settings";
    $banner_title = "Manage Villa Rooms";
    $banner_desc = "Update room status, pricing, details, and photos.";
} elseif ($current_filename === 'admin_accommodation_add.php') {
    $banner_badge = "Room Creation";
    $banner_title = "Add New Room Type";
    $banner_desc = "Create a new villa suite or guest room listing.";
} elseif ($current_filename === 'admin_accommodation_edit.php') {
    $banner_badge = "Room Modification";
    $banner_title = "Edit Room Details";
    $banner_desc = "Modify pricing, features, or content for this room.";
} elseif ($current_filename === 'admin_reviews.php') {
    $banner_badge = "Reviews Moderation";
    $banner_title = "Moderate Guest Reviews";
    $banner_desc = "Approve pending reviews or remove guest feedback entries.";
} elseif ($current_filename === 'settings.php') {
    $banner_badge = "System Settings";
    $banner_title = "Global Site Configuration";
    $banner_desc = "Update contact details, social media links, and passwords.";
} elseif ($current_filename === 'admin_gallery.php') {
    $banner_badge = "Gallery Configurations";
    $banner_title = "Manage Photo Gallery";
    $banner_desc = "Upload and delete photos to showcase your guesthouse & tours.";
}
?>

<div class="admin-header-card" style="background: var(--color-teal-dark); border-radius: var(--radius-md); padding: 1.75rem 2rem; border: 1px solid rgba(255,255,255,0.06); box-shadow: var(--shadow-sm); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.25rem; color: var(--color-white); margin-bottom: 2rem;">
    <div class="admin-header-text">
        <span class="badge-sub" style="margin-bottom: 0.35rem; background: rgba(255, 255, 255, 0.08); color: var(--color-gold); font-size: 0.72rem; padding: 0.25rem 0.65rem; border: 1px solid rgba(217, 171, 85, 0.2); font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; border-radius: var(--radius-full); display: inline-block;"><?php echo $banner_badge; ?></span>
        <h1 class="heading-md admin-header-title" style="margin: 0; color: var(--color-white); font-size: 1.65rem;"><?php echo $banner_title; ?></h1>
        <p class="admin-header-desc" style="color: rgba(255, 255, 255, 0.7); font-size: 0.88rem; margin-top: 0.25rem;"><?php echo $banner_desc; ?></p>
    </div>
    <div class="admin-header-actions">
        <a href="login?action=logout" style="background: var(--color-coral); color: var(--color-white); border-radius: var(--radius-sm); padding: 0.6rem 1.25rem; font-size: 0.85rem; font-weight: 700; display: inline-flex; align-items: center; gap: 0.5rem; transition: var(--transition-fast); border: 1px solid var(--color-coral); text-decoration: none;" onmouseover="this.style.background='var(--color-coral-hover)'; this.style.borderColor='var(--color-coral-hover)';" onmouseout="this.style.background='var(--color-coral)'; this.style.borderColor='var(--color-coral)';" class="btn-logout-header">
            <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
            Logout
        </a>
    </div>
</div>
