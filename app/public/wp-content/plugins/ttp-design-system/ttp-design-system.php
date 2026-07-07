<?php
/**
 * Plugin Name: TTP Design System
 * Description: Implements the global design system CSS and registers reusable block patterns for the Teacher Training Program LMS.
 * Version: 1.0.0
 * Author: Architecture Team
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Enqueue Design System CSS on Frontend
 */
function ttp_enqueue_design_system_assets() {
    wp_enqueue_style(
        'ttp-design-system-css',
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
        array(),
        '1.0.0',
        'all'
    );
}
add_action( 'wp_enqueue_scripts', 'ttp_enqueue_design_system_assets' );

/**
 * Enqueue Design System CSS in Gutenberg Editor
 */
function ttp_enqueue_block_editor_assets() {
    wp_enqueue_style(
        'ttp-design-system-editor-css',
        plugin_dir_url( __FILE__ ) . 'assets/css/style.css',
        array(),
        '1.0.0',
        'all'
    );
}
add_action( 'enqueue_block_editor_assets', 'ttp_enqueue_block_editor_assets' );

/**
 * Make sure wp_block post type is supported natively (it is by default in WP, but ensuring no conflicts).
 * Patterns or additional block categories could be registered here.
 */
function ttp_register_block_categories( $categories, $post ) {
    return array_merge(
        $categories,
        array(
            array(
                'slug'  => 'ttp-blocks',
                'title' => 'TTP Design System',
                'icon'  => 'layout',
            ),
        )
    );
}
add_filter( 'block_categories_all', 'ttp_register_block_categories', 10, 2 );
