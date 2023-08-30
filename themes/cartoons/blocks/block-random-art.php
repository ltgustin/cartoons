<?php 
$imageid_array = array();
for ($i=1; $i < 13; $i++) { 
    $image = block_value('image'.$i);

    array_push($imageid_array, $image);
}

if(count($imageid_array) > 3) :
    $random = array_rand($imageid_array, 4);

    echo '<div class="block random-art">';
        foreach($random as $rand) :
            echo '<div class="art-block img-wrap">';
                $imgid = $imageid_array[$rand];
                $img = wp_get_attachment_image_src($imgid,'full')[0];

                echo '<img src="'.esc_url($img).'" alt="" />';
            echo '</div>';
        endforeach;
    echo '</div>';
endif;