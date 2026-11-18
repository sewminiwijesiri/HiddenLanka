# 🌴 Hidden Lanka – Hospitality & Island Experience Platform

A responsive web application and Content Management System (CMS) built for **Hidden Lanka**, a boutique Sri Lankan guest house, guided tour operator, vehicle rental, and traditional cultural event service located in Sri Lanka.

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-MariaDB-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black)
![CSS3](https://img.shields.io/badge/CSS3-Custom%20Design%20System-1572B6?style=for-the-badge&logo=css3&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-mod__rewrite-D22128?style=for-the-badge&logo=apache&logoColor=white)

---

## 📖 Table of Contents
- [Features](#-features)
  - [Public Guest Experience](#public-guest-experience)
  - [Admin Management Panel (CMS)](#admin-management-panel-cms)
- [Tech Stack](#-tech-stack)
- [Database Architecture](#-database-architecture)
- [Installation & Local Setup](#-installation--local-setup)
- [Project Structure](#-project-structure)
- [Security Practices](#-security-practices)
- [License & Credits](#-license--credits)

---

## ✨ Features

### Public Guest Experience
* **Hero & Discovery:** Interactive homepage with experience showcases, high-resolution visual storytelling, and quick action anchors.
* **Accommodation Catalog & Room Details:** 
  * Multi-image widescreen slideshows with thumbnail navigation.
  * Room amenity badges, transparent pricing, and instant room-specific WhatsApp inquiries.
* **Five Dedicated Service Pillars:**
  1. *Authentic Sri Lankan Home-Cooked Food* (organic spices, garden dining, cooking demonstrations).
  2. *Custom Guided Island Tours* (secret beaches, wildlife safaris, Ella tea country excursions).
  3. *Tuk-Tuk & Scooter Rentals* (self-drive fleet, driving lessons, international permit assistance).
  4. *Mechanical Workshop & Roadside Repairs* (on-site vehicle tuning, maintenance, breakdown support).
  5. *Traditional Sri Lankan Village Weddings* (Poruwa rituals, traditional dancers, drummers, and cultural feasts).
* **Two-Tier Reviews & Testimonials:**
  * Public review submission portal with star ratings (1–5) and categorized feedback (General vs. Wedding).
  * Dynamic rating breakdown (Hospitality, Cleanliness, Food, Value).
  * Automatic guest initials avatar generation.
* **Interactive Media Gallery:** High-performance responsive image grid with an interactive JavaScript modal lightbox.
* **Instant WhatsApp Booking Pipeline:** Pre-formatted, URL-encoded inquiry links routing guest requests directly to host WhatsApp.
* **SPA-Style Micro-Interactions:** Smooth page-exit progress bar animations and `IntersectionObserver`-powered scroll reveals.

### Admin Management Panel (CMS)
* **Secure Authentication:** Protected admin portal utilizing PHP sessions and `PASSWORD_BCRYPT` hash verification.
* **Executive Metrics Dashboard:** Real-time KPI summary tracking active tours, room listings, gallery media counts, and average guest ratings.
* **Room Management (CRUD):** Add, update, and manage accommodations with multi-image gallery batch uploading (up to 10 photos per room).
* **Tour Packages CMS:** Dynamic creation and updating of tour itineraries, destinations, durations, and pricing.
* **Gallery Asset Manager:** Media uploading, automated naming sanitation, and deletion with file system cleanups.
* **Review Moderation Workflow:** Two-stage moderation pipeline where guest submissions remain hidden until approved or discarded by the administrator.
* **Account Security Settings:** In-portal administrator username updates and secure password resets.

---

## 🛠 Tech Stack

* **Backend:** PHP 8.x (OOP & Procedural, Session Control, Prepared Statements)
* **Web Server:** Apache with `mod_rewrite` for extensionless, SEO-friendly clean URLs (`.htaccess`)
* **Database:** MySQL / MariaDB (`utf8mb4` encoding)
* **Frontend:** Semantic HTML5, Vanilla CSS3 (Custom design tokens, CSS variables, Flexbox & CSS Grid), Vanilla JavaScript (ES6+, DOM APIs, IntersectionObserver)
* **Integration:** WhatsApp Click-to-Chat Business API, Google Maps Platform

---

## 🗄 Database Architecture

The application runs on a relational schema with 6 core tables:

* `admins` — Administrator credentials (username, Bcrypt password hashes).
* `accommodations` — Room details, pricing, titles, subtitles, badges, and amenity lists.
* `accommodation_images` — One-to-many relationship linking rooms to multiple slideshow gallery images.
* `tours` — Tour packages, highlights, pricing, durations, and itineraries.
* `reviews` — Verified guest feedback, star ratings, categories, and moderation flags (`is_approved`).
* `gallery` — Media items displayed in the public visual journey lightbox.

> See [`database.sql`](database.sql) for the complete schema and seed data.

---

## 🚀 Installation & Local Setup

### Prerequisites
* [XAMPP](https://www.apachefriends.org/) (or any Apache + PHP 8.x + MySQL stack)
* Git

### Step-by-Step Setup

1. **Clone the repository:**
   ```bash
   git clone https://github.com/sewminiwijesiri/HiddenLanka.git
   ```

2. **Move into your local web server root:**
   If using XAMPP on Windows, move the repository into `C:/xampp/htdocs/HiddenLanka`:
   ```bash
   # Target path: C:\xampp\htdocs\HiddenLanka
   ```

3. **Import Database:**
   * Open **phpMyAdmin** (`http://localhost/phpmyadmin`).
   * Create a new database named `hidden_lanka_db` with collation `utf8mb4_unicode_ci`.
   * Click **Import** and select the [`database.sql`](database.sql) file from the project root.

4. **Verify Configuration:**
   Open `config.php` and verify your local database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'hidden_lanka_db');
   ```

5. **Launch in Browser:**
   * Start **Apache** and **MySQL** in the XAMPP Control Panel.
   * Open your browser and navigate to:
     ```
     http://localhost/HiddenLanka/
     ```

6. **Admin Panel Access:**
   * URL: `http://localhost/HiddenLanka/login.php`
   * Default Username: `admin`
   * Default Password: `admin123` *(change immediately in Admin Settings)*

---

## 📂 Project Structure

```text
HiddenLanka/
├── assets/
│   ├── css/
│   │   └── style.css               # Bespoke design system & responsive styling
│   ├── images/
│   │   ├── accommodation/          # Room slideshow images
│   │   ├── gallery/                # Public photo gallery assets
│   │   ├── hero/                   # Banner visual media
│   │   └── tours/                  # Tour package promotional banners
│   └── js/
│       └── script.js               # Mobile navigation, SPA transitions, lightbox, sliders
├── includes/
│   ├── admin_header_card.php       # Reusable admin greeting widget
│   ├── admin_sidebar.php           # CMS sidebar navigation
│   ├── db.php                      # MySQLi database connection helper
│   ├── footer.php                  # Shared public footer
│   ├── header.php                  # HTML document header & meta tags
│   └── nav.php                     # Public responsive navigation bar
├── .gitignore
├── .htaccess                       # SEO clean URL rewrites & security rules
├── about.php                       # Host story & villa heritage
├── accommodation.php               # Room listings overview
├── accommodation_details.php       # Dynamic single-room showcase & slideshow
├── admin.php                       # Admin dashboard overview & analytics
├── admin_accommodation.php         # Manage rooms list
├── admin_accommodation_add.php     # Add room & multi-photo upload
├── admin_accommodation_edit.php    # Update room & manage gallery photos
├── admin_gallery.php               # Photo gallery CMS manager
├── admin_reviews.php               # Guest reviews moderation queue
├── admin_tours.php                 # Manage tour packages
├── admin_tours_add.php             # Create new tour package
├── config.php                      # Global application settings & contact constants
├── contact.php                     # Inquiry form & direct contact links
├── database.sql                    # MySQL schema definition & seed data
├── gallery.php                     # Public responsive photo gallery
├── index.php                       # Platform homepage
├── login.php                       # Admin authentication portal
├── README.md                       # Repository documentation
├── review.php                      # Public reviews & submission form
├── service.php                     # 5 Island service pillars
├── settings.php                    # Admin credentials configuration
└── tours.php                       # Guided island tour packages catalog
```

---

## 🔒 Security Practices

* **SQL Injection Prevention:** Uses prepared statements (`mysqli::prepare`) and parameterized binding for all user-supplied query parameters.
* **Password Encryption:** Sensitive credentials hashed using modern standard `password_hash()` with `PASSWORD_BCRYPT`.
* **File Upload Protection:** Strict whitelisting of permitted MIME extensions (`jpg`, `jpeg`, `png`, `webp`) and cryptographic renaming to eliminate remote code execution vulnerabilities.
* **Authentication Safeguards:** Restricted admin pages require validated session tokens (`$_SESSION['admin_logged_in']`), automatically redirecting unauthenticated traffic to the login portal.
* **Output Sanitization:** Escaping via `htmlspecialchars()` to mitigate Cross-Site Scripting (XSS).

---

## 📄 License & Credits

Developed with ❤️ for **Hidden Lanka** by [sewminiwijesiri](https://github.com/sewminiwijesiri).
