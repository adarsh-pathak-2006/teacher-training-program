<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * AJAX Handler: ttp_global_search_ajax
 * Fires parallel queries across post types and users.
 */
add_action('wp_ajax_ttp_global_search', 'ttp_global_search_handler');
add_action('wp_ajax_nopriv_ttp_global_search', 'ttp_global_search_handler');

function ttp_global_search_handler() {
    if ( ! isset($_POST['nonce']) || ! wp_verify_nonce($_POST['nonce'], 'ttp_search_nonce') ) {
        wp_send_json_error('Security check failed.');
    }

    $query = sanitize_text_field( $_POST['query'] ?? '' );
    if ( strlen($query) < 2 ) {
        wp_send_json_error('Query too short.');
    }

    $results = [];

    // ── 1. CONTENT SEARCH (Courses, Blog, Programs, FAQs, Startups) ─────────────
    $content_query = new WP_Query([
        's'              => $query,
        'post_type'      => ['courses', 'post', 'page', 'startup_task'],
        'post_status'    => 'publish',
        'posts_per_page' => 5,
        'orderby'        => 'relevance',
    ]);

    $type_labels = [
        'courses'      => 'Course',
        'post'         => 'Blog',
        'page'         => 'Program / FAQ',
        'startup_task' => 'Startup',
    ];

    foreach ( $content_query->posts as $post ) {
        $results[] = [
            'type'    => $type_labels[ $post->post_type ] ?? ucfirst($post->post_type),
            'title'   => $post->post_title,
            'excerpt' => wp_trim_words( get_the_excerpt($post), 15 ),
            'url'     => get_permalink($post),
            'icon'    => ttp_search_icon_for_type($post->post_type),
        ];
    }

    // ── 2. USER SEARCH (Role-Restricted) ─────────────────────────────────────────
    $current_user = wp_get_current_user();
    $can_search_students = current_user_can('manage_options') || in_array('trainer', $current_user->roles) || in_array('startup_mentor', $current_user->roles);

    // Determine which roles the current user is allowed to find
    if ( ! is_user_logged_in() ) {
        $searchable_roles = []; // Logged-out users cannot search users
    } elseif ( $can_search_students ) {
        $searchable_roles = ['student', 'trainer', 'startup_mentor', 'administrator'];
    } else {
        // Students can only discover Mentors/Trainers, NOT other students
        $searchable_roles = ['trainer', 'startup_mentor', 'administrator'];
    }

    if ( ! empty($searchable_roles) ) {
        $user_query = new WP_User_Query([
            'search'         => '*' . esc_attr($query) . '*',
            'search_columns' => ['user_login', 'user_email', 'display_name'],
            'role__in'       => $searchable_roles,
            'number'         => 4,
        ]);

        foreach ( $user_query->get_results() as $user ) {
            $role_label = ucfirst( $user->roles[0] ?? 'User' );
            $profile_url = function_exists('um_user_profile_url') ? um_user_profile_url($user->ID) : get_author_posts_url($user->ID);

            $results[] = [
                'type'    => $role_label,
                'title'   => $user->display_name,
                'excerpt' => $user->user_email,
                'url'     => $profile_url,
                'icon'    => '👤',
            ];
        }
    }

    wp_send_json_success($results);
}

/**
 * Helper: Return an icon for each post type
 */
function ttp_search_icon_for_type($post_type) {
    $icons = [
        'courses'      => '🎓',
        'post'         => '📝',
        'page'         => '📄',
        'startup_task' => '🚀',
    ];
    return $icons[$post_type] ?? '🔍';
}

/**
 * Shortcode: [ttp_global_search]
 * Renders the search bar + JS-powered live results.
 */
add_shortcode('ttp_global_search', function() {
    ob_start();
    ?>
    <div id="ttp-global-search-wrap" style="position: relative; max-width: 640px; margin: 0 auto;">
        <div style="position: relative;">
            <input
                type="text"
                id="ttp-search-input"
                placeholder="Search courses, mentors, startups, blog..."
                autocomplete="off"
                style="
                    width: 100%;
                    padding: 14px 48px 14px 20px;
                    border: 2px solid var(--ttp-border-light, #e2e8f0);
                    border-radius: 50px;
                    font-size: 1rem;
                    background: white;
                    color: var(--ttp-text-head-light, #1e293b);
                    box-sizing: border-box;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.06);
                    transition: border-color 0.2s, box-shadow 0.2s;
                "
                onfocus="this.style.borderColor='#2563eb'; this.style.boxShadow='0 4px 20px rgba(37,99,235,0.15)'"
                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='0 4px 12px rgba(0,0,0,0.06)'"
            >
            <span id="ttp-search-spinner" style="display:none; position:absolute; right:18px; top:50%; transform:translateY(-50%); font-size:1.2rem;">⟳</span>
            <span id="ttp-search-icon" style="position:absolute; right:18px; top:50%; transform:translateY(-50%); font-size:1.2rem; color:#94a3b8;">🔍</span>
        </div>

        <div id="ttp-search-results" style="
            display: none;
            position: absolute;
            top: calc(100% + 8px);
            left: 0;
            right: 0;
            background: white;
            border: 1px solid var(--ttp-border-light, #e2e8f0);
            border-radius: 12px;
            box-shadow: 0 16px 40px rgba(0,0,0,0.12);
            z-index: 9999;
            max-height: 480px;
            overflow-y: auto;
        "></div>
    </div>

    <script>
    (function() {
        var input    = document.getElementById('ttp-search-input');
        var results  = document.getElementById('ttp-search-results');
        var spinner  = document.getElementById('ttp-search-spinner');
        var icon     = document.getElementById('ttp-search-icon');
        var debounce = null;

        input.addEventListener('keyup', function() {
            var q = this.value.trim();
            clearTimeout(debounce);

            if (q.length < 2) {
                results.style.display = 'none';
                return;
            }

            debounce = setTimeout(function() {
                icon.style.display = 'none';
                spinner.style.display = 'block';
                spinner.style.animation = 'ttp-spin 0.8s linear infinite';

                var fd = new FormData();
                fd.append('action', 'ttp_global_search');
                fd.append('query', q);
                fd.append('nonce', '<?php echo wp_create_nonce("ttp_search_nonce"); ?>');

                fetch('<?php echo admin_url("admin-ajax.php"); ?>', {
                    method: 'POST',
                    body: fd
                })
                .then(function(r) { return r.json(); })
                .then(function(data) {
                    spinner.style.display = 'none';
                    icon.style.display = 'block';
                    renderResults(data);
                })
                .catch(function() {
                    spinner.style.display = 'none';
                    icon.style.display = 'block';
                });
            }, 300);
        });

        function renderResults(data) {
            results.innerHTML = '';

            if (!data.success || !data.data || data.data.length === 0) {
                results.innerHTML = '<div style="padding:24px; text-align:center; color:#94a3b8;">No results found.</div>';
                results.style.display = 'block';
                return;
            }

            // Group results by type
            var grouped = {};
            data.data.forEach(function(item) {
                if (!grouped[item.type]) grouped[item.type] = [];
                grouped[item.type].push(item);
            });

            var html = '';
            Object.keys(grouped).forEach(function(type) {
                html += '<div style="padding:8px 16px 4px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.08em; color:#94a3b8;">' + type + 's</div>';
                grouped[type].forEach(function(item) {
                    html += '<a href="' + item.url + '" style="display:flex; gap:12px; align-items:center; padding:12px 16px; text-decoration:none; border-bottom:1px solid #f1f5f9; transition:background 0.15s;" onmouseover="this.style.background=\'#f8fafc\'" onmouseout="this.style.background=\'white\'">';
                    html += '<span style="font-size:1.4rem;">' + item.icon + '</span>';
                    html += '<div>';
                    html += '<div style="font-weight:600; color:#1e293b; font-size:0.95rem;">' + item.title + '</div>';
                    if (item.excerpt) html += '<div style="font-size:0.8rem; color:#94a3b8; margin-top:2px;">' + item.excerpt + '</div>';
                    html += '</div>';
                    html += '</a>';
                });
            });

            results.innerHTML = html;
            results.style.display = 'block';
        }

        // Hide on outside click
        document.addEventListener('click', function(e) {
            if (!document.getElementById('ttp-global-search-wrap').contains(e.target)) {
                results.style.display = 'none';
            }
        });
    })();
    </script>

    <style>
    @keyframes ttp-spin {
        to { transform: translateY(-50%) rotate(360deg); }
    }
    </style>
    <?php
    return ob_get_clean();
});
?>
