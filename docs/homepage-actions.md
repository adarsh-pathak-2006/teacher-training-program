# Homepage Actions & Routing Document

This document verifies the mapping of every Call-To-Action (CTA) button on the Homepage, ensuring that the landing page contains zero dead-ends and acts as a high-converting funnel.

## 1. Hero Section (Block 40)
*   **Enroll Now**
    *   *Action*: Navigate to Page
    *   *Route*: `/programs/`
    *   *Purpose*: Drives users directly to the course catalog.
*   **Watch Demo**
    *   *Action*: Open Modal
    *   *Route*: `#ttp-video-modal` (Triggers native HTML5 `<dialog>`)
    *   *Purpose*: Keeps the user on the homepage while displaying a high-conversion video asset via an embedded YouTube player.

## 2. Mentors & Startups Section (Block 42)
*   **Meet the Mentors**
    *   *Action*: Navigate to Page
    *   *Route*: `/mentors/`
    *   *Purpose*: Directs users to the Mentor Archive to view profiles.
*   **View Partner Startups**
    *   *Action*: Navigate to Page
    *   *Route*: `/startup-partners/`
    *   *Purpose*: Directs users to the Startup Archive to view company profiles.

## 3. Community & Insights Section (Block 212)
*   **Join Community**
    *   *Action*: Navigate to Application
    *   *Route*: `/community/`
    *   *Purpose*: Drives users to the bbPress forum index.
*   **Read Blog**
    *   *Action*: Navigate to Page
    *   *Route*: `/blog/`
    *   *Purpose*: Drives users to the latest educational insights.

## 4. Conversion Footer (Block 213)
*   **Apply Now**
    *   *Action*: Navigate to Application
    *   *Route*: `/student-registration/`
    *   *Purpose*: Ultimate Member registration flow for the Startup Experience cohort.
*   **Subscribe (Newsletter Form)**
    *   *Action*: Submit Form
    *   *Route*: Fluent Forms (Form ID 2)
    *   *Purpose*: Captures email leads via AJAX without forcing a page reload.

## 5. Contact Section (Block 43)
*   **Submit Application (Contact Form)**
    *   *Action*: Submit Form
    *   *Route*: Fluent Forms (Form ID 1)
    *   *Purpose*: General inquiry capture.
