<?php
get_header();
    ltg()->get_header_images(); 
    ltg()->ltg_yoast_breadcrumbs();

    global $post;
    $post = get_page_by_path('404-page');
    setup_postdata($post);

    echo '<div class="content section container">';
        the_content();
    echo '</div>';

    wp_reset_postdata();
get_footer();