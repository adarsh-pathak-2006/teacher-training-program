# Authentication System Setup Report

The complete authentication backend for the Teacher Training Program has been successfully implemented using **Ultimate Member**, **Members**, and **Google reCAPTCHA**. 

As requested, the implementation adheres strictly to the "No Custom Styling" rule. We disabled all Ultimate Member CSS stylesheets via the database options to ensure the forms seamlessly inherit the global typography, spacing, and normalized input styles of our `TTP Design System` (defined in Phase 5).

## 1. Installed & Activated Components
*   `ultimate-member` (Core user management and forms)
*   `members` (Role and capability management)
*   `advanced-nocaptcha-recaptcha` (Spam protection for registration/login)

## 2. Role Architecture
Two new roles were programmatically created inheriting baseline capabilities from the standard 'Subscriber' role:
1.  **Student (`student`)**: The default role for new signups. Designed for users accessing courses and the Student Dashboard.
2.  **Mentor (`mentor`)**: A specialized role requiring manual assignment or a specific registration flow, designed for users accessing the Mentor Dashboard.

## 3. Core Pages & Workflows Generated
The following pages were programmatically generated and populated with Ultimate Member shortcodes. They automatically intercept WordPress's default `wp-login.php` workflow.

| Page | Path | Function |
| :--- | :--- | :--- |
| **Register** | `/register/` | Default signup form. Requires email confirmation (setting enabled). Protected by reCAPTCHA. |
| **Login** | `/login/` | Default login form. Protected by reCAPTCHA. |
| **User Profile** | `/user/` | Public-facing profile page for users. Allows avatar upload and bio editing for authenticated owners. |
| **Account** | `/account/` | Private account settings (Change password, privacy controls, delete account). |
| **Password Reset** | `/password-reset/` | Front-end password recovery workflow. |
| **Logout** | `/logout/` | Endpoint to terminate the session. |

## 4. Redirect Logic
To ensure a cohesive user experience, login and logout redirects were configured based on the user's role:

*   **Student Login** ➔ Redirects to `/student-dashboard/`
*   **Mentor Login** ➔ Redirects to `/mentor-dashboard/`
*   **Global Logout** ➔ Redirects to the Homepage (`/`)

## 5. Security Settings
*   **Email Verification**: Forced on registration (`um_require_email_confirmation = 1`). Users must click a link in their email before gaining access.
*   **reCAPTCHA**: Enabled on the `um_login` and `um_register` forms using placeholder keys. 

> [!WARNING]
> Before deploying to production, you must replace the `PLACEHOLDER_SITE_KEY` and `PLACEHOLDER_SECRET_KEY` in the Advanced noCaptcha settings within the WordPress Admin.

## Testing the Workflows Locally
1. **Registration**: Navigate to `/register` in an Incognito window. Fill out the form. You will be prompted to verify your email. (Local tools like MailHog or Local WP's built-in Mailhog can be used to catch the verification email).
2. **Login**: After verification, login at `/login`. You should be immediately redirected to the `/student-dashboard/` page we built previously.
3. **Profile Edit**: Navigate to `/user/` while logged in to test avatar uploads and bio modifications.
4. **Logout**: Click the Logout link to verify redirection to the homepage.
