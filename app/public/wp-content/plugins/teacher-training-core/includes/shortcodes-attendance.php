<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * AJAX Endpoint: ttp_log_attendance
 * Automatically logs a user as attended when they click a Join Link.
 */
add_action('wp_ajax_ttp_log_attendance', 'ttp_ajax_log_attendance');
function ttp_ajax_log_attendance() {
    if (!isset($_POST['class_id']) || !isset($_POST['nonce']) || !is_user_logged_in()) {
        wp_send_json_error('Invalid request');
    }

    if (!wp_verify_nonce($_POST['nonce'], 'ttp_attendance_nonce')) {
        wp_send_json_error('Security check failed');
    }

    $class_id = intval($_POST['class_id']);
    $user_id = get_current_user_id();

    // Get current attendance list
    $attendance = get_field('lc_attendance', $class_id);
    if (!is_array($attendance)) {
        $attendance = [];
    }

    // Convert ACF user objects to IDs if needed, but ACF usually returns an array of arrays or IDs depending on format.
    // Assuming return_format is 'array', we extract IDs.
    $attendance_ids = array_map(function($user) {
        return is_array($user) ? $user['ID'] : (is_object($user) ? $user->ID : $user);
    }, $attendance);

    if (!in_array($user_id, $attendance_ids)) {
        $attendance_ids[] = $user_id;
        update_field('lc_attendance', $attendance_ids, $class_id);
    }

    wp_send_json_success('Attendance logged');
}

/**
 * Core Function: Calculate Attendance Metrics
 * Returns [ 'total' => X, 'attended' => Y, 'percentage' => Z, 'missed_classes' => [...] ]
 */
function ttp_calculate_attendance($user_id, $course_id = null) {
    // Determine enrolled courses to check
    $enrolled_courses = [];
    if ($course_id) {
        $enrolled_courses[] = $course_id;
    } else {
        if (function_exists('tutor_utils')) {
            $enrolled = tutor_utils()->get_enrolled_courses_by_user($user_id);
            if ($enrolled) {
                foreach ($enrolled as $course) {
                    $enrolled_courses[] = $course->ID;
                }
            }
        }
    }

    $current_time = current_time('timestamp');
    
    // Get ALL past classes
    $args = [
        'post_type' => 'ttp_live_class',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ];
    $classes = get_posts($args);

    $total_past = 0;
    $attended_count = 0;
    $missed_classes = [];

    foreach ($classes as $class) {
        $linked_course = get_field('lc_linked_course', $class->ID);
        // Only count classes linked to enrolled courses
        if (!empty($enrolled_courses) && $linked_course && !in_array($linked_course->ID, $enrolled_courses)) {
            continue; 
        }

        $datetime_str = get_field('lc_datetime', $class->ID);
        $timestamp = strtotime($datetime_str);

        // Only count PAST classes (using a 1 hour buffer so active classes count if joined)
        if ($timestamp <= ($current_time - 3600)) {
            $total_past++;
            
            $attendance = get_field('lc_attendance', $class->ID);
            if (!is_array($attendance)) $attendance = [];
            
            $attendance_ids = array_map(function($u) {
                return is_array($u) ? $u['ID'] : (is_object($u) ? $u->ID : $u);
            }, $attendance);

            if (in_array($user_id, $attendance_ids)) {
                $attended_count++;
            } else {
                $missed_classes[] = [
                    'id' => $class->ID,
                    'title' => $class->post_title,
                    'date_formatted' => date('F j, Y', $timestamp),
                    'recording_link' => get_field('lc_recording_link', $class->ID)
                ];
            }
        }
    }

    $percentage = $total_past > 0 ? round(($attended_count / $total_past) * 100) : 100; // Default to 100% if no classes yet

    return [
        'total' => $total_past,
        'attended' => $attended_count,
        'percentage' => $percentage,
        'missed_classes' => $missed_classes
    ];
}

/**
 * Shortcode: [ttp_dash_attendance]
 * Renders the attendance progress and missed classes list.
 */
add_shortcode('ttp_dash_attendance', function() {
    if (!is_user_logged_in()) return '';

    $user_id = get_current_user_id();
    $metrics = ttp_calculate_attendance($user_id);
    
    $color = $metrics['percentage'] >= 80 ? '#10b981' : ($metrics['percentage'] >= 50 ? '#f59e0b' : '#ef4444');

    ob_start();
    ?>
    <div class="ttp-card ttp-attendance-widget" style="padding: 24px; background: white; border-radius: 8px; border: 1px solid var(--ttp-border-light);">
        <h3 style="margin-top: 0; color: var(--ttp-text-head-light); border-bottom: 2px solid var(--ttp-primary); display: inline-block; padding-bottom: 8px;">Attendance History</h3>
        
        <div style="display: flex; align-items: center; gap: 24px; margin-top: 24px; margin-bottom: 32px;">
            <div style="width: 100px; height: 100px; border-radius: 50%; border: 8px solid <?php echo $color; ?>; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; color: <?php echo $color; ?>;">
                <?php echo $metrics['percentage']; ?>%
            </div>
            <div>
                <p style="margin: 0 0 8px 0; font-size: 1.1rem; color: var(--ttp-text-head-light); font-weight: 600;">
                    <?php echo $metrics['attended']; ?> of <?php echo $metrics['total']; ?> Classes Attended
                </p>
                <p style="margin: 0; color: var(--ttp-text-body-light); font-size: 0.9rem;">
                    You must maintain 80% attendance to receive your certificate.
                </p>
            </div>
        </div>

        <?php if (!empty($metrics['missed_classes'])) : ?>
            <h4 style="margin: 0 0 16px 0; color: #ef4444;">Missed Sessions</h4>
            <div style="background: #fef2f2; border: 1px solid #fecaca; border-radius: 8px; overflow: hidden;">
                <?php foreach ($metrics['missed_classes'] as $missed) : ?>
                    <div style="padding: 12px 16px; border-bottom: 1px solid #fecaca; display: flex; justify-content: space-between; align-items: center; background: white;">
                        <div>
                            <div style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; margin-bottom: 2px;"><?php echo esc_html($missed['date_formatted']); ?></div>
                            <div style="color: var(--ttp-text-head-light); font-weight: 500;"><?php echo esc_html($missed['title']); ?></div>
                        </div>
                        <div>
                            <?php if ($missed['recording_link']) : ?>
                                <a href="<?php echo esc_url($missed['recording_link']); ?>" target="_blank" style="color: var(--ttp-primary); text-decoration: none; font-weight: 600; font-size: 0.875rem;">▶ Recording</a>
                            <?php else : ?>
                                <span style="color: #cbd5e1; font-size: 0.8rem; font-style: italic;">No Recording</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
});
?>
