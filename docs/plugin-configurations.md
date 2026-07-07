# Plugin Configurations

This document outlines the configurations applied to all installed plugins to ensure security, performance, and alignment with the PRD.

## 1. WordPress Core Settings
*   **Permalinks**: Set to `/%postname%/` for SEO optimization.
*   **Anyone can register**: Disabled in WP Core (Registration will be handled strictly by Ultimate Member to enforce roles and approval workflows).
*   **Timezone**: Set to `Asia/Kolkata` (assumed based on Razorpay/GST requirements).

## 2. WPS Hide Login
*   **Login URL**: Changed from `wp-login.php` to `portal`.
*   **Redirection URL**: Unauthorized access to `wp-admin` redirects to a generic 404 instead of exposing the WordPress backend.

## 3. Ultimate Member
*   **User Roles**: Configured the default registration role to "Student".
*   **Access Control**: Restricted global site access so that courses and dashboards are only visible to logged-in users.
*   **Password Security**: Enforced strong password requirements during registration.

## 4. Tutor LMS
*   **Monetization**: Enabled "WooCommerce" as the default eCommerce engine.
*   **Course Visibility**: Disabled public course viewing. Only enrolled users can access lesson content.
*   **Gutenberg Editor**: Enabled Gutenberg for course and lesson descriptions to maintain consistency with Kadence Blocks.
*   **YouTube/Vimeo Players**: Enforced default privacy settings for embedded videos.

## 5. WooCommerce
*   **Currency**: Set to `INR` (Indian Rupee) as per Razorpay & GST invoice requirements.
*   **Guest Checkout**: **Disabled**. Users must create an account (handled via Ultimate Member) to purchase a course.
*   **Inventory & Shipping**: Disabled (as this is a digital LMS platform).
*   **Tax**: Enabled basic tax calculations for future GST implementation.

## 6. Razorpay for WooCommerce
*   **Mode**: Set to `Test Mode` (Keys required for live configuration).
*   **Webhook**: Enabled webhook event logging for debugging payment failures.

## 7. bbPress (Community)
*   **Forum Visibility**: Restricted to logged-in users (Students and Mentors).
*   **Anonymous Posting**: Disabled.
*   **Flood Control**: Enforced a 60-second delay between posts to prevent spam.

## 8. LiteSpeed Cache
*   **Object Cache**: Enabled (configured for Redis/Memcached depending on final server environment).
*   **Browser Caching**: Enabled with secure headers.
*   **Minification**: Enabled basic CSS/JS minification (Advanced combining is left disabled until the frontend is fully built to avoid breaking UI).
*   **Auto Purge**: Configured to purge cache when courses or assignments are updated.

## 9. Rank Math SEO
*   **Modules Enabled**: Schema (Structured Data), XML Sitemaps, and SEO Analyzer.
*   **Modules Disabled**: WooCommerce (as products are courses), bbPress (to prevent indexing private community pages).
*   **Indexation**: Set community forums and dashboard pages to `noindex` to keep search engines focused on public marketing pages.

## 10. Wordfence Security
*   **Live Traffic**: Disabled to preserve database performance (a common issue on scalable sites).
*   **Rate Limiting**: Enabled strict rate limiting for login attempts and crawler activity.
*   **2FA**: Enforced for Administrator and Course Manager roles.

## 11. UpdraftPlus
*   **Backup Schedule**: Configured for Daily database backups and Weekly file backups.
*   **Retention**: Keep the last 4 backups.
*   **Remote Storage**: Set to local folder temporarily (Requires S3/Google Drive API credentials to configure remote offloading).

## 12. Advanced Custom Fields (ACF) & Fluent Forms & Kadence Blocks
*   **Status**: Initialized with secure defaults. No global configuration changes required until custom fields, forms, and pages are explicitly built.

---
*Note: No demo data was imported, and no pages were created during this configuration phase. All plugins are optimized for a production-ready, minimal-bloat environment.*
