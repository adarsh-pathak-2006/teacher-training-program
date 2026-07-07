<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode to render Live Classes widget on Dashboard
 * Usage: [ttp_dash_classes]
 */
add_shortcode('ttp_dash_classes', function() {
    if (!is_user_logged_in()) return '<p>Please log in to view your live classes.</p>';

    $user_id = get_current_user_id();
    
    // In a real scenario, we would query Tutor LMS to get the array of course IDs the user is enrolled in.
    // For this mockup, we'll query ALL live classes to demonstrate the UI sorting, 
    // or simulate enrollment.
    $enrolled_courses = [];
    if (function_exists('tutor_utils')) {
        $enrolled = tutor_utils()->get_enrolled_courses_by_user($user_id);
        if ($enrolled) {
            foreach ($enrolled as $course) {
                $enrolled_courses[] = $course->ID;
            }
        }
    }

    // Get all live classes (for demo purposes we don't strictly filter by course array if empty)
    $args = [
        'post_type' => 'ttp_live_class',
        'posts_per_page' => -1,
        'post_status' => 'publish'
    ];
    $classes = get_posts($args);

    $upcoming = [];
    $past = [];
    $current_time = current_time('timestamp');

    foreach ($classes as $class) {
        $linked_course = get_field('lc_linked_course', $class->ID);
        // Only show if user is enrolled in linked course, or if no courses enrolled (demo mode)
        if (!empty($enrolled_courses) && $linked_course && !in_array($linked_course->ID, $enrolled_courses)) {
            continue; 
        }

        $datetime_str = get_field('lc_datetime', $class->ID); // Format: Y-m-d H:i:s
        $timestamp = strtotime($datetime_str);
        
        $class_data = [
            'id' => $class->ID,
            'title' => $class->post_title,
            'type' => get_field('lc_class_type', $class->ID),
            'timestamp' => $timestamp,
            'date_formatted' => date('F j, Y', $timestamp),
            'time_formatted' => date('g:i a', $timestamp),
            'meeting_link' => get_field('lc_meeting_link', $class->ID),
            'offline_location' => get_field('lc_offline_location', $class->ID),
            'recording_link' => get_field('lc_recording_link', $class->ID)
        ];

        // If the class timestamp is in the future (or within the last hour)
        if ($timestamp > ($current_time - 3600)) {
            $upcoming[] = $class_data;
        } else {
            $past[] = $class_data;
        }
    }

    // Sort upcoming (soonest first)
    usort($upcoming, function($a, $b) { return $a['timestamp'] - $b['timestamp']; });
    // Sort past (most recent first)
    usort($past, function($a, $b) { return $b['timestamp'] - $a['timestamp']; });

    ob_start();
    ?>
    <div class="ttp-card ttp-live-classes-widget" style="background: white; border-radius: 8px; border: 1px solid var(--ttp-border-light); overflow: hidden;">
        
        <!-- Tabs -->
        <div style="display: flex; border-bottom: 1px solid var(--ttp-border-light); background: var(--ttp-bg-light);">
            <button class="ttp-tab-btn active" onclick="switchTab('upcoming')" id="tab-upcoming" style="flex: 1; padding: 16px; border: none; background: white; border-bottom: 2px solid var(--ttp-primary); font-weight: 600; cursor: pointer; color: var(--ttp-text-head-light);">Upcoming Sessions</button>
            <button class="ttp-tab-btn" onclick="switchTab('past')" id="tab-past" style="flex: 1; padding: 16px; border: none; background: transparent; font-weight: 600; cursor: pointer; color: var(--ttp-text-body-light);">Past Recordings</button>
        </div>

        <!-- Upcoming Tab -->
        <div id="content-upcoming" style="padding: 24px;">
            <?php if (empty($upcoming)) : ?>
                <p style="color: var(--ttp-text-body-light); text-align: center; padding: 32px 0;">No upcoming sessions scheduled.</p>
            <?php else : ?>
                <?php foreach ($upcoming as $session) : ?>
                    <div style="padding: 16px; border: 1px solid var(--ttp-border-light); border-radius: 8px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center; background: #f8fafc;">
                        <div>
                            <div style="font-weight: 700; color: var(--ttp-primary); font-size: 0.875rem; text-transform: uppercase; margin-bottom: 4px;">
                                <?php echo esc_html($session['date_formatted']); ?> &bull; <?php echo esc_html($session['time_formatted']); ?>
                            </div>
                            <h4 style="margin: 0 0 8px 0; color: var(--ttp-text-head-light);"><?php echo esc_html($session['title']); ?></h4>
                            <div style="font-size: 0.875rem; color: var(--ttp-text-body-light);">
                                <?php if ($session['type'] == 'offline') : ?>
                                    📍 <?php echo esc_html($session['offline_location']); ?>
                                <?php else : ?>
                                    📹 <?php echo ucfirst($session['type']); ?> Meeting
                                <?php endif; ?>
                            </div>
                        </div>
                        <div>
                            <?php if ($session['type'] == 'offline') : ?>
                                <span style="background: #e2e8f0; color: #475569; padding: 8px 16px; border-radius: 4px; font-weight: 600; font-size: 0.875rem;">In-Person</span>
                            <?php else : ?>
                                <a href="<?php echo esc_url($session['meeting_link']); ?>" target="_blank" class="ttp-btn-primary ttp-join-link" data-class-id="<?php echo esc_attr($session['id']); ?>" style="background: var(--ttp-primary); color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: 600; font-size: 0.875rem;">Join Link</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Past Tab -->
        <div id="content-past" style="padding: 24px; display: none;">
            <?php if (empty($past)) : ?>
                <p style="color: var(--ttp-text-body-light); text-align: center; padding: 32px 0;">No past recordings available.</p>
            <?php else : ?>
                <?php foreach ($past as $session) : ?>
                    <div style="padding: 16px; border: 1px solid var(--ttp-border-light); border-radius: 8px; margin-bottom: 16px; display: flex; justify-content: space-between; align-items: center;">
                        <div>
                            <div style="font-weight: 600; color: var(--ttp-text-body-light); font-size: 0.875rem; margin-bottom: 4px;">
                                <?php echo esc_html($session['date_formatted']); ?>
                            </div>
                            <h4 style="margin: 0 0 4px 0; color: var(--ttp-text-head-light);"><?php echo esc_html($session['title']); ?></h4>
                        </div>
                        <div>
                            <?php if ($session['recording_link']) : ?>
                                <a href="<?php echo esc_url($session['recording_link']); ?>" target="_blank" style="color: var(--ttp-primary); text-decoration: none; font-weight: 600; border: 1px solid var(--ttp-primary); padding: 6px 12px; border-radius: 4px; font-size: 0.875rem;">▶ Watch</a>
                            <?php else : ?>
                                <span style="color: #94a3b8; font-size: 0.875rem; font-style: italic;">Processing...</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

    </div>

    <script>
        function switchTab(tab) {
            document.getElementById('content-upcoming').style.display = (tab === 'upcoming') ? 'block' : 'none';
            document.getElementById('content-past').style.display = (tab === 'past') ? 'block' : 'none';
            
            document.getElementById('tab-upcoming').style.background = (tab === 'upcoming') ? 'white' : 'transparent';
            document.getElementById('tab-upcoming').style.borderBottom = (tab === 'upcoming') ? '2px solid var(--ttp-primary)' : 'none';
            document.getElementById('tab-upcoming').style.color = (tab === 'upcoming') ? 'var(--ttp-text-head-light)' : 'var(--ttp-text-body-light)';
            
            document.getElementById('tab-past').style.background = (tab === 'past') ? 'white' : 'transparent';
            document.getElementById('tab-past').style.borderBottom = (tab === 'past') ? '2px solid var(--ttp-primary)' : 'none';
            document.getElementById('tab-past').style.color = (tab === 'past') ? 'var(--ttp-text-head-light)' : 'var(--ttp-text-body-light)';
        }

        // AJAX Attendance Tracking
        document.addEventListener('DOMContentLoaded', function() {
            const joinLinks = document.querySelectorAll('.ttp-join-link');
            joinLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const classId = this.getAttribute('data-class-id');
                    
                    // Fire and forget AJAX request
                    fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: 'action=ttp_log_attendance&class_id=' + classId + '&nonce=<?php echo wp_create_nonce("ttp_attendance_nonce"); ?>'
                    });
                });
            });
        });
    </script>
    <?php
    return ob_get_clean();
});
?>
