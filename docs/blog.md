# Blog Page Structure

The Blog archive page has been successfully built natively in Gutenberg. It acts as the content hub for the platform, offering thought leadership, startup interviews, and teaching methodologies.

## Template Layout & Reusable Blocks

The layout is constructed using the `TTP Design System` to ensure performance and visual consistency without any page builders.

### 1. Featured Article (Hero)
*   **Block Name**: `Blog - Featured Post`
*   **Structure**: A full-width split layout (`.ttp-layout-sidebar` with modified `gap: 0` and `align-items: center`) featuring a prominent image on the left and the featured article details on the right. It includes the `Featured Insights` category tag, a large H2 heading, excerpt, and author metadata.

### 2. Main Content Area (Left Column)
*   **Block Name**: `Blog - Latest Articles`
*   **Content**: A 2-column grid (`.ttp-grid-2`) populated with placeholder Blog Cards (`.ttp-blog-card`). Each card displays:
    *   Thumbnail image (`.ttp-blog-thumb`)
    *   Category badge (`.ttp-blog-category`)
    *   Clickable Title (`.ttp-blog-title`)
    *   Brief Excerpt (`.ttp-blog-excerpt`)
    *   Meta Row (`.ttp-blog-meta`) containing the author's avatar, name, and reading time.
*   **Pagination**: Includes a static pagination component (`.ttp-pagination`) to indicate multi-page functionality.

### 3. Sticky Sidebar Area (Right Column)
*   **Block Name**: `Blog - Sidebar`
*   **Content**: A modular sidebar wrapped in `.ttp-sticky-sidebar` containing several distinct widgets (`.ttp-sidebar-widget`):
    *   **Search**: A simple text input for querying articles.
    *   **Categories**: A list of topic links with post counts.
    *   **Popular Posts**: A mini-list layout showing square thumbnails (`.ttp-popular-thumb`) alongside post titles.
    *   **Tags**: A flex-wrap cloud (`.ttp-tag-cloud`) containing individual tag pills (`.ttp-tag`).
    *   **Newsletter Subscription**: A visually distinct call-to-action box (`.ttp-newsletter-box`) featuring the primary gradient background, prompting users to subscribe to weekly insights.

## Technical Notes & Integration
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes for the blog cards, sidebar widgets, and newsletter block.
*   **Responsive**: The `flex-grow: 1` property ensures that the `.ttp-blog-content` and `.ttp-blog-excerpt` fill available vertical space, keeping the meta footers perfectly aligned across varying excerpt lengths.
*   **SEO Optimization**: The DOM structure utilizes proper heading hierarchy, maintaining `<h2>` for the section titles and `<h3>` for individual blog post titles, which is crucial for archive page indexation.
