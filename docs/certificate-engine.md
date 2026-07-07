# Certificate Engine Workflow

Because Tutor LMS Free does not support native certification or complex prerequisite chaining (like custom assignments and attendance), we engineered a bespoke validation engine inside our `teacher-training-core` plugin.

## 1. The Validation Engine
To earn a certificate, a student must meet four strict criteria. The engine validates this every time the student visits their dashboard or the `/certificate/` endpoint:

1.  **Quiz Passed**: The student must pass all required Tutor LMS quizzes.
2.  **Course Completed**: The Tutor LMS course status must be 100%.
3.  **Assignment Complete**: The student must have an "Approved" `ttp_submission` linked to the course.
4.  **Attendance Requirement**: An administrator must check the "Attendance Requirement Met" box on the student's User Profile in the WordPress backend.

## 2. Certificate Generation
*   **The Unlock**: Once all 4 criteria evaluate to `TRUE`, the student dashboard reveals a "View & Download Certificate" button.
*   **The Render**: Clicking this routes the student to `/certificate/?course=XYZ&user=ABC`. This page renders a high-resolution HTML/CSS certificate customized with their name, course title, and completion date.
*   **The Download**: A "Download PDF" button utilizes `html2pdf.js` to instantly convert the DOM into a paginated `.pdf` file in the browser, completely avoiding server-side PHP generation bloat.

## 3. Public Verification System
*   **The Hash**: Upon unlocking the certificate, the system generates a cryptographically secure 12-character Verification ID (e.g., `TTP-A1B2C3D4`) and attaches it to the PDF.
*   **The Portal**: Employers or institutions can navigate to the `/verify/` page on the public website. By entering the Verification ID into the search box, the system queries the database and outputs a digital proof of authenticity (displaying the Student's Name and Course Title) if valid.
