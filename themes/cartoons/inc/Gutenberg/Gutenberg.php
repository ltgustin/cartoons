<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('Gutenberg') ){
    trait Gutenberg {
        public function hooks(){
            if ( function_exists('register_block_type') ){
                add_action('after_setup_theme', array($this,'ltg_gutenberg_use_theme_colors'));

                add_action('init', array($this, 'cws_add_custom_block_styles'));
            }
        }

        function cws_add_custom_block_styles() {
            register_block_style('core/cover', [
                'name' => 'nopadding',
                'label' => 'No Padding',
            ]);
            register_block_style('core/cover', [
                'name' => 'noborder',
                'label' => 'No Border',
            ]);

            register_block_style('core/paragraph', [
                'name' => 'stat_small',
                'label' => 'Stat Small',
            ]);

            register_block_style('core/column', [
                'name' => 'padding',
                'label' => 'Padding',
            ]);
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* THEME COLORS OVERRIDE
        */
        function ltg_gutenberg_use_theme_colors() {
            add_theme_support( 'disable-custom-colors' );
            add_theme_support( 'disable-custom-gradients' );

            add_theme_support(
                'editor-gradient-presets',
                array(
                    array(
                        'name'     => 'Rainbow',
                        'gradient' => 'linear-gradient(to right, rgba(115,212,254,1) 0%, rgba(194,192,255,1) 50%, rgba(254,192,227,1) 100%)',
                        'slug'     => 'rainbow',
                    ),
                )
            );
            // add_theme_support('align-wide');

            add_theme_support(
                'editor-color-palette', array(
                    array(
                        'name'  => esc_html__( 'Primary', 'ltg' ),
                        'slug' => 'primary',
                        'color' => '#2B2263',
                    ),
                    array(
                        'name'  => esc_html__( 'Purple', 'ltg' ),
                        'slug' => 'purple',
                        'color' => '#C2C0FF',
                    ),
                    array(
                        'name'  => esc_html__( 'Blue', 'ltg' ),
                        'slug' => 'blue',
                        'color' => '#73D4FE',
                    ),
                    array(
                        'name'  => esc_html__( 'Pink', 'ltg' ),
                        'slug' => 'pink',
                        'color' => '#FEC0E3',
                    ),
                    array(
                        'name'  => esc_html__( 'White', 'ltg' ),
                        'slug' => 'white',
                        'color' => '#ffffff',
                    ),
                    array(
                        'name'  => esc_html__( 'Black', 'ltg' ),
                        'slug' => 'black',
                        'color' => '#2c2c2c',
                    ),
                    array(
                        'name'  => esc_html__( 'Gray', 'ltg' ),
                        'slug' => 'gray',
                        'color' => '#efefef',
                    ),
                )
            );

            add_theme_support( 'editor-font-sizes', array(
                array(
                    'name' => __( 'Small', 'ltg' ),
                    'size' => 14,
                    'slug' => 'small'
                ),
                array(
                    'name' => __( 'Regular', 'ltg' ),
                    'size' => 18,
                    'slug' => 'regular'
                ),
                array(
                    'name' => __( 'Large', 'ltg' ),
                    'size' => 20,
                    'slug' => 'large'
                ),
            ) );
        }
    } // gutenberg
} // if trait