# Required Plugin Stack

Based on the approved architecture and the constraints in the PRD, the following plugins have been selected. All plugins are **free**, **actively maintained**, available in the **official WordPress repository**, compatible with **WordPress 7+**, and compatible with each other.

---

## 1. Kadence Blocks – Gutenberg Blocks for Page Builder Features
*   **Why it is needed**: To build custom, responsive page layouts (Landing Page, About Us, etc.) without the bloat of Elementor. It extends the native WordPress block editor (Gutenberg).
*   **Which PRD feature it satisfies**: Module 1 (Website Pages), Non-Functional Requirements (Fast Loading, Mobile Responsive).
*   **Alternatives**: Spectra, Stackable.
*   **Known limitations**: The free version lacks some advanced dynamic content blocks, meaning custom PHP/shortcodes may be required to pull custom post type data (like Mentor profiles) directly into block layouts.

## 2. Tutor LMS
*   **Why it is needed**: Serves as the core Learning Management System engine.
*   **Which PRD feature it satisfies**: Module 4 (LMS), Module 5 (Video Learning), Module 9 (Quiz System).
*   **Alternatives**: LearnPress, LifterLMS.
*   **Known limitations**: The free tier does not natively support an Assignment submission workflow or automated PDF Certificates. (These will be handled via custom PHP and form workarounds as per our architecture).

## 3. Ultimate Member
*   **Why it is needed**: Handles frontend user registration, login, profile management, and restricts content based on roles.
*   **Which PRD feature it satisfies**: Module 2 (Authentication), Module 3 (Student Dashboard), Module 17 (User Roles).
*   **Alternatives**: Profile Builder, User Registration.
*   **Known limitations**: Social login (Google/Facebook) and some advanced access restriction logic require premium extensions. 

## 4. bbPress
*   **Why it is needed**: Provides discussion boards for students and mentors to interact. 
*   **Which PRD feature it satisfies**: Module 12 (Community). Replaces BuddyBoss Premium.
*   **Alternatives**: wpForo, PeepSo.
*   **Known limitations**: Visually basic out-of-the-box and requires custom CSS to match modern UI aesthetics. Can become resource-heavy if the community scales beyond server capacity.

## 5. WooCommerce
*   **Why it is needed**: Processes course enrollments and manages the e-commerce transaction flow.
*   **Which PRD feature it satisfies**: Module 14 (Payment System).
*   **Alternatives**: Easy Digital Downloads (EDD).
*   **Known limitations**: A heavy plugin that generates multiple database tables. It adds overhead to the site, so object caching must be strictly configured.

## 6. Razorpay for WooCommerce
*   **Why it is needed**: Integrates the Razorpay payment gateway seamlessly into the WooCommerce checkout process.
*   **Which PRD feature it satisfies**: Module 14 (Payment Gateway: Razorpay).
*   **Alternatives**: PayU Integration (if the gateway requirement changes).
*   **Known limitations**: Requires WooCommerce to be active. Requires verified Indian business KYC to switch from Test to Live mode.

## 7. Advanced Custom Fields (ACF)
*   **Why it is needed**: Adds custom metadata fields to standard and custom post types (e.g., adding Zoom Links to Lessons, or Company overviews to Startups).
*   **Which PRD feature it satisfies**: Module 1 (Mentors & Startup Profiles), Module 6 (Live Classes).
*   **Alternatives**: Pods, Meta Box.
*   **Known limitations**: The free version lacks Repeater fields, Gallery fields, and the ability to create Options Pages natively.

## 8. Fluent Forms
*   **Why it is needed**: To create contact forms and act as the frontend interface for student assignment file uploads.
*   **Which PRD feature it satisfies**: Module 1 (Contact Form), Module 8 (Assignments - via custom integration).
*   **Alternatives**: Forminator, WPForms Lite.
*   **Known limitations**: Deep integration with user registration or creating WordPress posts directly from form submissions is heavily restricted in the free tier, requiring custom PHP hooks to map form uploads to assignment post types.

## 9. Rank Math SEO
*   **Why it is needed**: Manages on-page SEO, XML sitemaps, and automatically applies JSON-LD Schema markup.
*   **Which PRD feature it satisfies**: Non-Functional Requirements (SEO Friendly URLs).
*   **Alternatives**: Yoast SEO, All in One SEO.
*   **Known limitations**: Advanced schemas (like Video or News) and multiple location local SEO are locked behind the Pro version.

## 10. Wordfence Security
*   **Why it is needed**: Provides an endpoint firewall, malware scanner, and Two-Factor Authentication (2FA) for administrators and mentors.
*   **Which PRD feature it satisfies**: Non-Functional Requirements (Secure Login).
*   **Alternatives**: Solid Security (formerly iThemes), Sucuri.
*   **Known limitations**: The free firewall rules are delayed by 30 days compared to the premium version. Running deep scans during peak hours can impact server performance.

## 11. WPS Hide Login
*   **Why it is needed**: Changes the default `/wp-login.php` URL to a custom path, drastically reducing automated brute force attacks.
*   **Which PRD feature it satisfies**: Non-Functional Requirements (Security).
*   **Alternatives**: Built-in feature of Solid Security (but better as a lightweight standalone).
*   **Known limitations**: If the custom URL is forgotten and caching is heavy, the site administrator must manually rename the plugin folder via SFTP to regain access.

## 12. LiteSpeed Cache (or W3 Total Cache)
*   **Why it is needed**: Provides page caching, object caching (Redis/Memcached), image optimization (WebP), and CSS/JS minification.
*   **Which PRD feature it satisfies**: Non-Functional Requirements (Fast Loading < 3 seconds).
*   **Alternatives**: W3 Total Cache, WP Optimize.
*   **Known limitations**: The best features (server-level caching) require the hosting environment to use a LiteSpeed Web Server. If Nginx/Apache is used, W3 Total Cache is the recommended fallback.

## 13. UpdraftPlus
*   **Why it is needed**: Automates regular database and file backups to remote cloud storage (Google Drive, AWS S3, etc.).
*   **Which PRD feature it satisfies**: Non-Functional Requirements (Daily Backup).
*   **Alternatives**: BackWPup.
*   **Known limitations**: Incremental backups (backing up only changes) and selecting exact times for scheduled backups are premium features.
