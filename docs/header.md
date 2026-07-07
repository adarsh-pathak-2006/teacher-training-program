# Global Header Structure

The Global Header template has been successfully designed and saved as a reusable native Gutenberg block. It serves as the primary navigation hub for the Teacher Training Program website.

## Design Architecture

The header utilizes a mobile-first approach within the `TTP Design System`, ensuring optimal performance and accessibility across all devices.

### 1. Sticky Navigation Layout
*   **CSS Class**: `.ttp-header`
*   **Structure**: Uses `position: sticky; top: 0; z-index: 1000;` to ensure the navigation bar remains accessible at the top of the viewport as the user scrolls down long pages (like the Homepage or Programs).
*   **Container**: Uses `.ttp-header-container` to maintain the maximum width (1280px) and alignment consistent with all other site sections.

### 2. Branding
*   **CSS Class**: `.ttp-brand`
*   **Structure**: A text-based logo pairing a colored icon block with the organization's name ("Teacher Training"), providing a clean, fast-loading alternative to an image logo.

### 3. Desktop Navigation & Mega Menu
*   **CSS Class**: `.ttp-nav-desktop` (Hidden on mobile, visible on `min-width: 992px`)
*   **Structure**: A horizontal list of standard links (About, Mentors, Startups, Blog) styled with `.ttp-nav-link`.
*   **Mega Menu (`.ttp-mega-menu-trigger` & `.ttp-mega-menu-dropdown`)**:
    *   The "Programs" link acts as a hover trigger.
    *   On hover, a wide dropdown panel appears using a CSS Grid layout.
    *   The left column lists specific career paths (e.g., "Product Management").
    *   The right column highlights a "Featured" program with a thumbnail and dates, acting as an integrated marketing tool.

### 4. User Actions & Authentication
*   **CSS Class**: `.ttp-header-actions` (Hidden on mobile, visible on desktop)
*   **Search**: A lightweight search icon toggle (`.ttp-search-icon`).
*   **Profile Dropdown (`.ttp-profile-dropdown-wrapper`)**:
    *   Displays a user icon (`👤`) indicating authentication state.
    *   On hover, it reveals a smaller dropdown menu providing quick links to the Student Dashboard, Profile Settings, and a Logout action.
*   **Call to Action**: A prominent "Apply Now" button utilizing the primary gradient button style (`.ttp-btn-primary`).

### 5. Mobile Menu Toggle
*   **CSS Class**: `.ttp-mobile-menu-toggle`
*   **Structure**: A standard hamburger icon (☰) that displays on mobile devices (`< 992px`) while hiding the desktop navigation and actions.

## Technical Notes
*   **No JavaScript Required for Hover States**: Both the complex Mega Menu and the simpler Profile Dropdown rely entirely on pure CSS (`:hover`) to toggle visibility and handle transitions. This guarantees lightning-fast interactions without relying on external jQuery or React libraries.
*   **Integration**: Because it is saved as a `wp_block` (Reusable Block), the site administrator can simply inject this block into the Kadence Theme's global header area or use it as a standard template part for Full Site Editing (FSE).
