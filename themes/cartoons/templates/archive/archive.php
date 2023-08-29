<?php 
ltg()->ltg_yoast_breadcrumbs();
$pt = is_home() ? 'post' : get_post_type();
$ajaxLoadMore = ltg()->get_ltg_option('ltg_setting_'.$pt.'AjaxLoadMore');
?>
<div class="entry-content container">
    <?php 
    ltg()->ltg_archive_title_and_content();

    // ('QUERY_VAR','POST_TYPE') //
    ltg()->ltg_archive_filter('cat', 'post');
    
    if(have_posts()) :

        echo '<div class="results-wrap">';
            $ajax_class = '';
            if($ajaxLoadMore) :
                echo '<div class="loader-wrap">';
                    echo '<div class="ham-loader">Loading...</div>';
                echo '</div>';

                $ajax_class = ' ajax-results';
            endif;

            echo '<div class="posts-wrap md-col2 lg-col3'.$ajax_class.'">';

                while (have_posts()) : the_post();
                    esc_url(get_template_part('templates/loop/loop')); 
                endwhile;

            echo '</div>'; // ajax results

            esc_url(get_template_part('templates/pagination', '', array('loadmore' => $ajaxLoadMore)));

        echo '</div>'; // results wrap
    endif;
    ?>
</div><!-- content -->