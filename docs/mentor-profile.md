# Mentor Profile Template

The Mentor Profile template has been successfully constructed natively in Gutenberg. A sample profile (`Mentor: Alex Rivera`) has been generated in the database to demonstrate the complete layout.

## Template Layout & Reusable Blocks

The template heavily utilizes the responsive CSS Grid sidebar layout (`.ttp-layout-sidebar`) from the `TTP Design System` to separate narrative biography from actionable booking details.

### 1. Hero Section
*   **Block Name**: `Mentor Profile - Hero`
*   **Structure**: A horizontal flex container featuring a large circular profile photo, the mentor's name, their current designation, meta badges (`.ttp-mentor-badge`) highlighting their experience and primary industry, and social links.

### 2. Main Content Area (Left Column)
*   **Block Name**: `Mentor Profile - Main Content`
    *   **Biography**: Standard text block detailing the mentor's background.
    *   **Professional Experience**: A custom vertical timeline utilizing the `.ttp-experience-list` and `.ttp-experience-item` classes to neatly display past roles and companies.
    *   **Skills & Expertise**: A cluster of pill-shaped tags (`.ttp-skill-tag`) representing specific domain knowledge (e.g., "Product Strategy", "Go-to-Market").
    *   **Key Achievements**: A flex layout (`.ttp-achievement-item`) pairing emojis/icons with major career milestones (e.g., "Forbes 30 Under 30").

### 3. Sticky Sidebar Area (Right Column)
*   **Block Name**: `Mentor Profile - Sidebar`
    *   A prominent card wrapped in `.ttp-sticky-sidebar` so it follows the user on desktop screens.
    *   **Book a Session**: The primary CTA for enrolled students to request 1-on-1 coaching.
    *   **Mentored Courses**: A checklist showing which specific programs the mentor participates in.
    *   **Associated Startups**: A logo garden (using placeholder images) of the companies the mentor has founded or worked for.

### 4. Testimonials
*   **Block Name**: `Mentor Profile - Testimonials`
*   **Structure**: A 2-column grid highlighting feedback from educators who have previously worked with this mentor.

### 5. Related Mentors
*   **Block Name**: `Mentor Profile - Related Mentors`
*   **Structure**: Displays alternative mentors in the same industry using the standard `.ttp-mentor-card` component developed for the archive page to ensure UI consistency.

## Technical Notes & Integration
*   **Reusable Template**: By modularizing these sections into `wp_block` post types, admins can insert the blocks and "Convert to Regular Blocks" to quickly fill in the details for new mentors without touching the layout code.
*   **CSS Enhancements**: The design system was expanded to include styling for skill tags, the vertical experience timeline, and achievement layouts.
*   **SEO**: The DOM structure naturally supports `Person` schema markup.
