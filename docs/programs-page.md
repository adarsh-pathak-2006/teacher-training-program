# Programs Page Structure

The Programs page has been successfully built utilizing the programmatic native Gutenberg block methodology. This page serves as the main catalog for all hybrid learning courses and is optimized for speed, semantic structure, and conversion.

## Reusable Blocks Created
The following `wp_block` sections were generated and inserted into the Programs page layout:

### 1. Hero Banner
*   **Block Name**: `Programs - Hero`
*   **Content**: Features the "Our Programs" badge, main H1 headline ("Find the Right Training for You"), and a brief introductory text utilizing the core design system classes.

### 2. Program Filters & Search
*   **Block Name**: `Programs - Filter Bar`
*   **Content**: A functional UI mock containing a search input (`.ttp-input`), a Category Dropdown, and a Sorting Dropdown (`.ttp-select`). *Note: These are currently UI placeholders and will be wired up to WP_Query/AJAX logic when the custom post types are fully integrated.*

### 3. Program Grid & Cards
*   **Block Name**: `Programs - Grid`
*   **Content**: A 3-column responsive grid (`.ttp-grid-3`) featuring placeholder Program Cards (`.ttp-program-card`). Each card displays:
    *   Thumbnail image (`.ttp-program-thumb`)
    *   Title (`.ttp-heading`)
    *   Short Description
    *   Meta information (Duration, Learning Mode) using `.ttp-program-meta`
    *   Price (`.ttp-program-price`)
    *   Primary CTA Button ("View Details")
*   **Pagination**: Includes a static pagination component (`.ttp-pagination`) to indicate multi-page functionality.

### 4. Testimonials
*   **Block Name**: `Programs - Testimonials`
*   **Content**: A 2-column grid of glassmorphic cards (`.ttp-glass-panel`) highlighting quotes from past educator cohorts to build social proof.

### 5. Frequently Asked Questions (FAQ)
*   **Block Name**: `Programs - FAQ`
*   **Content**: A clean, accessible accordion-style list (`.ttp-faq-item`) addressing common concerns like prerequisites, hybrid learning structure, and certification.

### 6. CTA Section
*   **Block Name**: `Programs - CTA`
*   **Content**: A final push section directing uncertain users to contact a career advisor.

## Technical Notes
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes for form controls (`.ttp-input`, `.ttp-select`), advanced card layouts (`.ttp-program-thumb`, `.ttp-program-meta`), and pagination.
*   **No Inline Styles**: Adhering to strict performance constraints, all visual elements are controlled via the centralized stylesheet.
*   **SEO Optimization**: The DOM structure utilizes proper heading hierarchy, maintaining `<h1>` for the page title and `<h3>` for program card titles, which is crucial for archive page indexation.
