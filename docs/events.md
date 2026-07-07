# Events Page Structure

The Events page has been successfully built natively in Gutenberg. It acts as the central hub for webinars, workshops, and networking mixers designed to connect educators with the startup ecosystem.

## Template Layout & Reusable Blocks

The layout is constructed using the `TTP Design System`, ensuring consistent typography and responsive behavior across complex components like maps and speaker profiles.

### 1. Hero Section
*   **Block Name**: `Events - Hero`
*   **Structure**: A clean, centered introductory header titled "Upcoming Events" with a "Community & Networking" badge.

### 2. Featured Event Section
*   **Block Name**: `Events - Featured Event`
*   **Structure**: Utilizes the `.ttp-layout-sidebar` class to create a highly detailed, conversion-focused event highlight.
    *   **Main Content (Left Column)**: Enclosed in a `.ttp-glass-panel` card. It features a prominent Date Badge (`.ttp-event-date-badge`), the event title, description, and a dedicated Speaker block (`.ttp-speaker-row`) showing the host's avatar and credentials. It ends with a primary Registration CTA.
    *   **Sidebar (Right Column)**: A standard card containing logistical details. It uses an icon list (`.ttp-event-meta-list`) for Date, Time, Location, and Cost. Below the list, it embeds a responsive Google Map utilizing the `.ttp-map-container` class established during the Contact page build.

### 3. Events Grid (Upcoming & Past)
*   **Block Name**: `Events - Grid`
*   **Structure**: 
    *   **Filter Bar**: A header section containing a select dropdown (`.ttp-select`) allowing users to filter by "Upcoming", "Past", or "Webinars".
    *   **Event Cards**: A `.ttp-grid-3` layout populated with `.ttp-event-card` elements. Each card is structured to prioritize temporal information:
        *   Date Badge (`.ttp-event-date-badge`) shifted to the top-left corner.
        *   Event Title (`.ttp-event-title`)
        *   Meta list (`.ttp-event-meta-list`) showing time and location.
        *   Speaker Row (`.ttp-speaker-row`) for quick identification of the host.
        *   CTA Button (RSVP). For past events, this button is styled with reduced opacity and `pointer-events: none` to indicate it is closed.

## Technical Notes & Integration
*   **CSS Enhancements**: The `style.css` in the `TTP Design System` plugin was updated with specific UI components for events. This includes `.ttp-event-date-badge` (a stacked, calendar-style date visual), `.ttp-speaker-row` (for aligning avatars and names), and `.ttp-event-card`.
*   **Flexbox Alignment**: The `.ttp-event-meta-list` utilizes `flex-grow: 1` to push the speaker row and RSVP button to the bottom of the card, ensuring all buttons align perfectly in a grid regardless of title length.
*   **SEO Optimization**: The DOM structure naturally supports `Event` schema markup, preparing the page for rich snippets in Google Search results.
