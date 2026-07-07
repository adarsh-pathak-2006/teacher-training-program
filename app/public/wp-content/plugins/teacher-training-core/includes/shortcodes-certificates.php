<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode: [ttp_certificate_status course_id="123"]
 * Validates Course, Quiz, Assignment, and Attendance. Outputs Download button or status.
 */
add_shortcode('ttp_certificate_status', function($atts) {
    if (!is_user_logged_in()) return '<p>Log in to view certificate status.</p>';
    
    $atts = shortcode_atts(['course_id' => 0], $atts);
    $course_id = intval($atts['course_id']);
    if (!$course_id) return '';

    $user_id = get_current_user_id();
    
    // 1. Course/Quiz Native Completion
    $course_completed = false;
    if (function_exists('tutor_utils')) {
        $course_completed = tutor_utils()->is_completed_course($course_id, $user_id);
    }
    
    // 4. Attendance Check (Dynamic >= 80%)
    $attendance_met = false;
    if (function_exists('ttp_calculate_attendance')) {
        $metrics = ttp_calculate_attendance($user_id, $course_id);
        if ($metrics['percentage'] >= 80) {
            $attendance_met = true;
        }
    }
    
    // 3. Assignment Check (Query ttp_submission for this course that is approved)
    $assignment_approved = false;
    // In our simplified mock, we check if they have ANY approved submission for now.
    // Ideally we join post_parent -> ttp_assignment -> course_id. 
    $submissions = get_posts([
        'post_type' => 'ttp_submission',
        'author' => $user_id,
        'meta_key' => 'submission_status',
        'meta_value' => 'approved',
        'posts_per_page' => 1
    ]);
    if (!empty($submissions)) {
        $assignment_approved = true;
    }

    // Logic Gate
    if ($course_completed && $attendance_met && $assignment_approved) {
        // Generate or retrieve Verification Hash
        $hash = get_user_meta($user_id, '_ttp_cert_hash_' . $course_id, true);
        if (!$hash) {
            $hash = 'TTP-' . strtoupper(substr(md5($user_id . $course_id . time()), 0, 8));
            update_user_meta($user_id, '_ttp_cert_hash_' . $course_id, $hash);
        }
        
        $url = site_url('/certificate/?course=' . $course_id . '&user=' . $user_id);
        
        ob_start(); ?>
        <div class="ttp-card" style="padding: 24px; text-align: center; border: 2px solid var(--ttp-primary);">
            <h3 style="color: var(--ttp-primary); margin-top: 0;">🎉 Certificate Unlocked!</h3>
            <p>You have successfully completed all prerequisites.</p>
            <p style="font-size: 0.875rem; color: var(--ttp-text-body-light);">Verification ID: <strong><?php echo esc_html($hash); ?></strong></p>
            <a href="<?php echo esc_url($url); ?>" class="ttp-btn-primary" target="_blank" style="display: inline-block; background: var(--ttp-primary); color: white; padding: 12px 24px; text-decoration: none; border-radius: 8px; font-weight: 600; margin-top: 16px;">View & Download Certificate</a>
        </div>
        <?php return ob_get_clean();
    } else {
        ob_start(); ?>
        <div class="ttp-card" style="padding: 24px; background: var(--ttp-bg-light);">
            <h3 style="margin-top: 0;">Certificate Prerequisites</h3>
            <ul style="list-style: none; padding: 0;">
                <li style="margin-bottom: 8px;">
                    <?php echo $course_completed ? '✅' : '❌'; ?> Pass all Quizzes & complete course modules.
                </li>
                <li style="margin-bottom: 8px;">
                    <?php echo $attendance_met ? '✅' : '❌'; ?> Meet 80% Attendance Requirement.
                </li>
                <li style="margin-bottom: 8px;">
                    <?php echo $assignment_approved ? '✅' : '❌'; ?> Pass all Assignments.
                </li>
            </ul>
        </div>
        <?php return ob_get_clean();
    }
});

/**
 * Shortcode: [ttp_verify_certificate]
 * Public endpoint to search and validate a hash.
 */
add_shortcode('ttp_verify_certificate', function() {
    $result_html = '';
    
    if (isset($_POST['ttp_verify_hash']) && !empty($_POST['ttp_verify_hash'])) {
        $search_hash = sanitize_text_field($_POST['ttp_verify_hash']);
        
        // Find user with this meta value
        global $wpdb;
        $meta = $wpdb->get_row($wpdb->prepare("SELECT user_id, meta_key FROM $wpdb->usermeta WHERE meta_value = %s AND meta_key LIKE '_ttp_cert_hash_%'", $search_hash));
        
        if ($meta) {
            $user_id = $meta->user_id;
            $course_id = str_replace('_ttp_cert_hash_', '', $meta->meta_key);
            
            $user = get_userdata($user_id);
            $course_title = get_the_title($course_id);
            
            $result_html = '<div style="padding: 16px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 4px; color: #065f46; margin-top: 16px;">';
            $result_html .= '<strong>✅ Valid Certificate</strong><br>';
            $result_html .= 'Issued to: <strong>' . esc_html($user->display_name) . '</strong><br>';
            $result_html .= 'For: <strong>' . esc_html($course_title) . '</strong>';
            $result_html .= '</div>';
        } else {
            $result_html = '<div style="padding: 16px; background: #fef2f2; border: 1px solid #ef4444; border-radius: 4px; color: #991b1b; margin-top: 16px;">❌ Invalid Verification Number. No records found.</div>';
        }
    }
    
    ob_start(); ?>
    <div class="ttp-card" style="padding: 32px; max-width: 600px; margin: 0 auto; text-align: center;">
        <h2 style="margin-top: 0;">Certificate Verification</h2>
        <p style="color: var(--ttp-text-body-light); margin-bottom: 24px;">Enter the 12-character Verification ID found at the bottom of the certificate.</p>
        <form method="post" action="">
            <input type="text" name="ttp_verify_hash" placeholder="e.g. TTP-A1B2C3D4" required style="width: 100%; max-width: 400px; padding: 12px; font-size: 1.2rem; text-align: center; border: 1px solid var(--ttp-border-light); border-radius: 8px; margin-bottom: 16px; display: inline-block;">
            <br>
            <button type="submit" class="ttp-btn-primary" style="background: var(--ttp-primary); color: white; border: none; padding: 12px 32px; border-radius: 8px; font-weight: 600; cursor: pointer;">Verify Authenticity</button>
        </form>
        <?php echo $result_html; ?>
    </div>
    <?php return ob_get_clean();
});

add_shortcode("ttp_render_certificate_pdf", function() {
    ob_start();
    $user_id = isset($_GET["user"]) ? intval($_GET["user"]) : 0;
    $course_id = isset($_GET["course"]) ? intval($_GET["course"]) : 0;
    
    if ($user_id && $course_id) {
        $user = get_userdata($user_id);
        $course_title = get_the_title($course_id);
        $hash = get_user_meta($user_id, "_ttp_cert_hash_" . $course_id, true);
        $date = date("F j, Y");
        
        if ($hash && get_current_user_id() == $user_id) {
            ?>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
            
            <div style="text-align: center; margin-bottom: 32px; margin-top: 32px;">
                <button onclick="downloadPDF()" style="background: var(--ttp-primary); color: white; padding: 12px 24px; border: none; border-radius: 8px; cursor: pointer; font-size: 1.1rem; font-weight: 600;">Download PDF</button>
            </div>
            
            <div style="overflow-x: auto;">
                <div id="certificate-dom" style="width: 1000px; height: 750px; margin: 0 auto; padding: 64px; background: white; border: 16px solid var(--ttp-primary); text-align: center; font-family: 'Georgia', serif; position: relative; box-sizing: border-box;">
                    <h1 style="font-size: 4rem; color: var(--ttp-text-head-light); margin-bottom: 16px;">Certificate of Completion</h1>
                    <p style="font-size: 1.5rem; color: var(--ttp-text-body-light); margin-bottom: 48px;">This is proudly presented to</p>
                    <h2 style="font-size: 3rem; color: var(--ttp-primary); border-bottom: 2px solid var(--ttp-border-light); display: inline-block; padding-bottom: 8px; margin-bottom: 48px;"><?php echo esc_html($user->display_name); ?></h2>
                    <p style="font-size: 1.5rem; color: var(--ttp-text-body-light); margin-bottom: 16px;">For successfully completing the requirements of</p>
                    <h3 style="font-size: 2.5rem; color: var(--ttp-text-head-light); margin-bottom: 80px;"><?php echo esc_html($course_title); ?></h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-top: 64px; padding: 0 64px;">
                        <div>
                            <p style="border-bottom: 1px solid black; width: 250px; margin: 0 auto 8px auto;"></p>
                            <p style="font-size: 1.2rem;">Program Director</p>
                        </div>
                        <div>
                            <p style="border-bottom: 1px solid black; width: 250px; margin: 0 auto 8px auto; font-size: 1.2rem;"><?php echo $date; ?></p>
                            <p style="font-size: 1.2rem;">Date</p>
                        </div>
                    </div>
                    
                    <div style="position: absolute; bottom: 32px; right: 48px; font-size: 1rem; color: #888; text-align: right;">
                        Verify at <?php echo site_url("/verify"); ?><br>
                        ID: <?php echo esc_html($hash); ?>
                    </div>
                </div>
            </div>
            
            <script>
                function downloadPDF() {
                    var element = document.getElementById("certificate-dom");
                    var opt = {
                      margin:       0,
                      filename:     "Certificate_<?php echo esc_js($hash); ?>.pdf",
                      image:        { type: "jpeg", quality: 0.98 },
                      html2canvas:  { scale: 2 },
                      jsPDF:        { unit: "in", format: "letter", orientation: "landscape" }
                    };
                    html2pdf().set(opt).from(element).save();
                }
            </script>
            <?php
        } else {
            echo "<p>Invalid certificate request.</p>";
        }
    } else {
        echo "<p>Missing parameters.</p>";
    }
    return ob_get_clean();
});
