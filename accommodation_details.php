<?php
/**
 * Hidden Lanka - Villa Room Accommodation Details Page
 */
session_start();
require_once __DIR__ . '/includes/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id <= 0) {
    header("Location: accommodation");
    exit();
}

// Fetch Room Category
$stmt = $db_conn->prepare("SELECT * FROM accommodations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$room = $res->fetch_assoc();
$stmt->close();

if (!$room) {
    header("Location: accommodation");
    exit();
}

$pageTitle = htmlspecialchars($room['title']) . ' - Room Details';
$pageDesc = htmlspecialchars($room['subtitle']);
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main style="background: var(--color-sand-bg);">
    <!-- Room Detail Hero Header -->
    <section class="hero-section" style="padding: 6rem 0; text-align: center; position: relative;
        <?php if (!empty($room['image_path'])): ?>
            background: linear-gradient(135deg, rgba(4, 36, 40, 0.45) 0%, rgba(4, 36, 40, 0.9) 100%), url('<?php echo htmlspecialchars($room['image_path']); ?>') no-repeat center center; background-size: cover;
        <?php else: ?>
            background: <?php echo ($room['id'] % 2 === 1) ? 'linear-gradient(135deg, var(--color-teal-dark) 0%, var(--color-teal-medium) 100%)' : 'linear-gradient(135deg, #0A4D52 0%, #0E6970 100%)'; ?>;
        <?php endif; ?>">
        <div class="container">
            <?php if (!empty($room['badge'])): ?>
                <span class="badge-sub" style="background: var(--color-gold); color: var(--color-teal-dark); border-color: rgba(212, 175, 55, 0.3); margin-bottom: 0.75rem; font-size: 0.78rem; font-weight: 700;"><?php echo htmlspecialchars($room['badge']); ?></span>
            <?php endif; ?>
            <h1 class="heading-xl" style="color: var(--color-white); margin-bottom: 0.75rem; font-size: 2.75rem;"><?php echo htmlspecialchars($room['title']); ?></h1>
            <p class="lead-text" style="color: rgba(255,255,255,0.9); margin: 0 auto; max-width: 750px; font-size: 1.15rem;"><?php echo htmlspecialchars($room['subtitle']); ?></p>
        </div>
    </section>

    <section style="padding: 2.5rem 0;">
        <div class="container" style="max-width: 1100px;">
            <!-- Back navigation link -->
            <div style="margin-bottom: 2rem;">
                <a href="accommodation" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--color-teal-medium); font-weight: 700; text-decoration: none; font-size: 0.95rem; transition: var(--transition-fast);" class="back-link">
                    <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>
                    Back to Villa Accommodations
                </a>
            </div>

            <!-- Unified Details Card -->
            <div class="reveal" style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); padding: 0; overflow: hidden;">
                <div style="display: grid; grid-template-columns: 1.15fr 0.85fr; gap: 0; align-items: stretch;" class="details-grid-main">
                    
                    <!-- Left Side: Widescreen Image Slideshow (Flush with Card Edges) -->
                    <div style="position: relative; overflow: hidden; background: var(--color-teal-dark); height: 100%; min-height: 440px;" class="details-left-side">
                        <?php
                            $gallery_res = $db_conn->query("SELECT * FROM accommodation_images WHERE accommodation_id = " . intval($room['id']) . " ORDER BY id ASC");
                            $gallery_images = [];
                            if ($gallery_res && $gallery_res->num_rows > 0) {
                                while ($g_row = $gallery_res->fetch_assoc()) {
                                    $gallery_images[] = $g_row['image_path'];
                                }
                            }
                            
                            $total_slides = count($gallery_images);
                            if ($total_slides > 0):
                        ?>
                            <!-- Slide Images -->
                            <?php foreach ($gallery_images as $index => $img_path): ?>
                                <div class="my-slide" style="display: <?php echo ($index === 0) ? 'block' : 'none'; ?>;">
                                    <img src="<?php echo htmlspecialchars($img_path); ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Villa View <?php echo ($index + 1); ?>">
                                    <div style="position: absolute; bottom: 1.5rem; left: 2rem; background: rgba(4, 36, 40, 0.7); padding: 0.4rem 0.85rem; border-radius: var(--radius-full); color: var(--color-white); font-size: 0.8rem; font-weight: 600; text-shadow: none; z-index: 5;">
                                        Room Photo <?php echo ($index + 1); ?> of <?php echo $total_slides; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if ($total_slides > 1): ?>
                                <!-- Controls -->
                                <button onclick="prevSlide()" style="position: absolute; left: 1.25rem; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.85); color: var(--color-teal-dark); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem; transition: var(--transition-fast); box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 5;" class="slider-btn">&lt;</button>
                                <button onclick="nextSlide()" style="position: absolute; right: 1.25rem; top: 50%; transform: translateY(-50%); width: 44px; height: 44px; border-radius: 50%; background: rgba(255,255,255,0.85); color: var(--color-teal-dark); border: none; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 1.25rem; transition: var(--transition-fast); box-shadow: 0 2px 6px rgba(0,0,0,0.15); z-index: 5;" class="slider-btn">&gt;</button>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Fallback for other rooms: static single image -->
                            <img src="<?php echo !empty($room['image_path']) ? htmlspecialchars($room['image_path']) : 'assets/images/logo.png'; ?>" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover;" alt="<?php echo htmlspecialchars($room['title']); ?>">
                        <?php endif; ?>
                    </div>

                    <!-- Right Side: Details & Highlights -->
                    <div style="padding: 2rem 2.25rem; display: flex; flex-direction: column; gap: 1.5rem;" class="details-right-side">
                        
                        <!-- Description Section -->
                        <div>
                            <h2 class="heading-md" style="color: var(--color-teal-dark); margin-bottom: 1rem; font-size: 1.3rem; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.5rem;">Room Description & Highlights</h2>
                            <div style="color: var(--color-text-muted); font-size: 0.94rem; line-height: 1.65; display: flex; flex-direction: column; gap: 1.25rem;">
                                <?php echo nl2br(htmlspecialchars($room['description'])); ?>
                            </div>
                        </div>

                        <!-- Amenities Section -->
                        <div>
                            <h3 class="heading-sm" style="color: var(--color-teal-dark); margin-bottom: 0.75rem; font-size: 1.05rem; border-bottom: 1px solid var(--color-sand-border); padding-bottom: 0.4rem;">What's Included</h3>
                            
                            <?php 
                                $amenities = array_filter(array_map('trim', explode(',', $room['amenities'])));
                                if (empty($amenities)):
                            ?>
                                <p style="color: var(--color-text-muted); font-size: 0.9rem; margin: 0;">Standard room amenities included.</p>
                            <?php else: ?>
                                <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 0.65rem;" class="amenities-list">
                                    <?php foreach ($amenities as $amenity): ?>
                                        <li style="display: flex; align-items: center; gap: 0.6rem; font-size: 0.92rem; color: var(--color-text-muted); font-weight: 500;">
                                            <span style="color: var(--color-teal-medium); font-weight: 700; font-size: 1.1rem;">✓</span>
                                            <?php echo htmlspecialchars($amenity); ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Separate Booking Card -->
            <div class="reveal booking-banner" style="background: var(--color-sand-card); border: 1px solid var(--color-sand-border); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); padding: 1.5rem 2.5rem; margin-top: 2rem; display: flex; justify-content: space-between; align-items: center; gap: 2rem;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: baseline; gap: 1rem; margin-bottom: 0.35rem; flex-wrap: wrap;">
                        <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.08em; color: var(--color-text-muted); font-weight: 700;">Direct Booking Rate:</span>
                        <strong style="font-size: 1.85rem; color: var(--color-coral); font-family: var(--font-heading); line-height: 1;"><?php echo htmlspecialchars($room['price']); ?></strong>
                    </div>
                    <p style="font-size: 0.88rem; color: var(--color-text-muted); margin: 0;">
                        Inquire availability and reserve directly with host. No pre-payment required.
                    </p>
                </div>
                <div>
                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I want to inquire about availability and reserve the ' . $room['title'] . '!'); ?>" class="btn btn-whatsapp" style="padding: 0.75rem 2rem; font-size: 0.95rem; border-radius: var(--radius-sm); white-space: nowrap; display: inline-flex; align-items: center; gap: 0.5rem;" target="_blank" rel="noopener">
                        Book via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .back-link:hover {
        color: var(--color-coral) !important;
        transform: translateX(-4px);
    }
    .slider-btn:hover {
        background: var(--color-white) !important;
        color: var(--color-coral) !important;
        transform: translateY(-50%) scale(1.08) !important;
    }
    
    @media (min-width: 993px) {
        .details-grid-main {
            min-height: 480px;
        }
    }
    
    .my-slide {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .my-slide img {
        width: 100%;
        height: 100%;
        transition: object-fit 0.2s ease;
    }
    
    @media (max-width: 992px) {
        .details-grid-main {
            grid-template-columns: 1fr !important;
        }
        .details-left-side {
            height: 380px !important;
            min-height: 300px !important;
        }
    }
    
    @media (max-width: 768px) {
        .booking-banner {
            flex-direction: column !important;
            text-align: center !important;
            padding: 1.5rem !important;
            gap: 1.25rem !important;
        }
        .booking-banner div {
            width: 100% !important;
        }
    }
    
    @media (max-width: 576px) {
        .amenities-list {
            grid-template-columns: 1fr !important;
        }
    }
</style>

<script>
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('.my-slide');

    // Automatically detect image aspect ratio: contain (zoom out) if portrait, cover (fill) if landscape
    document.querySelectorAll('.my-slide img').forEach(img => {
        function adjustObjectFit() {
            if (img.naturalHeight > img.naturalWidth) {
                img.style.objectFit = 'contain';
                img.style.background = '#031c1f';
            } else {
                img.style.objectFit = 'cover';
                img.style.background = 'transparent';
            }
        }
        img.addEventListener('load', adjustObjectFit);
        if (img.complete) {
            adjustObjectFit();
        }
    });

    function showSlide(index) {
        if (slides.length === 0) return;
        
        slides.forEach(slide => {
            slide.style.display = 'none';
        });
        
        if (index >= slides.length) {
            currentSlideIndex = 0;
        } else if (index < 0) {
            currentSlideIndex = slides.length - 1;
        } else {
            currentSlideIndex = index;
        }
        
        slides[currentSlideIndex].style.display = 'block';
    }

    function nextSlide() {
        showSlide(currentSlideIndex + 1);
    }

    function prevSlide() {
        showSlide(currentSlideIndex - 1);
    }
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
