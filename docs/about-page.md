# About Us Page Structure

The About Us page has been successfully built utilizing the programmatic native Gutenberg block methodology to ensure zero inline CSS and strict adherence to the design system.

## Reusable Blocks Created
The following `wp_block` sections were generated and inserted into the About Us page layout:

### 1. Hero Section
*   **Block Name**: `About - Hero`
*   **Content**: Features the "About Us" page badge, the main H1 headline ("Empowering Educators to Shape Innovators"), a breadcrumb navigation string, and a short introductory paragraph outlining the core purpose of the platform.

### 2. Vision & Mission
*   **Block Name**: `About - Vision & Mission`
*   **Content**: A 2-column grid utilizing the `.ttp-glass-panel` and `.ttp-card` CSS classes to display the Vision and Mission statements clearly and elegantly.

### 3. Story Timeline
*   **Block Name**: `About - Story Timeline`
*   **Content**: A custom timeline component tracing the organization's journey from Ideation (2020) to Platform Scaling (2023), built entirely with HTML/CSS without requiring third-party timeline plugins.

### 4. Founder Message
*   **Block Name**: `About - Founder Message`
*   **Content**: A 2-column layout pairing a placeholder profile image with an italicized quote and the founder's title.

### 5. Core Values
*   **Block Name**: `About - Core Values`
*   **Content**: A 3-column card grid highlighting "Innovation First", "Collaboration", and "Practical Impact" using the `.ttp-card-icon` layout from the design system.

### 6. Leadership Team
*   **Block Name**: `About - Leadership Team`
*   **Content**: A 4-column grid displaying team members with circular placeholder images (`.ttp-profile-img`), names, and titles.

### 7. Partner Organizations
*   **Block Name**: `About - Partner Organizations`
*   **Content**: A logo garden displaying 4 placeholder startup/incubator logos in a responsive 4-column grid with reduced opacity for a premium, subtle look.

### 8. Impact Statistics
*   **Block Name**: `About - Impact Statistics`
*   **Content**: A 4-column statistics row utilizing the `.ttp-stat-box` and `.ttp-stat-number` classes to highlight metrics like "500+ Educators Trained" and "10k+ Students Impacted".

### 9. Why Choose Us
*   **Block Name**: `About - Why Choose Us`
*   **Content**: A 2-column grid focusing on "Verified Curriculum" and "Real Equity Opportunities".

### 10. CTA Section
*   **Block Name**: `About - CTA Section`
*   **Content**: A final push section wrapped in the `.ttp-hero-section` gradient style, encouraging educators to apply to upcoming batches.

## Technical Notes
*   **Accessibility**: Semantic HTML (H1, H2, H3 tags in correct hierarchical order) was used throughout.
*   **Performance**: The page is constructed using CSS grids and flexbox classes from `style.css`. No inline styles or heavy block wrappers were generated.
*   **Design System Update**: Added specific grid (`ttp-grid-2`, `ttp-grid-4`), timeline, and statistic utility classes to the `TTP Design System` plugin to support these new components.
*   **Integration**: The page is fully built and visible in the WordPress Admin under the "About Us" page.
