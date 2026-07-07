<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Bridge BuddyPress and Ultimate Member
 * Since we disabled BuddyPress XProfile, BP might still try to generate its own profile links.
 * We need to redirect BuddyPress profile URLs to Ultimate Member profile URLs.
 */
add_filter('bp_core_get_user_domain', 'ttp_redirect_bp_profile_to_um', 10, 4);
function ttp_redirect_bp_profile_to_um($domain, $user_id, $user_nicename, $user_login) {
    if (function_exists('um_user_profile_url')) {
        um_fetch_user($user_id);
        $um_url = um_user_profile_url();
        um_reset_user();
        if ($um_url) {
            return $um_url;
        }
    }
    return $domain;
}

/**
 * Make sure BuddyPress avatar uses Ultimate Member avatar
 */
add_filter('bp_core_fetch_avatar', 'ttp_use_um_avatar_in_bp', 10, 2);
function ttp_use_um_avatar_in_bp($avatar, $params) {
    if (isset($params['item_id']) && function_exists('um_get_avatar_url')) {
        $um_avatar_url = um_get_avatar_url(get_avatar_data($params['item_id']));
        if ($um_avatar_url) {
            // Replace the src in the img tag with the UM avatar
            $avatar = preg_replace('/src=["\']([^"\']+)["\']/', 'src="' . esc_url($um_avatar_url) . '"', $avatar);
        }
    }
    return $avatar;
}

/**
 * Dashboard Shortcodes Update for BuddyPress
 */
// Override the community shortcode to pull BuddyPress Activity
add_shortcode('ttp_dash_community', 'ttp_bp_dash_community_override');
function ttp_bp_dash_community_override() {
    if (!function_exists('bp_is_active')) return '<p>Community offline.</p>';
    
    ob_start();
    ?>
    <div class="ttp-card ttp-community-feed" style="padding: 24px; background: white; border-radius: 8px; border: 1px solid var(--ttp-border-light);">
        <h3 style="margin-top: 0; color: var(--ttp-text-head-light); border-bottom: 2px solid var(--ttp-primary); display: inline-block; padding-bottom: 8px;">Live Activity</h3>
        <div style="margin-top: 16px;">
            <?php 
            if ( bp_has_activities( bp_ajax_querystring( 'activity' ) ) ) : 
                while ( bp_activities() ) : bp_the_activity(); 
            ?>
                <div class="activity-item" style="padding: 16px 0; border-bottom: 1px solid var(--ttp-border-light);">
                    <div style="display: flex; align-items: flex-start; gap: 16px;">
                        <div class="avatar" style="width: 40px; height: 40px; border-radius: 50%; overflow: hidden;">
                            <?php bp_activity_avatar('type=thumb&width=40&height=40'); ?>
                        </div>
                        <div class="content" style="flex: 1;">
                            <div class="header" style="font-size: 0.875rem; color: var(--ttp-text-body-light); margin-bottom: 4px;">
                                <?php bp_activity_action(); ?>
                            </div>
                            <?php if ( bp_activity_has_content() ) : ?>
                                <div class="body" style="font-size: 1rem; color: var(--ttp-text-head-light);">
                                    <?php bp_activity_content_body(); ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php 
                endwhile;
            else : 
            ?>
                <p>No recent activity found in your groups.</p>
            <?php 
            endif; 
            ?>
        </div>
        <div style="margin-top: 16px; text-align: right;">
            <a href="<?php echo bp_get_activity_directory_permalink(); ?>" class="ttp-btn-text" style="color: var(--ttp-primary); text-decoration: none; font-weight: 600;">View All Activity &rarr;</a>
        </div>
    </div>
    <?php
    return ob_get_clean();
}

// Override the messages shortcode to pull Better Messages
add_shortcode('ttp_dash_messages', 'ttp_bp_dash_messages_override');
function ttp_bp_dash_messages_override() {
    if (!class_exists('Better_Messages')) return '<p>Messaging offline.</p>';
    if (!is_user_logged_in()) return '';
    
    $user_id = get_current_user_id();
    // Better Messages API for unread count
    $unread_count = Better_Messages()->functions->get_unread_messages_count($user_id);
    
    // Better Messages Inbox URL (typically /bp-messages/ or a dedicated slug, Better Messages handles it)
    // We can use the Better Messages shortcode to render the inbox directly if needed, or link to the page.
    // Better Messages creates a dedicated page by default, usually /messages/
    $inbox_url = site_url('/messages/');
    
    ob_start();
    ?>
    <div class="ttp-card ttp-messages-widget" style="padding: 24px; background: white; border-radius: 8px; border: 1px solid var(--ttp-border-light);">
        <h3 style="margin-top: 0; color: var(--ttp-text-head-light); display: flex; justify-content: space-between; align-items: center;">
            Private Messages
            <?php if ($unread_count > 0) : ?>
                <span style="background: var(--ttp-primary); color: white; padding: 2px 8px; border-radius: 12px; font-size: 0.8rem;"><?php echo $unread_count; ?> New</span>
            <?php endif; ?>
        </h3>
        
        <?php if ($unread_count > 0) : ?>
            <p style="color: var(--ttp-text-body-light);">You have unread messages waiting in your inbox.</p>
        <?php else : ?>
            <p style="color: var(--ttp-text-body-light);">Your inbox is up to date.</p>
        <?php endif; ?>
        
        <a href="<?php echo esc_url($inbox_url); ?>" class="ttp-btn-primary" style="display: inline-block; background: var(--ttp-primary); color: white; padding: 8px 16px; text-decoration: none; border-radius: 4px; font-weight: 600; margin-top: 12px;">Open Live Chat</a>
    </div>
    <?php
    return ob_get_clean();
}
?>
