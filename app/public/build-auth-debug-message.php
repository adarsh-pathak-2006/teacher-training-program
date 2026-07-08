<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$um_options = get_option('um_options');
$results = [];

foreach ($um_options as $key => $value) {
    if (is_string($value) && strpos($value, 'activate your account') !== false) {
        $results[$key] = $value;
    }
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
