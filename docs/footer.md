# Global Footer Structure

The Global Footer template has been successfully designed and saved as a reusable native Gutenberg block. It provides essential secondary navigation, legal links, and a newsletter capture form across all public pages.

## Design Architecture

The footer utilizes a deep slate background (`#0F172A`) to strongly contrast with the primarily light UI of the website, providing visual closure to the page.

### 1. Main Grid Layout
*   **CSS Class**: `.ttp-footer-grid`
*   **Structure**: A highly responsive CSS Grid.
    *   **Mobile**: 1 column (`1fr`), stacking all sections vertically.
    *   **Tablet**: 2 columns (`repeat(2, 1fr)`).
    *   **Desktop**: 5 columns with a custom distribution ratio (`2fr 1fr 1fr 1fr 2fr`). This gives the Brand description (far left) and Newsletter signup (far right) more breathing room, while compressing the standard link lists in the middle.

### 2. Widget Columns
*   **Brand Column**: Features the `.ttp-footer-brand` (a text/icon combo matching the header) and a brief mission statement, followed by social media icons (`.ttp-footer-social`).
*   **Programs Column**: Quick links to the primary career paths.
*   **Company Column**: Links to About, Mentors, Startups, Blog, and Events.
*   **Support Column**: Links to the FAQ, Contact page, and login portals for both Students and Mentors.
*   **Newsletter Column**: Contains an inline email subscription form. It uses a flex layout to perfectly align the input field with a square, primary-colored submit button.

### 3. Bottom Bar (Legal & Copyright)
*   **CSS Class**: `.ttp-footer-bottom`
*   **Structure**: Separated from the main grid by a subtle top border. It displays the copyright notice on the left and a flex row (`.ttp-footer-bottom-links`) of legal policies (Privacy, Terms, Cookie) on the right. On mobile, these elements stack centrally.

## Technical Notes
*   **Typography & Contrast**: To ensure WCAG compliance against the dark background, paragraph text and links use a soft slate (`#94A3B8`), while headings and hover states brighten to a near-white (`#F8FAFC`) or the primary brand purple.
*   **Integration**: Saved as a `wp_block` (Reusable Block) named "Global Footer". Similar to the header, it can be dynamically injected into the site's footer hook via the Kadence Theme Customizer, ensuring that any changes made to the block immediately reflect across the entire website.
