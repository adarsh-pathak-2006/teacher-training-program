# FluentCRM Automation Blueprints

Because FluentCRM relies on a proprietary database structure and a visual builder to construct email funnels, this document serves as the architectural blueprint for Administrators to visually build the 7 requested automations inside the **wp-admin > FluentCRM > Automations** panel.

*Note: The prerequisite Lists (`Students`, `Mentors`) and Tags (`Registered`, `Certificate_Earned`, etc.) have already been programmatically generated in the database for you.*

---

## 1. Registration Automation
**Goal:** Welcome new users to the platform and provide initial dashboard links.
*   **Trigger:** WordPress User Registration (or Ultimate Member Registration).
*   **Action 1:** Apply List -> `Students`
*   **Action 2:** Apply Tag -> `Registered`
*   **Action 3:** Send Custom Email -> "Welcome to the Teacher Training Program! Here is how to access your dashboard..."

## 2. Course Enrollment
**Goal:** Onboard a student specifically into the Fundamentals course.
*   **Trigger:** WooCommerce Order Completed (Product: "Premium Course Access: Fundamentals") OR Tutor LMS Course Enrollment.
*   **Action 1:** Apply Tag -> `Enrolled_Fundamentals`
*   **Action 2:** Send Custom Email -> "You are enrolled! Join your first live class here..."
*   **Action 3:** Delay -> 3 Days
*   **Action 4:** Send Custom Email -> "Checking in: Have you completed Module 1?"

## 3. Assignment Reminder
**Goal:** Nudge students who have not submitted their weekly startup practical task.
*   **Trigger:** Tag Applied -> `Assignment_Pending`
*   **Action 1:** Send Custom Email -> "Reminder: Your weekly assignment is due in 48 hours."
*   **Action 2:** Delay -> 2 Days
*   **Condition:** Check if tag `Assignment_Pending` still exists.
*   **Action 3 (If Yes):** Send Custom Email -> "URGENT: Your assignment is overdue."
*   *Note: Our custom `ttp_submission` CPT logic can be hooked to apply/remove this tag via the FluentCRM API when a student submits work.*

## 4. Course Inactivity Reminder
**Goal:** Re-engage students who haven't logged in.
*   **Trigger:** Tutor LMS Course Inactivity (Requires FluentCRM Pro integration with Tutor LMS, or a custom WP Cron job checking last login).
*   **Action 1:** Send Custom Email -> "We miss you! Log back in to continue your Fundamentals course."

## 5. Certificate Ready
**Goal:** Notify the student the moment they pass the 80% attendance, assignment, and quiz thresholds.
*   **Trigger:** Tag Applied -> `Certificate_Earned`
*   **Action 1:** Send Custom Email -> "Congratulations! You have passed all requirements. Click here to view and download your official PDF Certificate: `[site_url]/certificate/`"
*   *Note: You can hook our custom `ttp_certificate_status` shortcode logic to apply this tag using `FluentCrmApi('tags')->attach([$tag_id], $user_id);` when the condition evaluates to true.*

## 6. Weekly Newsletter
**Goal:** Send global updates to the community.
*   **Setup:** This is NOT an "Automation" funnel. Instead, navigate to **FluentCRM > Campaigns**.
*   **Action:** Create a Recurring Campaign.
*   **Audience:** Select the `Students` and `Mentors` lists.
*   **Schedule:** Set to send every Friday at 9:00 AM.

## 7. Community Notifications
**Goal:** Digest emails for BuddyPress / Better Messages activity.
*   **Setup:** Because we installed Better Messages, live chat notifications are handled natively by the plugin (it sends "You have a new message" emails automatically).
*   **BuddyPress Integration:** For group announcements, FluentCRM has native BuddyPress triggers (e.g., "User joins a group"). You can create a funnel that triggers when a user joins the `Student Groups` BuddyPress group, automatically adding them to a specific cohort email sequence.
