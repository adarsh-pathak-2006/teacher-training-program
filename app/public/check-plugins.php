<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');
require_once(ABSPATH . 'wp-admin/includes/plugin.php');

$plugins = get_plugins();
$active_plugins = get_option('active_plugins');

$output = [
    'installed' => array_keys($plugins),
    'active' => $active_plugins
];

header('Content-Type: application/json');
echo json_encode($output, JSON_PRETTY_PRINT);
?>
