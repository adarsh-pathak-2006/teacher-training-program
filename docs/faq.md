# FAQ Page Structure

The FAQ page has been successfully built natively in Gutenberg. It acts as a comprehensive knowledge base for prospective students, utilizing a clean, scannable layout to reduce support tickets.

## Template Layout & Reusable Blocks

The layout is constructed using the `TTP Design System`, recycling the modular sidebar architecture and accordion components to maintain a lightweight stylesheet.

### 1. Hero Section
*   **Block Name**: `FAQ - Hero`
*   **Structure**: A centered header indicating the "Help Center" intent, with a brief explanatory paragraph.

### 2. Main Content Area
*   **Block Name**: `FAQ - Main Content`
*   **Structure**: Utilizes the `.ttp-layout-sidebar` class to create a dynamic reading experience.
    *   **Sticky Sidebar (Navigation)**: The left column (on desktop) acts as a persistent navigation menu wrapped in `.ttp-sticky-sidebar`. It contains:
        *   **Search Bar**: A text input (`.ttp-input`) allowing users to quickly query specific terms.
        *   **Categories**: A list of anchor links jumping to specific sections of the FAQ (e.g., `#admissions`, `#placements`).
    *   **Main Content (Accordions)**: The right column houses the actual questions and answers.
        *   Questions are grouped logically under `<h2>` headings (e.g., "Admissions & Eligibility").
        *   Each Q&A pair is wrapped in the `.ttp-accordion-item` class (developed previously for the Programs page), ensuring a consistent interaction pattern across the site.

### 3. Contact CTA
*   **Block Name**: `FAQ - Contact CTA`
*   **Structure**: A final push section at the bottom of the page directing users to the Contact page if their specific question was not answered in the knowledge base.

## Technical Notes & Integration
*   **CSS Reusability**: This page was built entirely using existing CSS classes from the `TTP Design System` plugin (`.ttp-layout-sidebar`, `.ttp-sticky-sidebar`, `.ttp-accordion-item`, `.ttp-sidebar-widget`). No new CSS was required, demonstrating the robust scalability of our design architecture.
*   **SEO Optimization**: The FAQ structure naturally lends itself to `FAQPage` schema markup. The questions are nested inside logical `<h2>` headers, and each question utilizes an `<h3>` tag (`.ttp-accordion-header`), ensuring perfect accessibility and search engine parsing.
*   **Responsive**: The sidebar navigation will stack cleanly above the accordion lists on mobile devices.
