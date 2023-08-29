<?php
class Taxonomy{
    function __construct() {
        add_action( 'acf/init', array($this,'taxonomy_acf_register_fields') );
    }

    function taxonomy_acf_register_fields(){
        if( ! function_exists('acf_add_local_field_group') )
            return;

        acf_add_local_field_group(array(
            'key' => 'custom_taxonomy_meta_fields_acf',
            'title' => 'Category Fields',
            'fields' => array(
                array(
                    'key' => 'cat_thumb',
                    'label' => 'Category Image',
                    'name' => 'cat_thumb',
                    'type' => 'image',
                    'return_format' => 'id',
                    'preview_size' => 'thumbnail',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'max_width' => '',
                    'max_height' => '',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'taxonomy',
                        'operator' => '==',
                        'value' => 'category',
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'left',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'show_in_rest' => 0,
        ));    
    }
}