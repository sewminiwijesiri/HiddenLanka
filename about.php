<?php
$pageTitle = 'About Us - Our Story & Host P H C Kelum';
$pageDesc = 'Discover the story behind Hidden Lanka in Sri Lanka. Learn about owner P H C Kelum and our commitment to authentic local hospitality, food, tours, and vehicle rentals.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Page Header Banner -->
    <section class="hero-section" style="padding: 4rem 0 4.5rem;">
        <div class="container text-center" style="text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.2); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.3);">Our Story & Values</span>
            <h1 class="heading-xl hero-title" style="margin-bottom: 0.75rem;">About Hidden Lanka</h1>
            <p class="lead-text" style="color: rgba(255,255,255,0.9); margin: 0 auto;">Authentic Sri Lankan hospitality, peaceful stays, and personal island adventure guidance.</p>
        </div>
    </section>

    <!-- Main Story Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="grid-2">
                <div>
                    <span class="badge-sub">Our Roots</span>
                    <h2 class="heading-lg">A Warm Garden Haven</h2>
                    <p style="font-size: 1.05rem; margin-bottom: 1.25rem; color: var(--color-text-muted);">
                        Situated in the serene southern region of <strong>Sri Lanka</strong>, Hidden Lanka was founded with a clear vision: to offer international travelers an authentic, stress-free, and memorable island experience away from commercialized resorts.
                    </p>
                    <p style="font-size: 1.05rem; margin-bottom: 1.25rem; color: var(--color-text-muted);">
                        Whether you are waking up to quiet garden surroundings, enjoying a freshly ground coconut curry breakfast, or setting off in a rented tuk-tuk to explore hidden waterfalls, Hidden Lanka provides total comfort and peace of mind.
                    </p>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted);">
                        We pride ourselves on offering more than just a place to sleep — we provide an all-inclusive local ecosystem where guests become lifelong friends.
                    </p>
                </div>

                <!-- Graphic Showcase Box -->
                <div class="graphic-banner" style="background-image: linear-gradient(rgba(4, 36, 40, 0.3), rgba(4, 36, 40, 0.45)), url('assets/images/hero/hero-room.jpg'); background-size: cover; background-position: center; border: none;">
                    <div style="background: var(--color-white); border-radius: var(--radius-md); border: 1px solid var(--color-sand-border);" class="about-choice-card">
                        <h3 class="heading-sm" style="color: var(--color-teal-dark); margin-bottom: 1rem;">Why Travelers Choose Us</h3>
                        <ul class="pillar-bullet-list" style="margin: 0;">
                            <li>
                                <span class="bullet-icon">✓</span>
                                <span><strong>Prime Location:</strong> Peaceful garden retreat.</span>
                            </li>
                            <li>
                                <span class="bullet-icon">✓</span>
                                <span><strong>Family-Style Dining:</strong> Authentic recipes cooked using fresh local seafood.</span>
                            </li>
                            <li>
                                <span class="bullet-icon">✓</span>
                                <span><strong>Total Mobility:</strong> In-house tuk-tuk and motorbike rental options.</span>
                            </li>
                            <li>
                                <span class="bullet-icon">✓</span>
                                <span><strong>Mechanical Safety:</strong> Dedicated repair garage for instant vehicle support.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA to Contact Page -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg); text-align: center;">
        <div class="container">
            <h2 class="heading-lg" style="margin-bottom: 1rem;">Have Questions? Get in Touch!</h2>
            <p class="lead-text" style="max-width: 600px; margin: 0 auto 2rem; color: var(--color-text-muted);">
                We are always happy to help with room bookings, vehicle rentals, tour planning, or general inquiries. Reach out to us directly.
            </p>
            <a href="contact" class="btn btn-primary" style="padding: 0.85rem 2rem; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem;">
                Contact Us
            </a>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
