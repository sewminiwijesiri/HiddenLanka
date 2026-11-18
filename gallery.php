<?php
$pageTitle = 'Photo Gallery - Hidden Lanka Guesthouse & Tours';
$pageDesc = 'Explore the beauty of Hidden Lanka. Photos of our tropical gardens, cozy villa rooms, guided tours, local culinary feasts, and Sri Lankan island adventures.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
require_once __DIR__ . '/includes/db.php';

// Fetch all gallery images
$gallery_result = $db_conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
$images = [];
if ($gallery_result) {
    while ($row = $gallery_result->fetch_assoc()) {
        $images[] = $row;
    }
}
?>

<main>
    <!-- Hero Banner Section -->
    <section class="hero-section" style="position: relative; background: linear-gradient(135deg, rgba(4, 36, 40, 0.65) 0%, rgba(3, 28, 31, 0.82) 100%), url('assets/images/gallery/WhatsApp%20Image%202026-08-28%20at%2010.51.28%20(2).jpeg') no-repeat center center/cover; padding: 5rem 0 5.5rem; overflow: hidden; color: var(--color-white);">
        <div class="container text-center" style="position: relative; z-index: 2; text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Visual Journey</span>
            <h1 class="heading-xl hero-title" style="background: linear-gradient(135deg, var(--color-white) 40%, var(--color-gold) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; text-shadow: none;">Our Photo Gallery</h1>
            <p class="lead-text" style="color: var(--color-white); margin: 0 auto; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85); max-width: 650px;">Take a look at the daily life, beautiful tours, and tropical stay experience at Hidden Lanka.</p>
        </div>
    </section>

    <!-- Gallery Showcase Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg); padding: 4.5rem 0;">
        <div class="container">
            <div class="section-title-wrap" style="text-align: center; margin-bottom: 3.5rem;">
                <span class="badge-sub">Moments Captured</span>
                <h2 class="heading-lg">Memories from Hidden Lanka</h2>
                <p class="lead-text" style="max-width: 700px; margin: 0 auto;">Browse through photos of our home-cooked meals, garden villa, surrounding wildlife, and tours guided by host Kelum.</p>
            </div>

            <?php if (empty($images)): ?>
                <div style="text-align: center; padding: 5rem 3rem; background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border); box-shadow: var(--shadow-sm); max-width: 600px; margin: 0 auto;">
                    <svg viewBox="0 0 24 24" width="48" height="48" fill="var(--color-text-muted)" style="margin-bottom: 1rem; opacity: 0.6;"><path d="M21 19V5c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2zM8.5 13.5l2.5 3.01L14.5 12l4.5 6H5l3.5-4.5z"/></svg>
                    <p style="color: var(--color-text-muted); font-size: 1.1rem; margin: 0; font-weight: 500;">No images have been uploaded to the gallery yet. Check back soon!</p>
                </div>
            <?php else: ?>
                <!-- Responsive Grid Layout -->
                <div class="gallery-grid">
                    <?php foreach ($images as $index => $img): ?>
                        <div class="gallery-card" onclick="openLightbox(<?php echo $index; ?>)" role="button" aria-label="View <?php echo htmlspecialchars($img['title'] ?? 'image'); ?>" tabindex="0">
                            <div class="gallery-img-container">
                                <img src="<?php echo htmlspecialchars($img['image_path']); ?>" alt="<?php echo htmlspecialchars($img['title'] ?? 'Hidden Lanka Gallery Image'); ?>" loading="lazy">
                                <div class="gallery-hover-overlay">
                                    <div class="zoom-icon-circle">
                                        <svg viewBox="0 0 24 24" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<!-- Lightbox Modal Viewer -->
<div id="lightbox" class="lightbox-overlay" aria-hidden="true" role="dialog">
    <span class="lightbox-close" onclick="closeLightbox()" aria-label="Close Lightbox">&times;</span>
    
    <button class="lightbox-btn lightbox-prev" onclick="prevImage()" aria-label="Previous Image">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
    </button>
    
    <div class="lightbox-content-container">
        <div class="lightbox-image-wrapper">
            <img id="lightbox-img" src="" alt="Lightbox View">
        </div>
        <div class="lightbox-details">
            <div id="lightbox-counter" class="lightbox-counter"></div>
        </div>
    </div>
    
    <button class="lightbox-btn lightbox-next" onclick="nextImage()" aria-label="Next Image">
        <svg viewBox="0 0 24 24" width="28" height="28" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
    </button>
</div>

<!-- Styles for Gallery Grid and Premium Lightbox -->
<style>
    /* Public Gallery Grid */
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.75rem;
    }
    
    @media (max-width: 992px) {
        .gallery-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }
    @media (max-width: 576px) {
        .gallery-grid {
            grid-template-columns: 1fr;
            gap: 1.25rem;
        }
    }

    .gallery-card {
        background: var(--color-white);
        border-radius: var(--radius-md);
        border: 1px solid var(--color-sand-border);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        cursor: pointer;
        display: flex;
        flex-direction: column;
        transition: var(--transition);
        outline: none;
    }

    .gallery-card:hover, .gallery-card:focus-visible {
        transform: translateY(-5px);
        box-shadow: var(--shadow-md);
        border-color: var(--color-gold);
    }
    
    .gallery-card:focus-visible {
        box-shadow: 0 0 0 3px rgba(217, 171, 85, 0.4), var(--shadow-md);
    }

    .gallery-img-container {
        position: relative;
        aspect-ratio: 4 / 3;
        overflow: hidden;
        background: var(--color-teal-dark);
    }

    .gallery-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .gallery-card:hover .gallery-img-container img,
    .gallery-card:focus-visible .gallery-img-container img {
        transform: scale(1.06);
    }

    .gallery-hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(4, 36, 39, 0.35);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: var(--transition-fast);
        z-index: 2;
    }

    .gallery-card:hover .gallery-hover-overlay,
    .gallery-card:focus-visible .gallery-hover-overlay {
        opacity: 1;
    }

    .zoom-icon-circle {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: var(--color-gold);
        color: var(--color-teal-dark);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.25);
        transform: scale(0.85);
        transition: var(--transition);
    }

    .gallery-card:hover .zoom-icon-circle,
    .gallery-card:focus-visible .zoom-icon-circle {
        transform: scale(1);
    }

    .gallery-card-info {
        padding: 1.25rem 1.5rem;
        background: var(--color-white);
        flex: 1;
        display: flex;
        flex-direction: column;
        gap: 0.35rem;
        border-top: 1px solid rgba(232, 222, 210, 0.6);
    }

    .gallery-card-title {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--color-teal-dark);
        font-family: var(--font-body);
        margin: 0;
    }

    .gallery-card-caption {
        font-size: 0.88rem;
        color: var(--color-text-muted);
        line-height: 1.45;
        margin: 0;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Lightbox Overlay */
    .lightbox-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(4, 20, 22, 0.96);
        z-index: 1000000;
        display: none;
        align-items: center;
        justify-content: center;
        user-select: none;
        opacity: 0;
        transition: opacity 0.35s ease;
    }
    
    .lightbox-overlay.active {
        display: flex;
        opacity: 1;
    }

    .lightbox-close {
        position: absolute;
        top: 20px;
        right: 25px;
        color: var(--color-white);
        font-size: 44px;
        font-weight: 300;
        cursor: pointer;
        z-index: 1000010;
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: var(--transition-fast);
        opacity: 0.75;
    }

    .lightbox-close:hover {
        opacity: 1;
        transform: rotate(90deg);
        color: var(--color-gold);
    }

    .lightbox-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: var(--color-white);
        width: 55px;
        height: 55px;
        border-radius: 50%;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 1000008;
        transition: var(--transition-fast);
        opacity: 0.7;
    }
    
    .lightbox-btn:hover {
        background: var(--color-gold);
        color: var(--color-teal-dark);
        border-color: var(--color-gold);
        opacity: 1;
    }

    .lightbox-prev {
        left: 30px;
    }

    .lightbox-next {
        right: 30px;
    }
    
    @media (max-width: 768px) {
        .lightbox-btn {
            width: 44px;
            height: 44px;
        }
        .lightbox-prev {
            left: 10px;
        }
        .lightbox-next {
            right: 10px;
        }
    }

    .lightbox-content-container {
        max-width: 900px;
        width: 90%;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.25rem;
        z-index: 1000005;
        animation: lightboxZoomIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }
    
    @keyframes lightboxZoomIn {
        from {
            opacity: 0;
            transform: scale(0.95);
        }
        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .lightbox-image-wrapper {
        width: 100%;
        max-height: 70vh;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: var(--radius-sm);
        overflow: hidden;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
        background: #000;
        border: 1px solid rgba(255, 255, 255, 0.08);
    }

    .lightbox-image-wrapper img {
        max-width: 100%;
        max-height: 70vh;
        object-fit: contain;
        display: block;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    
    .lightbox-image-wrapper img.loaded {
        opacity: 1;
    }

    .lightbox-details {
        text-align: center;
        color: var(--color-white);
        max-width: 650px;
        width: 100%;
        background: rgba(4, 36, 40, 0.4);
        padding: 1.25rem 1.75rem;
        border-radius: var(--radius-sm);
        border: 1px solid rgba(255, 255, 255, 0.05);
        backdrop-filter: blur(10px);
    }

    .lightbox-details h3 {
        color: var(--color-gold);
        font-family: var(--font-body);
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.35rem;
    }

    .lightbox-details p {
        font-size: 0.92rem;
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.5;
        margin-bottom: 0.5rem;
    }

    .lightbox-counter {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: rgba(255, 255, 255, 0.45);
        font-weight: 700;
    }
</style>

<!-- Lightbox Script -->
<script>
    // Package all database images into a JS array
    const galleryItems = <?php echo json_encode($images); ?>;
    let currentIndex = 0;
    
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightbox-img');
    const lightboxCounter = document.getElementById('lightbox-counter');

    function openLightbox(index) {
        currentIndex = index;
        updateLightboxContent();
        
        lightbox.style.display = 'flex';
        // Trigger reflow for transition
        void lightbox.offsetWidth;
        lightbox.classList.add('active');
        lightbox.setAttribute('aria-hidden', 'false');
        
        document.body.style.overflow = 'hidden'; // Disable background scroll
        document.addEventListener('keydown', handleKeyDown);
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = ''; // Re-enable background scroll
        document.removeEventListener('keydown', handleKeyDown);
        
        setTimeout(() => {
            lightbox.style.display = 'none';
            lightbox.setAttribute('aria-hidden', 'true');
            lightboxImg.src = '';
            lightboxImg.classList.remove('loaded');
        }, 350);
    }

    function updateLightboxContent() {
        const item = galleryItems[currentIndex];
        if (!item) return;

        lightboxImg.classList.remove('loaded');
        
        // Setup image loading callback
        lightboxImg.onload = function() {
            lightboxImg.classList.add('loaded');
        };
        
        lightboxImg.src = item.image_path;
        lightboxImg.alt = 'Hidden Lanka Gallery Image';
        
        lightboxCounter.textContent = `${currentIndex + 1} / ${galleryItems.length}`;
    }

    function nextImage() {
        if (galleryItems.length <= 1) return;
        currentIndex = (currentIndex + 1) % galleryItems.length;
        updateLightboxContent();
    }

    function prevImage() {
        if (galleryItems.length <= 1) return;
        currentIndex = (currentIndex - 1 + galleryItems.length) % galleryItems.length;
        updateLightboxContent();
    }

    function handleKeyDown(e) {
        if (e.key === 'Escape') {
            closeLightbox();
        } else if (e.key === 'ArrowRight') {
            nextImage();
        } else if (e.key === 'ArrowLeft') {
            prevImage();
        }
    }

    // Close on click outside the image container
    lightbox.addEventListener('click', function(e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
