<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Asset Dequeue Engine
 * Forcefully blocks massive plugins from loading on pages where they aren't used.
 */
add_action( 'wp_enqueue_scripts', 'ttp_dequeue_heavy_assets', 99 );
function ttp_dequeue_heavy_assets() {
    
    // 1. WooCommerce Optimization
    // Only load WC scripts on the Shop, Cart, Checkout, and My Account pages.
    if ( function_exists( 'is_woocommerce' ) ) {
        if ( ! is_woocommerce() && ! is_cart() && ! is_checkout() && ! is_account_page() && ! is_singular('courses') ) {
            
            // Dequeue Styles
            wp_dequeue_style( 'woocommerce-layout' );
            wp_dequeue_style( 'woocommerce-smallscreen' );
            wp_dequeue_style( 'woocommerce-general' );
            wp_dequeue_style( 'woocommerce-inline' );
            wp_dequeue_style( 'wc-block-style' );
            
            // Dequeue Scripts
            wp_dequeue_script( 'wc-add-to-cart' );
            wp_dequeue_script( 'wc-cart-fragments' );
            wp_dequeue_script( 'woocommerce' );
            wp_dequeue_script( 'jquery-blockui' );
            wp_dequeue_script( 'jquery-placeholder' );
        }
    }

    // 2. BuddyPress Optimization
    // Only load BuddyPress assets on actual community pages
    if ( function_exists( 'is_buddypress' ) ) {
        if ( ! is_buddypress() && ! is_page('activity') && ! is_page('groups') && ! is_page('members') && ! is_page('forums') ) {
            wp_dequeue_style( 'bp-nouveau' );
            wp_dequeue_script( 'bp-nouveau' );
            wp_dequeue_script( 'bp-confirm' );
            wp_dequeue_script( 'bp-widget-members' );
        }
    }

    // 3. Fluent Forms Optimization
    // Fluent Forms often loads its CSS globally. We only need it on the Application/Contact pages.
    // If you need it globally, remove this block.
    if ( ! is_page('contact') && ! is_page('apply') ) {
        wp_dequeue_style( 'fluent-form-styles' );
        wp_dequeue_style( 'fluentform-public-default' );
    }
}
?>
