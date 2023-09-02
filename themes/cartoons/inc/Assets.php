<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('Assets') ){
    trait Assets {
        public function hooks(){
            //Register styles/scripts
            add_action('init', array($this, 'registerScripts'));

            //Enqueue styles/scripts
            add_action('wp_enqueue_scripts', array($this, 'ltgEnqueueScripts'));
            add_action('admin_enqueue_scripts', array($this, 'ltg_admin_enqueue_scripts'));
            // block editor js
            add_action('enqueue_block_editor_assets', array($this,'ltg_gutenberg_scripts'));
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* REGISTER SCRIPTS / STYLES
        */
        public function registerScripts(){
            // this is to register the script/style, and then call it later dynamically (if needed) in enqueue_scripts

            $theme_version = wp_get_theme()->get( 'Version' );

            //Stylesheets
            wp_register_style( 'ltg-style', get_template_directory_uri() . '/dist/css/style.css', array(), $theme_version );
            wp_register_style( 'ltg-print-style', get_template_directory_uri() . '/print.css', null, $theme_version, 'print' );
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* ENQUEUE SCRIPTS / STYLES
        */
        public function ltgEnqueueScripts($hook){
            global $wp_query;
            $theme_version = wp_get_theme()->get( 'Version' );

            //Stylesheets
            wp_enqueue_style('ltg-style');
            wp_enqueue_style('ltg-print-style');

            $ltg_google_fonts = ltg()->get_ltg_option('ltg_setting_fonts_google');
            $ltg_adobe_fonts = ltg()->get_ltg_option('ltg_setting_fonts_adobe');

            if($ltg_google_fonts !== '') :
                wp_enqueue_style('ltg-google-fonts', $ltg_google_fonts, false);
            endif;

            if($ltg_adobe_fonts !== '') :
                wp_enqueue_style('ltg-adobe-fonts', $ltg_adobe_fonts, false);
            endif;

            // if there is a better spot / place for this - lets move it
            wp_enqueue_script( 'jquery' );

            if ( !is_admin() ) {
                wp_enqueue_script( 'ltg-header', get_bloginfo( 'template_url' ).'/dist/js/header-scripts.min.js' );
                wp_enqueue_script( 'ltg-footer', get_bloginfo( 'template_url' ).'/dist/js/scripts.min.js', 'jquery', $theme_version, true );
                wp_localize_script( 'ltg-header', 'bloginfo', array(
                    'url'           => home_url(),
                    'template_url'  => get_stylesheet_directory_uri(),
                    'ajax_url'      => admin_url('admin-ajax.php'),
                    'posts'         => json_encode( $wp_query->query_vars ),
                    'current_page'  => $wp_query->query_vars['paged'] ? $wp_query->query_vars['paged'] : 1,
                    'max_page'      => $wp_query->max_num_pages,
                    'xapi'          => XAPIKEY,
                    'xcontract'     => XCONTRACT
                ));
            }
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* GUTENBERG SCRIPTS
        */
        public function ltg_gutenberg_scripts() {
            wp_enqueue_script(
                'ltg_gutenberg_editor', 
                get_stylesheet_directory_uri() . '/assets/js/editor.js', 
                array( 'wp-blocks', 'wp-dom-ready', 'wp-edit-post' )
            );
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* ADMIN STYLES & SCRIPTS
        */
        public function ltg_admin_enqueue_scripts($hook) {
            $theme_version = wp_get_theme()->get( 'Version' );

            wp_register_style( 'ltg_custom_admin_styles', get_template_directory_uri() . '/admin-styles.css', false, $theme_version );
            wp_enqueue_style( 'ltg_custom_admin_styles' );

            wp_register_script( 'ltg_custom_admin_scripts', get_template_directory_uri() . '/assets/js/admin-scripts.min.js', false, $theme_version, true );
            wp_enqueue_script( 'ltg_custom_admin_scripts' );
        }
    } // trait
} // if trait