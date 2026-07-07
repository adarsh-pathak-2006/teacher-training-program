<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Welcome Widget
add_shortcode('ttp_dash_welcome', function() {
    $user = wp_get_current_user();
    $name = $user->exists() ? $user->display_name : 'Student';
    // Count logic (Mocked pending tasks for now)
    $pending_tasks = 2; 

    ob_start(); ?>
    <div class="ttp-dash-widget" style="background: linear-gradient(135deg, var(--ttp-primary) 0%, var(--ttp-accent-cyan) 100%); color: white; border: none;">
        <h2 style="color: white; margin-bottom: 8px;">Welcome back, <?php echo esc_html($name); ?>!</h2>
        <p style="color: rgba(255,255,255,0.9); margin-bottom: 24px;">You have <?php echo $pending_tasks; ?> pending tasks to complete this week.</p>
        <a href="#courses" class="ttp-btn-primary" style="display: inline-block; background: white; color: var(--ttp-primary); padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Resume Learning</a>
    </div>
    <?php return ob_get_clean();
});

// 2. Active Courses (Tutor LMS)
add_shortcode('ttp_dash_active_courses', function() {
    if (!function_exists('tutor_utils')) return '<p>Tutor LMS is required.</p>';
    $user_id = get_current_user_id();
    $enrolled = tutor_utils()->get_enrolled_courses_by_user($user_id);
    
    ob_start();
    echo '<h3>Active Courses</h3><div class="ttp-grid-3" style="gap: 16px;">';
    
    if ($enrolled && $enrolled->have_posts()) {
        while ($enrolled->have_posts()) {
            $enrolled->the_post();
            $course_id = get_the_ID();
            $progress = tutor_utils()->get_course_completed_percent($course_id, $user_id);
            ?>
            <div class="ttp-card" style="padding: 16px;">
                <h4 style="font-size: 1rem; margin-bottom: 8px;"><?php the_title(); ?></h4>
                <div class="ttp-progress-bar">
                    <div class="ttp-progress-fill" style="width: <?php echo esc_attr($progress); ?>%;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; margin-top: 8px; font-size: 0.75rem; color: var(--ttp-text-body-light);">
                    <span><?php echo $progress; ?>% Complete</span>
                    <a href="<?php echo get_permalink(); ?>" style="color: var(--ttp-primary); text-decoration: none;">Continue</a>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>You are not enrolled in any courses yet.</p>';
    }
    echo '</div>';
    return ob_get_clean();
});

// 3. Progress Overview
add_shortcode('ttp_dash_progress', function() {
    // Calculates overall average progress across enrolled courses
    $progress = 0;
    if (function_exists('tutor_utils')) {
        $user_id = get_current_user_id();
        $enrolled = tutor_utils()->get_enrolled_courses_by_user($user_id);
        $total = 0;
        $count = 0;
        if ($enrolled && $enrolled->have_posts()) {
            while ($enrolled->have_posts()) {
                $enrolled->the_post();
                $total += tutor_utils()->get_course_completed_percent(get_the_ID(), $user_id);
                $count++;
            }
            wp_reset_postdata();
            if ($count > 0) $progress = round($total / $count);
        }
    }
    
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
            <h3 style="margin: 0;">Overall Progress</h3>
            <span style="font-size: 1.5rem; font-weight: 700; color: var(--ttp-primary);"><?php echo $progress; ?>%</span>
        </div>
        <div class="ttp-progress-bar" style="height: 12px;">
            <div class="ttp-progress-fill" style="width: <?php echo $progress; ?>%; background: var(--ttp-primary);"></div>
        </div>
    </div>
    <?php return ob_get_clean();
});

// 4. Assignments
add_shortcode('ttp_dash_assignments', function() {
    $args = ['post_type' => 'ttp_assignment', 'posts_per_page' => 3];
    $assignments = new WP_Query($args);
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Pending Assignments</h3><ul style="list-style: none; padding: 0;">';
    if ($assignments->have_posts()) {
        while ($assignments->have_posts()) {
            $assignments->the_post();
            echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light); display: flex; justify-content: space-between;">';
            echo '<span>' . get_the_title() . '</span>';
            echo '<span style="color: #F59E0B; font-size: 0.875rem;">Due Soon</span>';
            echo '</li>';
        }
        wp_reset_postdata();
    } else {
        echo '<li>No assignments pending.</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 5. Certificates
add_shortcode('ttp_dash_certificates', function() {
    $args = ['post_type' => 'ttp_certificate', 'posts_per_page' => 2];
    $certs = new WP_Query($args);
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Earned Certificates</h3><ul style="list-style: none; padding: 0;">';
    if ($certs->have_posts()) {
        while ($certs->have_posts()) {
            $certs->the_post();
            echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light);">';
            echo '<strong>' . get_the_title() . '</strong>';
            echo '</li>';
        }
        wp_reset_postdata();
    } else {
        echo '<li>No certificates earned yet.</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 6. Live Classes
add_shortcode('ttp_dash_live_classes', function() {
    // Queries WP Posts tagged with 'Event' or 'Live Class'
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>Upcoming Live Classes</h3>
        <div style="display: flex; gap: 16px; margin-top: 16px;">
            <div class="ttp-event-date-badge" style="margin-bottom: 0;">
                <span class="day">15</span>
                <span class="month">Nov</span>
            </div>
            <div>
                <h4 style="margin: 0 0 4px 0;">Pedagogy Workshop</h4>
                <p style="margin: 0; font-size: 0.875rem; color: var(--ttp-text-body-light);">Zoom Link inside Course Portal</p>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
});

// 7. Community
add_shortcode('ttp_dash_community', function() {
    $comments = get_comments(['number' => 3, 'status' => 'approve']);
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Recent Community Activity</h3><ul style="list-style: none; padding: 0;">';
    foreach($comments as $comment) {
        echo '<li style="padding: 12px 0; border-bottom: 1px dashed var(--ttp-border-light); font-size: 0.875rem;">';
        echo '<strong>' . $comment->comment_author . ':</strong> ' . wp_trim_words($comment->comment_content, 10);
        echo '</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 8. Messages & Notifications
add_shortcode('ttp_dash_notifications', function() {
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>System Notifications</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="padding: 12px; background: rgba(79, 70, 229, 0.05); border-left: 4px solid var(--ttp-primary); margin-bottom: 8px;">
                Your assignment was graded by your mentor.
            </li>
            <li style="padding: 12px; background: var(--ttp-bg-light); margin-bottom: 8px;">
                Welcome to the TTP Platform!
            </li>
        </ul>
    </div>
    <?php return ob_get_clean();
});

// 9. Recommended Courses
add_shortcode('ttp_dash_recommended', function() {
    $args = ['post_type' => 'courses', 'posts_per_page' => 2, 'orderby' => 'rand'];
    $courses = new WP_Query($args);
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Recommended for You</h3><ul style="list-style: none; padding: 0;">';
    if ($courses->have_posts()) {
        while ($courses->have_posts()) {
            $courses->the_post();
            echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light);">';
            echo '<a href="' . get_permalink() . '" style="color: var(--ttp-text-head-light); text-decoration: none; font-weight: 500;">' . get_the_title() . '</a>';
            echo '</li>';
        }
        wp_reset_postdata();
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 10. Recent Activity
add_shortcode('ttp_dash_activity', function() {
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>Recent Activity</h3>
        <p style="font-size: 0.875rem; color: var(--ttp-text-body-light);">You logged in recently and completed Module 1 of Fundamentals of Education.</p>
    </div>
    <?php return ob_get_clean();
});
?>
