<?php
/**
 * Hidden Lanka - Admin Dashboard
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$pageTitle = 'Admin Dashboard';
$pageDesc = 'Admin control panel for Hidden Lanka.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 85vh; padding: 3rem 0;">
    <div class="container" style="max-width: 1600px; width: 96%;">
        
        <!-- Dashboard Layout Grid (Sidebar + Content) -->
        <div style="display: grid; grid-template-columns: 230px 1fr; gap: 2rem; align-items: start;" class="db-grid">
            
            <!-- Sidebar Panel -->
            <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

            <!-- Dashboard Main Content Panel -->
            <div class="reveal" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Welcome Title Header -->
                <?php require_once __DIR__ . '/includes/admin_header_card.php'; ?>

                <!-- Theme-matching Stats Cards -->
                <div class="stats-grid">
                    
                    <!-- Card 1: Rating (Live Data) -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); border-top: 4px solid var(--color-coral); display: flex; flex-direction: column; gap: 0.5rem; transition: var(--transition); position: relative; overflow: hidden;" class="stat-card">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="currentColor" style="position: absolute; top: 1.5rem; right: 1.5rem; color: rgba(235, 94, 67, 0.06); pointer-events: none;"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                        <span style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Guest Feedback</span>
                        <strong style="font-size: 2.25rem; color: var(--color-teal-dark); font-family: var(--font-heading);"><?php
                            $res_avg = $db_conn->query("SELECT AVG(rating) as avg, COUNT(*) as count FROM reviews WHERE is_approved = 1");
                            $row_avg = $res_avg->fetch_assoc();
                            $avg = $row_avg['avg'] ? round($row_avg['avg'], 1) : '5.0';
                            echo $avg . ' ★';
                        ?></strong>
                        <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: auto;">Approved reviews (<?php echo $row_avg['count']; ?> total)</p>
                    </div>

                    <!-- Card 2: Tours (Live Data) -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); border-top: 4px solid var(--color-teal-medium); display: flex; flex-direction: column; gap: 0.5rem; transition: var(--transition); position: relative; overflow: hidden;" class="stat-card">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="currentColor" style="position: absolute; top: 1.5rem; right: 1.5rem; color: rgba(14, 94, 101, 0.06); pointer-events: none;"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>
                        <span style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Guided Tours</span>
                        <strong style="font-size: 2.25rem; color: var(--color-teal-dark); font-family: var(--font-heading);"><?php
                            $res_t = $db_conn->query("SELECT COUNT(*) as count FROM tours");
                            $tours_row = $res_t->fetch_assoc();
                            echo $tours_row['count'];
                        ?></strong>
                        <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: auto;">Active tour packages</p>
                    </div>

                    <!-- Card 3: Rooms (Live Data) -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); border-top: 4px solid var(--color-teal-main); display: flex; flex-direction: column; gap: 0.5rem; transition: var(--transition); position: relative; overflow: hidden;" class="stat-card">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="currentColor" style="position: absolute; top: 1.5rem; right: 1.5rem; color: rgba(6, 60, 64, 0.06); pointer-events: none;"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                        <span style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Villa Accommodations</span>
                        <strong style="font-size: 2.25rem; color: var(--color-teal-dark); font-family: var(--font-heading);"><?php
                            $res_a = $db_conn->query("SELECT COUNT(*) as count FROM accommodations");
                            $acc_row = $res_a->fetch_assoc();
                            echo $acc_row['count'];
                        ?></strong>
                        <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: auto;">Active accommodations</p>
                    </div>

                    <!-- Card 4: Gallery (Live Data) -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); border-top: 4px solid var(--color-gold); display: flex; flex-direction: column; gap: 0.5rem; transition: var(--transition); position: relative; overflow: hidden;" class="stat-card">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="currentColor" style="position: absolute; top: 1.5rem; right: 1.5rem; color: rgba(217, 171, 85, 0.06); pointer-events: none;"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                        <span style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Gallery Photos</span>
                        <strong style="font-size: 2.25rem; color: var(--color-teal-dark); font-family: var(--font-heading);"><?php
                            $res_g = $db_conn->query("SELECT COUNT(*) as count FROM gallery");
                            $gallery_row = $res_g->fetch_assoc();
                            echo $gallery_row ? $gallery_row['count'] : '0';
                        ?></strong>
                        <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: auto;">Active gallery images</p>
                    </div>

                    <!-- Card 5: Admin Users (Live Data) -->
                    <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); border-top: 4px solid var(--color-gold); display: flex; flex-direction: column; gap: 0.5rem; transition: var(--transition); position: relative; overflow: hidden;" class="stat-card" style="border-top-color: var(--color-teal-medium) !important;">
                        <svg viewBox="0 0 24 24" width="44" height="44" fill="currentColor" style="position: absolute; top: 1.5rem; right: 1.5rem; color: rgba(14, 94, 101, 0.06); pointer-events: none;"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        <span style="font-size: 0.82rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Admin Users</span>
                        <strong style="font-size: 2.25rem; color: var(--color-teal-dark); font-family: var(--font-heading);"><?php
                            $res = $db_conn->query("SELECT COUNT(*) as count FROM admins");
                            $admins_row = $res->fetch_assoc();
                            echo $admins_row['count'];
                        ?></strong>
                        <p style="font-size: 0.88rem; color: var(--color-text-muted); margin-top: auto;">Active login accounts</p>
                    </div>
                </div>

                <!-- Quick Portal shortcuts -->
                <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.25rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); margin-top: 1rem;">
                    <h3 class="heading-md" style="margin-top: 0; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.75rem; margin-bottom: 1.5rem; font-size: 1.25rem; color: var(--color-teal-dark);">Quick Shortcuts Panel</h3>
                    
                    <div class="shortcuts-grid">
                        
                        <!-- Tours Link -->
                        <a href="admin_tours" class="shortcut-card">
                            <div style="width: 44px; height: 44px; background: rgba(14, 94, 101, 0.08); color: var(--color-teal-medium); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>
                            </div>
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--color-teal-dark); font-family: var(--font-body);">Guided Tours</h4>
                                <p style="font-size: 0.78rem; color: var(--color-text-muted); margin-top: 0.15rem;">Add, update, or remove tour packages.</p>
                            </div>
                        </a>

                        <!-- Accommodation Link -->
                        <a href="admin_accommodation" class="shortcut-card">
                            <div style="width: 44px; height: 44px; background: rgba(6, 60, 64, 0.08); color: var(--color-teal-main); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
                            </div>
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--color-teal-dark); font-family: var(--font-body);">Villa Stays</h4>
                                <p style="font-size: 0.78rem; color: var(--color-text-muted); margin-top: 0.15rem;">Manage room packages & descriptions.</p>
                            </div>
                        </a>

                        <!-- Gallery Link -->
                        <a href="admin_gallery" class="shortcut-card">
                            <div style="width: 44px; height: 44px; background: rgba(14, 94, 101, 0.08); color: var(--color-teal-medium); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                            </div>
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--color-teal-dark); font-family: var(--font-body);">Photo Gallery</h4>
                                <p style="font-size: 0.78rem; color: var(--color-text-muted); margin-top: 0.15rem;">Upload new photos and prune database.</p>
                            </div>
                        </a>

                        <!-- Reviews Link -->
                        <a href="admin_reviews" class="shortcut-card">
                            <div style="width: 44px; height: 44px; background: rgba(235, 94, 67, 0.08); color: var(--color-coral); border-radius: 50%; display: flex; align-items: center; justify-content: center; flex-shrink: 0;">
                                <svg viewBox="0 0 24 24" width="20" height="20" fill="currentColor"><path d="M20 2H4c-1.1 0-1.99.9-1.99 2L2 22l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-2 12H6v-2h12v2zm0-3H6V9h12v2zm0-3H6V6h12v2z"/></svg>
                            </div>
                            <div>
                                <h4 style="font-size: 0.95rem; font-weight: 700; margin: 0; color: var(--color-teal-dark); font-family: var(--font-body);">Guest Reviews</h4>
                                <p style="font-size: 0.78rem; color: var(--color-text-muted); margin-top: 0.15rem;">Review submissions and approve feedback.</p>
                            </div>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>
</main>

<!-- CSS Sidebar layout & card hover micro-animations matching the main site theme -->
<style>
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 1.25rem;
    }
    @media (max-width: 1400px) {
        .stats-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }
    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 576px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }

    .db-nav-link:hover {
        background: rgba(255,255,255,0.05);
        color: var(--color-white) !important;
        transform: translateX(4px);
    }
    .db-logout-link:hover {
        background: rgba(235, 94, 67, 0.08);
        transform: translateX(4px);
    }
    .db-nav-link, .db-logout-link {
        transition: var(--transition-fast);
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
    }

    /* Shortcuts panel classes */
    .shortcut-card {
        background: var(--color-white);
        border: 1px solid var(--color-sand-border);
        border-radius: var(--radius-sm);
        padding: 1.25rem;
        display: flex;
        gap: 1rem;
        align-items: center;
        transition: var(--transition);
        text-decoration: none;
    }
    .shortcut-card:hover {
        border-color: var(--color-teal-medium) !important;
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
        background: var(--color-teal-light);
    }

    /* Full-width 4-column shortcuts grid responsive layout */
    .shortcuts-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 1.25rem;
    }
    @media (max-width: 1200px) {
        .shortcuts-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 600px) {
        .shortcuts-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 992px) {
        .db-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
