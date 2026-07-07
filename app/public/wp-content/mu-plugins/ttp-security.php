<?php
/**
 * Plugin Name: TTP Core Security Engine
 * Description: Must-Use plugin that injects strict security headers, disables XML-RPC, and blocks author enumeration.
 * Version: 1.0.0
 * Author: Platform Architect
 */

if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * 1. Inject Strict HTTP Security Headers
 */
add_action( 'send_headers', 'ttp_inject_security_headers' );
function ttp_inject_security_headers() {
    if ( ! headers_sent() ) {
        // Enforce HTTPS
        header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' );
        // Prevent clickjacking
        header( 'X-Frame-Options: SAMEORIGIN' );
        // Prevent MIME sniffing
        header( 'X-Content-Type-Options: nosniff' );
        // Enable Cross-Site Scripting filter
        header( 'X-XSS-Protection: 1; mode=block' );
        // Referrer policy
        header( 'Referrer-Policy: strict-origin-when-cross-origin' );
    }
}

/**
 * 2. Completely Disable XML-RPC (Blocks DDoS vectors)
 */
add_filter( 'xmlrpc_enabled', '__return_false' );

// Block direct access to xmlrpc.php
if ( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) {
    wp_die( 'XML-RPC is completely disabled on this platform for security reasons.', 'Security Lockdown', 403 );
}

/**
 * 3. Block Author Enumeration Scans
 * Prevents bots from guessing admin usernames by accessing /?author=1
 */
add_action( 'template_redirect', 'ttp_block_author_enumeration' );
function ttp_block_author_enumeration() {
    if ( is_author() && ! is_user_logged_in() ) {
        // Allow author pages if needed for the frontend, but block numeric query strings
        // Actually, our SEO schema relies on Author pages for Mentors. 
        // We will only block the raw `/?author=X` query string, letting `/author/username/` pass if permalinks are active.
        if ( isset( $_GET['author'] ) && preg_match( '/^\d+$/', $_GET['author'] ) ) {
            wp_redirect( home_url(), 301 );
            exit;
        }
    }
}

/**
 * 4. Hide WordPress Version Generator
 */
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
?>
