<?php
/**
 * Hidden Lanka - Guest Reviews & Testimonials
 */
session_start();
require_once __DIR__ . '/includes/db.php';

$success_msg = '';
$error_msg = '';

// Handle review submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_review'])) {
    $name = trim($_POST['reviewer_name'] ?? '');
    $rating = intval($_POST['review_rating'] ?? 5);
    $title = trim($_POST['review_title'] ?? '');
    $content = trim($_POST['review_content'] ?? '');
    $country = trim($_POST['reviewer_country'] ?? '');
    $trip_type = trim($_POST['reviewer_trip_type'] ?? '');
    $review_type = trim($_POST['review_type'] ?? 'general');

    if ($review_type !== 'wedding') {
        $review_type = 'general';
    }

    if ($rating < 1)
        $rating = 1;
    if ($rating > 5)
        $rating = 5;

    if (!empty($name) && !empty($content)) {
        // Calculate initials
        $words = explode(' ', $name);
        $initials = '';
        if (count($words) > 0 && !empty($words[0])) {
            $initials .= strtoupper(substr($words[0], 0, 1));
        }
        if (count($words) > 1 && !empty($words[1])) {
            $initials .= strtoupper(substr($words[1], 0, 1));
        } else {
            $initials .= strtoupper(substr($name, 1, 1));
        }
        $initials = substr(trim($initials), 0, 2);
        if (empty($initials))
            $initials = 'G';

        $stmt_ins = $db_conn->prepare("INSERT INTO reviews (name, rating, title, content, avatar_initials, country, trip_type, review_type, is_approved) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 0)");
        $stmt_ins->bind_param("sissssss", $name, $rating, $title, $content, $initials, $country, $trip_type, $review_type);
        if ($stmt_ins->execute()) {
            $success_msg = "Thank you! Your review has been submitted for moderation. It will appear on the site once approved by the administrator.";
        } else {
            $error_msg = "Error submitting review. Please try again later.";
        }
        $stmt_ins->close();
    } else {
        $error_msg = "Please fill in all required fields (Name, Review Title, and Review Content).";
    }
}

// Fetch approved reviews from database
$stmt = $db_conn->prepare("SELECT * FROM reviews WHERE is_approved = 1 ORDER BY created_at DESC");
$stmt->execute();
$reviews_result = $stmt->get_result();

$reviews_general = [];
$reviews_wedding = [];
while ($r = $reviews_result->fetch_assoc()) {
    if (($r['review_type'] ?? 'general') === 'wedding') {
        $reviews_wedding[] = $r;
    } else {
        $reviews_general[] = $r;
    }
}
$stmt->close();

$pageTitle = 'Guest Reviews & Testimonials';
$pageDesc = 'Read authentic reviews from guests who stayed at Hidden Lanka in Sri Lanka. Rated 4.9/5 for host hospitality, home food, tours, and vehicle rentals.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Banner -->
    <section class="hero-section" style="position: relative; background: url('assets/images/tours/tour-ella.jpg') no-repeat center center/cover; padding: 5rem 0 5.5rem; overflow: hidden; color: var(--color-white);">
        <!-- Deep Teal Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.60) 100%); z-index: 1;"></div>
        
        <div class="container text-center" style="position: relative; z-index: 2; text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Verified Guest Stories</span>
            <h1 class="heading-xl hero-title" style="background: linear-gradient(135deg, var(--color-white) 40%, var(--color-gold) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; text-shadow: none;">Guest Reviews</h1>
            <p class="lead-text" style="color: var(--color-white); margin: 0 auto; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85);">See what travelers from around the world say about their experience at Hidden Lanka.</p>
        </div>
    </section>

    <!-- Overall Rating Summary -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="review-summary-banner">
                <div class="rating-big-box">
                    <div class="rating-score">4.9</div>
                    <div class="stars-row">★★★★★</div>
                    <p style="font-size: 0.9rem; color: rgba(255,255,255,0.85); font-weight: 600;">Based on 120+ Guest
                        Reviews</p>
                </div>

                <div>
                    <h3 class="heading-md" style="color: var(--color-white); margin-bottom: 1rem;">Experience Rating
                        Breakdown</h3>
                    <div class="rating-breakdown-grid">
                        <div>
                            <span style="font-size: 0.85rem; color: rgba(255,255,255,0.8);">Host Hospitality &
                                Warmth</span>
                            <div style="font-size: 1.1rem; font-weight: 700; color: var(--color-gold);">5.0 / 5.0 ★★★★★
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 0.85rem; color: rgba(255,255,255,0.8);">Home-Cooked Food</span>
                            <div style="font-size: 1.1rem; font-weight: 700; color: var(--color-gold);">4.9 / 5.0 ★★★★★
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 0.85rem; color: rgba(255,255,255,0.8);">Tuk Tuk & Bike
                                Condition</span>
                            <div style="font-size: 1.1rem; font-weight: 700; color: var(--color-gold);">4.9 / 5.0 ★★★★★
                            </div>
                        </div>
                        <div>
                            <span style="font-size: 0.85rem; color: rgba(255,255,255,0.8);">Guided Tour
                                Experience</span>
                            <div style="font-size: 1.1rem; font-weight: 700; color: var(--color-gold);">5.0 / 5.0 ★★★★★
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Messages banners -->
            <?php if (!empty($success_msg)): ?>
                <div id="leave-review-status"
                    style="background: var(--color-teal-light); border-left: 4px solid var(--color-teal-main); color: var(--color-teal-dark); padding: 1.2rem; border-radius: var(--radius-sm); margin-bottom: 2rem; font-size: 0.95rem; font-weight: 600; text-align: center; box-shadow: var(--shadow-sm);">
                    <?php echo $success_msg; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($error_msg)): ?>
                <div id="leave-review-status"
                    style="background: rgba(235, 94, 67, 0.1); border-left: 4px solid var(--color-coral); color: #b7321a; padding: 1.2rem; border-radius: var(--radius-sm); margin-bottom: 2rem; font-size: 0.95rem; font-weight: 600; text-align: center; box-shadow: var(--shadow-sm);">
                    <?php echo $error_msg; ?>
                </div>
            <?php endif; ?>

            <!-- Tabs Navigation -->
            <div class="reviews-tabs-nav" style="display: flex; justify-content: center; gap: 1rem; margin-bottom: 3rem; border-bottom: 2px solid var(--color-sand-border); padding-bottom: 0.75rem;">
                <button class="review-tab-btn active" onclick="switchReviewTab('general')" id="tab-btn-general" style="background: none; border: none; padding: 0.75rem 1.5rem; font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--color-text-muted); cursor: pointer; border-radius: var(--radius-sm); transition: all 0.3s ease; position: relative;">
                    Villa Stay & Tours
                </button>
                <button class="review-tab-btn" onclick="switchReviewTab('wedding')" id="tab-btn-wedding" style="background: none; border: none; padding: 0.75rem 1.5rem; font-family: var(--font-heading); font-size: 1.1rem; font-weight: 700; color: var(--color-text-muted); cursor: pointer; border-radius: var(--radius-sm); transition: all 0.3s ease; position: relative;">
                    Village Weddings
                </button>
            </div>

            <!-- Villa Stay Reviews Grid -->
            <div id="reviews-container-general" class="reviews-tab-content">
                <div class="grid-3">
                    <?php if (count($reviews_general) > 0): ?>
                        <?php foreach ($reviews_general as $r): ?>
                            <div class="review-card">
                                <div class="stars-row" style="justify-content: flex-start;">
                                    <?php echo str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']); ?>
                                </div>
                                <?php if (!empty($r['title'])): ?>
                                    <h4 style="font-size: 1.1rem; color: var(--color-teal-dark);">
                                        "<?php echo htmlspecialchars($r['title']); ?>"</h4>
                                <?php endif; ?>
                                <p style="color: var(--color-text-muted); font-size: 0.95rem;">
                                    "<?php echo htmlspecialchars($r['content']); ?>"
                                </p>
                                <div class="reviewer-meta" style="margin-top: auto;">
                                    <div class="reviewer-avatar"><?php echo htmlspecialchars($r['avatar_initials'] ?: 'G'); ?></div>
                                    <div class="reviewer-info">
                                        <h4><?php echo htmlspecialchars($r['name']); ?></h4>
                                        <p>
                                            <?php
                                            $loc = [];
                                            if ($r['country'])
                                                $loc[] = htmlspecialchars($r['country']);
                                            if ($r['trip_type'])
                                                $loc[] = htmlspecialchars($r['trip_type']);
                                            echo implode(' • ', $loc);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1/-1; text-align: center; color: var(--color-text-muted); font-size: 1.1rem; padding: 3rem 0; width: 100%;">
                            No villa stay reviews posted yet. Be the first to share your experience!</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Wedding Reviews Grid -->
            <div id="reviews-container-wedding" class="reviews-tab-content" style="display: none;">
                <div class="grid-3">
                    <?php if (count($reviews_wedding) > 0): ?>
                        <?php foreach ($reviews_wedding as $r): ?>
                            <div class="review-card">
                                <div class="stars-row" style="justify-content: flex-start;">
                                    <?php echo str_repeat('★', $r['rating']) . str_repeat('☆', 5 - $r['rating']); ?>
                                </div>
                                <?php if (!empty($r['title'])): ?>
                                    <h4 style="font-size: 1.1rem; color: var(--color-teal-dark);">
                                        "<?php echo htmlspecialchars($r['title']); ?>"</h4>
                                <?php endif; ?>
                                <p style="color: var(--color-text-muted); font-size: 0.95rem;">
                                    "<?php echo htmlspecialchars($r['content']); ?>"
                                </p>
                                <div class="reviewer-meta" style="margin-top: auto;">
                                    <div class="reviewer-avatar"><?php echo htmlspecialchars($r['avatar_initials'] ?: 'W'); ?></div>
                                    <div class="reviewer-info">
                                        <h4><?php echo htmlspecialchars($r['name']); ?></h4>
                                        <p>
                                            <?php
                                            $loc = [];
                                            if ($r['country'])
                                                $loc[] = htmlspecialchars($r['country']);
                                            if ($r['trip_type'])
                                                $loc[] = htmlspecialchars($r['trip_type']);
                                            echo implode(' • ', $loc);
                                            ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p style="grid-column: 1/-1; text-align: center; color: var(--color-text-muted); font-size: 1.1rem; padding: 3rem 0; width: 100%;">
                            No wedding reviews posted yet. Be the first to share your experience!</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <!-- Write a Review CTA Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-card); padding: 4.5rem 0;">
        <div class="container text-center">
            <div class="cta-banner"
                style="background: linear-gradient(135deg, var(--color-teal-dark) 0%, #063236 100%); padding: 3.5rem 2rem; border-radius: var(--radius-md); box-shadow: var(--shadow-md);">
                <h2 style="color: var(--color-white); margin-bottom: 0.5rem; font-family: var(--font-heading);">Stayed
                    with Us Recently?</h2>
                <p
                    style="color: rgba(255,255,255,0.85); max-width: 600px; margin: 0 auto 2.25rem; font-size: 1rem; line-height: 1.6;">
                    We love hearing from our guests! Share your experience directly on our site or submit via WhatsApp.
                </p>
                <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
                    <button onclick="openReviewModal()" class="btn"
                        style="background-color: var(--color-gold); border-color: var(--color-gold); color: var(--color-white); font-weight: 700; padding: 0.8rem 2rem; border-radius: var(--radius-sm); cursor: pointer; transition: var(--transition-fast);">Write
                        a Review Here</button>
                    <a href="<?php echo get_whatsapp_url('Hi Kelum! I recently stayed at Hidden Lanka and would like to leave a review: '); ?>"
                        class="btn btn-whatsapp" style="padding: 0.8rem 2rem; border-radius: var(--radius-sm);"
                        target="_blank" rel="noopener">
                        Submit via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Popup Review Form -->
    <div id="review-modal" class="modal-overlay">
        <div class="modal-content-card">
            <button class="modal-close-btn" onclick="closeReviewModal()" aria-label="Close Form">&times;</button>

            <div style="text-align: center; margin-bottom: 2rem;">
                <span class="badge-sub"
                    style="background: var(--color-teal-light); color: var(--color-teal-main); font-size: 0.75rem; padding: 0.25rem 0.65rem; border-radius: var(--radius-full);">Guest
                    Feedback</span>
                <h2 class="heading-md"
                    style="color: var(--color-teal-dark); margin: 0.5rem 0 0.25rem; font-size: 1.5rem;">Write a Guest
                    Review</h2>
                <p style="color: var(--color-text-muted); font-size: 0.88rem;">Tell us about your stay, meal, tour, or
                    rental experience at Hidden Lanka.</p>
            </div>

            <form action="review.php" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
                <input type="hidden" name="submit_review" value="1">

                <div class="form-grid-2">
                    <div>
                        <label for="reviewer_name"
                            style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Your
                            Name *</label>
                        <input type="text" id="reviewer_name" name="reviewer_name" required
                            placeholder="e.g. Sophie Lars"
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                    </div>
                    <div>
                        <label for="review_rating"
                            style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Rating
                            *</label>
                        <select id="review_rating" name="review_rating" required
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast); cursor: pointer;">
                            <option value="5">5 Stars (Excellent)</option>
                            <option value="4">4 Stars (Good)</option>
                            <option value="3">3 Stars (Average)</option>
                            <option value="2">2 Stars (Poor)</option>
                            <option value="1">1 Star (Very Poor)</option>
                        </select>
                    </div>
                </div>

                <div class="form-grid-2">
                    <div>
                        <label for="reviewer_country"
                            style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Country
                            / Home Town</label>
                        <input type="text" id="reviewer_country" name="reviewer_country" placeholder="e.g. Sweden"
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast);">
                    </div>
                    <div>
                        <label for="review_type"
                            style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Review Type *</label>
                        <select id="review_type" name="review_type" required
                            style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast); cursor: pointer;">
                            <option value="general">Villa Stay & General</option>
                            <option value="wedding">Traditional Village Wedding</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="review_content"
                        style="display: block; font-size: 0.85rem; font-weight: 700; color: var(--color-teal-dark); margin-bottom: 0.4rem;">Your
                        Review *</label>
                    <textarea id="review_content" name="review_content" required rows="4"
                        placeholder="Share the details of your experience staying with us or renting our vehicles..."
                        style="width: 100%; padding: 0.75rem 1rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); background-color: var(--color-sand-bg); font-family: var(--font-body); font-size: 0.9rem; color: var(--color-text-dark); outline: none; transition: var(--transition-fast); resize: vertical;"></textarea>
                </div>

                <button type="submit" class="btn btn-secondary"
                    style="width: 100%; justify-content: center; margin-top: 0.5rem; padding: 0.8rem 1.5rem; border-radius: var(--radius-sm);">Submit
                    Review for Approval</button>
            </form>
        </div>
    </div>
</main>

<style>
    /* Modal Styles */
    .modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(4, 36, 39, 0.75);
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
        max-width: 680px;
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

    input:focus,
    select:focus,
    textarea:focus {
        border-color: var(--color-teal-medium) !important;
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.15);
        background-color: var(--color-white) !important;
    }

    @media (max-width: 576px) {
        .modal-content-card {
            padding: 2rem 1.5rem;
        }
    }

    /* Tabs Styles */
    .review-tab-btn {
        position: relative;
    }
    .review-tab-btn::after {
        content: '';
        position: absolute;
        bottom: -0.85rem;
        left: 0;
        width: 100%;
        height: 3px;
        background-color: var(--color-teal-main);
        transform: scaleX(0);
        transition: transform 0.3s ease;
    }
    .review-tab-btn.active {
        color: var(--color-teal-dark) !important;
    }
    .review-tab-btn.active::after {
        transform: scaleX(1);
    }
    .review-tab-btn:hover {
        color: var(--color-teal-medium);
    }

    .reviews-tab-content .grid-3 {
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    }
</style>

<script>
    function openReviewModal() {
        const modal = document.getElementById('review-modal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden'; // Lock background scroll
    }

    function closeReviewModal() {
        const modal = document.getElementById('review-modal');
        modal.classList.remove('active');
        document.body.style.overflow = ''; // Restore background scroll
    }

    function switchReviewTab(type) {
        // Toggle active states on buttons
        document.querySelectorAll('.review-tab-btn').forEach(btn => btn.classList.remove('active'));
        document.getElementById('tab-btn-' + type).classList.add('active');

        // Toggle active display on content containers
        const genContainer = document.getElementById('reviews-container-general');
        const wedContainer = document.getElementById('reviews-container-wedding');

        if (type === 'wedding') {
            genContainer.style.display = 'none';
            wedContainer.style.display = 'block';
        } else {
            genContainer.style.display = 'block';
            wedContainer.style.display = 'none';
        }
    }

    // Open modal if page URL indicates review submission action
    window.addEventListener('DOMContentLoaded', () => {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('write') === '1' || window.location.hash === '#write-review') {
            setTimeout(openReviewModal, 300);
        }

        // Wire site-wide floating review button to trigger popup on review.php directly
        const floatBtn = document.querySelector('.floating-review');
        if (floatBtn) {
            floatBtn.removeAttribute('href'); // Disable redirection
            floatBtn.addEventListener('click', (e) => {
                e.preventDefault();
                openReviewModal();
            });
        }
    });

    // Close modal if overlay is clicked
    document.getElementById('review-modal').addEventListener('click', function (e) {
        if (e.target === this) {
            closeReviewModal();
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>