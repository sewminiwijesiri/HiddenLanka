<?php
$pageTitle = 'Guided Island Tours - Explore Sri Lanka';
$pageDesc = 'Explore Sri Lanka with custom guided tours by host P H C Kelum. Southern Coast beaches, Ella highlands, misty waterfalls, and Kandy cultural temples.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/db.php';

// Fetch all tours from database
$tours_result = $db_conn->query("SELECT * FROM tours ORDER BY created_at ASC");
$tours = [];
if ($tours_result) {
    while ($row = $tours_result->fetch_assoc()) {
        $tours[] = $row;
    }
}
?>

<main>
    <!-- Hero Banner -->
    <section class="hero-section" style="position: relative; background: url('assets/images/tours/tour-beach.jpg') no-repeat center center/cover; padding: 5rem 0 5.5rem; overflow: hidden; color: var(--color-white);">
        <!-- Deep Teal Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.60) 100%); z-index: 1;"></div>
        
        <div class="container text-center" style="position: relative; z-index: 2; text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Island Adventures</span>
            <h1 class="heading-xl hero-title" style="background: linear-gradient(135deg, var(--color-white) 40%, var(--color-gold) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; text-shadow: none;">Guided Island Tours</h1>
            <p class="lead-text" style="color: var(--color-white); margin: 0 auto; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85);">Custom-tailored day trips and safaris to explore the hidden gems of Sri Lanka with host Kelum.</p>
        </div>
    </section>

    <!-- Tours Showcase Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="section-title-wrap">
                <span class="badge-sub">Explore With Us</span>
                <h2 class="heading-lg">Our Curated Day Tours</h2>
                <p class="lead-text">All tours are fully flexible. We provide comfortable transportation, refreshing king coconuts, local lunch stops, and friendly guiding service.</p>
            </div>

            <?php if (empty($tours)): ?>
                <div style="text-align: center; padding: 4rem 3rem; background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm);">
                    <p style="color: var(--color-text-muted); font-size: 1.1rem; margin: 0;">No tour packages available at the moment. Please contact the host directly via WhatsApp for custom tours!</p>
                </div>
            <?php else: ?>
                <?php foreach ($tours as $index => $t): 
                    $is_last = ($index === count($tours) - 1);
                    $margin_style = $is_last ? '' : ' style="margin-bottom: 3rem;"';
                    
                    // We can determine background alignment based on the title
                    $bg_align = (strpos(strtolower($t['title']), 'ella') !== false) ? 'center bottom' : 'center center';
                ?>
                    <!-- Tour: <?php echo htmlspecialchars($t['title']); ?> -->
                    <div class="villa-card"<?php echo $margin_style; ?>>
                        <div class="tour-card-grid">
                            <div class="villa-card-header" style="min-height: 280px; padding: 3rem 2.5rem; justify-content: center; background: linear-gradient(135deg, rgba(4, 36, 40, 0.45) 0%, rgba(4, 36, 40, 0.2) 100%), url('<?php echo htmlspecialchars($t['image_path']); ?>') no-repeat <?php echo $bg_align; ?>; background-size: cover;">
                                <?php if (!empty($t['badge'])): ?>
                                    <span class="villa-badge" style="background: <?php echo ($t['badge'] === 'Most Popular') ? 'var(--color-coral)' : 'var(--color-gold)'; ?>; color: <?php echo ($t['badge'] === 'Most Popular') ? 'var(--color-white)' : 'var(--color-teal-dark)'; ?>;"><?php echo htmlspecialchars($t['badge']); ?></span>
                                <?php endif; ?>
                                <h2 style="color: var(--color-white); font-size: 2rem; margin-bottom: 0.5rem; text-shadow: 0 2px 5px rgba(4, 36, 40, 0.8);"><?php echo htmlspecialchars($t['title']); ?></h2>
                            </div>

                            <div class="villa-card-body" style="padding: 2.5rem;">
                                <h3 class="heading-md">Tour Highlights</h3>
                                <p style="color: var(--color-text-muted); margin-bottom: 1.25rem;">
                                    <?php echo nl2br(htmlspecialchars($t['description'])); ?>
                                </p>
                                
                                <?php if (!empty($t['places'])): ?>
                                    <h4 style="font-size: 0.95rem; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-teal-dark); margin-bottom: 0.5rem;">Places You'll Visit:</h4>
                                    <ul class="amenities-list">
                                        <?php 
                                            $places_list = explode(',', $t['places']);
                                            foreach ($places_list as $place):
                                                $place = trim($place);
                                                if (!empty($place)):
                                        ?>
                                            <li class="amenity-chip">📍 <?php echo htmlspecialchars($place); ?></li>
                                        <?php 
                                                endif;
                                            endforeach; 
                                        ?>
                                    </ul>
                                <?php endif; ?>

                                <div class="villa-price">
                                    <div>
                                        <span style="font-size: 0.85rem; color: var(--color-text-muted);">Duration: <?php echo htmlspecialchars($t['duration']); ?></span>
                                        <div class="price-val"><?php echo htmlspecialchars($t['price']); ?></div>
                                    </div>
                                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I want to book the ' . $t['title'] . '!'); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">
                                        Book via WhatsApp
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
