<?php 
ltg()->ltg_yoast_breadcrumbs();
?>
<div class="entry-content container">
    <?php 
    if(have_posts()) :
        echo '<div class="results-wrap">';
            echo '<div class="posts-wrap md-col2 lg-col3">';

                while (have_posts()) : the_post();
                    esc_url(get_template_part('templates/loop/loop')); 
                endwhile;

            echo '</div>';

            esc_url(get_template_part('templates/pagination', '', array('loadmore' => '')));
        echo '</div>'; // results wrap
    endif;
    ?>
</div><!-- content -->