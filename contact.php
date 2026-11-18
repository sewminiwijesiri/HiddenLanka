<?php
$pageTitle = 'Contact Us - Get in Touch';
$pageDesc = 'Contact Hidden Lanka in Sri Lanka. Reach out to host P H C Kelum for villa room bookings, tuk-tuk & scooter rentals, and custom island tours.';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/nav.php';
?>

<main>
    <!-- Page Banner -->
    <section class="hero-section" style="position: relative; background: url('assets/images/tours/tour-beach.jpg') no-repeat center center/cover; padding: 5rem 0 5.5rem; overflow: hidden; color: var(--color-white);">
        <!-- Deep Teal Overlay -->
        <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(135deg, rgba(6, 60, 64, 0.45) 0%, rgba(3, 28, 31, 0.60) 100%); z-index: 1;"></div>
        
        <div class="container text-center" style="position: relative; z-index: 2; text-align: center;">
            <span class="badge-sub" style="background: rgba(212, 175, 55, 0.3); color: var(--color-gold); border-color: rgba(212, 175, 55, 0.5); text-shadow: 0 1px 2px rgba(4, 36, 40, 0.8);">Get In Touch</span>
            <h1 class="heading-xl hero-title" style="background: linear-gradient(135deg, var(--color-white) 40%, var(--color-gold) 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; margin-bottom: 0.75rem; text-shadow: none;">Contact Hidden Lanka</h1>
            <p class="lead-text" style="color: var(--color-white); margin: 0 auto; text-shadow: 0 1px 4px rgba(4, 36, 40, 0.85);">Have questions about rooms, vehicle rentals, or guided tours? Reach out to host Kelum anytime.</p>
        </div>
    </section>

    <!-- Contact Content Grid -->
    <section class="section-padding reveal" style="background: var(--color-sand-bg);">
        <div class="container">
            <div class="grid-2" style="align-items: stretch; gap: 4rem;">
                
                <!-- Contact Form Card -->
                <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 3rem; border: 1px solid var(--color-sand-border); border-top: 4px solid var(--color-gold); box-shadow: var(--shadow-md); display: flex; flex-direction: column; height: 100%;">
                    <h2 class="heading-md" style="margin-bottom: 0.5rem; color: var(--color-teal-dark);">Send a Message</h2>
                    <p style="color: var(--color-text-muted); margin-bottom: 2rem; font-size: 0.95rem;">Fill out the form below and we will get back to you within 24 hours.</p>
                    
                    <form onsubmit="sendWhatsAppMessage(event)" style="display: flex; flex-direction: column; gap: 1.5rem; flex: 1;">
                        <div>
                            <label for="name" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--color-teal-dark); margin-bottom: 0.5rem;">Your Name *</label>
                            <input type="text" id="name" name="name" required style="width: 100%; padding: 0.85rem 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); font-family: var(--font-body); font-size: 0.95rem; color: var(--color-text-dark); background-color: var(--color-sand-bg); outline: none; transition: var(--transition-fast);">
                        </div>

                        <div>
                            <label for="message" style="display: block; font-size: 0.9rem; font-weight: 600; color: var(--color-teal-dark); margin-bottom: 0.5rem;">Your Message *</label>
                            <textarea id="message" name="message" rows="5" required style="width: 100%; padding: 0.85rem 1.25rem; border-radius: var(--radius-sm); border: 1px solid var(--color-sand-border); font-family: var(--font-body); font-size: 0.95rem; color: var(--color-text-dark); background-color: var(--color-sand-bg); outline: none; resize: vertical; transition: var(--transition-fast);"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary" style="align-self: flex-start; min-width: 160px; margin-top: auto;">Send Message</button>
                    </form>
                </div>

                <!-- Contact Channels Column -->
                <div style="display: flex; flex-direction: column; gap: 2rem; height: 100%;">
                    
                    <!-- WhatsApp Priority Card -->
                    <div class="card-service" style="padding: 2.25rem; border: 1px solid var(--color-sand-border); border-top: 4px solid #25D366; background: var(--color-white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; flex: 1;">
                        <div class="service-icon-box" style="background: rgba(37, 211, 102, 0.1); color: #25D366; width: 50px; height: 50px; border-radius: 12px; margin-bottom: 1.25rem;">
                            <svg viewBox="0 0 24 24" style="width: 26px; height: 26px;"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984 0 1.763.459 3.483 1.33 5.001l-1.414 5.16 5.283-1.385c1.464.798 3.118 1.218 4.79 1.219h.004c5.505 0 9.988-4.478 9.989-9.985 0-2.668-1.037-5.176-2.924-7.062-1.886-1.887-4.394-2.932-7.068-2.932zm0 1.666c4.587 0 8.322 3.733 8.323 8.318 0 2.23-.867 4.327-2.446 5.904-1.579 1.577-3.676 2.444-5.908 2.444h-.003c-1.446 0-2.868-.378-4.113-1.093l-.295-.17-3.055.801.815-2.978-.187-.298c-.787-1.253-1.203-2.705-1.203-4.187 0-4.585 3.735-8.319 8.322-8.319z"/></svg>
                        </div>
                        <h3 class="heading-sm" style="margin-bottom: 0.5rem; color: var(--color-teal-dark);">Direct WhatsApp Chat</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">For instant responses, room availability checks, and booking quotes, message host Kelum directly.</p>
                        <a href="<?php echo get_whatsapp_url('Hi Kelum, I am visiting your website and have a question.'); ?>" class="btn btn-whatsapp" target="_blank" rel="noopener" style="align-self: flex-start; margin-top: auto;">
                            Chat on WhatsApp
                        </a>
                    </div>
 
                    <!-- Direct Calls Card -->
                    <div class="card-service" style="padding: 2.25rem; border: 1px solid var(--color-sand-border); border-top: 4px solid var(--color-coral); background: var(--color-white); border-radius: var(--radius-md); box-shadow: var(--shadow-sm); display: flex; flex-direction: column; flex: 1;">
                        <div class="service-icon-box" style="width: 50px; height: 50px; border-radius: 12px; margin-bottom: 1.25rem; background: rgba(235, 94, 67, 0.1); color: var(--color-coral); display: flex; align-items: center; justify-content: center;">
                            <svg viewBox="0 0 24 24" style="width: 26px; height: 26px;"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                        </div>
                        <h3 class="heading-sm" style="margin-bottom: 0.5rem; color: var(--color-teal-dark);">Call Host Support</h3>
                        <p style="color: var(--color-text-muted); font-size: 0.95rem; margin-bottom: 1.25rem;">Speak with Kelum directly over regular phone line:</p>
                        <div style="display: flex; flex-direction: column; gap: 0.5rem; font-weight: 700; color: var(--color-teal-main); margin-top: auto;">
                            <span>Mobile: <a href="tel:<?php echo PHONE_MOBILE_RAW; ?>" style="color: var(--color-coral); text-decoration: none;"><?php echo PHONE_MOBILE; ?></a></span>
                            <span>Landline: <a href="tel:<?php echo PHONE_LANDLINE_RAW; ?>" style="color: var(--color-coral); text-decoration: none;"><?php echo PHONE_LANDLINE; ?></a></span>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <!-- Map Embed Section -->
    <section class="section-padding reveal" style="background: var(--color-sand-card); border-top: 1px solid var(--color-sand-border);">
        <div class="container text-center">
            <div class="section-title-wrap" style="margin-bottom: 3rem;">
                <span class="badge-sub" style="background: rgba(14, 94, 101, 0.1); color: var(--color-teal-dark);">Find Us</span>
                <h2 class="heading-lg" style="margin-bottom: 0.5rem; color: var(--color-teal-dark);">Our Location on Google Maps</h2>
                <div style="width: 60px; height: 3px; background-color: var(--color-teal-medium); margin: 0.75rem auto 0; border-radius: var(--radius-full);"></div>
            </div>

            <!-- Map Card Frame -->
            <div style="background: var(--color-white); border-radius: var(--radius-md); padding: 1rem; border: 2px solid var(--color-gold); box-shadow: var(--shadow-md); overflow: hidden; line-height: 0;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3968.2125219468925!2d80.4187211!3d5.9669661!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae114ddb5b3d88b%3A0xf9a5b4761322e212!2sVIHANSHA%20GUESTHouse!5e0!3m2!1sen!2slk!4v1700000000000!5m2!1sen!2slk" 
                    width="100%" 
                    height="480" 
                    style="border:0; border-radius: calc(var(--radius-md) - 8px);" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
</main>

<!-- CSS Focus Ring override for Form Inputs -->
<style>
    input:focus, textarea:focus {
        border-color: var(--color-teal-medium) !important;
        box-shadow: 0 0 0 3px rgba(14, 94, 101, 0.15);
        background-color: var(--color-white) !important;
    }
</style>

<script>
function sendWhatsAppMessage(event) {
    event.preventDefault();
    const name = document.getElementById('name').value.trim();
    const message = document.getElementById('message').value.trim();
    
    // Compose the text message
    const text = `Hi Kelum, my name is ${name}.\n\n${message}`;
    
    // Open the official WhatsApp redirection URL
    const whatsappUrl = `https://wa.me/94770709899?text=${encodeURIComponent(text)}`;
    window.open(whatsappUrl, '_blank');
}
</script>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
