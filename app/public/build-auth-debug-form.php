<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$results = [];

// 1. Get UM Options for Registration
$um_options = get_option('um_options');
$results['global_require_email_activation'] = $um_options['require_email_activation'] ?? 'not set';

// 2. Get UM Form (ID 218) Settings
$form_id = 218;
$form_meta = get_post_meta($form_id);

$results['form_meta'] = [];
foreach ($form_meta as $key => $value) {
    if (strpos($key, '_um_') === 0) {
        $results['form_meta'][$key] = $value[0];
    }
}

// 3. Get UM Role specific settings for Student
global $wpdb;
$student_role = $wpdb->get_row("SELECT ID FROM $wpdb->posts WHERE post_type = 'um_role' AND post_name = 'student'");
if ($student_role) {
    $results['student_role_register_status'] = get_post_meta($student_role->ID, '_um_register_status', true);
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
