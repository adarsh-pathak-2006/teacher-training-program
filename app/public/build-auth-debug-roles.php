<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$um_options = get_option('um_options');
$results = [
    'wp_default_role' => get_option('default_role'),
    'um_register_role' => $um_options['register_role'] ?? 'not set',
];

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
