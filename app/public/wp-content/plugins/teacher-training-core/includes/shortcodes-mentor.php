<?php
if ( ! defined( 'ABSPATH' ) ) exit;

// 1. Welcome Widget
add_shortcode('ttp_mentor_welcome', function() {
    $user = wp_get_current_user();
    $name = $user->exists() ? $user->display_name : 'Mentor';
    
    // Query assigned students
    $students = get_users([
        'meta_key' => '_ttp_assigned_mentor',
        'meta_value' => $user->ID
    ]);
    $student_count = count($students);

    ob_start(); ?>
    <div class="ttp-dash-widget" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%); color: white; border: none;">
        <h2 style="color: white; margin-bottom: 8px;">Welcome back, <?php echo esc_html($name); ?>!</h2>
        <p style="color: rgba(255,255,255,0.9); margin-bottom: 24px;">You are currently mentoring <?php echo $student_count; ?> active students.</p>
        <a href="#assignments" class="ttp-btn-primary" style="display: inline-block; background: white; color: #059669; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600;">Grade Assignments</a>
    </div>
    <?php return ob_get_clean();
});

// 2. Assigned Students List
add_shortcode('ttp_mentor_assigned_students', function() {
    $user_id = get_current_user_id();
    $students = get_users([
        'meta_key' => '_ttp_assigned_mentor',
        'meta_value' => $user_id
    ]);
    
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>My Cohort</h3><ul style="list-style: none; padding: 0;">';
    if (!empty($students)) {
        foreach($students as $student) {
            // Mock progress calculation for placeholder
            $progress = rand(20, 95); 
            echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light);">';
            echo '<div style="display: flex; justify-content: space-between; margin-bottom: 8px;">';
            echo '<strong>' . esc_html($student->display_name) . '</strong>';
            echo '<span style="font-size: 0.875rem; color: var(--ttp-primary);">' . $progress . '%</span>';
            echo '</div>';
            echo '<div class="ttp-progress-bar" style="height: 6px;">';
            echo '<div class="ttp-progress-fill" style="width: ' . $progress . '%; background: var(--ttp-primary);"></div>';
            echo '</div></li>';
        }
    } else {
        echo '<li>No students assigned yet.</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 3. Pending Assignments
add_shortcode('ttp_mentor_pending_assignments', function() {
    // In a real app, query ttp_assignment where author is in the $students array
    $args = ['post_type' => 'ttp_assignment', 'posts_per_page' => 3];
    $assignments = new WP_Query($args);
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Pending Submissions</h3><ul style="list-style: none; padding: 0;">';
    if ($assignments->have_posts()) {
        while ($assignments->have_posts()) {
            $assignments->the_post();
            echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light); display: flex; justify-content: space-between;">';
            echo '<span>' . get_the_title() . '</span>';
            echo '<a href="#" style="color: var(--ttp-primary); text-decoration: none; font-size: 0.875rem;">Grade Now</a>';
            echo '</li>';
        }
        wp_reset_postdata();
    } else {
        echo '<li>No assignments pending review.</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 4. Weekly Tasks
add_shortcode('ttp_mentor_weekly_tasks', function() {
    $tasks = [
        "Review Jane's Lesson Plan",
        "Host Weekly 1-on-1 Call",
        "Approve Cohort Startup Milestones"
    ];
    ob_start();
    echo '<div class="ttp-dash-widget"><h3>Weekly Checklist</h3><ul style="list-style: none; padding: 0;">';
    foreach($tasks as $task) {
        echo '<li style="padding: 12px 0; border-bottom: 1px solid var(--ttp-border-light); display: flex; align-items: center; gap: 12px;">';
        echo '<input type="checkbox" style="width: 18px; height: 18px; cursor: pointer;">';
        echo '<span>' . $task . '</span>';
        echo '</li>';
    }
    echo '</ul></div>';
    return ob_get_clean();
});

// 5. Mentor Sessions
add_shortcode('ttp_mentor_sessions', function() {
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>Upcoming 1-on-1s</h3>
        <div style="display: flex; gap: 16px; margin-top: 16px;">
            <div class="ttp-event-date-badge" style="margin-bottom: 0;">
                <span class="day">16</span>
                <span class="month">Nov</span>
            </div>
            <div>
                <h4 style="margin: 0 0 4px 0;">Call with Jane Doe</h4>
                <p style="margin: 0; font-size: 0.875rem; color: var(--ttp-text-body-light);">Via Google Meet</p>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
});

// 6. Mentor Reports
add_shortcode('ttp_mentor_reports', function() {
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>Cohort Performance</h3>
        <div style="display: flex; gap: 16px; margin-top: 16px;">
            <div style="flex: 1; padding: 16px; background: rgba(79, 70, 229, 0.05); border-radius: 8px; text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: var(--ttp-primary);">85%</div>
                <div style="font-size: 0.75rem; color: var(--ttp-text-body-light); text-transform: uppercase;">Avg Progress</div>
            </div>
            <div style="flex: 1; padding: 16px; background: rgba(16, 185, 129, 0.05); border-radius: 8px; text-align: center;">
                <div style="font-size: 1.5rem; font-weight: 700; color: #10B981;">100%</div>
                <div style="font-size: 0.75rem; color: var(--ttp-text-body-light); text-transform: uppercase;">Assignment Pass Rate</div>
            </div>
        </div>
    </div>
    <?php return ob_get_clean();
});

// 7. Student Feedback Placeholder
add_shortcode('ttp_mentor_feedback', function() {
    ob_start(); ?>
    <div class="ttp-dash-widget">
        <h3>Recent Feedback</h3>
        <p style="font-size: 0.875rem; color: var(--ttp-text-body-light); font-style: italic;">"The 1-on-1 session really helped clarify the lesson plan requirements. Thank you!" - Jane Doe</p>
    </div>
    <?php return ob_get_clean();
});
?>
