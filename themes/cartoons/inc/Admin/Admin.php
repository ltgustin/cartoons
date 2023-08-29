<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('Admin') ){
    require_once get_template_directory() . '/inc/Admin/SiteOptions.php';

    trait Admin {
        use SiteOptions { SiteOptions::hooks as SiteOptionHooks; }

        public function hooks(){
            $this->SiteOptionHooks();

            //All admin pages (including AJAX requests)
            if ( is_admin() ){
                // SVG
                add_filter('wp_check_filetype_and_ext', array($this, 'allow_svg_uploads'), 10, 4);
                add_filter('upload_mimes', array($this, 'additional_upload_mime_types'));
                add_filter( 'wp_prepare_attachment_for_js', array( $this, 'fix_admin_preview' ), 10, 3 );
                add_filter ('wp_prepare_attachment_for_js', array($this,'custom_image_sizes_for_js'), 10, 3  );
            }

            add_action('wp_before_admin_bar_render', array($this, 'remove_admin_bar_logo'), 0);
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* ABILITY TO ADD SVGs TO MEDIA LIBRARY
        */
        public function fix_admin_preview( $response, $attachment, $meta ) {
            if ( $response['mime'] === 'image/svg+xml' ) {
                $dimensions = $this->svg_dimensions( get_attached_file( $attachment->ID ) );
                if ( $dimensions ) {
                    $response = array_merge( $response, $dimensions );
                }

                $possible_sizes = apply_filters( 'image_size_names_choose', array(
                    'full'      => __( 'Full Size' ),
                    'thumbnail' => __( 'Thumbnail' ),
                    'medium'    => __( 'Medium' ),
                    'large'     => __( 'Large' ),
                ) );

                $sizes = array();

                foreach ( $possible_sizes as $size => $label ) {
                    $default_height = 2000;
                    $default_width  = 2000;

                    if ( 'full' === $size && $dimensions ) {
                        $default_height = $dimensions['height'];
                        $default_width  = $dimensions['width'];
                    }

                    $sizes[ $size ] = array(
                        'height'      => get_option( "{$size}_size_w", $default_height ),
                        'width'       => get_option( "{$size}_size_h", $default_width ),
                        'url'         => $response['url'],
                        'orientation' => 'portrait',
                    );
                }

                $response['sizes'] = $sizes;
                $response['icon']  = $response['url'];
            }
            return $response;
        }
        // FIXING DIMENSIONS
        protected function svg_dimensions( $svg ) {
            $svg    = @simplexml_load_file( $svg );
            $width  = 0;
            $height = 0;
            if ( $svg ) {
                $attributes = $svg->attributes();
                if ( isset( $attributes->width, $attributes->height ) ) {
                    $width  = floatval( $attributes->width );
                    $height = floatval( $attributes->height );
                } elseif ( isset( $attributes->viewBox ) ) {
                    $sizes = explode( ' ', $attributes->viewBox );
                    if ( isset( $sizes[2], $sizes[3] ) ) {
                        $width  = floatval( $sizes[2] );
                        $height = floatval( $sizes[3] );
                    }
                } else {
                    return false;
                }
            }

            return array(
                'width'       => $width,
                'height'      => $height,
                'orientation' => ( $width > $height ) ? 'landscape' : 'portrait'
            );
        }
        // Allow SVG files to be uploaded to the Media Library
        public function allow_svg_uploads($data = null, $file = null, $filename = null, $mimes = null){
            $filetype = wp_check_filetype($filename, $mimes);

            return array(
                'ext' => $filetype['ext'],
                'type' => $filetype['type'],
                'proper_filename' => $data['proper_filename']
            );
        }
        public function additional_upload_mime_types($mime_types){
            $mime_types['svg'] = 'image/svg+xml';
            $mime_types['svgz'] = 'image/svg+xml';
            return $mime_types;
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* REMOVING ADMIN BAR WP LOGO
        */
        public function remove_admin_bar_logo() {
            if ( is_admin_bar_showing() ){
                global $wp_admin_bar;
                $wp_admin_bar->remove_menu('wp-logo');
                $wp_admin_bar->remove_menu('customize');

                // disabled comments
                if($this->get_ltg_option('ltg_setting_CommentsOff')) :
                    $wp_admin_bar->remove_menu('comments');
                endif;
            }
        }

        public function custom_image_sizes_for_js( $response, $attachment, $meta ) {
            global $_wp_additional_image_sizes;
            foreach ( $_wp_additional_image_sizes as $size => $value ):
                if ( isset($meta['sizes'][$size]) ) {
                    $attachment_url = wp_get_attachment_url( $attachment->ID );
                    $base_url = str_replace( wp_basename( $attachment_url ), '', $attachment_url );
                    $size_meta = $meta['sizes'][ $size ];

                    $response['sizes'][ $size ] = array(
                        'height'        => $size_meta['height'],
                        'width'         => $size_meta['width'],
                        'url'           => $base_url . $size_meta['file'],
                        'orientation'   => $size_meta['height'] > $size_meta['width'] ? 'portrait' : 'landscape',
                    );
                }
            endforeach;
            return $response;
        }

    } // Admin trait
    
} // if admin
