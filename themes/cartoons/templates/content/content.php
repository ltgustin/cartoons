<?php 
ltg()->ltg_yoast_breadcrumbs();
?>

<div class="entry-content container">
    <div class="row">
        
        <?php if(have_posts()): while(have_posts()): the_post(); ?>
       
        <div class="left col-xs-12 col-sm-8 col-md-9">
            <?php 
            $subtitle = get_post_meta(get_the_ID(), '_ltg_custom_page_custom_subheading',true);

            if($subtitle) echo '<h2 class="subtitle">'.esc_html($subtitle).'</h2>';
            ?>

            <div class="post-meta">
                <span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
                <span class="author"><?php esc_html_e( 'Published by', 'ltg' ); ?> <?php the_author_posts_link(); ?></span>
            </div>

            <?php 
            the_content();

            the_tags( __( 'Tags: ', 'ltg' ), ', ', '<br>');


            echo '<div class="post-share-wrap">';
                echo '<div class="share-text">Share</div>';
                ltg()->share();
            echo '</div>';

            comments_template();
            ?>
        </div><!-- left -->
            
        <div class="sidebar col-xs-12 col-sm-4 col-md-3" role="complementary">
            <?php dynamic_sidebar('primary'); ?>
        </div><!-- sidebar -->

    <?php endwhile; endif; ?>

    </div><!-- row -->
</div><!-- entry-content -->