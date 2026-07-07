# Startup Practical Experience Workflow

The Startup Practical Experience module integrates real-world startup tasks into the LMS journey. By leveraging WordPress Core, Advanced Custom Fields (ACF), and Fluent Forms, we have built a robust relational architecture without relying on fragile custom database tables.

## 1. Application Phase
*   **Student Action**: The student navigates to `/startup-application/` and submits the Fluent Form (Placeholder ID `1`).
*   **Admin Action**: The administrator receives the application in the WordPress backend under **Fluent Forms > Entries**.
*   *Note on Customization*: Admins can visually drag-and-drop fields in the Fluent Forms editor to customize the exact questions asked during the application phase.

## 2. Startup & Mentor Assignment
Once an application is approved, the Admin links the Student to a Startup and a Mentor.
*   **Admin Action**: Navigate to **Users > All Users**, and edit the Student's profile.
*   **ACF Integration**: Scroll down to the "Startup Practical Experience" section. Using the dropdowns, the Admin selects the:
    1.  `Assigned Startup` (Queries the `startup` CPT).
    2.  `Assigned Mentor` (Queries users with the `startup_mentor` role).
*   **Result**: The Mentor Dashboard dynamically queries this relationship, populating the student into the Mentor's "My Cohort" widget.

## 3. Weekly Task Management
*   **Mentor Action**: Mentors navigate to the backend and create a new **Startup Task** (`startup_task` CPT). 
*   **Student Action**: Students view these tasks on the frontend. To submit their weekly work, they utilize a dedicated submission Fluent Form embedded on the task page (or provide a direct URL to a Google Doc/GitHub repo).
*   *Phase 4 Alignment*: This native CPT approach completely bypasses the need for Tutor LMS Pro's assignment module, fulfilling the custom assignment workflow requirement.

## 4. Performance & Completion
*   **Mentor Action**: After reviewing a student's weekly submission, the Mentor updates the student's `Startup Performance Score` (0-100) via their User Profile in the backend (or eventually via a frontend dashboard hook).
*   **Completion**: Once all tasks are satisfactory, the Mentor toggles the `Experience Completed` True/False checkbox on the Student's profile.
*   **Certification**: Toggling this field to `True` signals the system to unlock the custom Certificate of Completion (querying the `ttp_certificate` CPT) for the student to download.
