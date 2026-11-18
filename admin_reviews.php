<?php
/**
 * Hidden Lanka - Admin Reviews Moderation
 */
session_start();
require_once __DIR__ . '/includes/db.php';

// Security Check: Redirect to login if not authenticated
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$success_msg = '';
$error_msg = '';

// Handle Moderation Actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = intval($_POST['review_id'] ?? 0);
    $action = $_POST['action'] ?? '';
    
    if ($review_id > 0) {
        if ($action === 'approve') {
            $stmt = $db_conn->prepare("UPDATE reviews SET is_approved = 1 WHERE id = ?");
            $stmt->bind_param("i", $review_id);
            if ($stmt->execute()) {
                $success_msg = "Review approved and published successfully!";
            } else {
                $error_msg = "Failed to approve review.";
            }
            $stmt->close();
        } elseif ($action === 'delete') {
            $stmt = $db_conn->prepare("DELETE FROM reviews WHERE id = ?");
            $stmt->bind_param("i", $review_id);
            if ($stmt->execute()) {
                $success_msg = "Review deleted successfully!";
            } else {
                $error_msg = "Failed to delete review.";
            }
            $stmt->close();
        }
    }
}

// Fetch All Reviews
$stmt_all = $db_conn->prepare("SELECT * FROM reviews ORDER BY created_at DESC");
$stmt_all->execute();
$reviews_result = $stmt_all->get_result();

$pending_count = 0;
$all_reviews = [];
while ($row = $reviews_result->fetch_assoc()) {
    if ($row['is_approved'] == 0) {
        $pending_count++;
    }
    $all_reviews[] = $row;
}
$stmt_all->close();

$pageTitle = 'Moderation Panel';
$pageDesc = 'Moderate and publish user-submitted reviews.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg); min-height: 85vh; padding: 3rem 0;">
    <div class="container" style="max-width: 1600px; width: 96%;">
        
        <!-- Dashboard Layout Grid (Sidebar + Content) -->
        <div style="display: grid; grid-template-columns: 230px 1fr; gap: 2rem; align-items: start;" class="db-grid">
            
            <!-- Sidebar Panel (Reviews link active) -->
            <?php require_once __DIR__ . '/includes/admin_sidebar.php'; ?>

            <!-- Content Panel -->
            <div class="reveal" style="display: flex; flex-direction: column; gap: 2rem;">
                
                <!-- Welcome Title Header -->
                <?php require_once __DIR__ . '/includes/admin_header_card.php'; ?>
                
                <!-- Notification Alert Messages -->
                <?php if (!empty($success_msg)): ?>
                    <div style="background: var(--color-teal-light); border-left: 4px solid var(--color-teal-main); color: var(--color-teal-dark); padding: 1rem 1.25rem; border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 600;">
                        <?php echo $success_msg; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($error_msg)): ?>
                    <div style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1rem 1.25rem; border-radius: var(--radius-sm); font-size: 0.9rem; font-weight: 600;">
                        <?php echo $error_msg; ?>
                    </div>
                <?php endif; ?>

                <!-- Section: Guest Reviews Management Table -->
                <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 2.5rem 2rem; border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm);">
                    <div class="db-card-header" style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap; gap: 0.75rem;">
                        <div>
                            <h2 class="heading-sm" style="color: var(--color-teal-dark); margin: 0;">Guest Reviews Moderation</h2>
                            <p style="color: var(--color-text-muted); font-size: 0.85rem; margin-top: 0.15rem;">Manage all guest submissions, moderate pending reviews, and remove published feedback in one place.</p>
                        </div>
                        <div style="display: flex; gap: 0.5rem; align-items: center;">
                            <span style="background: var(--color-teal-main); color: var(--color-white); font-weight: 700; font-size: 0.8rem; padding: 0.25rem 0.75rem; border-radius: var(--radius-full);"><?php echo count($all_reviews); ?> Total</span>
                            <?php if ($pending_count > 0): ?>
                                <span style="background: var(--color-coral); color: var(--color-white); font-weight: 700; font-size: 0.8rem; padding: 0.25rem 0.75rem; border-radius: var(--radius-full);"><?php echo $pending_count; ?> Pending</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if (count($all_reviews) > 0): ?>
                        <div style="overflow-x: auto;">
                            <table class="db-table">
                                <thead>
                                    <tr>
                                        <th>Guest</th>
                                        <th>Location</th>
                                        <th>Type</th>
                                        <th>Rating</th>
                                        <th>Review Details</th>
                                        <th>Status</th>
                                        <th style="text-align: right; padding-right: 1.5rem;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($all_reviews as $r): ?>
                                        <tr>
                                            <td style="font-weight: 700; color: var(--color-teal-dark); white-space: nowrap;"><?php echo htmlspecialchars($r['name']); ?></td>
                                            <td style="color: var(--color-text-muted); font-size: 0.85rem; white-space: nowrap;"><?php echo htmlspecialchars($r['country'] ?: 'N/A'); ?></td>
                                            <td>
                                                <?php if (($r['review_type'] ?? 'general') === 'wedding'): ?>
                                                    <span style="background: rgba(212, 175, 55, 0.15); color: var(--color-gold); font-weight: 700; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: var(--radius-full); white-space: nowrap; display: inline-block;">Wedding</span>
                                                <?php else: ?>
                                                    <span style="background: var(--color-teal-light); color: var(--color-teal-dark); font-weight: 700; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: var(--radius-full); white-space: nowrap; display: inline-block;">General</span>
                                                <?php endif; ?>
                                            </td>
                                            <td style="color: var(--color-gold); font-size: 0.88rem; white-space: nowrap;">
                                                <?php echo str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']); ?>
                                            </td>
                                            <td>
                                                <?php if (!empty($r['title'])): ?>
                                                    <strong style="display: block; color: var(--color-teal-medium); font-size: 0.88rem; margin-bottom: 0.15rem;">"<?php echo htmlspecialchars($r['title']); ?>"</strong>
                                                <?php endif; ?>
                                                <span style="color: var(--color-text-muted); font-size: 0.85rem;"><?php echo htmlspecialchars(substr($r['content'], 0, 100)) . (strlen($r['content']) > 100 ? '...' : ''); ?></span>
                                            </td>
                                            <td>
                                                <?php if ($r['is_approved'] == 1): ?>
                                                    <span style="background: var(--color-teal-main); color: var(--color-white); font-weight: 700; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: var(--radius-full); white-space: nowrap; display: inline-block;">Approved</span>
                                                <?php else: ?>
                                                    <span style="background: var(--color-coral); color: var(--color-white); font-weight: 700; font-size: 0.75rem; padding: 0.25rem 0.6rem; border-radius: var(--radius-full); white-space: nowrap; display: inline-block;">Pending</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 0.5rem; justify-content: flex-end; align-items: center;">
                                                    <button type="button" onclick='showReviewDetails(<?php echo json_encode($r, JSON_HEX_APOS | JSON_HEX_QUOT); ?>)' class="btn-view-icon" style="background: none; border: none; cursor: pointer; color: var(--color-teal-medium); display: flex; align-items: center; justify-content: center; padding: 0.45rem; border-radius: 50%; transition: var(--transition-fast);" title="View Full Review">
                                                        <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                    </button>
                                                    
                                                    <?php if ($r['is_approved'] == 0): ?>
                                                        <form action="admin_reviews.php" method="POST" style="margin: 0;">
                                                            <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="btn btn-secondary" style="padding: 0.4rem 0.85rem; font-size: 0.78rem; border-radius: var(--radius-sm);">Approve</button>
                                                        </form>
                                                    <?php endif; ?>
                                                    
                                                    <form action="admin_reviews.php" method="POST" style="margin: 0;" onsubmit="return confirm('Are you sure you want to delete this review permanently?');">
                                                        <input type="hidden" name="review_id" value="<?php echo $r['id']; ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="btn btn-secondary" style="padding: 0.4rem 0.85rem; font-size: 0.78rem; border-radius: var(--radius-sm); <?php echo $r['is_approved'] == 1 ? 'background-color: transparent; border-color: var(--color-coral); color: var(--color-coral);' : 'background-color: var(--color-coral); border-color: var(--color-coral); color: var(--color-white);'; ?>" <?php if ($r['is_approved'] == 1): ?>onmouseover="this.style.backgroundColor='var(--color-coral)'; this.style.color='#fff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='var(--color-coral)';"<?php endif; ?>><?php echo $r['is_approved'] == 1 ? 'Remove' : 'Delete'; ?></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p style="color: var(--color-text-muted); font-size: 0.9rem; text-align: center; padding: 2rem 0;">No guest reviews have been submitted yet.</p>
                    <?php endif; ?>
                </div>

            </div>

        </div>

    </div>
</main>

<style>
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
    .btn:hover {
        transform: translateY(-2px);
    }
    
    .btn-view-icon:hover {
        background-color: var(--color-sand-border);
        color: var(--color-teal-dark);
    }
    
    /* Table Styling */
    .db-table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 0.5rem;
        font-size: 0.88rem;
        text-align: left;
    }
    .db-table th {
        background-color: var(--color-teal-dark);
        color: var(--color-white);
        padding: 0.95rem 1.1rem;
        font-weight: 700;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        font-size: 0.78rem;
    }
    .db-table th:first-child {
        border-top-left-radius: var(--radius-sm);
        border-bottom-left-radius: var(--radius-sm);
    }
    .db-table th:last-child {
        border-top-right-radius: var(--radius-sm);
        border-bottom-right-radius: var(--radius-sm);
    }
    .db-table td {
        padding: 1.1rem;
        border-bottom: 1px solid var(--color-sand-border);
        color: var(--color-text-dark);
        vertical-align: middle;
    }
    .db-table tr:last-child td {
        border-bottom: none;
    }
    .db-table tr {
        transition: var(--transition-fast);
    }
    .db-table tr:hover {
        background-color: var(--color-teal-light);
    }

    /* Modal Overlay styling */
    .modal-overlay {
        position: fixed;
        top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(4, 36, 40, 0.75);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        z-index: 10000;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }
    
    .modal-overlay.active {
        opacity: 1;
        visibility: visible;
    }
    
    .modal-content-card {
        background: var(--color-white);
        border-radius: var(--radius-md);
        width: 92%;
        max-width: 600px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: var(--shadow-lg);
        border: 1px solid var(--color-sand-border);
        transform: scale(0.9);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 3rem 2.5rem;
    }
    
    .modal-overlay.active .modal-content-card {
        transform: scale(1);
    }
    
    .modal-close-btn {
        position: absolute;
        top: 1rem;
        right: 1.25rem;
        background: transparent;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: var(--color-text-muted);
        line-height: 1;
        transition: var(--transition-fast);
    }
    
    .modal-close-btn:hover {
        color: var(--color-coral);
        transform: scale(1.1);
    }

    @media (max-width: 992px) {
        .db-grid {
            grid-template-columns: 1fr !important;
            gap: 2rem !important;
        }
    }
</style>

<!-- Review Details View Modal -->
<div id="view-review-modal" class="modal-overlay">
    <div class="modal-content-card">
        <button class="modal-close-btn" onclick="closeViewModal()">&times;</button>
        <div style="margin-bottom: 1.5rem; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 1rem;">
            <div id="modal-view-stars" style="color: var(--color-gold); font-size: 1.1rem; margin-bottom: 0.4rem;"></div>
            <h3 id="modal-view-name" class="heading-sm" style="color: var(--color-teal-dark); margin: 0; font-size: 1.3rem;"></h3>
            <span id="modal-view-meta" style="font-size: 0.82rem; color: var(--color-text-muted); display: block; margin-top: 0.2rem;"></span>
        </div>
        <div>
            <h4 id="modal-view-title" style="color: var(--color-teal-medium); font-size: 1.05rem; margin-bottom: 0.6rem; font-weight: 700;"></h4>
            <p id="modal-view-content" style="color: var(--color-text-muted); font-size: 0.95rem; line-height: 1.6; margin: 0; white-space: pre-wrap;"></p>
        </div>
    </div>
</div>

<script>
function showReviewDetails(review) {
    const modal = document.getElementById('view-review-modal');
    
    // Set text elements
    document.getElementById('modal-view-name').textContent = review.name;
    
    let metaText = '';
    if (review.country) metaText += review.country;
    if (review.trip_type) metaText += (metaText ? ' • ' : '') + review.trip_type;
    const typeLabel = (review.review_type === 'wedding') ? 'Wedding Review' : 'General Review';
    metaText += (metaText ? ' • ' : '') + typeLabel;
    metaText += (metaText ? ' • ' : '') + 'Submitted: ' + review.created_at;
    document.getElementById('modal-view-meta').textContent = metaText;
    
    // Set stars row
    const rating = parseInt(review.rating);
    document.getElementById('modal-view-stars').textContent = '★'.repeat(rating) + '☆'.repeat(5 - rating);
    
    // Set title and content
    const titleEl = document.getElementById('modal-view-title');
    if (review.title && review.title.trim() !== '') {
        titleEl.textContent = '"' + review.title + '"';
        titleEl.style.display = 'block';
    } else {
        titleEl.style.display = 'none';
    }
    
    document.getElementById('modal-view-content').textContent = review.content;
    
    // Show modal & prevent background scroll
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeViewModal() {
    const modal = document.getElementById('view-review-modal');
    modal.classList.remove('active');
    document.body.style.overflow = '';
}

// Close modal when clicking outside card
document.getElementById('view-review-modal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeViewModal();
    }
});
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
