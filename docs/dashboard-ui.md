# Student Dashboard UI Structure

The static interface for the Student Dashboard has been successfully built. It is designed as a standalone, app-like experience that lives inside the WordPress ecosystem without relying on slow, third-party dashboard plugins.

## Template Layout & Reusable Blocks

The dashboard utilizes a custom layout paradigm added to the `TTP Design System`, shifting away from the standard container-based grid to a full viewport height, sticky sidebar layout.

### 1. Dashboard Layout Container
*   **CSS Class**: `.ttp-dashboard-layout`
*   **Structure**: A flex container that stacks its children vertically on mobile devices, and switches to a horizontal row on desktop screens (`min-width: 992px`). This ensures the dashboard always fills the viewport.

### 2. Sidebar Navigation
*   **Block Name**: `Dashboard - Sidebar Navigation`
*   **Structure**: Utilizes the `.ttp-dash-sidebar` class. On desktop, this sidebar is fixed to the left side of the screen (`position: sticky`), allowing the main content to scroll independently. It contains:
    *   **Branding Header**: "TTP Student Portal"
    *   **Primary Navigation**: A clean list menu (`.ttp-dash-menu`) linking to Overview, Courses, Assignments, Certificates, Live Sessions, Messages, and Community.
    *   **Notification Badges**: Specific menu items (like Messages or Assignments) include a `.ttp-badge-notification` (e.g., a red pill showing '2') to alert the user of pending actions.
    *   **Secondary Navigation**: Settings, Profile, and Logout placed below a separator line.

### 3. Dashboard Content Area
The right-hand side of the dashboard is wrapped in `.ttp-dash-content`. It acts as a modular grid for various widgets:

*   **Welcome Widget (`Dashboard - Welcome Widget`)**: A full-width, gradient banner greeting the user by name and summarizing immediate pending tasks (e.g., "You have 2 pending assignments"). Includes a "Resume Course" CTA.
*   **Learning Progress Widget (`Dashboard - Learning Progress Widget`)**: Uses a 3-column internal grid to display active courses and upcoming assignment deadlines.
    *   **Progress Bars**: Introduces `.ttp-progress-bar` and `.ttp-progress-fill` classes to visually represent course completion percentages.
*   **Split Row (Sessions & Notifications)**: A 2-column layout mapping out the remainder of the dashboard.
    *   **Upcoming Live Sessions (`Dashboard - Upcoming Live Sessions`)**: Lists upcoming webinars utilizing the `.ttp-event-date-badge` we developed for the Events page, maintaining design consistency across the site.
    *   **Recent Notifications**: A simple list widget mapping recent system, grading, and messaging alerts.

## Technical Notes & Dark Mode
*   **Dark Mode Ready**: The dashboard interface fully supports native OS Dark Mode. A `@media (prefers-color-scheme: dark)` query was appended to `style.css`. Because the entire design system was built using CSS Custom Properties (Variables) like `--ttp-bg-light` and `--ttp-text-body-light`, we simply reassigned these variables to dark slate hex codes within the media query. The UI will automatically invert based on the user's system preferences.
*   **Modular Widgets**: By saving each dashboard section as a Reusable Gutenberg Block (`wp_block`), backend developers can easily isolate and replace the static placeholder text within a specific widget (e.g., swapping the Welcome text for a PHP `get_user_meta` call) without breaking the surrounding layout.
