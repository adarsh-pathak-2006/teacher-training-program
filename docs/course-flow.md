# Complete Course Workflow

This document outlines the linear progression of a student through a standard course on the Teacher Training Program platform. We have programmatically configured the database placeholders for each of these steps to ensure the underlying data relationships are established for frontend UI testing.

## The Student Journey

### 1. Enroll
*   **Trigger**: User clicks "Enroll Now" on a Course page.
*   **Mechanism**: Handled via Tutor LMS native free enrollment (configured in `lms-config.md`). 
*   **Result**: Course is added to the student's "Enrolled Courses" list on their dashboard.

### 2. Watch Lessons
*   **Trigger**: User navigates to a Module (Topic) and opens a Lesson.
*   **Mechanism**: Handled via the Tutor LMS `lesson` custom post type.
*   **Status**: We generated placeholder lessons (e.g., *Lesson 1.1*) linked hierarchically to the *Module 1* topic.

### 3. Complete Lesson
*   **Trigger**: User finishes reading/watching and clicks the "Complete Lesson" button.
*   **Mechanism**: Updates the student's progress percentage for the specific course in the database.

### 4. Attempt Quiz
*   **Trigger**: User reaches the end of a module and begins the assessment.
*   **Mechanism**: Handled via the `tutor_quiz` and `tutor_quiz_question` custom post types.
*   **Status**: We generated a placeholder *Quiz: Module 1 Assessment* with a passing grade threshold of 80%, a 15-minute time limit, and 3 allowed attempts. We also generated a sample Single Choice question.

### 5. Submit Assignment
*   **Trigger**: A practical task required before course completion.
*   **Mechanism**: As per Phase 4 of `PROJECT.md`, standard Tutor Free does not include Assignments. We have registered a custom `ttp_assignment` post type placeholder to facilitate our Custom Assignment Workflow build-out.
*   **Status**: Generated *Assignment: Create a Lesson Plan* linked to the parent course.

### 6. Course Complete
*   **Trigger**: All lessons are marked complete, the quiz is passed (≥80%), and the assignment is approved by a Trainer or Course Manager.
*   **Mechanism**: The user's status for the course is marked as 'Completed', triggering the certificate generation.

### 7. Certificate
*   **Trigger**: Course completion status = True.
*   **Mechanism**: As per Phase 4 of `PROJECT.md`, we have registered a custom `ttp_certificate` post type placeholder. This will be used by our custom module to generate a PDF/HTML certificate upon completion.
*   **Status**: Generated a placeholder *Certificate of Completion: Fundamentals*.

---

## Technical Considerations for Phase 4
By generating these placeholders now, we have the necessary database entries (`post_parent` linking the Quiz, Assignment, and Certificate to the Course) required to begin developing the UI logic for the Custom Certificates and Assignment workflows in Phase 4.
