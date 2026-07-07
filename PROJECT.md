# Project Architecture: Teacher Training Program

This document serves as the permanent source of truth for the Teacher Training Program LMS project. It strictly adheres to the constraints of using free plugins, avoiding premium page builders and premium LMS solutions, and maintaining a high standard of performance, scalability, and maintainability.

## 1. Complete Project Architecture
The platform is built on WordPress Core, utilizing a highly optimized, low-bloat architecture:
*   **Theme Layer**: A lightweight, performance-focused theme (Kadence or GeneratePress) replacing heavy visual themes.
*   **Page Builder**: Native WordPress Gutenberg Block Editor augmented with Kadence Blocks. This replaces Elementor Pro, drastically reducing DOM size and improving Core Web Vitals.
*   **LMS Engine**: Tutor LMS (Free Tier) or LearnPress (Free Tier). This will handle core course structuring, lessons, and basic quizzes.
*   **E-Commerce**: WooCommerce (Free) paired with Razorpay (Free) for transactional processing.
*   **User & Community Layer**: Ultimate Member (Free) for user roles and registration workflows. bbPress (Free) for the community forums instead of BuddyBoss Premium.
*   **Custom Application Logic**: A streamlined custom PHP plugin to handle complex business logic (e.g., the Startup Practical Experience module) that free plugins cannot achieve out-of-the-box.

## 2. Recommended Free Plugin Stack
*   **Theme**: Kadence Theme (Free)
*   **Page Builder**: Kadence Blocks (Free)
*   **LMS**: Tutor LMS (Free) or LearnPress (Free)
*   **Forms**: Fluent Forms (Free) or Forminator (Free)
*   **User Profiles/Roles**: Ultimate Member (Free)
*   **Community Forums**: bbPress (Free)
*   **E-Commerce**: WooCommerce (Free)
*   **Payment Gateway**: WooCommerce Razorpay Integration (Free)
*   **Custom Fields**: Advanced Custom Fields (ACF - Free)
*   **SEO**: Rank Math SEO (Free)
*   **Security**: Wordfence Security (Free) + WPS Hide Login
*   **Performance/Caching**: LiteSpeed Cache (Free) or W3 Total Cache (Free)
*   **Backups**: UpdraftPlus (Free)

## 3. Features That Cannot Be Achieved Using Free Plugins Alone
Because we are strictly avoiding premium versions (like Tutor LMS Pro), the following features from the PRD are unsupported natively by the free stack:
1.  **Startup Practical Experience Module**: Assigning students to specific startups, weekly task tracking, and mentor evaluations is a highly custom workflow.
2.  **Advanced Assignments System**: Free LMS tiers typically lack robust assignment upload, grading, and feedback loops.
3.  **Automated Custom Certificates**: Generating dynamic, verifiable PDF certificates with QR codes upon completion criteria is gated behind Pro versions.
4.  **Native Zoom/Live Class Integrations**: Typically requires premium LMS add-ons to integrate deeply into the student dashboard.

## 4. Features Requiring Custom Development
To fulfill the PRD requirements without paid plugins, minimal custom PHP development is required for:
*   **Startup Practical Experience Module**: 
    *   Creation of Custom Post Types (CPTs) for `Startups` and `Projects`.
    *   Custom relational database tables or advanced user meta to link Students, Mentors, and Startups.
    *   Custom frontend dashboards for Mentors to review student submissions and grade them.
*   **Assignment Submission System**:
    *   Utilizing Fluent Forms (Free) combined with CPTs to allow students to upload files.
    *   Custom views in the Trainer dashboard to approve/reject submissions.
*   **Certificate Generator**:
    *   Implementation of a custom PHP library (e.g., FPDF or TCPDF).
    *   Hooking into the LMS course completion action to generate and email/display the PDF certificate automatically.
*   **Live Class Embeds**:
    *   Custom ACF fields on `Lesson` or `Course` CPTs to display Zoom/Google Meet links and dynamic "Join" buttons based on time constraints.

## 5. Alternative Implementation Strategies
*   **LMS Alternative**: Instead of fighting the limitations of a free LMS plugin, we could build a fully custom "LMS lite" using CPTs (`Courses`, `Lessons`), Restrict Content Pro (Free), and custom queries. This ensures 100% control over the flow, assignments, and certificates without bloat.
*   **Community Alternative**: Instead of hosting a resource-heavy forum (bbPress) on the same server, integrate a free external community platform like Discord. Use SSO or invite links upon course enrollment to keep the WP database light and fast.
*   **Video Hosting**: Avoid hosting videos on the server. Use unlisted YouTube links or Cloudflare Stream integrated via native WordPress video blocks to minimize bandwidth costs.

## 6. WordPress Structure
*   **Custom Post Types (CPTs)**:
    *   `Courses`, `Lessons`, `Quizzes` (Handled by LMS plugin)
    *   `Assignments` (Custom CPT)
    *   `Startups` (Custom CPT)
    *   `Mentors` (Custom CPT)
*   **Taxonomies**:
    *   `Course Categories`
    *   `Startup Industries`
    *   `Expertise Areas` (For Mentors)
*   **Custom Fields (ACF)**:
    *   Startups: Logo, overview, employee count, available roles.
    *   Mentors: Experience, expertise, social links, associated startups.
    *   Live Classes: Zoom URL, Date, Time.

## 7. User Roles
Leveraging Ultimate Member and custom WordPress roles:
1.  **Super Admin**: Complete administrative access.
2.  **Course Manager**: Manages courses, lessons, and curriculum content.
3.  **Trainer**: Teaches courses, evaluates and grades assignments.
4.  **Startup Mentor**: Views assigned students, reviews weekly practical tasks, provides feedback scores.
5.  **Student**: Enrolls in courses, consumes video/live content, submits assignments, interacts in the community.

## 8. Navigation Hierarchy
*   **Primary Navigation (Logged Out)**: Home | About | Programs | Mentors | Startup Partners | Blog | Contact | Login / Register
*   **User Navigation (Logged In)**: Dashboard | My Courses | Live Classes | Startup Projects | Community | Profile | Logout
*   **Footer Navigation**: Terms & Conditions | Privacy Policy | FAQs | Social Links | Contact Info

## 9. Page Hierarchy
*   `/` (Home)
*   `/about`
*   `/programs/` (Archive)
    *   `/programs/{program-name}` (Single)
*   `/mentors/` (Archive)
    *   `/mentors/{mentor-name}` (Single)
*   `/startup-partners/` (Archive)
    *   `/startup-partners/{startup-name}` (Single)
*   `/blog/`
*   `/contact/`
*   `/dashboard/` (Parent Dashboard)
    *   `/dashboard/my-courses/`
    *   `/dashboard/live-classes/`
    *   `/dashboard/assignments/`
    *   `/dashboard/certificates/`
    *   `/dashboard/startup-projects/`
*   `/community/`

## 10. Database Considerations
*   **Object Caching**: Dynamic content (dashboards, LMS progress) bypasses page caches. A robust Object Cache (Redis or Memcached) is mandatory to reduce database queries for logged-in users.
*   **Database Bloat Prevention**: Disable or limit post revisions, auto-drafts, and transients to keep the `wp_posts` and `wp_options` tables lean.
*   **Index Optimization**: As the user base grows (Target: 10,000+), custom database indexes on user meta and LMS progress tables will be required to maintain fast dashboard load times.

## 11. Security Considerations
*   **Authentication**: Implement Two-Factor Authentication (2FA) for Admin, Manager, and Mentor roles via Wordfence.
*   **Endpoint Protection**: Secure the REST API to prevent unauthorized scraping of user or mentor data.
*   **File Uploads**: Strictly validate and sanitize assignment uploads (limit to PDF/DOCX, enforce max file sizes) to prevent malicious script execution.
*   **Hardening**: Hide the default `wp-login.php` portal, disable XML-RPC, and enforce strict file permissions (755 directories, 644 files).

## 12. Performance Considerations
*   **Gutenberg Over Elementor**: By using the native block editor, we eliminate hundreds of kilobytes of CSS/JS libraries associated with page builders.
*   **Asset Optimization**: Minify CSS/JS and defer non-critical scripts. Use LiteSpeed Cache for advanced optimization.
*   **Image Optimization**: Serve all media in WebP format and enforce lazy loading.
*   **Server Architecture**: For 10,000+ users, shared hosting is inadequate. A Managed VPS or Cloud infrastructure (e.g., AWS, DigitalOcean) with dedicated resources for PHP workers is necessary.

## 13. SEO Strategy
*   **Technical SEO**: Implement Rank Math for semantic metadata.
*   **Structured Data**: Use JSON-LD Schema markup for `Course`, `Organization`, `Person` (Mentors), and `BreadcrumbList`.
*   **URL Structure**: Maintain clean, hierarchy-based permalinks (e.g., `/programs/%postname%/`).
*   **Core Web Vitals**: Ensure the site passes LCP, FID, and CLS metrics, which is highly achievable with the Kadence + Gutenberg stack.

## 14. Risks and Mitigation
*   **Risk**: Developing custom LMS features (Assignments, Certificates) introduces technical debt and maintenance overhead.
    *   **Mitigation**: Keep custom PHP strictly modular (via a custom utility plugin). Document code thoroughly. Rely on standard WordPress hooks rather than core modifications.
*   **Risk**: High server load during simultaneous live classes or quiz deadlines.
    *   **Mitigation**: Offload video processing (Zoom, YouTube). Ensure robust Redis caching. Scale PHP workers on the server during peak times.
*   **Risk**: Community forum (bbPress) slows down the entire application.
    *   **Mitigation**: Monitor database query times. If performance degrades, decouple the community to a subdomain or a third-party service like Discord.

## 15. Development Roadmap (Estimated: 8-10 Weeks)
*   **Phase 1: Architecture & Setup (Week 1-2)**
    *   Server provisioning, WordPress installation, Kadence theme setup, security hardening.
*   **Phase 2: Data Modeling (Week 3)**
    *   Configuration of CPTs, Taxonomies, ACF, and User Roles.
*   **Phase 3: Core LMS & E-Commerce Integration (Week 4-5)**
    *   Setup Free LMS engine, configure WooCommerce & Razorpay.
*   **Phase 4: Custom Modules Development (Week 6-7)**
    *   Develop Startup Practical Experience module, Custom Certificates, and Assignment workflows.
    *   [x] Implement complete authentication system via Ultimate Member.
*   **Phase 5: UI/UX & Frontend Integration (Week 8)**
    *   [x] Build Homepage using reusable Gutenberg blocks.
    *   [x] Build About Us page using reusable Gutenberg blocks.
    *   [x] Build Programs archive page using reusable Gutenberg blocks.
    *   [x] Build Program Detail template using reusable Gutenberg blocks.
    *   [x] Build Mentors archive page using reusable Gutenberg blocks.
    *   [x] Build Mentor Profile template using reusable Gutenberg blocks.
    *   [x] Build Startups archive page using reusable Gutenberg blocks.
    *   [x] Build Startup Detail template using reusable Gutenberg blocks.
    *   [x] Build Blog page using reusable Gutenberg blocks.
    *   [x] Build Single Blog template using reusable Gutenberg blocks.
    *   [x] Build Contact page using reusable Gutenberg blocks.
    *   [x] Build FAQ page using reusable Gutenberg blocks.
    *   [x] Build Testimonials page using reusable Gutenberg blocks.
    *   [x] Build Events page using reusable Gutenberg blocks.
    *   [x] Build Student Dashboard interface using reusable Gutenberg blocks.
    *   [x] Build Global Header using reusable Gutenberg blocks.
    *   [x] Build Global Footer using reusable Gutenberg blocks.
    *   [x] Build Custom 404 Page using reusable Gutenberg blocks.
    *   [ ] Build remaining dashboard templates.
*   **Phase 6: QA, Testing, & Optimization (Week 9)**
    *   [x] Conduct global UI audit and apply automated CSS refactoring.
    *   [x] Configure WordPress Core settings for production LMS environment.
    *   User acceptance testing, load testing, security audits, caching configuration.
*   **Phase 7: Deployment (Week 10)**
    *   Go-live and post-launch monitoring.
