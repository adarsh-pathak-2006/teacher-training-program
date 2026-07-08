<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$results = [];

// 1. Fix Global UM Options
$um_options = get_option('um_options');
if (!is_array($um_options)) $um_options = [];

$um_options['register_status'] = 'approved';
$um_options['register_role'] = 'student';

// Global redirect after registration
$um_options['register_redirect_type'] = 'redirect_url';
$um_options['register_redirect_url'] = home_url('/student-dashboard/');

update_option('um_options', $um_options);
$results[] = "Fixed global UM options (register_status=approved, register_role=student).";

// 2. Fix the Registration Form (ID 218) explicitly
$form_id = 218;
update_post_meta($form_id, '_um_register_use_custom_settings', 1);
update_post_meta($form_id, '_um_register_status', 'approved');
update_post_meta($form_id, '_um_register_role', 'student');
update_post_meta($form_id, '_um_register_redirect_type', 'redirect_url');
update_post_meta($form_id, '_um_register_redirect_url', home_url('/student-dashboard/'));

$results[] = "Forced Form 218 to Auto-Approve and Redirect to Dashboard.";

// Clean up previous test users so the user can test cleanly if they want
global $wpdb;
$wpdb->query("DELETE FROM $wpdb->users WHERE user_login LIKE 'test%'");
$wpdb->query("DELETE FROM $wpdb->usermeta WHERE user_id NOT IN (SELECT ID FROM $wpdb->users)");

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
