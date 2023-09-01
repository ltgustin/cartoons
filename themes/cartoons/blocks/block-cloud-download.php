<?php 
$image = block_value('image');
$title = block_value('title') ? block_value('title') : 'Cloud Download';
$text = block_value('text');

echo '<div class="block cloud-download-wrap wide">';
    echo '<div class="download-left">';
        if($image) echo '<img src="'.wp_get_attachment_image_src($image,'full')[0].'" alt="" />';
        echo '<div class="inner">';
            echo '<h1>'.esc_html($title).'</h1>';
            if($text) echo '<p>'.esc_html($text).'</p>';

            echo '<form id="download-form" method="post" name="download-form">';

                echo '<div class="field number">';
                    echo '<label for="number">Asset ID#</label>';
                    echo '<input type="text" name="theid" id="theid" placeholder="1234" pattern="\d{1,4}" maxlength="4" />';
                echo '</div>'; // field

                echo '<button class="btn"><span>Get Cartoon Asset</span></button>';

            echo '</form>';
        echo '</div>'; // inner
    echo '</div>'; // left

    echo '<canvas height=775px width=775px id="download-canvas" class="download-canvas"></canvas>';
echo '</div>';
?>

<script>
    jQuery(document).ready(function() {
        let canvas = document.getElementById('download-canvas');
        canvas.height = canvas.width * 1;

    });
</script>