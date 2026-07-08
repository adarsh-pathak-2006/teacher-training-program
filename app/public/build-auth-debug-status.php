<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$um_options = get_option('um_options');
$results = [
    'register_status' => $um_options['register_status'] ?? 'not set',
];

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
