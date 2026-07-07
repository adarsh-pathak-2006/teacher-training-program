# Contact Page Structure

The Contact page has been successfully built natively in Gutenberg. It provides a centralized hub for prospective students, mentors, and partners to reach out to the Teacher Training Program administrators.

## Template Layout & Reusable Blocks

The layout is constructed using the `TTP Design System`, ensuring a clean, accessible interface that works seamlessly on all device sizes.

### 1. Hero Section
*   **Block Name**: `Contact - Hero`
*   **Structure**: A simple, centered hero introducing the page intent ("Get In Touch") with a brief explanatory paragraph.

### 2. Main Contact Area
*   **Block Name**: `Contact - Main Content`
*   **Structure**: Utilizes the responsive `.ttp-grid-2` class to split the screen into two distinct halves on desktop (stacking on mobile):
    *   **Left Column (Form)**: Wraps the Fluent Forms shortcode (`[fluentform id="1"]`) inside a premium glassmorphism card (`.ttp-glass-panel`).
    *   **Right Column (Info & Map)**: 
        *   Displays the physical address, phone number, email, and business hours utilizing the new `.ttp-contact-info-list` class for clean iconography alignment.
        *   Embeds a responsive Google Maps iframe within the `.ttp-map-container` class, ensuring the map maintains its aspect ratio and rounded corners.
        *   Displays social media links at the bottom.

### 3. FAQ Section
*   **Block Name**: `Contact - FAQ`
*   **Structure**: Reuses the exact `.ttp-accordion-item` classes developed for the Programs page, providing a consistent UI for answering common logistical queries before users submit a form.

### 4. Call to Action
*   **Block Name**: `Contact - CTA`
*   **Structure**: A final push section directing users who might have landed on the contact page back to the primary conversion funnel (the Programs page).

## Technical Notes & Integration
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes for the contact list iconography (`.ttp-contact-info-list`) and the responsive map embed (`.ttp-map-container`).
*   **Fluent Forms Integration**: The form area relies entirely on the previously installed and configured Fluent Forms plugin, ensuring all submissions are securely stored in the WordPress database and routed to the correct administrative emails.
*   **Accessibility**: The contrast ratios for the contact icons and text adhere to WCAG standards, and the map iframe includes a `loading="lazy"` attribute for improved Core Web Vitals.
