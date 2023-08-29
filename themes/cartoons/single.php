<?php 
get_header();
    ltg()->get_header_images();

    if(get_post_type() === 'post') {
        get_template_part( 'templates/content/content' );
    } else {
        get_template_part( 'templates/content/content', get_post_type() );
    }
get_footer(); 