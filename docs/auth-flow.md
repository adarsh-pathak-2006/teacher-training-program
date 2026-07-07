# Authentication Flow & Routing Document

This document verifies the strict authentication routing enforced across the platform using the Ultimate Member (UM) core engine. All authentication forms have been dynamically generated and assigned to their respective WordPress pages.

## 1. Registration Flow
*   **Trigger**: User submits the Registration Form on `/register/` (or via `/startup-experience-application/` if custom routed).
*   **Step 1**: The user's account is created but marked as "Awaiting Email Activation".
*   **Step 2**: An email is dispatched containing an activation link.
*   **Step 3**: The user clicks the link and is automatically redirected to the `/login/` page to authenticate for the first time.
*   **Result**: Zero ghost accounts; all students are verified.

## 2. Login Flow (Role-Based Routing)
A generic login redirect has been disabled. The destination is dynamically determined by the user's role metadata:
*   **Student Login**: Routes directly to `/student-dashboard/`.
*   **Mentor Login**: Routes directly to `/mentor-dashboard/`.
*   **Admin Login**: Uses default WordPress logic to route to `/wp-admin/`.

## 3. Password Reset Flow
*   **Trigger**: User clicks "Forgot Password" on the Login form.
*   **Step 1**: User is routed to `/password-reset/` to submit their email.
*   **Step 2**: The user receives a recovery link via email.
*   **Step 3**: The user clicks the link, enters a new password, and is automatically redirected back to `/login/` to authenticate.

## 4. Logout Flow
*   **Trigger**: User clicks the "Logout" link in the global navigation or their dashboard.
*   **Action**: The session is destroyed.
*   **Route**: The user is forcibly redirected to the platform Homepage (`/`) rather than the default WordPress login screen.

## 5. Profile Update Flow
*   **Trigger**: User navigates to `/account/` (or clicks "Account" from their Profile).
*   **Action**: User updates details (password, privacy, notifications) and clicks "Save Changes".
*   **Result**: The user is *not* redirected. Instead, Ultimate Member uses AJAX to flash a native "Success" message on the screen, keeping the user in the Account context.

## Core Initialization
All missing Ultimate Member forms (Default Login, Default Registration, Default Profile) were programmatically generated and embedded into the blank WordPress pages via the `UM()->setup()->run_setup()` engine, ensuring a stable architecture.
