<?php
define('WP_USE_THEMES', false);
require_once('wp-load.php');

$bp_pages = get_option('bp-pages');
$results = [
    'bp_pages' => $bp_pages
];

if (isset($bp_pages['register'])) {
    unset($bp_pages['register']);
    unset($bp_pages['activate']);
    update_option('bp-pages', $bp_pages);
    $results['fixed'] = true;
}

header('Content-Type: application/json');
echo json_encode($results, JSON_PRETTY_PRINT);
?>
