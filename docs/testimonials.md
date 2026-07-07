# Testimonials Page Structure

The Testimonials page has been successfully built natively in Gutenberg. It serves as social proof for the Teacher Training Program, highlighting successful career transitions and practical project outcomes.

## Template Layout & Reusable Blocks

The layout is constructed using the `TTP Design System`, introducing specialized UI components for video embeds and "Before/After" journey mapping.

### 1. Hero Section
*   **Block Name**: `Testimonials - Hero`
*   **Structure**: A clean, centered introductory header titled "Success Stories".

### 2. Featured Video Story
*   **Block Name**: `Testimonials - Featured Video`
*   **Structure**: Utilizes the `.ttp-grid-2` class to split the screen.
    *   **Left Column (Video)**: Introduces the `.ttp-video-container` class, which uses a 16:9 aspect ratio wrapper to ensure responsive YouTube or Vimeo iframe embeds. Currently populated with a placeholder thumbnail and play button.
    *   **Right Column (Text & Journey)**: Displays a star rating (`.ttp-rating`), a prominent pull quote, and a new component (`.ttp-journey-box`). The journey box maps the user's career transition from their "Before" state (e.g., High School Teacher) to their "After" state (e.g., Content Strategist), emphasizing the program's ROI.

### 3. Text Testimonials Grid
*   **Block Name**: `Testimonials - Text Grid`
*   **Structure**: 
    *   **Filter Bar**: A header section containing a select dropdown (`.ttp-select`) allowing users to theoretically filter reviews by career transition path (e.g., "To Product Management").
    *   **Review Cards**: A `.ttp-grid-3` layout populated with `.ttp-testimonial-card` elements. Each card displays:
        *   Star rating (`.ttp-rating`)
        *   Italicized review text (`.ttp-testimonial-text`) that flex-grows to push the author block to the bottom.
        *   Author Block (`.ttp-testimonial-header`) containing a circular avatar (`.ttp-testimonial-avatar`), name, and their previous/current roles.
    *   **Pagination**: Included at the bottom to handle growing numbers of reviews.

## Technical Notes & Integration
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specialized classes specifically for review cards (`.ttp-testimonial-card`, `.ttp-rating`) and the responsive journey mapper (`.ttp-journey-box`, `.ttp-journey-phase`). 
*   **Responsive Media**: The `.ttp-video-container` class utilizes the standard padding-bottom CSS hack (56.25%) to ensure iframe videos maintain a perfect 16:9 aspect ratio across all devices without requiring external JavaScript libraries.
*   **Design Consistency**: The testimonial cards leverage `flex-grow: 1` on the quote text to guarantee that the author avatars align perfectly at the bottom of a grid row, regardless of how long the review text is.
