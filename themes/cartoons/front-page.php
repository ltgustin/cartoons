<?php get_header(); 
ltg()->get_header_images(); 

// have a carousel? uncomment this!! //
//echo get_template_part('templates/carousel'); 
?>

    <div class="entry-content">
        <?php 
        if(have_posts()): while(have_posts()): the_post();

            // <button data-micromodal-trigger="modal1">Trigger Modal TESTING NOW</button>

            // <button data-micromodal-trigger="modal2">Trigger Modal 2</button>

            the_content();
        endwhile; endif;
        ?>
    </div><!--main_wrap-->


    <?php
    //normal one
    // echo ltg()->ham_modal_start('modal1','Title Goes Here');
       
    //     echo '<p>Try hitting the <code>tab</code> key and notice how the focus stays within the modal itself. Also, <code>esc</code> to close modal.</p>';
    //     echo '<button class="btn primary" data-micromodal-close aria-label="Close this dialog window">Close</button>';

    // echo ltg()->ham_modal_end();

    //iframe embed
    // echo ltg()->ham_modal_start('modal2',null,true,false);
    //     echo '<iframe width="650" height="325" src="https://www.youtube-nocookie.com/embed/yhCuCqJbOVE?controls=0" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    // //true = the ending wrapper for the iframe scaler
    // echo ltg()->ham_modal_end(true);
get_footer();