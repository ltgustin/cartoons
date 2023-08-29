<?php

class Posttype{

    public $p = "_ltg_";
    // post type
    public $post_type = "p_t";
    public $post_type_rewrite = "pt";
    public $pretty_name = "Post Type";
    public $pretty_name_plural = "Post Types";
    // taxonomy
    public $category_slug = "cat_slug";
    public $category_rewrite = "cat-slug";
    public $category_pretty = "Cat Name";
    public $category_plural = "Cat Names";

    function __construct() {
        add_action( 'init', array($this,'register_post_type') );
        add_action( 'acf/init', array($this, 'register_fields') );

        // add_action( 'wp_ajax_postType_ajax', array($this, 'postType_ajax' ));
        // add_action( 'wp_ajax_nopriv_postType_ajax', array($this, 'postType_ajax' ));
    }

    // REGISTER
    
    function register_post_type(){
        register_post_type( $this->post_type,
            array(
                'labels'            => array(
                    'menu_name'     => $this->pretty_name_plural,
                    'name'          => $this->pretty_name,
                    'add_new_item'  => 'Add New '.$this->pretty_name,
                    'singular_name' => $this->pretty_name,
                    'search_items'  => 'Search '.$this->pretty_name_plural,
                    'edit_item'     => 'Edit '.$this->pretty_name
                ),
                'description'   => $this->pretty_name.' Content',
                'hierarchical'  => true,
                'public'        => true,
                'exclude_from_search' => false,
                'has_archive'   => true,
                // SHOWS IN GUTENBERG
                'show_in_rest'  => true,
                'menu_icon'     => 'dashicons-carrot',
                'supports'      => array('title', 'editor', 'thumbnail', 'revisions'),
                'rewrite'       => array( 'slug' => $this->post_type_rewrite ),
            )
        );

        $labels = array(
            'name'              => $this->category_plural,
            'singular_name'     => $this->category_pretty,
            'search_items'      => 'Search '.$this->category_pretty,
            'all_items'         => 'All '.$this->category_plural,
            'parent_item'       => 'Parent '.$this->category_pretty,
            'parent_item_colon' => 'Parent '.$this->category_pretty.':',
            'edit_item'         => 'Edit '.$this->category_pretty,
            'update_item'       => 'Update '.$this->category_pretty,
            'add_new_item'      => 'Add New '.$this->category_pretty,
            'new_item_name'     => 'New '.$this->category_pretty.' Name',
            'menu_name'         => $this->category_pretty
        );

        $args = array(
            'hierarchical'      => true,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'show_in_rest'      => true,
            'rewrite'           => array( 'slug' => $this->category_rewrite ),
        );
        register_taxonomy( $this->category_slug, array($this->post_type), $args );
    }

    // META BOXES
    
    function register_fields(){
        // FIELD TYPES
        // https://www.advancedcustomfields.com/resources/
    
        if( ! function_exists('acf_add_local_field_group') )
            return;

        // array(
        //     'key' => $this->p.$this->post_type.'_text_field',
        //     'label' => 'Text Field',
        //     'name' => 'text_field',
        //     'type' => 'text',
        //     'instructions' => '',
        //     'required' => 0,
        // ),

        acf_add_local_field_group(array(
            'key' => 'custom_'.$this->post_type.'_meta_fields_acf',
            'title' => $this->pretty_name.' Fields',
            'fields' => array(
                array(
                    'key' => $this->p.$this->post_type.'_text_field',
                    'label' => 'Text Field',
                    'name' => 'text_field',
                    'type' => 'text',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_text_area',
                    'label' => 'Text Area',
                    'name' => 'text_area',
                    'type' => 'textarea',
                    'rows' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_email_field',
                    'label' => 'Email Field',
                    'name' => 'email_field',
                    'type' => 'email',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_url_field',
                    'label' => 'URL Field',
                    'name' => 'url_field',
                    'type' => 'url',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_image_field',
                    'label' => 'Image Field',
                    'name' => 'image_field',
                    'type' => 'image',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'library' => 'all',
                    'min_width' => '',
                    'min_height' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_file_field',
                    'label' => 'File Field',
                    'name' => 'file_field',
                    'type' => 'file',
                    'return_format' => 'array',
                    'library' => 'all',
                    'min_size' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_gallery_field',
                    'label' => 'Gallery Field',
                    'name' => 'gallery_field',
                    'type' => 'gallery',
                    'return_format' => 'array',
                    'preview_size' => 'medium',
                    'insert' => 'append',
                    'library' => 'all',
                    'min' => '',
                    'max' => '',
                    'min_width' => '',
                    'min_height' => '',
                    'min_size' => '',
                    'max_width' => '',
                    'max_height' => '',
                    'max_size' => '',
                    'mime_types' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_select_field',
                    'label' => 'Select Field',
                    'name' => 'select_field',
                    'type' => 'select',
                    'choices' => array(
                        'first' => 'First',
                        'second' => 'Second',
                    ),
                    'default_value' => 'first',
                    'allow_null' => 0,
                    'multiple' => 0,
                    'ui' => 1,
                    'ajax' => 0,
                    'return_format' => 'value',
                    'placeholder' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_checkbox_field',
                    'label' => 'Checkbox Field',
                    'name' => 'checkbox_field',
                    'type' => 'checkbox',
                    'choices' => array(
                        'true' => 'True',
                        'false' => 'False',
                    ),
                    'allow_custom' => 0,
                    'default_value' => array(
                        0 => 'true',
                    ),
                    'layout' => 'horizontal',
                    'toggle' => 0,
                    'return_format' => 'value',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_radio_field',
                    'label' => 'Radio Field',
                    'name' => 'radio_field',
                    'type' => 'radio',
                    'choices' => array(
                        'true' => 'True',
                        'false' => 'False',
                    ),
                    'allow_null' => 0,
                    'other_choice' => 0,
                    'default_value' => 'true',
                    'layout' => 'horizontal',
                    'return_format' => 'value',
                    'save_other_choice' => 0,
                ),
                array(
                    'key' => $this->p.$this->post_type.'_true_or_false',
                    'label' => 'True or False',
                    'name' => 'true_or_false',
                    'type' => 'true_false',
                    'message' => 'Message text',
                    'default_value' => 0,
                    'ui' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_page_link_field',
                    'label' => 'Page Link Field',
                    'name' => 'page_link_field',
                    'type' => 'link',
                    'return_format' => 'array',
                ),
                array(
                    'key' => $this->p.$this->post_type.'_post_object_field',
                    'label' => 'Post Object Field',
                    'name' => 'post_object_field',
                    'type' => 'post_object',
                    'post_type' => array(
                        0 => 'post',
                        1 => 'page',
                    ),
                    'taxonomy' => array(
                        0 => 'category:category_name',
                    ),
                    'allow_null' => 0,
                    'multiple' => 1,
                    'return_format' => 'id',
                    'ui' => 1,
                ),
                array(
                    'key' => $this->p.$this->post_type.'_page_link',
                    'label' => 'Page Link',
                    'name' => 'page_link',
                    'type' => 'page_link',
                    'post_type' => array(
                        0 => 'page',
                    ),
                    'taxonomy' => '',
                    'allow_null' => 0,
                    'allow_archives' => 1,
                    'multiple' => 0,
                ),
                array(
                    'key' => $this->p.$this->post_type.'_taxonomy_field',
                    'label' => 'Taxonomy Field',
                    'name' => 'taxonomy_field',
                    'type' => 'taxonomy',
                    'taxonomy' => 'category',
                    'field_type' => 'checkbox',
                    'add_term' => 0,
                    'save_terms' => 1,
                    'load_terms' => 0,
                    'return_format' => 'id',
                    'multiple' => 0,
                    'allow_null' => 0,
                ),
                array(
                    'key' => $this->p.$this->post_type.'_date_picker_field',
                    'label' => 'Date Picker Field',
                    'name' => 'date_picker_field',
                    'type' => 'date_picker',
                    'display_format' => 'm/d/Y',
                    'return_format' => 'm/d/Y',
                    'first_day' => 0,
                ),
                array(
                    'key' => $this->p.$this->post_type.'_repeater_field',
                    'label' => 'Repeater Field',
                    'name' => 'repeater_field',
                    'type' => 'repeater',
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add More',
                    'sub_fields' => array(
                        array(
                            'key' => $this->p.$this->post_type.'_repeater_title',
                            'label' => 'Title',
                            'name' => 'title',
                            'type' => 'text',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => $this->post_type,
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

    /* - - - - - - - - - - - - - - - - - - - - - - - - - -
    /* AJAX
    */

    function postType_ajax() {
        $html = '';
        $type = isset($_POST['type']) ? sanitize_text_field( wp_unslash($_POST['type'])) : '';

        $args = array(
            'post_type'      => $this->post_type,
            'posts_per_page' => -1,
            'order'          => 'ASC',       
        ); 

        if($type != 'all') {
            $args['cat'] = $type;
        }
        
        $ajax_results = new WP_Query($args);

        ob_start();
        
        echo '<div class="loader-wrap">';
            echo '<div class="loader">Loading...</div>';
        echo '</div>';

        if( $ajax_results->have_posts() ) : 

            while( $ajax_results->have_posts() ) : $ajax_results->the_post();
                get_template_part( 'templates/loop/loop', $this->post_type );
            endwhile; 
            wp_reset_postdata();

            else :
              echo '<div class="no-results">No results found.</div>';

        endif;

        $html .= ob_get_contents();
        ob_end_clean();

        echo wp_json_encode(array('html'=>$html));
        die();
    }
}