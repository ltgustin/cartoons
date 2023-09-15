<?php 
$title = block_value('title');
$links = block_value('links');

echo '<div class="block table-of-contents">';
    echo '<div class="title">'.esc_html($title).'</div>';

    echo $links;
echo '</div>';