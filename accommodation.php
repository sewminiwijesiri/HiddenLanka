<?php
session_start();
require_once __DIR__ . '/includes/db.php';

// Fetch all active rooms
$acc_query = "SELECT * FROM accommodations ORDER BY id ASC";
$acc_result = $db_conn->query($acc_query);
$rooms = [];
if ($acc_result && $acc_result->num_rows > 0) {
    while ($row = $acc_result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$pageTitle = 'Villa Accommodations - Rooms & Booking';
$pageDesc = 'Explore our villa room options at Hidden Lanka in Sri Lanka. Choose between comfortable A/C and fan-cooled rooms with modern amenities and direct WhatsApp booking.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Hero Banner -->
    <section class="hero-section" style="padding: 4rem 0 4.5rem;">
        <div class="container text-center" style="text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.2); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.3);">Villa Comfort</span>
            <h1 class="heading-xl hero-title" style="margin-bottom: 0.75rem;">Our Villa Rooms</h1>
            <p class="lead-text" style="color: rgba(255,255,255,0.9); margin: 0 auto;">Designed for peaceful relaxation with quiet garden verandas and modern guest amenities.</p>
        </div>
    </section>

    <!-- Room Showcase Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="section-title-wrap">
                <span class="badge-sub">Choose Your Sanctuary</span>
                <h2 class="heading-lg">Villa Accommodation Types</h2>
                <p class="lead-text">All rooms include daily housekeeping, high-speed Wi-Fi, hot water showers, and optional traditional Sri Lankan breakfast prepared by host Kelum.</p>
            </div>

            <?php if (empty($rooms)): ?>
                <p style="text-align: center; color: var(--color-text-muted); padding: 3rem 0;">No accommodation options found. Please check back later!</p>
            <?php else: ?>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(290px, 1fr)); gap: 2.25rem;" class="rooms-grid">
                    <?php foreach ($rooms as $index => $r): 
                        $bg_style = '';
                        if (!empty($r['image_path'])) {
                            $bg_style = "background: linear-gradient(135deg, rgba(4, 36, 40, 0.35) 0%, rgba(4, 36, 40, 0.85) 100%), url('" . htmlspecialchars($r['image_path']) . "') no-repeat center center; background-size: cover;";
                        } else {
                            if ($index % 2 === 0) {
                                $bg_style = "background: linear-gradient(135deg, var(--color-teal-dark) 0%, var(--color-teal-medium) 100%);";
                            } else {
                                $bg_style = "background: linear-gradient(135deg, #0A4D52 0%, #0E6970 100%);";
                            }
                        }
                    ?>
                        <div class="villa-card" style="margin: 0; display: flex; flex-direction: column; height: 100%;">
                            <!-- Card Header -->
                            <div class="villa-card-header" style="height: 220px; padding: 2.25rem 2rem; justify-content: flex-end; <?php echo $bg_style; ?>">
                                <?php if (!empty($r['badge'])): ?>
                                    <span class="villa-badge" style="background: <?php echo ($r['badge'] === 'Premium Comfort') ? 'var(--color-gold)' : 'var(--color-teal-light)'; ?>; color: var(--color-teal-dark); top: 1.25rem; left: 1.25rem;"><?php echo htmlspecialchars($r['badge']); ?></span>
                                <?php endif; ?>
                                <h2 style="color: var(--color-white); font-size: 1.6rem; margin-bottom: 0.3rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3); font-weight:700;"><?php echo htmlspecialchars($r['title']); ?></h2>
                                <p style="font-size: 0.92rem; color: rgba(255,255,255,0.9); margin: 0; text-shadow: 0 1px 3px rgba(0,0,0,0.3);"><?php echo htmlspecialchars($r['subtitle']); ?></p>
                            </div>

                            <!-- Card Body -->
                            <div class="villa-card-body" style="padding: 2rem; display: flex; flex-direction: column; flex: 1; background: var(--color-white);">
                                <h3 class="heading-md" style="font-size: 1.15rem; margin-bottom: 0.6rem;">Room Highlights</h3>
                                <p style="color: var(--color-text-muted); margin-bottom: 1.5rem; font-size: 0.9rem; line-height: 1.6;">
                                    <?php 
                                        $desc_preview = strip_tags($r['description']);
                                        if (strlen($desc_preview) > 130) {
                                            $desc_preview = substr($desc_preview, 0, 127) . '...';
                                        }
                                        echo htmlspecialchars($desc_preview);
                                    ?>
                                </p>

                                <div class="villa-price" style="margin-top: auto; padding-top: 1.25rem; border-top: 1px solid var(--color-sand-border); display: flex; justify-content: space-between; align-items: center;">
                                    <div>
                                        <span style="font-size: 0.78rem; color: var(--color-text-muted);">Direct Host Booking</span>
                                        <div class="price-val" style="font-size: 1.3rem; margin-top: 0.15rem;"><?php echo htmlspecialchars($r['price']); ?></div>
                                    </div>
                                    <a href="accommodation_details?id=<?php echo $r['id']; ?>" class="btn btn-secondary" style="padding: 0.55rem 1.25rem; font-size: 0.88rem;">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Amenities Grid Banner -->
    <section class="section-padding reveal" style="background: var(--color-sand-card);">
        <div class="container text-center">
            <div class="section-title-wrap">
                <span class="badge-sub">Standard Privileges</span>
                <h2 class="heading-lg">Included With Every Stay</h2>
            </div>

            <div class="grid-4" style="text-align: left;">
                <div class="privilege-card privilege-meals">
                    <h4 style="color: var(--color-teal-dark); margin-bottom: 0.5rem;">🍳 Homemade Meals</h4>
                    <p style="font-size: 0.9rem; color: var(--color-text-muted);">Optional daily home-cooked breakfast and fresh dinner banquets made by Kelum’s family.</p>
                </div>

                <div class="privilege-card privilege-vehicle">
                    <h4 style="color: var(--color-teal-dark); margin-bottom: 0.5rem;">🛵 Vehicle Priority</h4>
                    <p style="font-size: 0.9rem; color: var(--color-text-muted);">Guaranteed priority access to our in-house tuk-tuks and scooters at discounted guest rates.</p>
                </div>

                <div class="privilege-card privilege-check">
                    <h4 style="color: var(--color-teal-dark); margin-bottom: 0.5rem;">🔧 Free Vehicle Check</h4>
                    <p style="font-size: 0.9rem; color: var(--color-text-muted);">Complimentary quick tyre/oil inspection at our on-site workshop before your day trips.</p>
                </div>

                <div class="privilege-card privilege-advice">
                    <h4 style="color: var(--color-teal-dark); margin-bottom: 0.5rem;">🌴 Local Tour Advice</h4>
                    <p style="font-size: 0.9rem; color: var(--color-text-muted);">Insider guidance on secret beaches, surf spots, waterfalls, and local spice markets.</p>
                </div>
            </div>
        </div>
    </section>

    <style>
    .privilege-card {
        background: var(--color-white);
        padding: 1.75rem;
        border-radius: var(--radius-md);
        border: 1px solid var(--color-sand-border);
        transition: var(--transition);
        box-shadow: var(--shadow-sm);
    }
    .privilege-card:hover {
        transform: translateY(-5px);
        box-shadow: var(--shadow-lg);
    }
    .privilege-meals { border-top: 4px solid var(--color-gold); }
    .privilege-vehicle { border-top: 4px solid var(--color-coral); }
    .privilege-check { border-top: 4px solid #147e87; }
    .privilege-advice { border-top: 4px solid #2e7d32; }
    </style>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
