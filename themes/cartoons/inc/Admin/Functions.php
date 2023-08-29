<?php
if (!defined('ABSPATH')){ die(); } //Exit if accessed directly

if (!trait_exists('Functions')) {
    trait Functions {
        /**
        /* TABLE OF CONTENTS
        //
        THEME SETUP
            ADD THEME SUPPORTS
            HEADER SIZE
            IMAGE SIZES
            REGISTER NAV MENUS
        IMAGE SIZE NAME CHANGES
        LOGIN STYLE ENQUEUE
        ADDING SKIP LINK
        CUSTOM BODY CLASSES
        OPEN GRAPH SIZE
        REMOVE DASHBOARD METABOXES
        REMOVES APPEARANCE WIDGETS
        HIDE MENUS FROM NON-ADMIN
        SIDEBAR PARAMETERS
        POST TYPE ARCHIVE MENU ITEMS
        DISABLE COMMENTS - if checked
        GRAVITY FORMS
        CUSTOM EXCERPT
        YOAST BREADCRUMBS
        SOCIAL MEDIA GET
        ltg TITLE
        MODAL START
        MODAL END
        //
        */

        public function hooks() {
            add_action('after_setup_theme', array($this, 'theme_setup'));

            add_action('login_enqueue_scripts', array($this,'login_css_ltg'));

            add_action('wp_body_open', array($this,'ltg_skip_link'), 5);

            add_filter('body_class', array($this,'ltg_custom_body_classes'));

            add_action('admin_init', array($this, 'ltg_disable_comments_main'));
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);
            add_filter('comments_array', '__return_empty_array', 10, 2);
        }
        
        /**
        /* THEME SETUP
        */
        public function theme_setup() {
            load_theme_textdomain( 'ltg' );
            // ADD THEME SUPPORTS
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'html5', array('comment-list', 'comment-form', 'search-form', 'caption', 'gallery', 'script', 'style' ));
            add_theme_support( 'title-tag' );
            add_theme_support( 'automatic-feed-links' );
            // Add support for full and wide align images.
            add_theme_support( 'align-wide' );
            // Add support for editor styles.
            add_theme_support( 'editor-styles' );
            // Enqueue editor styles.
            add_editor_style( 'style-editor.css' );
            // Add support for responsive embedded content.
            add_theme_support( 'responsive-embeds' );

            add_post_type_support('page', array('excerpt')); // allow pages to have excerpts too !

            add_action('wp_dashboard_setup', array($this, 'remove_dashboard_metaboxes')); // removes dashboard widgets
            add_action('widgets_init', array($this,'unregister_default_widgets')); // removes some widgets

            // IMAGE SIZES
            // add_image_size('open_graph_small', 600, 315, 1);

            // REGISTER NAV MENUS
            register_nav_menus( array(
                'primary'   => __('Primary Menu', 'ltg' ),
            ));
        }

        /**
        /* LOGIN STYLE ENQUEUE
        */
        public function login_css_ltg() {
            wp_enqueue_style( 'custom_login', get_bloginfo('template_url').'/admin-styles.css' );
        }

        /**
        /* ADDING SKIP LINK
        */
        public function ltg_skip_link() {
            echo '<a class="skip-to-content screen-reader-text" href="#maincontent">' . esc_html__( 'Skip to the content', 'ltg' ) . '</a>';
        }

        /**
        /* CUSTOM BODY CLASSES
        */
        public function ltg_custom_body_classes( $classes ) {
            if (is_singular()) :
                $classes[] = 'singular';
                // ADD MORE HERE
            endif;

            return $classes;
        }

        /**
        /* REMOVE DASHBOARD METABOXES
        */
        public function remove_dashboard_metaboxes() {
            remove_meta_box('dashboard_primary', 'dashboard', 'side'); //Wordpress News
            remove_meta_box('dashboard_secondary', 'dashboard', 'side');
            remove_meta_box('dashboard_plugins', 'dashboard', 'normal');
            remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');
            remove_meta_box('dashboard_quick_press', 'dashboard', 'side');
            // remove_meta_box('dashboard_right_now', 'dashboard', 'normal');
            remove_meta_box('dashboard_activity', 'dashboard', 'normal');
            remove_action('welcome_panel', 'wp_welcome_panel');
        }

        /**
        /* REMOVES APPEARANCE WIDGETS
        */
        public function unregister_default_widgets() {
            unregister_widget('WP_Widget_Calendar');
            unregister_widget('WP_Widget_Archives');
            unregister_widget('WP_Widget_Links');
            unregister_widget('WP_Widget_Meta');
            unregister_widget('WP_Widget_Recent_Posts');
            unregister_widget('WP_Widget_Recent_Comments');
            unregister_widget('WP_Widget_Media_Audio');
            // unregister_widget('WP_Widget_Media_Video');
            unregister_widget('WP_Widget_RSS');
            unregister_widget('WP_Widget_Tag_Cloud');
        }

        /**
        /* DISABLE COMMENTS - if checked
        */
        public function ltg_disable_comments_main() {
            // Redirect any user trying to access comments page
            global $pagenow;
            
            if ($pagenow === 'edit-comments.php') {
                wp_redirect(admin_url());
                exit;
            }

            // Remove comments metabox from dashboard
            remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');

            // Disable support for comments and trackbacks in post types
            foreach (get_post_types() as $post_type) {
                if (post_type_supports($post_type, 'comments')) {
                    remove_post_type_support($post_type, 'comments');
                    remove_post_type_support($post_type, 'trackbacks');
                }
            }
        }

        /**
        /* YOAST BREADCRUMBS
        */
        public function ltg_yoast_breadcrumbs() {
            if (function_exists('yoast_breadcrumb')) : yoast_breadcrumb('<div class="crumbs container">','</div>'); endif;
        }

       /**
       /* ltg TITLE
       */
       public function ltg_title() {
            $intro_title = get_post_meta(get_the_ID(), '_ltg_custom_page_custom_heading',true);

            echo '<h1 class="intro-page-title">';
                if (is_singular()) {
                    if($intro_title) {
                        echo esc_html($intro_title);
                    } else {
                        echo esc_html(get_the_title());
                    }
                } elseif (is_search()) {
                    echo 'Search results for ';
                    echo '<span class="search-terms">"';
                    echo get_search_query();
                    echo '"</span>';
                // is taxonomy page
                } elseif (is_tax() || is_category() || is_tag()) {
                    echo single_term_title('',false);
                // post type archives
                } elseif (is_post_type_archive()) {
                    echo post_type_archive_title('', false);
                // blog page
                } elseif (is_home()) {
                    $posts_page = get_option( 'page_for_posts' );
                    $intro_title = get_post_meta($posts_page, '_ltg_custom_page_custom_heading',true);
                    if($intro_title) {
                        echo esc_html($intro_title);
                    } else {
                        echo esc_html(get_post($posts_page)->post_title);
                    }
                } elseif (is_404()) {
                    echo 'Page Not Found';
                } elseif (is_year()) {
                    echo get_the_date('Y');
                } elseif (is_month()) {
                    echo get_the_date('F Y');
                } elseif (is_day()) {
                    echo get_the_date();
                }
            echo '</h1>';
       }

        /**
        * MODAL START
        * id = the modal id, this allows you to have multiple on a page
        * titleText = the title. OPTIONAL ()
        * embed = adds a wrapping element around the body, allows for scalable iframes. the content should ONLY be a youtube/vimeo iframe
        * padding = false will remove padding - should only be used with embeds
        */
        public function ltg_modal_start($id='modal1', $titleText=null, $embed=false, $padding=true) {
            $titleID = '';

            $padding = $padding ? '' : 'no-padding ';

            if($titleText) :
                $titleID = str_replace(' ', '_', strtolower($titleText));
                $title = '<div class="modal__title" id="'.$titleID.'">'.$titleText.'</div>';
            endif;

            $start = '<div id="'.$id.'" class="modal" aria-hidden="true">';
            $start .= '<div class="modal__overlay" tabindex="-1" data-micromodal-close>';
                $start .= '<div class="'.$padding.'modal__container" role="dialog" aria-modal="true" aria-labelledby="'.$titleID.'">';
                // header
                if($titleText) :
                    $start .= $title;
                endif;

                $start .= '<button class="modal__close" aria-label="Close modal" data-micromodal-close>X</button>';

                $start .= '<div class="modal__content" id="'.$titleID.'_content">';

                if($embed) :
                    $start .= '<div class="iframe-container">';
                endif;

            return $start;
        }

        /**
        * MODAL END
        */
        public function ltg_modal_end($embed=false) {
            $end = '';
            if($embed) :
                $end .= '</div>';
            endif;
            $end .= '</div></div></div></div>';
            return $end;
        }

       /**
       /* HEX TO RGB
       */
        function hex2rgb($hex) {
            $hex = str_replace("#", "", $hex);

            if(strlen($hex) === 3) {
                $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            } else {
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
            }
            $rgb = array($r, $g, $b);
            return implode(",", $rgb); // returns the rgb values separated by commas
            // return $rgb; // returns an array with the rgb values
        }
    }
}