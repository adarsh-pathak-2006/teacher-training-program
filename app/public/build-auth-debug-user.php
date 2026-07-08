<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$user = get_user_by('login', 'testusernew');
$results = [];
if ($user) {
    $results['ID'] = $user->ID;
    $results['roles'] = $user->roles;
    $results['um_status'] = get_user_meta($user->ID, 'account_status', true);
} else {
    $results['error'] = 'User testusernew not found.';
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
