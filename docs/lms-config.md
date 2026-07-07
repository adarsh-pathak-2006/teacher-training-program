# Tutor LMS Configuration & Data Structure

This document outlines the initial configuration and placeholder data generation for Tutor LMS Free. This setup validates the core LMS architecture without relying on manual entry, ensuring the database is prepped for testing templates and dynamic frontend components.

## 1. Global Settings
*   **Course Marketplace**: Disabled. The platform operates on a single-institution model where approved Trainers create content, rather than a public Udemy-style marketplace.
*   **Enrollment**: Native Tutor LMS free enrollment is active. Courses are marked as public/free by default for this testing phase.

## 2. LMS Data Hierarchy (Placeholder Structure)
We generated a strict hierarchy using WordPress custom post types managed by Tutor LMS. This structure is essential for testing the Learning Path UI:

*   **Course Categories** (Taxonomy: `course-category`)
    *   *Placeholders Created*: Technology, Pedagogy, Leadership
*   **Course** (CPT: `courses`)
    *   *Title*: "Placeholder Course: Fundamentals of Education"
    *   *Meta (Difficulty)*: Beginner (`_tutor_course_level`)
    *   *Meta (Duration)*: 2 Hours 30 Minutes (`_tutor_course_duration`)
    *   *Meta (Learning Outcomes)*: 3 sample outcomes (`_tutor_course_benefits`)
    *   *Meta (Target Audience)*: New Teachers, Educators (`_tutor_course_target_audience`)
    *   *Status*: Featured (`_is_tutor_featured = yes`)
*   **Modules / Topics** (CPT: `topics`)
    *   *Structure*: Modules act as containers for lessons. They are linked to the Course ID via the WordPress `post_parent` relationship.
    *   *Placeholders Created*: "Module 1", "Module 2"
*   **Lessons** (CPT: `lesson`)
    *   *Structure*: Lessons are the actual content nodes. They are linked to the Topic ID via the `post_parent` relationship.
    *   *Placeholders Created*: 2 placeholder lessons per module (e.g., Lesson 1.1, Lesson 1.2), each with a placeholder duration of 15 minutes.

## 3. Next Steps for Production
When migrating from this placeholder setup to production content:
1.  **Media Assets**: You must manually attach a Featured Image to the Course post for the UI thumbnails to populate, as media uploads cannot be fully simulated via text-only scripts.
2.  **Completion Rules**: While this placeholder is set up, strict Completion Rules (e.g., requiring 80% on a quiz to pass a module) require manual configuration per course within the Tutor LMS Course Builder UI.
