<?php get_header(); 
?>

    <div class="entry-content">
        <?php 
        if(have_posts()): while(have_posts()): the_post();
            the_content();
        endwhile; endif;
        ?>
    </div><!--main_wrap-->

<?php
get_footer();