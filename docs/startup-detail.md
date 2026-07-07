# Startup Detail Template

The Startup Detail template has been successfully constructed natively in Gutenberg. A sample company profile (`Startup: TechFlow`) has been generated in the database to demonstrate the complete layout, showcasing how educators can discover and apply for practical projects.

## Template Layout & Reusable Blocks

The template heavily utilizes the responsive CSS Grid sidebar layout (`.ttp-layout-sidebar`) to separate narrative company information from actionable project application details.

### 1. Hero Section
*   **Block Name**: `Startup Detail - Hero`
*   **Structure**: A horizontal flex container featuring the startup's logo (`.ttp-startup-logo`), Company Name, Industry, and a meta row highlighting the Founder, Team Size, and Location. It also includes the visual mentor availability badge.

### 2. Main Content Area (Left Column)
*   **Block Name**: `Startup Detail - Main Content`
    *   **Overview**: A narrative paragraph detailing the company's mission, backing, and why they partner with educators.
    *   **Available Projects**: A vertical list utilizing the `.ttp-experience-list` and `.ttp-experience-item` classes to neatly outline specific project roles (e.g., "Customer Onboarding Redesign") and durations.
    *   **Learning Opportunities & Tasks**: A distinct `.ttp-card` highlighting specific tools to be learned (using the `.ttp-check-list` checkmarks) and a clear bulleted list of typical weekly commitments (standups, async work, wrap-ups).

### 3. Sticky Sidebar Area (Right Column)
*   **Block Name**: `Startup Detail - Sidebar`
    *   A prominent card wrapped in `.ttp-sticky-sidebar` so it follows the user on desktop screens.
    *   **Internship Opportunities**: Displays pill tags (`.ttp-startup-tag`) for the roles they are actively recruiting for (e.g., Product Management, Marketing).
    *   **Prerequisites**: Lists the mandatory courses an educator must pass before applying.
    *   **Application CTA**: The primary action button for educators to request placement on a project.

### 4. Related Startups
*   **Block Name**: `Startup Detail - Related`
*   **Structure**: Displays alternative startups in the same industry using the standard `.ttp-startup-card` component developed for the archive page to ensure UI consistency.

## Technical Notes & Integration
*   **Reusable Template**: By modularizing these sections into `wp_block` post types, admins can insert the blocks and "Convert to Regular Blocks" to quickly fill in the details for new startups without touching the layout code.
*   **CSS Reusability**: This template achieves a highly complex, professional layout without requiring any new CSS. It perfectly recycles the `.ttp-layout-sidebar`, `.ttp-experience-list`, and `.ttp-check-list` classes developed in previous phases, keeping the stylesheet lean and performant.
*   **SEO**: The DOM structure naturally supports `Organization` schema markup, which will be dynamically populated later via SEO plugins.
