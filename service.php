<?php
$pageTitle = 'Our Services - Food, Tours, Weddings, Rentals & Repairs';
$pageDesc = 'Explore services at Hidden Lanka: home-cooked Sri Lankan food, guided island tours, traditional village weddings, self-drive tuk tuk & motorbike rentals, and mechanical workshop repairs by P H C Kelum.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Page Banner -->
    <section class="hero-section" style="padding: 4rem 0 4.5rem;">
        <div class="container text-center" style="text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.2); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.3);">Island Services</span>
            <h1 class="heading-xl hero-title" style="margin-bottom: 0.75rem;">Services & Experiences</h1>
            <p class="lead-text" style="color: rgba(255,255,255,0.9); margin: 0 auto;">Everything you need for dining, exploring, riding, and maintaining your vehicles in Sri Lanka.</p>
        </div>
    </section>

    <!-- Services Pillar Container -->
    <section class="section-padding" style="background: var(--color-sand-bg);">
        <div class="container services-timeline-container">
            <!-- Pillar 1: Local Home-Cooked Food -->
            <div id="food" class="service-pillar-row reveal">
                <div class="timeline-node">1</div>
                <div>
                    <span class="badge-sub">Taste of Lanka</span>
                    <h2 class="heading-lg">1. Authentic Local Home-Cooked Food</h2>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                        Nothing compares to a home-cooked Sri Lankan meal. At Hidden Lanka, we serve freshly prepared traditional dishes made from locally sourced ingredients, ground spices, and fresh ocean catches.
                    </p>
                    
                    <ul class="pillar-bullet-list">
                        <li>
                            <span class="bullet-icon">🍛</span>
                            <span><strong>Traditional Rice & Curry Feasts</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🐟</span>
                            <span><strong>Fresh Ocean Seafood</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🥥</span>
                            <span><strong>Sri Lankan Breakfasts</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🍵</span>
                            <span><strong>Cooking Demos</strong></span>
                        </li>
                    </ul>

                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I would like to order a home-cooked Sri Lankan meal / reserve a dining table!'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                        Reserve a Meal via WhatsApp
                    </a>
                </div>

                <div class="service-graphic-box" style="background-image: linear-gradient(rgba(4, 36, 40, 0.45), rgba(4, 36, 40, 0.6)), url('assets/images/11.jpg'); background-size: cover; background-position: center; border: none; color: var(--color-white);">
                    <div class="service-icon-box" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); color: var(--color-gold); backdrop-filter: blur(4px);">
                        <svg viewBox="0 0 24 24"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.46 3.9 3.43 4.38l-.43 7.62h2l.43-7.62C10.54 12.9 12 11.12 12 9V2h-1v7zm9-7h-1c-1.66 0-3 1.34-3 3v6h2v10h2V2z"/></svg>
                    </div>
                    <h3 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-white); text-shadow: 0 2px 4px rgba(4, 36, 40, 0.85);">Family Kitchen Philosophy</h3>
                    <p style="color: var(--color-white); font-size: 0.95rem; text-shadow: 0 1px 3px rgba(4, 36, 40, 0.85);">
                        We don't use commercial MSG or pre-packaged pastes. Every meal is cooked slow with organic coconut milk and garden spices, tailored to your spice preference (mild to traditional heat).
                    </p>
                    <span style="font-weight: 700; color: var(--color-gold); font-size: 0.9rem; text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Dietary options available: Vegetarian, Vegan, Gluten-Free</span>
                </div>
            </div>

            <!-- Pillar 2: Guided Tours -->
            <div id="tours" class="service-pillar-row reverse reveal">
                <div class="timeline-node">2</div>
                <div>
                    <span class="badge-sub">Island Adventures</span>
                    <h2 class="heading-lg">2. Custom Guided Island Tours</h2>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                        Explore Sri Lanka like a true insider with host Kelum as your knowledgeable guide. Skip overcrowded tours and enjoy flexible, personalized day trips in comfort.
                    </p>
                    
                    <ul class="pillar-bullet-list">
                        <li>
                            <span class="bullet-icon">🌴</span>
                            <span><strong>Secret Beaches & Surf Spots</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🐘</span>
                            <span><strong>Wildlife & Safaris</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🍃</span>
                            <span><strong>Tea Country Excursions</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🛺</span>
                            <span><strong>Tuk-Tuk Safari Day</strong></span>
                        </li>
                    </ul>

                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I am interested in booking a guided tour with you!'); ?>" class="btn btn-secondary" target="_blank" rel="noopener">
                        Plan a Custom Tour
                    </a>
                </div>

                <div class="service-graphic-box" style="background-image: linear-gradient(rgba(4, 36, 40, 0.45), rgba(4, 36, 40, 0.6)), url('assets/images/10.jpg'); background-size: cover; background-position: center; border: none; color: var(--color-white);">
                    <div class="service-icon-box" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); color: var(--color-coral); backdrop-filter: blur(4px);">
                        <svg viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/></svg>
                    </div>
                    <h3 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-white); text-shadow: 0 2px 4px rgba(4, 36, 40, 0.85);">Why Tour With Kelum?</h3>
                    <p style="color: var(--color-white); font-size: 0.95rem; text-shadow: 0 1px 3px rgba(4, 36, 40, 0.85);">
                        Kelum knows every winding coastal road, local shortcut, and genuine fruit seller. You get zero high-pressure commission stops — only pure, authentic Sri Lankan sightseeing.
                    </p>
                    <span style="font-weight: 700; color: var(--color-coral); font-size: 0.9rem; text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Half-day & full-day itineraries customized on request</span>
                </div>
            </div>

            <!-- Pillar 3: Tuk Tuk & Motorbike Rental -->
            <div id="rentals" class="service-pillar-row reveal">
                <div class="timeline-node">3</div>
                <div>
                    <span class="badge-sub">Self-Drive Freedom</span>
                    <h2 class="heading-lg">3. Tuk Tuk & Motorbike Rental</h2>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                        Experience ultimate travel independence by driving yourself around the island! We maintain a fleet of reliable 3-wheeler tuk-tuks and automatic scooters ready for rental.
                    </p>
                    
                    <ul class="pillar-bullet-list">
                        <li>
                            <span class="bullet-icon">🛵</span>
                            <span><strong>Scooter & Motorbike Rentals</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🛺</span>
                            <span><strong>Self-Drive Tuk-Tuks</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🎓</span>
                            <span><strong>Driving Lessons Included</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">📋</span>
                            <span><strong>License & Permit Help</strong></span>
                        </li>
                    </ul>

                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I would like to inquire about renting a tuk-tuk or motorbike!'); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">
                        Inquire Vehicle Rental
                    </a>
                </div>

                <div class="service-graphic-box" style="background-image: linear-gradient(rgba(4, 36, 40, 0.45), rgba(4, 36, 40, 0.6)), url('assets/images/12.jpg'); background-size: cover; background-position: center; border: none; color: var(--color-white);">
                    <div class="service-icon-box" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); color: var(--color-white); backdrop-filter: blur(4px);">
                        <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3z"/></svg>
                    </div>
                    <h3 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-white); text-shadow: 0 2px 4px rgba(4, 36, 40, 0.85);">Rental Conditions</h3>
                    <p style="color: var(--color-white); font-size: 0.95rem; text-shadow: 0 1px 3px rgba(4, 36, 40, 0.85);">
                        All rentals come with clean helmets, comprehensive insurance options, 24/7 roadside hotline, and emergency backup replacement vehicle guarantee.
                    </p>
                    <span style="font-weight: 700; color: var(--color-coral); font-size: 0.9rem; text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Flexible Daily, Weekly, & Monthly Rates</span>
                </div>
            </div>

            <!-- Pillar 4: Maintenance & Repair -->
            <div id="repairs" class="service-pillar-row reverse reveal">
                <div class="timeline-node">4</div>
                <div>
                    <span class="badge-sub">Workshop & Mechanical Support</span>
                    <h2 class="heading-lg">4. Tuk Tuk & Motorbike Maintenance & Repair</h2>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                        Traveling on two or three wheels across Sri Lanka? Our on-site workshop provides reliable maintenance, repairs, and roadside support to keep you moving safely.
                    </p>
                    
                    <ul class="pillar-bullet-list">
                        <li>
                            <span class="bullet-icon">🔧</span>
                            <span><strong>Full Mechanical Repairs</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🛞</span>
                            <span><strong>Tyre & Tube Repairs</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🛢️</span>
                            <span><strong>Routine Maintenance</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🆘</span>
                            <span><strong>Emergency Roadside Assistance</strong></span>
                        </li>
                    </ul>

                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I need mechanic assistance or vehicle maintenance support!'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                        Contact Workshop Mechanics
                    </a>
                </div>

                <div class="service-graphic-box" style="background-image: linear-gradient(rgba(4, 36, 40, 0.45), rgba(4, 36, 40, 0.6)), url('assets/images/13.jpg'); background-size: cover; background-position: center; border: none; color: var(--color-white);">
                    <div class="service-icon-box" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); color: var(--color-gold); backdrop-filter: blur(4px);">
                        <svg viewBox="0 0 24 24"><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>
                    </div>
                    <h3 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-white); text-shadow: 0 2px 4px rgba(4, 36, 40, 0.85);">Expert Hands You Can Trust</h3>
                    <p style="color: var(--color-white); font-size: 0.95rem; text-shadow: 0 1px 3px rgba(4, 36, 40, 0.85);">
                        Kelum has over a decade of hands-on experience tuning and repairing Sri Lankan vehicles. We use genuine parts and honest, transparent pricing for all travelers.
                    </p>
                    <span style="font-weight: 700; color: var(--color-gold); font-size: 0.9rem; text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Emergency Phone: <?php echo PHONE_MOBILE; ?></span>
                </div>
            </div>

            <!-- Pillar 5: Traditional Sri Lankan Village Weddings -->
            <div id="weddings" class="service-pillar-row reveal">
                <div class="timeline-node">5</div>
                <div>
                    <span class="badge-sub">Unique Cultural Events</span>
                    <h2 class="heading-lg">5. Traditional Sri Lankan Village Weddings</h2>
                    <p style="font-size: 1.05rem; color: var(--color-text-muted); margin-bottom: 1rem;">
                        Dreaming of a unique, culturally rich wedding? We can organize a beautiful, authentic traditional Sri Lankan style wedding ceremony nestled in a scenic, rural Sri Lankan village.
                    </p>
                    
                    <ul class="pillar-bullet-list">
                        <li>
                            <span class="bullet-icon">🌸</span>
                            <span><strong>Authentic Village Setting</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🏛️</span>
                            <span><strong>Traditional Poruwa Rituals</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🥁</span>
                            <span><strong>Dancers & Drumming Procession</strong></span>
                        </li>
                        <li>
                            <span class="bullet-icon">🍛</span>
                            <span><strong>Delicious Traditional Feast</strong></span>
                        </li>
                    </ul>

                    <a href="<?php echo get_whatsapp_url('Hi Kelum, I am interested in organizing a traditional Sri Lankan village wedding ceremony!'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                        Inquire Wedding Booking via WhatsApp
                    </a>
                </div>

                <div class="service-graphic-box" style="background-image: linear-gradient(rgba(4, 36, 40, 0.45), rgba(4, 36, 40, 0.6)), url('assets/images/wedding.png'); background-size: cover; background-position: center; border: none; color: var(--color-white);">
                    <div class="service-icon-box" style="width: 70px; height: 70px; background: rgba(255, 255, 255, 0.15); color: var(--color-gold); backdrop-filter: blur(4px);">
                        <svg viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                    </div>
                    <h3 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-white); text-shadow: 0 2px 4px rgba(4, 36, 40, 0.85);">Custom Wedding Planning</h3>
                    <p style="color: var(--color-white); font-size: 0.95rem; text-shadow: 0 1px 3px rgba(4, 36, 40, 0.85);">
                        From traditional Kandyan wedding attire (Mul Anduma and Osariya) and a beautifully decorated wooden Poruwa, to local drumming, dancers, blessings, and a delicious village feast—we take care of every detail.
                    </p>
                    <span style="font-weight: 700; color: var(--color-gold); font-size: 0.9rem; text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Tailored to your preferences for a magical celebration</span>
                </div>
            </div>

        </div>
    </section>
</main>

<style>
.services-timeline-container {
    position: relative;
    padding-top: 3rem;
    padding-bottom: 3rem;
}

.timeline-node {
    display: none;
}

/* Scroll reveal vertical slide-in animations for service pillars */
.service-pillar-row.reveal {
    opacity: 0;
    transform: translateY(40px);
    transition: opacity 0.85s cubic-bezier(0.16, 1, 0.3, 1), transform 0.85s cubic-bezier(0.16, 1, 0.3, 1);
}

.service-pillar-row.reveal.active {
    opacity: 1;
    transform: translateY(0);
}

@media (min-width: 993px) {
    /* Central vertical timeline chain line */
    .services-timeline-container::before {
        content: '';
        position: absolute;
        top: 0;
        bottom: 0;
        left: 50%;
        width: 2px;
        background: linear-gradient(to bottom, var(--color-teal-medium) 0%, var(--color-coral) 50%, var(--color-teal-dark) 100%);
        transform: translateX(-50%);
        z-index: 1;
        opacity: 0.8;
    }
    
    .service-pillar-row {
        position: relative;
        border-bottom: none !important;
        padding: 4rem 0 !important;
    }
    
    .timeline-node {
        display: flex;
        position: absolute;
        left: 50%;
        top: 50%;
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: var(--color-white);
        border: 3px solid var(--color-white);
        color: var(--color-white);
        font-family: var(--font-heading);
        font-weight: 700;
        font-size: 1.1rem;
        align-items: center;
        justify-content: center;
        z-index: 10;
        box-shadow: 0 4px 12px rgba(4, 36, 40, 0.18);
        transform: translate(-50%, -50%) scale(0);
        transition: transform 0.6s cubic-bezier(0.34, 1.56, 0.64, 1) 0.2s, background 0.3s, border-color 0.3s, color 0.3s, box-shadow 0.3s;
    }
    
    .service-pillar-row.reveal.active .timeline-node {
        transform: translate(-50%, -50%) scale(1);
    }
    
    /* Individual colors for timeline nodes */
    #food .timeline-node { background: var(--color-gold); }
    #tours .timeline-node { background: var(--color-coral); }
    #rentals .timeline-node { background: #147e87; }
    #repairs .timeline-node { background: #2e7d32; }
    #weddings .timeline-node { background: var(--color-gold); }
    
    /* Vibrant hover triggers with colorful glowing shadows */
    #food.reveal.active:hover .timeline-node { transform: translate(-50%, -50%) scale(1.22); box-shadow: 0 0 20px rgba(217, 171, 85, 0.6); }
    #tours.reveal.active:hover .timeline-node { transform: translate(-50%, -50%) scale(1.22); box-shadow: 0 0 20px rgba(235, 94, 67, 0.6); }
    #rentals.reveal.active:hover .timeline-node { transform: translate(-50%, -50%) scale(1.22); box-shadow: 0 0 20px rgba(20, 126, 135, 0.6); }
    #repairs.reveal.active:hover .timeline-node { transform: translate(-50%, -50%) scale(1.22); box-shadow: 0 0 20px rgba(46, 125, 50, 0.6); }
    #weddings.reveal.active:hover .timeline-node { transform: translate(-50%, -50%) scale(1.22); box-shadow: 0 0 20px rgba(217, 171, 85, 0.6); }
}
</style>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
