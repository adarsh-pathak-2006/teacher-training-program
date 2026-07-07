# Dynamic Navigation & Routing Architecture

This document maps out the dynamic routing structure implemented to convert the static Teacher Training Program (LMS) into a fully functional application.

## 1. Role-Based Header Navigation
Instead of generating multiple disjointed menus, a single master menu (`TTP Dynamic Navigation`) was built and assigned to the Kadence Primary header. Visibility of each item is strictly governed by the **Ultimate Member** access control engine.

### Global Routes (Visible to Everyone)
*   **Home**: `/`
*   **Programs**: `/programs/`
*   **Mentors**: `/mentors/`
*   **Startup Partners**: `/startup-partners/`
*   **Blog**: `/blog/`
*   **Events**: `/events/`
*   **Contact**: `/contact/`

### Guest Routes (Visible to Logged-Out Users)
*   **Login**: `/login/`
*   **Register**: `/register/`
*   **Apply Now**: `/startup-experience-application/`

### Student Routes (Requires Login + Student Role)
*   **Student Dashboard**: `/student-dashboard/`
*   **My Courses**: `/student-dashboard/my-courses/`
*   **Certificates**: `/student-dashboard/certificates/`
*   **Profile**: `/user/`

### Mentor Routes (Requires Login + Mentor Role)
*   **Mentor Dashboard**: `/mentor-dashboard/`
*   **Messages**: `/user/?profiletab=messages`
*   **Profile**: `/user/`

### Admin Routes (Requires Login + Admin Role)
*   **Admin Dashboard**: `/wp-admin/`

### Global Authenticated Routes (Requires Login)
*   **Logout**: `/logout/`

## 2. Call-to-Action (CTA) Resolution
All static `#` and blank `href` placeholders across every page and Gutenberg Block have been programmatically resolved. 
An automated regex crawler mapped the placeholder anchor text to the correct application endpoints:
*   `"Apply Now"` / `"Get Started"` -> `/student-registration/`
*   `"Login"` -> `/login/`
*   `"View Courses"` / `"Explore Programs"` -> `/programs/`
*   `"Find a Mentor"` -> `/mentors/`
*   `"Dashboard"` -> `/student-dashboard/`
*   `"Contact Us"` -> `/contact/`

## 3. Active Highlighting & Breadcrumbs
*   **Breadcrumbs**: Rank Math's dynamic breadcrumb generation has been enabled in the core SEO settings to allow users to navigate deep taxonomy hierarchies (e.g., `Home > Programs > Foundational Education`).
*   **Highlighting**: Because the Kadence theme standard primary menu is utilized, WordPress automatically appends the `current-menu-item` CSS class to the active page, enabling visual highlighting governed by the master Design System.
