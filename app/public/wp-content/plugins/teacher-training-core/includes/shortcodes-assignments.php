<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Shortcode to render secure file upload form and handle submissions
 * Usage: [ttp_submit_assignment]
 */
add_shortcode('ttp_submit_assignment', function() {
    if (!is_user_logged_in()) {
        return '<p>You must be logged in to submit an assignment.</p>';
    }

    $message = '';
    
    // Handle form submission
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ttp_submit_assignment_nonce'])) {
        if (wp_verify_nonce($_POST['ttp_submit_assignment_nonce'], 'ttp_submit_assignment_action')) {
            require_once(ABSPATH . 'wp-admin/includes/file.php');
            require_once(ABSPATH . 'wp-admin/includes/media.php');
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            $assignment_id = get_the_ID(); // Current page ID (the assignment post)
            $user_id = get_current_user_id();

            // Create the Submission CPT
            $submission_id = wp_insert_post([
                'post_title' => 'Submission: ' . get_the_title() . ' by ' . wp_get_current_user()->user_login,
                'post_type' => 'ttp_submission',
                'post_status' => 'publish',
                'post_author' => $user_id,
                'post_parent' => $assignment_id
            ]);

            if (!is_wp_error($submission_id) && !empty($_FILES['assignment_file']['name'])) {
                $file = $_FILES['assignment_file'];
                
                // Securely upload file
                $attachment_id = media_handle_upload('assignment_file', $submission_id);

                if (is_wp_error($attachment_id)) {
                    $message = '<div style="color: red; margin-bottom: 16px;">Error uploading file: ' . $attachment_id->get_error_message() . '</div>';
                    wp_delete_post($submission_id, true); // Cleanup failed submission
                } else {
                    update_post_meta($submission_id, '_attached_file_id', $attachment_id);
                    // Initialize ACF fields
                    update_post_meta($submission_id, 'submission_status', 'pending');
                    
                    $message = '<div style="color: green; margin-bottom: 16px; padding: 12px; background: #ecfdf5; border: 1px solid #10b981; border-radius: 4px;">Assignment submitted successfully! Awaiting trainer review.</div>';
                }
            } else {
                $message = '<div style="color: red; margin-bottom: 16px;">Failed to create submission or missing file.</div>';
            }
        }
    }

    ob_start(); ?>
    <div class="ttp-assignment-upload-box" style="padding: 24px; background: var(--ttp-bg-light); border: 1px dashed var(--ttp-border-light); border-radius: 8px;">
        <?php echo $message; ?>
        <h3 style="margin-top: 0;">Submit Your Work</h3>
        <p style="font-size: 0.875rem; color: var(--ttp-text-body-light);">Accepted formats: PDF, DOCX, PPT, JPG, PNG.</p>
        <form method="post" enctype="multipart/form-data" action="">
            <?php wp_nonce_field('ttp_submit_assignment_action', 'ttp_submit_assignment_nonce'); ?>
            
            <div style="margin-bottom: 16px;">
                <input type="file" name="assignment_file" id="assignment_file" accept=".pdf,.doc,.docx,.ppt,.pptx,.jpg,.jpeg,.png" required style="display: block; width: 100%; padding: 8px; border: 1px solid var(--ttp-border-light); border-radius: 4px; background: white;">
            </div>
            
            <button type="submit" class="ttp-btn-primary" style="background: var(--ttp-primary); color: white; border: none; padding: 12px 24px; border-radius: 4px; cursor: pointer; font-weight: 600;">Upload Submission</button>
        </form>
    </div>
    <?php return ob_get_clean();
});
?>
