<?php
require_once __DIR__ . '/includes/db.php';

// Fetch first 2 accommodations for homepage teaser
$acc_query = "SELECT * FROM accommodations ORDER BY id ASC LIMIT 2";
$acc_result = $db_conn->query($acc_query);
$rooms = [];
if ($acc_result && $acc_result->num_rows > 0) {
    while ($row = $acc_result->fetch_assoc()) {
        $rooms[] = $row;
    }
}

$pageTitle = 'Guest House & Island Experience';
$pageDesc = 'Welcome to Hidden Lanka in Sri Lanka. Enjoy villa accommodation, authentic home-cooked meals, guided island tours, tuk-tuk & motorbike rentals and workshop repairs with host P H C Kelum.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Hero Section -->
    <section class="hero-section home-hero">
        <div class="container">
            <div class="hero-grid">
                <div class="hero-content">
                    <span class="badge-sub" style="background: rgba(212, 175, 55, 0.2); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.3);">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        Welcome to Paradise in Sri Lanka
                    </span>
                    <h1 class="heading-xl hero-title"><?php echo SITE_NAME; ?></h1>
                    <p class="hero-desc">Experience the heart of Sri Lanka: wander through peaceful rural villages, savor rich traditional village cuisine, and enjoy a cozy overnight stay.</p>
                    
                    <div class="hero-cta-group">
                        <a href="<?php echo get_whatsapp_url('Hi Kelum, I am planning a trip and would like to check room availability!'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.33 5.001l-1.414 5.16 5.283-1.385c1.464.798 3.118 1.218 4.79 1.219h.004c5.505 0 9.988-4.478 9.989-9.985 0-2.668-1.037-5.176-2.924-7.062-1.886-1.887-4.394-2.932-7.068-2.932zm0 1.666c4.587 0 8.322 3.733 8.323 8.318 0 2.23-.867 4.327-2.446 5.904-1.579 1.577-3.676 2.444-5.908 2.444h-.003c-1.446 0-2.868-.378-4.113-1.093l-.295-.17-3.055.801.815-2.978-.187-.298c-.787-1.253-1.203-2.705-1.203-4.187 0-4.585 3.735-8.319 8.322-8.319z"/></svg>
                            Instant WhatsApp Booking
                        </a>
                        <a href="accommodation.php" class="btn btn-white">
                            Explore Villa Rooms
                        </a>
                    </div>
                </div>

                <!-- Hero Feature Card Visual -->
                <div class="hero-card-visual">
                    <div class="hero-feature-item">
                        <div class="hero-feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M12 3L2 12h3v8h6v-6h2v6h6v-8h3L12 3z"/></svg>
                        </div>
                        <div>
                            <h4>Villa Stay</h4>
                        </div>
                    </div>
                    
                    <div class="hero-feature-item">
                        <div class="hero-feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M11 9H9V2H7v7H5V2H3v7c0 2.12 1.46 3.9 3.43 4.38l-.43 7.62h2l.43-7.62C10.54 12.9 12 11.12 12 9V2h-1v7zm9-7h-1c-1.66 0-3 1.34-3 3v6h2v10h2V2z"/></svg>
                        </div>
                        <div>
                            <h4>Authentic Home Cooking</h4>
                        </div>
                    </div>

                    <div class="hero-feature-item">
                        <div class="hero-feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M20.5 3l-.16.03L15 5.1 9 3 3.36 4.9c-.21.07-.36.25-.36.48V20.5c0 .28.22.5.5.5l.16-.03L9 18.9l6 2.1 5.64-1.9c.21-.07.36-.25.36-.48V3.5c0-.28-.22-.5-.5-.5zM15 19l-6-2.11V5l6 2.11V19z"/></svg>
                        </div>
                        <div>
                            <h4>Guided Island Tours</h4>
                        </div>
                    </div>

                    <div class="hero-feature-item">
                        <div class="hero-feature-icon">
                            <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3zM19 17H5v-4h14v4z"/></svg>
                        </div>
                        <div>
                            <h4>Rentals & Workshop Repair</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 4-Service Highlight Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="section-title-wrap">
                <span class="badge-sub">What We Offer</span>
                <h2 class="heading-lg">Your Complete Sri Lankan Island Experience</h2>
                <p class="lead-text">Everything you need for an unforgettable island holiday, under one warm host's care.</p>
            </div>

            <div class="grid-4">
                <!-- Service 1 -->
                <div class="card-service service-food reveal" style="transition-delay: 0.1s;">
                    <div class="card-service-image">
                        <img src="assets/images/11.jpg" alt="Home-Cooked Sri Lankan Food">
                    </div>
                    <div class="card-service-content">
                        <div class="service-icon-box">
                            <svg viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/></svg>
                        </div>
                        <h3 class="heading-sm">Home-Cooked Food</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">Taste authentic Sri Lankan family recipes cooked fresh daily using locally caught fish, spices, and coconut.</p>
                        <a href="service.php#food" class="btn btn-primary" style="margin-top: auto;">Learn More</a>
                    </div>
                </div>
 
                <!-- Service 2 -->
                <div class="card-service service-tours reveal" style="transition-delay: 0.2s;">
                    <div class="card-service-image">
                        <img src="assets/images/10.jpg" alt="Guided Tours in Sri Lanka">
                    </div>
                    <div class="card-service-content">
                        <div class="service-icon-box">
                            <svg viewBox="0 0 24 24"><path d="M21 16v-2l-8-5V3.5c0-.83-.67-1.5-1.5-1.5S10 2.67 10 3.5V9l-8 5v2l8-2.5V19l-2 1.5V22l3.5-1 3.5 1v-1.5L13 19v-5.5l8 2.5z"/></svg>
                        </div>
                        <h3 class="heading-sm">Guided Tours</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">Custom tuk-tuk & car tours to hidden beaches, waterfalls, tea country viewpoints, and wildlife safaris.</p>
                        <a href="service.php#tours" class="btn btn-primary" style="margin-top: auto;">Learn More</a>
                    </div>
                </div>
 
                <!-- Service 3 -->
                <div class="card-service service-rentals reveal" style="transition-delay: 0.3s;">
                    <div class="card-service-image">
                        <img src="assets/images/12.jpg" alt="Tuk Tuk and Motorbike Rentals">
                    </div>
                    <div class="card-service-content">
                        <div class="service-icon-box">
                            <svg viewBox="0 0 24 24"><path d="M18.92 6.01C18.72 5.42 18.16 5 17.5 5h-11c-.66 0-1.21.42-1.42 1.01L3 12v8c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-1h12v1c0 .55.45 1 1 1h1c.55 0 1-.45 1-1v-8l-2.08-5.99zM6.85 7h10.29l1.04 3H5.81l1.04-3z"/></svg>
                        </div>
                        <h3 class="heading-sm">Tuk Tuk & Bike Rental</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">Rent your own tuk-tuk or scooter with full driving lesson, permit help, and flexible daily/weekly rates.</p>
                        <a href="service.php#rentals" class="btn btn-primary" style="margin-top: auto;">Learn More</a>
                    </div>
                </div>
 
                <!-- Service 4 -->
                <div class="card-service service-repairs reveal" style="transition-delay: 0.4s;">
                    <div class="card-service-image">
                        <img src="assets/images/13.jpg" alt="Workshop Repair Garage">
                    </div>
                    <div class="card-service-content">
                        <div class="service-icon-box">
                            <svg viewBox="0 0 24 24"><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>
                        </div>
                        <h3 class="heading-sm">Workshop & Repair</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">On-site garage offering quick repairs, tyre changes, engine tune-ups, and emergency road assistance.</p>
                        <a href="service.php#repairs" class="btn btn-primary" style="margin-top: auto;">Learn More</a>
                    </div>
                </div>
 
                <!-- Service 5 -->
                <div class="card-service service-wedding reveal" style="transition-delay: 0.5s;">
                    <div class="card-service-image">
                        <img src="assets/images/wedding.png" alt="Traditional Sri Lankan Village Wedding">
                    </div>
                    <div class="card-service-content">
                        <div class="service-icon-box">
                            <svg viewBox="0 0 24 24"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                        </div>
                        <h3 class="heading-sm">Traditional Weddings</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">Beautiful, authentic traditional Sri Lankan style village wedding ceremonies, fully organized in detail.</p>
                        <a href="service.php#weddings" class="btn btn-primary" style="margin-top: auto;">Learn More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Teaser -->
    <section class="section-padding reveal" style="position: relative; background: url('assets/images/tours/tour-beach.jpg') no-repeat center center/cover; padding: 6rem 0; overflow: hidden; color: var(--color-white);">
        <!-- Deep Teal Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.60) 100%); z-index: 1;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <div style="max-width: 800px; margin: 0 auto; text-align: center;">
                <div>
                    <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Meet Your Host</span>
                    <h2 class="heading-lg" style="color: var(--color-white); margin-top: 1rem; margin-bottom: 1.5rem; text-shadow: 0 2px 8px rgba(4, 36, 40, 0.85), 0 1px 3px rgba(4, 36, 40, 0.9);">Personal Sri Lankan Hospitality by P H C Kelum</h2>
                    <p style="font-size: 1.1rem; margin-bottom: 1.25rem; color: var(--color-white); line-height: 1.7; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85);">
                        At <strong>Hidden Lanka</strong>, we believe travel is about genuine connections. Situated in the serene southern region, our guest house was built to give travelers an authentic home away from home.
                    </p>
                    <p style="font-size: 1.1rem; margin-bottom: 2.5rem; color: var(--color-white); line-height: 1.7; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85);">
                        Owner Kelum brings years of local knowledge, mechanical expertise, and warm Sri Lankan smiles to ensure your stay is peaceful, safe, and rich in local culture.
                    </p>
                    <div style="display: flex; gap: 1.5rem; align-items: center; justify-content: center; flex-wrap: wrap;">
                        <a href="about.php" class="btn btn-secondary" style="background: var(--color-white); color: var(--color-teal-dark); border-color: var(--color-white);">Read Our Story</a>
                        <a href="tel:<?php echo PHONE_MOBILE_RAW; ?>" class="btn" style="color: var(--color-white); border: 2px solid var(--color-white); font-weight: 700; padding: 0.85rem 2rem; font-size: 0.95rem; border-radius: var(--radius-sm); text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; transition: all 0.25s ease;" onmouseover="this.style.background='var(--color-white)'; this.style.color='var(--color-teal-dark)';" onmouseout="this.style.background='transparent'; this.style.color='var(--color-white)';">
                            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            Direct Phone: <?php echo PHONE_MOBILE; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Traditional Sri Lankan Village Wedding Section -->
    <section class="section-padding reveal" style="background: var(--color-white);">
        <div class="container">
            <div style="display: grid; grid-template-columns: 1.2fr 1fr; gap: 4rem; align-items: center;" class="wedding-grid">
                
                <!-- Left: Text content -->
                <div>
                    <span class="badge-sub">Unique Cultural Events</span>
                    <h2 class="heading-lg" style="margin-top: 0.75rem; margin-bottom: 1.5rem; color: var(--color-teal-dark);">Traditional Sri Lankan Village Weddings</h2>
                    
                    <p style="font-size: 1.05rem; line-height: 1.7; color: var(--color-text-muted); margin-bottom: 1.25rem;">
                        Dreaming of a unique, culturally rich wedding? We can organize a beautiful, authentic **traditional Sri Lankan style wedding ceremony** nestled in a scenic, rural Sri Lankan village. 
                    </p>
                    <p style="font-size: 1.05rem; line-height: 1.7; color: var(--color-text-muted); margin-bottom: 2rem;">
                        From traditional Kandyan wedding attire (Mul Anduma and Osariya) and a beautifully decorated wooden Poruwa, to local drumming, dancers, blessings, and a delicious village feast—we take care of every detail to create a magical celebration for you and your guests.
                    </p>
                    
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
                        <a href="<?php echo get_whatsapp_url('Hi Kelum, I am interested in organizing a traditional Sri Lankan village wedding ceremony!'); ?>" class="btn btn-primary" target="_blank" rel="noopener">
                            Inquire Wedding Booking
                        </a>
                        <a href="service.php#weddings" class="btn btn-outline" style="border-color: var(--color-teal-medium); color: var(--color-teal-medium);">
                            Learn More
                        </a>
                    </div>
                </div>

                <!-- Right: Visual Card with stats/features -->
                <div style="background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.65) 100%), url('assets/images/wedding.png') no-repeat center center; background-size: cover; border: 1px solid var(--color-sand-border); border-radius: var(--radius-md); padding: 2.5rem; box-shadow: var(--shadow-sm); position: relative; overflow: hidden;" class="wedding-features-card">
                    <!-- Subtle background SVG floral icon or pattern -->
                    <svg viewBox="0 0 24 24" width="120" height="120" fill="currentColor" style="position: absolute; bottom: -20px; right: -20px; color: rgba(255, 255, 255, 0.04); pointer-events: none;"><path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/></svg>
                    
                    <h3 class="heading-sm" style="margin-top: 0; margin-bottom: 1.5rem; color: var(--color-white); border-bottom: 2px solid var(--color-gold); padding-bottom: 0.5rem; display: inline-block; text-shadow: 0 2px 4px rgba(0,0,0,0.65);">Wedding Highlights</h3>
                    
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 1.25rem;">
                        <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                            <span style="color: var(--color-gold); font-size: 1.2rem; line-height: 1; margin-top: 0.15rem; text-shadow: 0 1px 3px rgba(0,0,0,0.65);">★</span>
                            <div>
                                <strong style="color: var(--color-white); font-size: 0.95rem; display: block; text-shadow: 0 1px 3px rgba(0,0,0,0.75);">Authentic Village Setting</strong>
                                <span style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.95); font-weight: 500; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.85);">Celebrate in a scenic rural village surrounded by lush nature.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                            <span style="color: var(--color-gold); font-size: 1.2rem; line-height: 1; margin-top: 0.15rem; text-shadow: 0 1px 3px rgba(0,0,0,0.65);">★</span>
                            <div>
                                <strong style="color: var(--color-white); font-size: 0.95rem; display: block; text-shadow: 0 1px 3px rgba(0,0,0,0.75);">Traditional Poruwa Rituals</strong>
                                <span style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.95); font-weight: 500; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.85);">Perform blessing rituals on a beautifully crafted wooden platform.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                            <span style="color: var(--color-gold); font-size: 1.2rem; line-height: 1; margin-top: 0.15rem; text-shadow: 0 1px 3px rgba(0,0,0,0.65);">★</span>
                            <div>
                                <strong style="color: var(--color-white); font-size: 0.95rem; display: block; text-shadow: 0 1px 3px rgba(0,0,0,0.75);">Dancers & Drumming</strong>
                                <span style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.95); font-weight: 500; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.85);">Traditional Kandyan drummers and dancers to lead your procession.</span>
                            </div>
                        </li>
                        <li style="display: flex; align-items: flex-start; gap: 0.75rem;">
                            <span style="color: var(--color-gold); font-size: 1.2rem; line-height: 1; margin-top: 0.15rem; text-shadow: 0 1px 3px rgba(0,0,0,0.65);">★</span>
                            <div>
                                <strong style="color: var(--color-white); font-size: 0.95rem; display: block; text-shadow: 0 1px 3px rgba(0,0,0,0.75);">Authentic Village Feast</strong>
                                <span style="font-size: 0.88rem; color: rgba(255, 255, 255, 0.95); font-weight: 500; text-shadow: 0 1px 3px rgba(0, 0, 0, 0.85);">Enjoy custom-cooked traditional Sri Lankan village meals.</span>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </div>
    </section>

    <style>
        @media (max-width: 992px) {
            .wedding-grid {
                grid-template-columns: 1fr !important;
                gap: 2.5rem !important;
            }
        }
    </style>

    <!-- Local Experiences Gallery Section -->
    <section class="section-padding reveal" style="background: var(--color-white); border-top: 1px solid var(--color-sand-border);">
        <div class="container">
            <div class="section-title-wrap" style="text-align: center; margin-bottom: 3.5rem;">
                <span class="badge-sub">Create Memories</span>
                <h2 class="heading-lg">Authentic Island & Village Experiences</h2>
                <p class="lead-text" style="max-width: 700px; margin: 0.75rem auto 0;">Beyond accommodation, we help you discover the true essence of Sri Lankan life through unique local activities.</p>
            </div>

            <div class="experiences-slider-wrapper">
                <!-- Floating Nav Arrows for Mobile -->
                <button class="exp-nav-btn exp-nav-prev" id="expPrevBtn" aria-label="Previous experience">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M15 18l-6-6 6-6"/></svg>
                </button>

                <div class="experiences-grid" id="experiencesSlider">
                    <!-- Card 1: Beach Party (B1.jpg) -->
                    <div class="experience-card reveal" style="transition-delay: 0.2s;">
                        <div class="experience-img-wrap">
                            <img src="assets/images/B1.jpg" alt="Vibrant Beach Parties & Nightlife" class="experience-img">
                        </div>
                        <div class="experience-overlay">
                            <span class="experience-badge" style="background: var(--color-coral);">Nightlife</span>
                            <h3 class="experience-title">Vibrant Beach Parties</h3>
                        </div>
                    </div>

                    <!-- Card 2: King Coconut (B2.jpg) -->
                    <div class="experience-card reveal" style="transition-delay: 0.4s;">
                        <div class="experience-img-wrap">
                            <img src="assets/images/B2.jpg" alt="Fresh King Coconuts" class="experience-img">
                        </div>
                        <div class="experience-overlay">
                            <span class="experience-badge" style="background: var(--color-gold);">Local Flavors</span>
                            <h3 class="experience-title">Fresh King Coconuts</h3>
                        </div>
                    </div>

                    <!-- Card 3: BBQ Steak (B3.jpg) -->
                    <div class="experience-card reveal" style="transition-delay: 0.6s;">
                        <div class="experience-img-wrap">
                            <img src="assets/images/B3.jpg" alt="Garden BBQ Grilling" class="experience-img">
                        </div>
                        <div class="experience-overlay">
                            <span class="experience-badge" style="background: var(--color-teal-medium);">Culinary</span>
                            <h3 class="experience-title">Garden BBQ Feasts</h3>
                        </div>
                    </div>

                    <!-- Card 4: Bullock Cart (B4.jpg) -->
                    <div class="experience-card reveal" style="transition-delay: 0.8s;">
                        <div class="experience-img-wrap">
                            <img src="assets/images/B4.jpg" alt="Traditional Bullock Cart Ride" class="experience-img">
                        </div>
                        <div class="experience-overlay">
                            <span class="experience-badge" style="background: var(--color-teal-dark); color: var(--color-white);">Heritage</span>
                            <h3 class="experience-title">Village Bullock Cart Rides</h3>
                        </div>
                    </div>

                    <!-- Card 5: Chena Hut (B5.jpg) -->
                    <div class="experience-card reveal" style="transition-delay: 1.0s;">
                        <div class="experience-img-wrap">
                            <img src="assets/images/B5.jpg" alt="Traditional Chena Huts & Paddy Fields" class="experience-img">
                        </div>
                        <div class="experience-overlay">
                            <span class="experience-badge" style="background: #2e7d32; color: var(--color-white);">Rural Life</span>
                            <h3 class="experience-title">Paddy Fields & Chena Huts</h3>
                        </div>
                    </div>
                </div>

                <button class="exp-nav-btn exp-nav-next" id="expNextBtn" aria-label="Next experience">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 18l6-6-6-6"/></svg>
                </button>
            </div>

            <!-- Dots Pagination for Mobile Slideshow -->
            <div class="experiences-pagination" id="expPagination">
                <button class="exp-dot active" aria-label="Slide 1"></button>
                <button class="exp-dot" aria-label="Slide 2"></button>
                <button class="exp-dot" aria-label="Slide 3"></button>
                <button class="exp-dot" aria-label="Slide 4"></button>
                <button class="exp-dot" aria-label="Slide 5"></button>
            </div>

        </div>
    </section>

    <!-- Accommodations Teaser -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="section-title-wrap">
                <span class="badge-sub">Stay With Us</span>
                <h2 class="heading-lg">Villa-Style Accommodations</h2>
                <p class="lead-text">Clean, comfortable rooms designed for peaceful relaxation and equipped with modern guest amenities.</p>
            </div>

            <div class="grid-2">
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
                            <h3 style="color: var(--color-white); font-size: 1.4rem; margin-bottom: 0.3rem; text-shadow: 0 2px 4px rgba(0,0,0,0.3); font-weight:700;"><?php echo htmlspecialchars($r['title']); ?></h3>
                            <p style="font-size: 0.85rem; color: rgba(255,255,255,0.9); margin: 0; text-shadow: 0 1px 3px rgba(0,0,0,0.3);"><?php echo htmlspecialchars($r['subtitle']); ?></p>
                        </div>

                        <!-- Card Body -->
                        <div class="villa-card-body" style="padding: 2rem; display: flex; flex-direction: column; flex: 1; background: var(--color-white);">
                            <p style="color: var(--color-text-muted); margin-bottom: 1.5rem; font-size: 0.95rem; line-height: 1.6;">
                                <?php 
                                    $desc_preview = strip_tags($r['description']);
                                    if (strlen($desc_preview) > 130) {
                                        $desc_preview = substr($desc_preview, 0, 127) . '...';
                                    }
                                    echo htmlspecialchars($desc_preview);
                                ?>
                            </p>
                            
                            <?php 
                                $amenities = array_filter(array_map('trim', explode(',', $r['amenities'])));
                                if (!empty($amenities)): 
                            ?>
                                <ul class="amenities-list" style="margin-bottom: 1.5rem;">
                                    <?php 
                                        $limit_amenities = array_slice($amenities, 0, 4);
                                        foreach ($limit_amenities as $am): 
                                    ?>
                                        <li class="amenity-chip"><?php echo htmlspecialchars($am); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <div class="villa-price" style="margin-top: auto; padding-top: 1.25rem; border-top: 1px solid var(--color-sand-border); display: flex; justify-content: space-between; align-items: center;">
                                <div class="price-val" style="font-size: 1.2rem; font-weight: 700; color: var(--color-teal-dark);"><?php echo htmlspecialchars($r['price']); ?></div>
                                <a href="accommodation_details?id=<?php echo $r['id']; ?>" class="btn btn-secondary btn-sm" style="padding: 0.55rem 1.25rem; font-size: 0.88rem;">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <!-- View All Accommodations Button -->
            <div style="text-align: center; margin-top: 3.5rem;">
                <a href="accommodation" class="btn btn-primary" style="padding: 0.85rem 2.5rem; font-size: 0.95rem; display: inline-flex; align-items: center; gap: 0.5rem; border-radius: var(--radius-sm); font-weight: 700;">
                    View All Accommodations
                </a>
            </div>
        </div>
    </section>

    <!-- Guest Testimonial Teaser -->
    <section class="section-padding reveal" style="position: relative; background: url('assets/images/tours/tour-ella.jpg') no-repeat center center/cover; padding: 6rem 0; overflow: hidden;">
        <!-- Deep Teal Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.60) 100%); z-index: 1;"></div>
        
        <div class="container" style="position: relative; z-index: 2;">
            <div class="section-title-wrap" style="text-align: center; margin-bottom: 3.5rem;">
                <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Guest Feedback</span>
                <h2 class="heading-lg" style="color: var(--color-white); margin-top: 0.75rem; text-shadow: 0 2px 8px rgba(4, 36, 40, 0.85), 0 1px 3px rgba(4, 36, 40, 0.9);">Loved by Travelers Worldwide</h2>
            </div>

            <div class="grid-3">
                <div class="review-card">
                    <div class="stars-row" style="justify-content: flex-start;">★★★★★</div>
                    <p style="font-style: italic; font-size: 0.95rem;">"Kelum's guest house was the highlight of our 2 weeks in Sri Lanka! The home-cooked curry was the best meal we had, and renting his tuk-tuk gave us total freedom."</p>
                    <div class="reviewer-meta">
                        <div class="reviewer-avatar">JS</div>
                        <div class="reviewer-info">
                            <h4>Julian & Sarah</h4>
                            <p>Germany • Stayed 5 Nights</p>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="stars-row" style="justify-content: flex-start;">★★★★★</div>
                    <p style="font-style: italic; font-size: 0.95rem;">"When our rented motorbike had a flat tire down the road, Kelum came with his tools within 15 minutes and fixed it on the spot! Incredible host."</p>
                    <div class="reviewer-meta">
                        <div class="reviewer-avatar">MK</div>
                        <div class="reviewer-info">
                            <h4>Marco Rossi</h4>
                            <p>Italy • Motorbike Tourer</p>
                        </div>
                    </div>
                </div>

                <div class="review-card">
                    <div class="stars-row" style="justify-content: flex-start;">★★★★★</div>
                    <p style="font-style: italic; font-size: 0.95rem;">"Clean and comfortable rooms, amazing host family, and excellent local tour suggestions. We felt like family from day one!"</p>
                    <div class="reviewer-meta">
                        <div class="reviewer-avatar">EH</div>
                        <div class="reviewer-info">
                            <h4>Emma & Harry</h4>
                            <p>UK • Backpacker Couple</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="text-align: center; margin-top: 3.5rem;">
                <a href="review.php" class="btn btn-outline" style="color: var(--color-white); border: 2px solid var(--color-white); transition: all 0.25s ease;" onmouseover="this.style.background='var(--color-white)'; this.style.color='var(--color-teal-dark)';" onmouseout="this.style.background='transparent'; this.style.color='var(--color-white)';">Read All Guest Reviews</a>
            </div>
        </div>
    </section>

    <!-- Global CTA Banner -->
    <section class="section-padding reveal">
        <div class="container">
            <div class="cta-banner">
                <h2>Ready for an Unforgettable Island Escape?</h2>
                <p>Contact P H C Kelum directly on WhatsApp for instant room availability, customized tour plans, or vehicle rental quotes.</p>
                <div class="cta-actions">
                    <a href="<?php echo get_whatsapp_url('Hi Kelum! I want to inquire about availability and rates.'); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener">
                        Chat on WhatsApp
                    </a>
                    <a href="tel:<?php echo PHONE_LANDLINE_RAW; ?>" class="btn btn-outline" style="border-color: var(--color-white); color: var(--color-white);">
                        Call Landline
                    </a>
                </div>
            </div>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
