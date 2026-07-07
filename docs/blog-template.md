# Single Blog Template Structure

The Single Blog Template has been successfully built as a native Gutenberg template. A sample post (`Blog: Translating Lesson Plans into Product Roadmaps`) has been generated in the database to showcase the layout.

## Template Layout & Reusable Blocks

The article template prioritizes readability, sharing, and lead generation, utilizing the `TTP Design System` to ensure high performance.

### 1. Header Section
*   **Block Name**: `Blog Template - Header`
*   **Structure**: A centered header displaying the category badge, H1 title, and a meta row (Author, Reading Time, Date). This sits directly above a large, full-width featured image with rounded corners.

### 2. Main Article Content
*   **Block Name**: `Blog Template - Main Content`
    *   **Table of Contents (TOC)**: An in-page navigation block (`.ttp-toc`) allowing readers to jump to specific sections.
    *   **Typography**: The body text utilizes the `.ttp-article-content` class, establishing a readable line-height (1.8), an optimal reading width (max 800px), and increased spacing around headings.
    *   **Share Buttons**: A row of pill-shaped buttons (`.ttp-share-btn`) at the end of the article encouraging social sharing.

### 3. Author Box
*   **Block Name**: `Blog Template - Author Box`
*   **Structure**: A highlighted card (`.ttp-author-box`) providing a brief biography of the writer and a link to their full Mentor/User profile.

### 4. Lead Generation (Newsletter)
*   **Block Name**: `Blog Template - Newsletter CTA`
*   **Structure**: Reuses the vibrant `.ttp-newsletter-box` component introduced on the archive page, positioned directly after the article to capture engaged readers.

### 5. Related Posts
*   **Block Name**: `Blog Template - Related Posts`
*   **Structure**: A responsive grid (`.ttp-grid-3`) recommending 2-3 similar articles using the standard `.ttp-blog-card` component to keep users on the site.

## Technical Notes & Integration
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specific typography rules for long-form reading (`.ttp-article-content`), TOC styling, share buttons, and author box layouts.
*   **Reusable Template**: By structuring the post as `wp_block` references, content creators can load the template, "Convert to Regular Blocks", and immediately start writing within a pre-formatted structure without adjusting paddings or margins.
*   **SEO Optimization**: The template naturally supports `Article` and `Breadcrumb` schema markup (which will be injected via Rank Math SEO) and adheres to strict H1 -> H2 -> H3 hierarchical flow.
