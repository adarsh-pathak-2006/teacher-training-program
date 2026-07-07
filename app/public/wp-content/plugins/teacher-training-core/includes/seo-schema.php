<?php
if ( ! defined( 'ABSPATH' ) ) exit;

/**
 * Custom Schema Injection Engine (Rank Math Hook)
 */
add_filter( 'rank_math/json_ld', function( $data, $jsonld ) {
    
    // 1. Organization Schema (Homepage)
    if ( is_front_page() ) {
        $data['Organization'] = [
            '@type' => 'Organization',
            '@id'   => site_url('/#organization'),
            'name'  => get_bloginfo('name'),
            'url'   => site_url(),
            'logo'  => [
                '@type' => 'ImageObject',
                'url'   => site_url('/wp-content/uploads/logo.png')
            ]
        ];
    }

    // 2. Course Schema (Tutor LMS Courses)
    if ( is_singular('courses') ) {
        global $post;
        $product_id = get_post_meta($post->ID, '_tutor_course_product_id', true);
        $price = 0;
        
        if ($product_id && class_exists('WC_Product')) {
            $product = wc_get_product($product_id);
            if ($product) {
                $price = $product->get_price();
            }
        }

        $author = get_userdata($post->post_author);

        $data['Course'] = [
            '@type' => 'Course',
            '@id'   => get_permalink($post->ID) . '#course',
            'name'  => get_the_title($post->ID),
            'description' => wp_trim_words(wp_strip_all_tags($post->post_content), 30),
            'provider' => [
                '@type' => 'Organization',
                'name'  => get_bloginfo('name'),
                'sameAs'=> site_url()
            ],
            'hasCourseInstance' => [
                '@type' => 'CourseInstance',
                'courseMode' => 'Online',
                'instructor' => [
                    '@type' => 'Person',
                    'name'  => $author ? $author->display_name : 'Instructor'
                ]
            ],
            'offers' => [
                '@type' => 'Offer',
                'category' => 'Paid',
                'priceCurrency' => 'INR',
                'price' => $price
            ]
        ];
    }

    // 3. Startup Schema (Custom Post Type)
    if ( is_singular('startup_task') ) {
        global $post;
        $data['Project'] = [
            '@type' => 'Project',
            '@id'   => get_permalink($post->ID) . '#startup',
            'name'  => get_the_title($post->ID),
            'description' => wp_trim_words(wp_strip_all_tags($post->post_content), 30),
            'provider' => [
                '@type' => 'Organization',
                'name'  => get_bloginfo('name')
            ]
        ];
    }

    // 4. Mentor (Person) Schema (Author Archives)
    if ( is_author() ) {
        $author_id = get_query_var('author');
        $author = get_userdata($author_id);
        
        if ($author && (in_array('startup_mentor', $author->roles) || in_array('trainer', $author->roles))) {
            $data['Person'] = [
                '@type' => 'Person',
                '@id'   => get_author_posts_url($author_id) . '#mentor',
                'name'  => $author->display_name,
                'jobTitle' => 'Platform Mentor',
                'worksFor' => [
                    '@type' => 'Organization',
                    'name'  => get_bloginfo('name')
                ]
            ];
        }
    }

    return $data;
}, 99, 2);
?>
