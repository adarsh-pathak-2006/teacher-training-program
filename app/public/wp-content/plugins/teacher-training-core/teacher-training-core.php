<?php
/**
 * Plugin Name: Teacher Training Core
 * Description: Handles core business logic for Mentor-Student relationships, reporting, and custom dashboards.
 * Version: 1.0.0
 * Author: Architecture Team
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Load Mentor Dashboard Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-mentor.php';

/**
 * Load Assignment Submission Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-assignments.php';

/**
 * Load Certificate Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-certificates.php';

/**
 * Load BuddyPress Integration
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/buddypress-integration.php';

/**
 * Load Live Classes Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-live-classes.php';

/**
 * Load Attendance Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-attendance.php';

/**
 * Load Notifications Shortcodes
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-notifications.php';

/**
 * Load Admin Reports Dashboard
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/admin-reports.php';

/**
 * Load Analytics Engine
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/analytics.php';

/**
 * Load Global Search Engine
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/global-search.php';

/**
 * Load Global SEO & Schema
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/seo-schema.php';

/**
 * Load Asset Dequeue Engine (Performance)
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/performance.php';

/**
 * Enqueue Global Design System CSS
 */
add_action( 'wp_enqueue_scripts', function() {
    wp_enqueue_style( 'ttp-design-system', plugin_dir_url( __FILE__ ) . 'assets/css/design-system.css', array(), '1.0.0' );
}, 100 ); // Load late to override plugin styles

/**
 * Enforce File Upload Restrictions (Security)
 * Restricts uploads to safe document and image formats.
 */
add_filter('upload_mimes', function($mimes) {
    // Only allow specific safe types
    $safe_mimes = [
        'pdf'  => 'application/pdf',
        'doc'  => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'jpg|jpeg|jpe' => 'image/jpeg',
        'png'  => 'image/png',
        'webp' => 'image/webp',
        'zip'  => 'application/zip' // Allowed for course materials/assignments
    ];
    return $safe_mimes;
});

/**
 * Dynamic Program Grid Shortcode
 * Generates the TTP HTML structure but loops through real Tutor LMS courses
 * Handles dynamic CTA button logic (Guest, Student, Enrolled, Completed)
 */
add_shortcode('ttp_program_grid', function($atts) {
    ob_start();
    
    $args = [
        'post_type' => 'courses', // Tutor LMS course post type
        'post_status' => 'publish',
        'posts_per_page' => -1
    ];
    $query = new WP_Query($args);
    
    echo '<div class="ttp-grid-3">';
    
    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $course_id = get_the_ID();
            $thumb_url = get_the_post_thumbnail_url($course_id, 'medium_large') ?: 'https://via.placeholder.com/400x200';
            
            // Get Tutor LMS Course Metadata
            $duration_meta = get_post_meta($course_id, '_tutor_course_duration', true);
            $duration = is_array($duration_meta) ? ($duration_meta['hours'] ?? 0) . 'h ' . ($duration_meta['minutes'] ?? 0) . 'm' : ($duration_meta ?: 'Self-Paced');
            $level = get_post_meta($course_id, '_tutor_course_level', true) ?: 'Beginner';
            $is_free = get_post_meta($course_id, '_tutor_is_free_course', true) === 'yes';
            
            // Determine Dynamic CTA Action
            $btn_text = 'View Details';
            $btn_url = get_permalink();
            $btn_class = 'ttp-btn-primary';
            
            if (is_user_logged_in()) {
                $user_id = get_current_user_id();
                if (function_exists('tutor_utils')) {
                    $is_enrolled = tutor_utils()->is_enrolled($course_id, $user_id);
                    $is_completed = tutor_utils()->is_completed_course($course_id, $user_id);
                    
                    if ($is_completed) {
                        $btn_text = 'Download Certificate';
                        $btn_url = home_url('/student-dashboard/certificates/');
                        $btn_class = 'ttp-btn-secondary';
                    } elseif ($is_enrolled) {
                        $btn_text = 'Continue Learning';
                        $btn_url = tutor_utils()->get_course_first_lesson($course_id) ?: get_permalink();
                    } else {
                        $btn_text = $is_free ? 'Enroll Now' : 'Buy Course';
                        $btn_url = get_permalink(); // Let Tutor LMS handle the add to cart on the single page
                    }
                }
            } else {
                $btn_text = 'Login to Enroll';
                $btn_url = home_url('/login/');
                $btn_class = 'ttp-btn-secondary';
            }
            
            // Output HTML Card
            ?>
            <div class="ttp-card ttp-program-card">
                <img src="<?php echo esc_url($thumb_url); ?>" class="ttp-program-thumb" alt="Program Thumbnail">
                <h3 class="ttp-heading"><?php echo esc_html(get_the_title()); ?></h3>
                <p style="margin-bottom: 24px; font-size: 14px; color: var(--ttp-text-light);"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                
                <div class="ttp-program-meta" style="display:flex; gap:12px; font-size:13px; font-weight:600; color:var(--ttp-primary); margin-bottom:16px;">
                    <span>⏳ <?php echo esc_html($duration); ?></span>
                    <span>🎓 <?php echo esc_html($level); ?></span>
                </div>
                
                <div class="wp-block-buttons">
                    <div class="wp-block-button <?php echo esc_attr($btn_class); ?>" style="width:100%;">
                        <a class="wp-block-button__link" style="width:100%; text-align:center;" href="<?php echo esc_url($btn_url); ?>"><?php echo esc_html($btn_text); ?></a>
                    </div>
                </div>
            </div>
            <?php
        }
        wp_reset_postdata();
    } else {
        echo '<p>No programs available at this time.</p>';
    }
    
    echo '</div>';
    
    return ob_get_clean();
});

/**
 * Register Startup Practical Experience CPTs
 */
function ttp_core_register_cpts() {
    // Startup CPT (If not registered by UI design system)
    if ( ! post_type_exists( 'startup' ) ) {
        register_post_type( 'startup', [
            'labels'      => [ 'name' => 'Startups', 'singular_name' => 'Startup' ],
            'public'      => true,
            'has_archive' => true,
            'supports'    => [ 'title', 'editor', 'thumbnail' ],
            'menu_icon'   => 'dashicons-lightbulb',
        ] );
    }

    // Startup Tasks CPT
    register_post_type( 'startup_task', [
        'labels'      => [ 'name' => 'Startup Tasks', 'singular_name' => 'Startup Task' ],
        'public'      => true,
        'has_archive' => false,
        'supports'    => [ 'title', 'editor', 'author' ],
        'menu_icon'   => 'dashicons-clipboard',
        'show_in_rest'=> true,
    ] );

    // Student Submissions CPT
    register_post_type( 'ttp_submission', [
        'labels'      => [ 'name' => 'Submissions', 'singular_name' => 'Submission' ],
        'public'      => false, // Keep private, only trainers/admins see them
        'show_ui'     => true,
        'has_archive' => false,
        'supports'    => [ 'title', 'editor', 'author', 'comments', 'custom-fields' ],
        'menu_icon'   => 'dashicons-upload',
    ] );

    // Live Classes CPT
    register_post_type( 'ttp_live_class', [
        'labels'      => [ 'name' => 'Live Classes', 'singular_name' => 'Live Class' ],
        'public'      => true,
        'show_ui'     => true,
        'has_archive' => true,
        'supports'    => [ 'title', 'editor', 'author', 'thumbnail' ],
        'menu_icon'   => 'dashicons-video-alt3',
    ] );
}
add_action( 'init', 'ttp_core_register_cpts' );

/**
 * Inject Native Video Modal (HTML5 Dialog)
 */
add_action('wp_footer', function() {
    ?>
    <dialog id="ttp-video-modal" style="border:none; border-radius:12px; padding:0; max-width:800px; width:90%; background:transparent; backdrop-filter:blur(10px);">
        <div style="background:#0F172A; padding:24px; border-radius:12px; position:relative; box-shadow:0 25px 50px -12px rgba(0, 0, 0, 0.5);">
            <button onclick="document.getElementById('ttp-video-modal').close()" style="position:absolute; top:12px; right:12px; background:transparent; border:none; color:white; font-size:24px; cursor:pointer;">&times;</button>
            <h3 style="color:white; margin-top:0;">Platform Demo</h3>
            <div style="position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:8px;">
                <iframe src="https://www.youtube-nocookie.com/embed/dQw4w9WgXcQ?rel=0" style="position:absolute; top:0; left:0; width:100%; height:100%; border:none;" allowfullscreen></iframe>
            </div>
        </div>
    </dialog>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var buttons = document.querySelectorAll('.ttp-video-trigger a, a.ttp-video-trigger');
            buttons.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    document.getElementById('ttp-video-modal').showModal();
                });
            });
            // Close when clicking outside
            var modal = document.getElementById('ttp-video-modal');
            modal.addEventListener('click', function(event) {
                var rect = modal.getBoundingClientRect();
                var isInDialog = (rect.top <= event.clientY && event.clientY <= rect.top + rect.height && rect.left <= event.clientX && event.clientX <= rect.left + rect.width);
                if (!isInDialog) { modal.close(); }
            });
        });
    </script>
    <?php
});


/**
 * Register ACF Field Group for User Profile
 * Links Student to Startup, Mentor, and tracks Performance
 */
function ttp_core_acf_add_local_field_groups() {
    if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_startup_experience',
        'title' => 'Startup Practical Experience',
        'fields' => array(
            array(
                'key' => 'field_assigned_startup',
                'label' => 'Assigned Startup',
                'name' => 'assigned_startup',
                'type' => 'post_object',
                'post_type' => array('startup'),
                'return_format' => 'object',
            ),
            array(
                'key' => 'field_assigned_mentor',
                'label' => 'Assigned Mentor',
                'name' => 'assigned_mentor',
                'type' => 'user',
                'role' => array('startup_mentor'),
                'return_format' => 'array',
            ),
            array(
                'key' => 'field_startup_performance_score',
                'label' => 'Performance Score',
                'name' => 'startup_performance_score',
                'type' => 'number',
                'min' => 0,
                'max' => 100,
            ),
            array(
                'key' => 'field_startup_completed',
                'label' => 'Experience Completed',
                'name' => 'startup_completed',
                'type' => 'true_false',
                'message' => 'Mark as completed to issue certificate',
                'ui' => 1,
            ),
            array(
                'key' => 'field_attendance_met',
                'label' => 'Attendance Requirement Met',
                'name' => 'attendance_met',
                'type' => 'true_false',
                'message' => 'Has the student met the 80% attendance requirement?',
                'ui' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'user_role',
                    'operator' => '==',
                    'value' => 'student',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    // Assignment System Grading
    acf_add_local_field_group(array(
        'key' => 'group_assignment_grading',
        'title' => 'Trainer Grading & Review',
        'fields' => array(
            array(
                'key' => 'field_submission_grade',
                'label' => 'Grade',
                'name' => 'submission_grade',
                'type' => 'number',
                'min' => 0,
                'max' => 100,
            ),
            array(
                'key' => 'field_submission_status',
                'label' => 'Status',
                'name' => 'submission_status',
                'type' => 'select',
                'choices' => array(
                    'pending' => 'Pending Review',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ),
                'default_value' => 'pending',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'ttp_submission',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'side',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    // Live Class Configurations
    acf_add_local_field_group(array(
        'key' => 'group_live_class_config',
        'title' => 'Live Class Details',
        'fields' => array(
            array(
                'key' => 'field_lc_linked_course',
                'label' => 'Linked Course',
                'name' => 'lc_linked_course',
                'type' => 'post_object',
                'post_type' => array('courses'),
                'return_format' => 'object',
            ),
            array(
                'key' => 'field_lc_class_type',
                'label' => 'Class Type',
                'name' => 'lc_class_type',
                'type' => 'select',
                'choices' => array(
                    'zoom' => 'Zoom',
                    'meet' => 'Google Meet',
                    'offline' => 'Offline / Physical',
                ),
                'default_value' => 'zoom',
            ),
            array(
                'key' => 'field_lc_datetime',
                'label' => 'Date & Time',
                'name' => 'lc_datetime',
                'type' => 'date_time_picker',
                'display_format' => 'F j, Y g:i a',
                'return_format' => 'Y-m-d H:i:s',
            ),
            array(
                'key' => 'field_lc_meeting_link',
                'label' => 'Meeting URL (Zoom/Meet)',
                'name' => 'lc_meeting_link',
                'type' => 'url',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_lc_class_type',
                            'operator' => '!=',
                            'value' => 'offline',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_lc_offline_location',
                'label' => 'Physical Location',
                'name' => 'lc_offline_location',
                'type' => 'text',
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_lc_class_type',
                            'operator' => '==',
                            'value' => 'offline',
                        ),
                    ),
                ),
            ),
            array(
                'key' => 'field_lc_recording_link',
                'label' => 'Recording URL',
                'name' => 'lc_recording_link',
                'type' => 'url',
                'instructions' => 'Add this after the session concludes.',
            ),
            array(
                'key' => 'field_lc_attendance',
                'label' => 'Attendance List',
                'name' => 'lc_attendance',
                'type' => 'user',
                'role' => array('student'),
                'multiple' => 1,
                'return_format' => 'array',
                'instructions' => 'Tag students who attended the session.',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'ttp_live_class',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'active' => true,
    ));

    endif;
}
add_action('acf/init', 'ttp_core_acf_add_local_field_groups');
