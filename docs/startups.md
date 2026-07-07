# Startup Partners Page Structure

The Startup Partners archive page has been successfully built utilizing the programmatic native Gutenberg block methodology. This page highlights the innovative companies participating in the Teacher Training Program, providing a directory for educators to explore practical project opportunities.

## Reusable Blocks Created
The following `wp_block` sections were generated and inserted into the "Startup Partners" page layout:

### 1. Hero Banner
*   **Block Name**: `Startups - Hero`
*   **Content**: Features the "Our Network" badge, main H1 headline ("Partner Startups"), and a brief introductory text utilizing the core design system classes.

### 2. Startup Filters & Search
*   **Block Name**: `Startups - Filter Bar`
*   **Content**: A functional UI mock containing a search input (`.ttp-input`), an Industry Dropdown (EdTech, FinTech, etc.), and an Opportunities Dropdown (`.ttp-select`). *Note: These will be wired up to WP_Query/AJAX logic when the Startups Custom Post Types (CPT) are fully integrated.*

### 3. Startup Grid & Cards
*   **Block Name**: `Startups - Grid`
*   **Content**: A 3-column responsive grid (`.ttp-grid-3`) featuring placeholder Startup Cards (`.ttp-startup-card`). Each card displays:
    *   **Header**: Logo (`.ttp-startup-logo`), Company Name, and Industry.
    *   **Founder**: Identifying the primary contact (`.ttp-startup-founder`).
    *   **Availability Badge**: Visual indicator (Green/Yellow/Red) showing if mentors are currently accepting educators for projects (`.ttp-startup-availability`).
    *   **Description**: A short summary of the company (`.ttp-startup-description`).
    *   **Opportunities**: Tags representing the types of projects available (e.g., "Product Management", "Marketing") using `.ttp-startup-meta` and `.ttp-startup-tag`.
    *   **CTA Button**: Primary action to "View Company Profile".
*   **Pagination**: Includes a static pagination component (`.ttp-pagination`) to indicate multi-page functionality.

## Technical Notes
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes for the startup cards (`.ttp-startup-card`, `.ttp-startup-logo`, `.ttp-startup-tag`, etc.) utilizing flexbox for perfect vertical alignment and stretching.
*   **No Inline Styles**: Adhering to strict performance constraints, all visual elements are controlled via the centralized stylesheet.
*   **Responsive Alignment**: The card layout uses `flex-grow: 1` on the description and `margin-top: auto` on the button wrappers to ensure all buttons align flawlessly at the bottom of the grid row, regardless of text length.
