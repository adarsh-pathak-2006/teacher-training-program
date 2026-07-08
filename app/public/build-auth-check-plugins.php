<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$results = get_option('active_plugins');

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
