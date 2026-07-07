# User Roles & Permission Matrix

The user roles and capabilities for the Teacher Training Program have been programmatically configured in the WordPress database. These roles map to both core WordPress capabilities and custom capabilities used by our LMS and community integrations.

## 1. Configured Roles

*   **Super Admin (`administrator`)**: Complete access to all backend settings, plugins, themes, and global site data.
*   **Course Manager (`course_manager`)**: High-level academic staff. Can oversee all courses, manage global certificates, moderate the community forums, and manage content created by other trainers.
*   **Trainer (`trainer`)**: Instructors who create and manage their own courses. They can review and grade assignments submitted to their courses, and publish their own content.
*   **Startup Mentor (`startup_mentor`)**: Industry professionals tasked with guiding students through the Startup Practical Experience. They can approve specific startup tasks and edit their own mentor profiles.
*   **Student (`student`)**: The base role for all learners. Grants access to view enrolled courses, participate in the community, and submit assignments.

---

## 2. Permission Matrix

| Capability / Action | Super Admin | Course Manager | Trainer | Startup Mentor | Student |
| :--- | :---: | :---: | :---: | :---: | :---: |
| **View (Frontend Content)** | ✔️ | ✔️ | ✔️ | ✔️ | ✔️ |
| **Create (Courses/Posts)** | ✔️ | ✔️ | ✔️ | ❌ | ❌ |
| **Edit Content** | ✔️ (All) | ✔️ (All) | ✔️ (Own Only) | ✔️ (Own Only) | ❌ |
| **Delete Content** | ✔️ (All) | ✔️ (All) | ✔️ (Own Only) | ❌ | ❌ |
| **Manage All Courses** | ✔️ | ✔️ | ❌ | ❌ | ❌ |
| **Review Assignments** | ✔️ | ✔️ | ✔️ | ❌ | ❌ |
| **Approve Startup Tasks** | ✔️ | ❌ | ❌ | ✔️ | ❌ |
| **Manage Community** | ✔️ | ✔️ | ❌ | ❌ | ❌ |
| **Manage Certificates** | ✔️ | ✔️ | ❌ | ❌ | ❌ |

## 3. Technical Implementation Details

The roles were injected into the database utilizing native WordPress functionality (`add_role()` and `add_cap()`). 
To modify these roles in the future, navigate to **Settings > Roles** in the WordPress Dashboard (powered by the `Members` plugin we installed during the Authentication setup phase). This provides a visual interface to toggle the underlying capabilities (`manage_tutor_courses`, `review_assignments`, `approve_startup_tasks`, etc.) defined in this matrix.
