<?php
if (!defined('ABSPATH')){ die(); } //Exit if accessed directly

if (!trait_exists('Functions_Custom')) {
    trait Functions_Custom {
       /*------------------------------------------
       >>> TABLE OF CONTENTS:
       --------------------------------------------
       # PRE GET POSTS
       # QUERY VARS
       # ARCHIVE TITLE
       # ARCHIVE FILTER
       ------------------------------------------*/

        public function hooks() {
            // add_action('pre_get_posts', array($this,'ltg_pre_get_posts'), 1);
            // add_filter('query_vars', array($this,'ltg_register_query_vars'));
        }

        /**
        /* RANDOM HEADER IMAGES
        */
        public function get_header_images() {
            $page_header_image = get_post_meta(get_the_ID(), '_ltg_custom_page_custom_image_id',true);

            $thumb = false;

            if($page_header_image) {
                $thumbarray = wp_get_attachment_image_src($page_header_image, 'full');
                $thumb = aq_resize($thumbarray[0], 1600, 250, true, true, true);
            } else {
                $thumb = get_header_image();
            }

            if(!$thumb) return;

            echo '<div class="top-header" style="background-image:url('.esc_url($thumb).');">';
                echo '<div class="container clearfix">';
                        ltg()->ltg_title();
                echo '</div>';
            echo '</div>';
        }
        
        /**
        /* PRE GET POSTS
        */
        function ltg_pre_get_posts($query) {
            if(is_admin() || !$query->is_main_query()) {
                return;
            }
            
            //blog
            if(is_home()) {
                // $query->set('post_type', array('post'));
                // $query->set('post__not_in', get_option('sticky_posts'));

                // if( !empty( get_query_var('cat'))) {
                //     $query->set('category__in', array(get_query_var('cat')));
                // }
            }
        }

        /**
        /* QUERY VARS
        */
        function ltg_register_query_vars( $vars ) {
            $vars[] .= 'cat';
            return $vars;
        }
       
        /**
        /* ARCHIVE TITLE
        */
        public function ltg_archive_title_and_content() {
            if(is_home()) {
                $archive_page = get_option( 'page_for_posts' );
            } else {
                $pt = get_queried_object()->name;
                // $archive_page = $this->get_ltg_option('archive_page_'.$pt);
            }

            $intro_title = $archive_page ? get_post_meta($archive_page, '_ltg_custom_page_custom_heading',true) : '';

            setup_postdata( $archive_page );
            
            echo '<h1 class="intro-page-title">';
                if($intro_title) {
                    echo wp_kses($intro_title, array('strong' => array()), '');
                } else {
                    echo post_type_archive_title('', false);
                }
            echo '</h1>';

            the_content();

            // reset
            wp_reset_postdata();
        }

        /**
        /* ARCHIVE FILTER
        */
        public function ltg_archive_filter($filter, $pt) {
            global $post;
            $query_var = '';

            // THE BLOG
            if($pt == 'post') {
                //
                // ltg_register_query_vars must be uncommented above in hooks()
                // 
                if( !empty( get_query_var('cat'))) :
                    $query_var = get_query_var('cat');
                endif;

                $categories = get_categories(array(
                    'orderby'       => 'menu_order',
                    'order'         => 'ASC',
                    'exclude'       => 1,
                    'hide_empty'    => true,
                ));

                if( $categories ) : 
                    echo '<div class="archive-filter-wrap">';
                        echo '<div class="archive-filter container '.$filter.'">';
                        foreach( $categories as $category ) :
                            $active = ($category->term_id == $query_var) ? ' active' : '';
                            echo '<button data-'.esc_attr($filter).'="'.$category->term_id.'" class="filter-btn'.$active.'" data-type="'.$pt.'"><span>'.esc_html($category->name).'</span></button>';
                        endforeach; 
                        echo '</div>';
                    echo '</div>';
                endif;
             } 
             // IF NEEDED, UNCOMMENT
             /*
             else {
                 if( !empty( get_query_var('CUSTOM_QUERY_VAR'))) :
                     $query_var = get_query_var('CUSTOM_QUERY_VAR');
                 endif;

                 $args = array(
                     'post_type'      => 'CPT_NAME',
                     'posts_per_page' => -1,
                     'orderby'        => 'menu_order',
                     'order'          => 'ASC',
                     'post_parent'    => 0
                 );
                 
                 $pt_query = new WP_Query($args);

                 if( $pt_query->have_posts() ) : 
                     echo '<div class="archive-filter-wrap">';
                         echo '<span class="dd-trigger"><span>Filter '.ucfirst($pt).'</span> <i class="icon-down"></i></span>';
                         echo '<div class="archive-filter container '.$filter.'">';
                             while( $pt_query->have_posts() ) : $pt_query->the_post();
                                 $active = ($query_var == $post->ID) ? ' active' : '';
                                 echo '<button data-'.esc_attr($filter).'="'.$post->ID.'" class="filter-btn'.$active.'" data-type="'.$pt.'"><span>'.esc_html(get_the_title()).'</span></button>';
                             endwhile; 
                         echo '</div>';
                     echo '</div>';
                 endif;
             }
             */
        }
    }
}