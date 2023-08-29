<?php 
get_header();
ltg()->get_header_images();

global $wp_query;
    if(is_home()) {
        get_template_part( 'templates/archive/archive' );
    } elseif(is_search()) {
        get_template_part( 'templates/archive/archive', 'search' );
    } else {
        $posttype = $wp_query->query['post_type'];
        get_template_part( 'templates/archive/archive', $posttype );
    }
get_footer();