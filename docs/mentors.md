# Mentors Page Structure

The Mentors page has been successfully built utilizing the programmatic native Gutenberg block methodology. This page introduces the industry experts participating in the program and provides a way for users to browse and filter them.

## Reusable Blocks Created
The following `wp_block` sections were generated and inserted into the Mentors page layout:

### 1. Hero Banner
*   **Block Name**: `Mentors - Hero`
*   **Content**: Features the "Our Mentors" badge, main H1 headline ("Learn from the Best"), and introductory text summarizing the high caliber of the mentors (active founders, VCs).

### 2. Mentor Filters & Search
*   **Block Name**: `Mentors - Filter Bar`
*   **Content**: A functional UI mock containing a search input (`.ttp-input`), an Industry Dropdown, and a Specialization Dropdown (`.ttp-select`). *Note: These will be wired up to WP_Query/AJAX logic when the Mentor Custom Post Types (CPT) are fully integrated.*

### 3. Mentor Grid & Cards
*   **Block Name**: `Mentors - Grid`
*   **Content**: A 3-column responsive grid (`.ttp-grid-3`) featuring placeholder Mentor Cards (`.ttp-mentor-card`). Each card displays:
    *   Circular Photo (`.ttp-mentor-photo`)
    *   Name (`.ttp-mentor-name`)
    *   Designation / Title (`.ttp-mentor-title`)
    *   Badges for Experience and Industry (`.ttp-mentor-badges` & `.ttp-mentor-badge`)
    *   Associated Courses (`.ttp-mentor-courses`)
    *   Social Links (`.ttp-mentor-social`)
    *   Primary CTA Button ("View Profile")
*   **Pagination**: Includes a static pagination component (`.ttp-pagination`) to indicate multi-page functionality.

### 4. CTA Section
*   **Block Name**: `Mentors - CTA`
*   **Content**: A final push section designed to recruit new mentors, directing interested startup founders to the application form.

## Technical Notes
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes for the mentor cards (`.ttp-mentor-card`, `.ttp-mentor-photo`, `.ttp-mentor-badges`, etc.).
*   **No Inline Styles**: Adhering to strict performance constraints, all visual elements are controlled via the centralized stylesheet.
*   **Responsive**: The 3-column grid collapses to a single column on mobile devices natively via CSS Grid rules.
