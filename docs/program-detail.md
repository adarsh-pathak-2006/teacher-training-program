# Program Detail Template

The Program Detail template has been successfully constructed as a native Gutenberg page using highly modular reusable blocks. A sample page (`Program: Ideation Masterclass`) has been generated in the database to demonstrate the complete layout.

## Template Layout & Reusable Blocks

The template is divided into several reusable blocks (`wp_block`) mapped to CSS Grid layouts in the `TTP Design System` plugin:

### 1. Hero Section
*   **Block Name**: `Program Detail - Hero`
*   **Structure**: A left-aligned header containing the Program Category badge, H1 Title, short descriptive lead text, and inline metadata (Duration, Learning Mode, Rating).

### 2. Main Content & Sidebar Layout
The core of the page utilizes a specialized CSS grid class (`.ttp-layout-sidebar`) that creates a responsive 2-column layout (Main Content on the left, Sticky Sidebar on the right).

#### Main Content Area (Left Column)
*   **Block Name**: `Program Detail - Overview & Outcomes`
    *   Contains the narrative course description.
    *   Features a custom checklist (`.ttp-check-list`) to highlight key learning outcomes.
*   **Block Name**: `Program Detail - Curriculum`
    *   An interactive accordion component showcasing the syllabus modules.
    *   Built using `.ttp-accordion-item` and `.ttp-lesson-item` classes to list lessons and durations cleanly.

#### Sticky Sidebar Area (Right Column)
*   **Block Name**: `Program Detail - Sidebar`
    *   A prominent card wrapped in `.ttp-sticky-sidebar` so it follows the user as they scroll.
    *   Contains vital conversion information: Price, Next Batch Dates, Enrollment CTA Button, and Guarantee text.

### 3. Mentors
*   **Block Name**: `Program Detail - Mentors`
*   **Structure**: A 2-column grid highlighting the industry experts teaching the course.

### 4. Related Programs
*   **Block Name**: `Program Detail - Related`
*   **Structure**: Displays alternative or advanced programs using the standard `.ttp-program-card` component developed for the archive page to ensure UI consistency.

## Technical Notes & Integration
*   **Reusable Template**: By modularizing these sections into `wp_block` post types, course creators can simply insert the blocks and "Convert to Regular Blocks" to quickly fill in the details for new programs without touching the layout code.
*   **CSS Upgrades**: The design system was expanded to include accordion styling, custom list markers (checkmarks), and a responsive sticky sidebar layout.
*   **SEO & Schema**: The DOM hierarchy natively supports `Course` Schema markup, which will be injected via Rank Math SEO based on the Title, Description, and Price fields.
