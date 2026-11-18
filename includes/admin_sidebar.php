<?php
/**
 * Shared Admin Sidebar Panel
 * Displays dashboard navigation menu with dynamic active states and pending approvals count.
 */

// Get the current page name
$current_page = basename($_SERVER['PHP_SELF']);

// Query pending reviews count
$pending_count = 0;
if (isset($db_conn)) {
    $res_pending = $db_conn->query("SELECT COUNT(*) as count FROM reviews WHERE is_approved = 0");
    if ($res_pending) {
        $row_pending = $res_pending->fetch_assoc();
        $pending_count = intval($row_pending['count']);
    }
}

// Current page title mapping for mobile header indicator
$page_titles = [
    'admin.php' => 'Overview',
    'admin_tours.php' => 'Manage Tours',
    'admin_tours_add.php' => 'Add Tour',
    'admin_accommodation.php' => 'Accommodations',
    'admin_accommodation_add.php' => 'Add Accommodation',
    'admin_accommodation_edit.php' => 'Edit Accommodation',
    'admin_gallery.php' => 'Gallery',
    'admin_reviews.php' => 'Guest Reviews',
    'settings.php' => 'Settings'
];
$active_title = $page_titles[$current_page] ?? 'Dashboard';
?>
<!-- Admin Sidebar Panel -->
<aside class="admin-sidebar-card reveal" id="adminSidebar">
    <!-- Mobile Header Bar (Visible on mobile/tablet) -->
    <div class="admin-sidebar-mobile-bar">
        <div class="admin-user-info-mobile">
            <div class="admin-avatar-mini">
                <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
            </div>
            <div>
                <div class="admin-name-mobile"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?> <span class="admin-badge-mobile">Admin</span></div>
                <div class="admin-current-page-tag">📍 <?php echo htmlspecialchars($active_title); ?></div>
            </div>
        </div>
        
        <button type="button" class="admin-menu-toggle-btn" id="adminMenuToggleBtn" aria-expanded="false" aria-label="Toggle Admin Navigation">
            <span class="btn-text">Menu</span>
            <svg class="toggle-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="6 9 12 15 18 9"></polyline>
            </svg>
        </button>
    </div>

    <!-- Desktop User Header (Visible on Desktop) -->
    <div class="admin-sidebar-desktop-header">
        <div class="admin-avatar-lg">
            <svg viewBox="0 0 24 24" width="22" height="22" fill="currentColor"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </div>
        <h3 class="admin-name-desktop"><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></h3>
        <span class="admin-role-desktop">Administrator</span>
    </div>

    <!-- Sidebar Nav Menu (Collapsible on Mobile, always open on Desktop) -->
    <div class="admin-nav-collapse" id="adminNavCollapse">
        <ul class="db-nav">
            <li>
                <a href="admin" class="db-nav-item <?php echo ($current_page == 'admin.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z"/></svg>
                    <span>Dashboard Overview</span>
                </a>
            </li>
            <li>
                <a href="admin_tours" class="db-nav-item <?php echo ($current_page == 'admin_tours.php' || $current_page == 'admin_tours_add.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>
                    <span>Manage Tours</span>
                </a>
            </li>
            <li>
                <a href="admin_accommodation" class="db-nav-item <?php echo ($current_page == 'admin_accommodation.php' || $current_page == 'admin_accommodation_add.php' || $current_page == 'admin_accommodation_edit.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                    <span>Manage Accommodations</span>
                </a>
            </li>
            <li>
                <a href="admin_gallery" class="db-nav-item <?php echo ($current_page == 'admin_gallery.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                    <span>Manage Gallery</span>
                </a>
            </li>
            <li>
                <a href="admin_reviews" class="db-nav-item <?php echo ($current_page == 'admin_reviews.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                    <span>Guest Reviews</span>
                    <?php if ($pending_count > 0): ?>
                        <span class="db-pending-badge"><?php echo $pending_count; ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li>
                <a href="settings" class="db-nav-item <?php echo ($current_page == 'settings.php') ? 'active' : ''; ?>">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M19.14 12.94c.04-.3.06-.61.06-.94 0-.32-.02-.64-.07-.94l2.03-1.58c.18-.14.23-.41.12-.61l-1.92-3.32c-.12-.22-.37-.29-.59-.22l-2.39.96c-.5-.38-1.03-.7-1.62-.94l-.36-2.54c-.04-.24-.24-.41-.48-.41h-3.84c-.24 0-.43.17-.47.41l-.36 2.54c-.59.24-1.13.57-1.62.94l-2.39-.96c-.22-.08-.47 0-.59.22L2.74 8.87c-.12.21-.08.47.12.61l2.03 1.58c-.05.3-.09.63-.09.94s.02.64.07.94l-2.03 1.58c-.18.14-.23.41-.12.61l1.92 3.32c.12.22.37.29.59.22l2.39-.96c.5.38 1.03.7 1.62.94l.36 2.54c.05.24.24.41.48.41h3.84c.24 0 .44-.17.47-.41l.36-2.54c.59-.24 1.13-.56 1.62-.94l2.39.96c.22.08.47 0 .59-.22l1.92-3.32c.12-.22.07-.47-.12-.61l-2.01-1.58zM12 15.6c-1.98 0-3.6-1.62-3.6-3.6s1.62-3.6 3.6-3.6 3.6 1.62 3.6 3.6-1.62 3.6-3.6 3.6z"/></svg>
                    <span>Admin Settings</span>
                </a>
            </li>
            <li>
                <a href="index" class="db-nav-item">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/></svg>
                    <span>View Live Site</span>
                </a>
            </li>
            <li class="db-nav-logout-wrap">
                <a href="login?action=logout" class="db-nav-item db-logout-item">
                    <svg viewBox="0 0 24 24" width="16" height="16" fill="currentColor"><path d="M10.09 15.59L11.5 17l5-5-5-5-1.41 1.41L12.67 11H3v2h9.67l-2.58 2.59zM19 3H5c-1.11 0-2 .9-2 2v4h2V5h14v14H5v-4H3v4c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
                    <span>Secure Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>

