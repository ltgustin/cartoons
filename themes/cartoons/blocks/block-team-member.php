<?php 
$image = block_value('image');
$name = block_value('name');
$title = block_value('title');
$twitter = block_value('twitter');

echo '<div class="block team-member">';
    if($image) :
        $img = wp_get_attachment_image_src($image,'full');
        echo '<div class="img-wrap-wrap">';
            echo '<div class="img-wrap"><img src="'.esc_url($img[0]).'" alt="'.esc_attr($name).'" />';
            echo '</div>';
            
            if($twitter) echo '<a class="twitter" href="'.esc_url($twitter).'" target="_blank">T</a>';
        echo '</div>'; // image

        echo '<h4>'.esc_html($name).'</h4>';

        if($title) echo '<div class="title">'.esc_html($title).'</div>';
    endif;
echo '</div>'; // team member