# TTP UI Design System & Component Guidelines

This document outlines the global styles, spacing utilities, and interactive components added to the Teacher Training Program's custom CSS framework (`style.css`).

## 1. Global Spacing (CSS Variables)

To ensure consistency across custom Gutenberg blocks and avoid hardcoding padding/margins, the following spacing scale has been applied to the `:root`:

*   `--ttp-space-sm`: 8px
*   `--ttp-space-md`: 16px
*   `--ttp-space-lg`: 24px
*   `--ttp-space-xl`: 32px
*   `--ttp-space-2xl`: 64px

*Best Practice: When building new layouts, utilize these variables instead of absolute pixel values.*

## 2. Accessibility: Focus States

Keyboard accessibility has been vastly improved. A global `:focus-visible` rule now applies a clear, 2px offset outline utilizing the brand's primary color (`--ttp-primary`) to all interactive elements (links, buttons, form inputs) when navigating via keyboard.

## 3. Button States

The primary (`.ttp-btn-primary`) and secondary (`.ttp-btn-secondary`) buttons have been augmented with complete state styling:
*   **Hover**: Retains the `transform: translateY(-2px)` elevation effect.
*   **Active**: Adds a tactile click-down effect (`transform: translateY(0)` and removes shadow).
*   **Disabled**: Applies `opacity: 0.6` and `cursor: not-allowed`.

## 4. Form & Input Normalization

All form inputs (including `.ttp-input`, `.ttp-select`, and generic `input[type="text"]`, `textarea`) have been normalized to ensure consistency, particularly when third-party forms (like Fluent Forms) are embedded via shortcode.

*   **Box Model**: All inputs use `box-sizing: border-box` and share consistent 12px vertical / 16px horizontal padding.
*   **Focus Ring**: Inputs utilize a subtle `box-shadow` (rgba primary color) alongside border color changes, rather than harsh outlines, for a premium feel.
*   **Select Dropdowns**: Native select dropdowns (`.ttp-select`) now feature a custom SVG chevron replacing standard browser UI, ensuring cross-browser design parity.

## 5. Animations

*   **Smooth Scrolling**: Added `scroll-behavior: smooth` to the HTML tag to ensure anchor links glide down the page naturally.
*   **Entrance Animations**: Added a utility class `.ttp-fade-in` which applies a 0.5s fade and slide-up animation. This can be attached to hero containers or cards via the Gutenberg "Advanced" panel.
*   **Hover Transitions**: Updated the transition curve on interactive elements like `.ttp-card` from standard `ease` to `cubic-bezier(0.4, 0, 0.2, 1)` for a significantly smoother, more natural elevation effect.
