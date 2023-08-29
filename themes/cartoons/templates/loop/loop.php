<div class="loop-wrap">
    <?php if (!have_posts()): // if there are no posts ?>
        
        <article>
            <h2><?php esc_html_e( 'Sorry, nothing to display.', 'ltg' ); ?></h2>
        </article>

        <?php else: // now the loop can start

            while (have_posts()) : the_post(); ?>

            <article <?php post_class(); ?>>
                <?php 
                echo '<a class="img-wrap" href="'.esc_url(get_permalink()).'" title="'.esc_html(get_the_title()).'">';
                if ( has_post_thumbnail()) {
                    $imgpath = get_the_post_thumbnail_url(get_the_ID(), array(300,300));
                } else {
                    $imgpath = get_stylesheet_directory_uri().'/assets/images/default-blog.jpg'; 
                }
                echo '<img src="'.esc_url($imgpath).'" />';
                echo '</a>';
                ?>
                <div class="blog-content">
                    <h3><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></h3>

                    <div class="post-meta">
                        <span class="date"><?php the_time('F j, Y'); ?> <?php the_time('g:i a'); ?></span>
                        <span class="author"><?php esc_html_e( 'Published by', 'ltg' ); ?> <?php the_author_posts_link(); ?></span>
                        <?php /*<span class="comments"><?php if (comments_open( get_the_ID() ) ) comments_popup_link( __( 'Leave your thoughts', 'ltg' ), __( '1 Comment', 'ltg' ), __( '% Comments', 'ltg' )); ?></span>*/ ?>
                    </div>

                    <p><?php echo esc_html(ltg()->ltg_excerpt(20)); ?></p>

                    <a class="btn" href="<?php the_permalink(); ?>">Continue Reading</a>
                </div>
            </article>
        <!-- /article -->
        <?php endwhile;
    endif; ?>
</div>
