<?php
global $wp_query;
$pt = is_home() ? 'post' : get_post_type();
$ajaxLoadMore = $args['loadmore'];

if($ajaxLoadMore) {
    // ajax pagination
    if($wp_query->max_num_pages > 1) :
        echo '<div class="load-more-wrap">';
            echo '<button id="feed_load_more" class="btn btn-primary btn-wide" data-type="'.$pt.'">Load More</button>';
        echo '</div>';
    endif;
} else {
    // normal pagination
    echo '<div class="pagination">';
        $big = 999999999;    
        echo wp_kses_post(paginate_links(array(
            'base' => str_replace($big, '%#%', get_pagenum_link($big)),
            'format' => '?paged=%#%',
            'current' => max(1, get_query_var('paged')),
            'total' => $wp_query->max_num_pages,
            'prev_text' => '<span><</span> Previous',
            'next_text' => 'Next <span>></span>'
        )));
    echo '</div>';
}

if($ajaxLoadMore) :
?>
<script>
    jQuery('#feed_load_more').on('click',function(e){
        var post_type = jQuery(this).data('type'),
            results = jQuery('.results-wrap .ajax-results'),
            loadbtn = jQuery(this);

        jQuery.ajax({
            type: 'post',
            url: bloginfo.ajax_url,
            data: {
                action: 'load_more_ajax',
                post_type: post_type,
                query: bloginfo.posts,
                page: bloginfo.current_page
            },
            beforeSend:function(xhr) {
                loadbtn.text('Loading...');
            },
            success:function(posts){
                if(posts) {
                    setTimeout(function () {
                        loadbtn.text('More posts');
                        results.append(posts);
                        bloginfo.current_page++;
                        
                        if(bloginfo.current_page == bloginfo.max_page) 
                            loadbtn.hide();
                    }, 1200);
                } else {
                    loadbtn.hide();
                }
            }
        });
        return false;
    });
</script>
<?php endif; ?>