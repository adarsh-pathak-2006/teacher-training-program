<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$bp_components = get_option('bp-active-components');
$results = [
    'bp_active_components' => $bp_components
];

// If 'settings' or 'registration' (actually it's usually hooked to 'members' or is its own component)
// BuddyPress registration is tied to the 'members' component, but we can't disable members.
// Wait, BuddyPress core has a 'BP_ENABLE_USER_REGISTRATION' filter or setting? No, BuddyPress looks at the WordPress 'users_can_register' option. Wait, it only intercepts if BuddyPress registration is enabled?
// Let's just remove the BuddyPress registration hook.
// Or we can just disable BuddyPress activation by overriding the filter `bp_core_enable_activation`.

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
