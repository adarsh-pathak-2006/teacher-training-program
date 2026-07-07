# WordPress Core Settings

This document outlines the fundamental WordPress Core configurations applied to harden the platform and align it with the PRD requirements. These settings ensure the site operates strictly as a Learning Management System (LMS) rather than a generic blogging platform.

## 1. General & Registration Settings
*   **Timezone**: `Asia/Kolkata`
    *   *Rationale*: Required for accurate timestamping of Razorpay transactions, LMS quiz submissions, and Live Class scheduling.
*   **Native User Registration**: Disabled (`users_can_register = 0`).
    *   *Rationale*: All user registration and onboarding is routed through the Ultimate Member plugin to enforce custom roles (Student, Mentor, Trainer) and approval workflows.
*   **Default Role**: `student`.

## 2. Reading & Permalinks
*   **Permalinks**: `/%postname%/`
    *   *Rationale*: Optimal structure for Technical SEO and clean URL routing for LMS courses.
*   **Static Homepage**: Set to the dedicated `Home` page.
*   **Posts Page (Blog)**: Set to the dedicated `Blog` page.
*   **Search Engine Visibility**: Enabled (`blog_public = 1`) to allow indexing by Rank Math SEO.

## 3. Discussion & Comment Policy
*   **Default Comment Status**: Closed (`default_comment_status = closed`).
    *   *Rationale*: Prevents automated comment spam on standard pages. Discussions should happen within the BuddyPress community forums or specific LMS lesson Q&A sections.
*   **Comment Registration**: Enforced (`comment_registration = 1`).
    *   *Rationale*: Users must be registered and logged in to leave any comments or reviews on courses.

## 4. Privacy & Trash Management
*   **Privacy Policy Page**: Officially assigned to the WP Privacy Policy pointer (`wp_page_for_privacy_policy`).
*   **Trash Cleanup**: Enforced via `wp-config.php` constant `EMPTY_TRASH_DAYS = 7`.
    *   *Rationale*: Automatically purges trashed posts/pages after 7 days to prevent database bloat over time.

## 5. Media & File Upload Restrictions
*   **Media Dimensions**: Configured optimal defaults for thumbnails (300px), medium (800px), and large (1200px) images to ensure consistency across UI layouts.
*   **File Upload Restrictions**: 
    *   *Implementation*: A custom `upload_mimes` filter was added to the `teacher-training-core` plugin.
    *   *Rationale*: Hardens server security by explicitly allowing only safe document formats (PDF, DOCX, ZIP) and standard images (JPG, PNG, WebP) for student assignment uploads. All dangerous file types (e.g., EXE, SVG, PHP scripts) are strictly blocked.
