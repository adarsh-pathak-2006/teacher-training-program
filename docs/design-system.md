# Design System: Teacher Training Program

This document serves as the foundational design system for the Teacher Training Program platform. It strictly adheres to modern web design principles, prioritizing visual excellence, dynamic interactions, and a premium aesthetic to provide an engaging Learning Management System (LMS) experience.

---

## 1. Design Principles
*   **Premium Aesthetic**: Utilize vibrant gradients, high-contrast dark/light modes, and curated typography to elevate the platform beyond a standard LMS.
*   **Dynamic & Interactive**: Every interactive element should provide immediate visual feedback through micro-animations and smooth transitions.
*   **Glassmorphism & Depth**: Strategic use of backdrop filters, soft drop shadows, and overlapping layers to create a sense of depth and hierarchy.
*   **Clarity over Clutter**: Ample negative space to reduce cognitive load, especially important for educational content and dashboards.

---

## 2. Typography
We use a dual-font strategy from Google Fonts to balance readability with a modern, startup-focused brand identity.

*   **Headings (`h1` - `h6`)**: **Outfit** (Sans-Serif, Geometric)
    *   *Weights*: Medium (500), SemiBold (600), Bold (700)
    *   *Usage*: Marketing headers, dashboard page titles, course titles.
*   **Body & UI Elements**: **Inter** (Sans-Serif, Grotesque)
    *   *Weights*: Regular (400), Medium (500)
    *   *Usage*: Paragraphs, buttons, form labels, navigation links, data tables.

**Scale (Base: 16px / 1rem)**:
*   Display / Hero: `3.5rem` (56px) - Tracking: `-0.02em`
*   H1: `2.5rem` (40px) - Tracking: `-0.02em`
*   H2: `2rem` (32px)
*   H3: `1.5rem` (24px)
*   Body Large: `1.125rem` (18px)
*   Body Base: `1rem` (16px)
*   Caption / Small: `0.875rem` (14px)

---

## 3. Color Palette
The color palette is designed to support both a clean Light Mode and a sleek, immersive Dark Mode.

### Primary (Brand)
*   **Indigo Base**: `#4F46E5` (Primary Buttons, Active States)
*   **Indigo Hover**: `#4338CA`
*   **Purple Accent**: `#7C3AED` (Used in gradients with Indigo)

### Secondary (Accents)
*   **Electric Cyan**: `#06B6D4` (Highlights, Success indicators, progress bars)
*   **Neon Pink**: `#EC4899` (Rare usage: alert badges, premium markers)

### Surfaces & Backgrounds
**Light Mode**:
*   Background: `#F8FAFC` (Slate 50)
*   Surface (Cards): `#FFFFFF`
*   Borders: `#E2E8F0` (Slate 200)

**Dark Mode**:
*   Background: `#0F172A` (Slate 900)
*   Surface (Cards): `#1E293B` (Slate 800)
*   Borders: `#334155` (Slate 700)

### Text
*   **Light Mode**: `#0F172A` (Headings), `#475569` (Body), `#94A3B8` (Muted)
*   **Dark Mode**: `#F8FAFC` (Headings), `#CBD5E1` (Body), `#64748B` (Muted)

### Semantic Colors
*   Success: `#10B981` (Green)
*   Warning: `#F59E0B` (Amber)
*   Error: `#EF4444` (Red)

---

## 4. Spacing System
Based on a strict `8px` grid system to ensure vertical and horizontal rhythm.
*   `xs`: 4px (0.25rem)
*   `sm`: 8px (0.5rem)
*   `md`: 16px (1rem) - *Default padding for tight components*
*   `lg`: 24px (1.5rem) - *Default container padding*
*   `xl`: 32px (2rem)
*   `2xl`: 48px (3rem)
*   `3xl`: 64px (4rem) - *Standard section spacing*
*   `4xl`: 96px (6rem) - *Hero section spacing*

---

## 5. UI Components

### Buttons
*   **Primary**: Indigo-to-Purple linear gradient background, white text.
    *   *Hover State*: Transform `translateY(-2px)`, shadow intensifies (`box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3)`).
*   **Secondary**: Transparent background, 1px solid Indigo border, Indigo text.
    *   *Hover State*: Indigo background (10% opacity).
*   **Ghost**: Transparent background, gray text.
    *   *Hover State*: Gray background (10% opacity).
*   **Radius**: `0.5rem` (8px) for a modern, friendly feel.
*   **Transition**: `all 0.2s cubic-bezier(0.4, 0, 0.2, 1)`

### Cards (Course Cards, Mentor Profiles)
*   **Background**: Solid White (Light) or Slate 800 (Dark).
*   **Border**: `1px solid` subtle border to separate from background.
*   **Radius**: `1rem` (16px) - softer curves for premium feel.
*   **Shadow**: Soft, diffused shadows (`box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05)`).
*   **Hover**: Elevate the card (`translateY(-4px)`) and increase shadow spread to invite clicking.
*   **Glassmorphism Use-Case**: For floating UI elements (like a sticky course progress widget), use `backdrop-filter: blur(12px)` with a semi-transparent background (`rgba(255,255,255,0.7)`).

### Forms
*   **Inputs**: Minimalist. 
*   **Background**: Slightly off-white/gray (Light) or darker slate (Dark).
*   **Border**: 1px solid transparent by default, transitioning to 1px solid Slate 300 on hover.
*   **Focus State**: Remove default outline. Apply a `2px` ring in Electric Cyan (`box-shadow: 0 0 0 2px #06B6D4`) to make it highly visible and accessible.
*   **Labels**: Small, uppercase, letter-spacing `0.05em`, Slate 500 text above the input.

### Tables (Gradebooks, Mentee Lists)
*   **Header**: Sticky top, distinct background (Slate 100 / Slate 800), bold text.
*   **Rows**: Subtly separated by 1px bottom borders. 
*   **Hover**: Highlight entire row on hover (`rgba(0,0,0,0.02)`) to assist horizontal tracking.
*   **Padding**: Ample padding (`1rem` vertical, `1.5rem` horizontal) to prevent cramped data.

---

## 6. Iconography
*   **Library**: **Lucide Icons** or **Phosphor Icons**.
*   **Style**: Outline / Line-art style. Consistent stroke width (`2px` standard).
*   **Usage**: Paired with text labels in navigation; used as decorative elements in feature grids.

---

## 7. Layout & Structure

### Navigation
*   **Behavior**: Sticky at the top of the viewport.
*   **Style**: Glassmorphic (`backdrop-filter: blur(8px)`, 80% opacity background) to allow page content to slide beautifully underneath.
*   **Elements**: Logo (left), Links (center - hidden on mobile), CTA + User Avatar (right).

### Footer
*   **Background**: Deep Slate (`#0F172A`) across all themes to anchor the page.
*   **Layout**: 4-column grid (Brand/About, Quick Links, Legal, Newsletter/Contact).
*   **Text**: Muted Slate (`#94A3B8`) for readability against the dark background.

---

## 8. Responsive Breakpoints
Following standard Tailwind CSS breakpoints:
*   `sm`: `640px` (Large Phones / Phablets)
*   `md`: `768px` (Tablets - Portrait) - *Navigation collapses to hamburger menu here.*
*   `lg`: `1024px` (Tablets - Landscape / Small Laptops)
*   `xl`: `1280px` (Desktops)
*   `2xl`: `1536px` (Large Monitors) - *Max-width wrapper applied here to constrain content.*

---

## 9. Accessibility (a11y) Guidelines
*   **Contrast**: All text must meet WCAG 2.1 AA requirements (minimum 4.5:1 contrast ratio for normal text).
*   **Focus Indicators**: Never remove focus outlines without providing a visible alternative. The Electric Cyan focus ring will be applied to all interactive elements (links, buttons, inputs).
*   **Semantic HTML**: Utilize proper landmark tags (`<nav>`, `<main>`, `<article>`, `<aside>`) to support screen readers.
*   **Aria Attributes**: Ensure dynamic elements (tabs, modals, dropdowns) utilize appropriate `aria-expanded`, `aria-hidden`, and `aria-label` tags.

---
*Note: This design system will guide the configuration of the Kadence Theme and Kadence Blocks in the WordPress implementation phase.*
