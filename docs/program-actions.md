# Program Card Actions & Routing

This document details the dynamic routing engine built into the custom `[ttp_program_grid]` shortcode. This engine replaces static HTML cards with dynamic, state-aware components hooked directly into the Tutor LMS database.

## Architecture
To preserve the bespoke UI design of the `/programs/` page without relying on basic Tutor LMS templates, a custom shortcode was injected into the `teacher-training-core` plugin. This shortcode loops through the `courses` Custom Post Type (CPT) and renders the exact HTML/CSS grid structure defined by the Kadence Design System, but with dynamic metadata and CTA buttons.

## State-Aware Routing Logic

The CTA button on every program card evaluates the user's current session and enrollment status in real-time using native `tutor_utils()` APIs.

### 1. Guest (Logged Out)
*   **Condition**: `!is_user_logged_in()`
*   **Button Text**: `Login to Enroll`
*   **Button Style**: Secondary outline (`ttp-btn-secondary`)
*   **Action Route**: Redirects the user to `/login/`

### 2. Authenticated Student (Not Enrolled)
*   **Condition**: `is_user_logged_in() && !is_enrolled`
*   **Button Text**: `Enroll Now` (or `Buy Course` if priced)
*   **Button Style**: Primary solid (`ttp-btn-primary`)
*   **Action Route**: Routes to the Single Course page (`get_permalink()`) to initiate the Tutor LMS / WooCommerce enrollment flow.

### 3. Authenticated Student (Enrolled, Not Completed)
*   **Condition**: `is_enrolled && !is_completed`
*   **Button Text**: `Continue Learning`
*   **Button Style**: Primary solid (`ttp-btn-primary`)
*   **Action Route**: Bypasses the course landing page and routes directly to the student's active lesson via `tutor_utils()->get_course_first_lesson($course_id)`.

### 4. Authenticated Student (Course Completed)
*   **Condition**: `is_completed`
*   **Button Text**: `Download Certificate`
*   **Button Style**: Secondary outline (`ttp-btn-secondary`)
*   **Action Route**: Routes directly to the centralized certificate repository (`/student-dashboard/certificates/`).

## Implementation Details
The static Reusable Block (ID 58) previously used on the Programs page was overwritten in the database to contain only the `[ttp_program_grid]` shortcode. This ensures that anytime a new course is published via Tutor LMS, it will automatically populate on the front-end grid with perfectly mapped functional buttons.
