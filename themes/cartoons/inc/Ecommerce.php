<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('Ecommerce') ){
    trait Ecommerce {
        public function hooks(){
            // add_action('after_setup_theme', array($this, 'theme_setup_ecommerce'));
            // remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
            // add_action('woocommerce_before_main_content', array($this, 'custom_woocommerce_start'), 10);
            // remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);
            // add_action('woocommerce_after_main_content', array($this, 'custom_woocommerce_end'), 10);
            add_action('ltg_metadata_end', array($this, 'json_ld_ecommerce'));
        }

        // Declare support for WooCommerce
        public function theme_setup_ecommerce(){
            add_theme_support('woocommerce');
        }

        // Replace WooCommerce start wrapper
        public function custom_woocommerce_start(){
            echo '<section id="woocommerce" class="ltg-woocommerce">';
        }

        // Replace WooCommerce end wrapper
        public function custom_woocommerce_end(){
            echo '</section>';
        }

        // JSON-LD for Products
        public function json_ld_ecommerce(){
            if ( function_exists('is_product') && is_product() ){
                global $post;
                $product = new WC_Product($post->ID);

                $site_owner = ltg()->get_ltg_option('meta_site_owner');
                $meta_business_type = ltg()->get_ltg_option('meta_business_type');
                $meta_phone_number = ltg()->get_ltg_option('meta_phone_number');
                
                $meta_address_address = ltg()->get_ltg_option('meta_location_address');
                $meta_address_address2 = ltg()->get_ltg_option('meta_location_address2') ? ltg()->get_ltg_option('meta_location_address2') : '';
                $meta_address_city = ltg()->get_ltg_option('meta_location_city');
                $meta_address_state = ltg()->get_ltg_option('meta_location_state');
                $meta_address_zip = ltg()->get_ltg_option('meta_location_zip');
                $meta_address_country = ltg()->get_ltg_option('meta_location_country');

                $address_street = $meta_address_address2 ? $meta_address_address . ' ' . $meta_address_address2 : $meta_address_address;
                
                $excerpt = $this->ltg_excerpt(25);

                $company_type = ( $meta_business_type ) ? $meta_business_type : 'LocalBusiness';
                ?>
                <script type="application/ld+json">
                {
                    "@context": "http://schema.org/",
                    "@type": "Product",
                    "name": "<?php echo esc_html(get_the_title()); ?>",

                    <?php $post_thumbnail_meta = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>
                    "image": {
                        "@type": "ImageObject",
                        "url": "<?php echo esc_url($post_thumbnail_meta[0]); ?>",
                        "width": "<?php echo $post_thumbnail_meta[1]; ?>",
                        "height": "<?php echo $post_thumbnail_meta[2]; ?>"
                    },

                    "description": "<?php echo esc_html($excerpt); ?>",

                    "offers": {
                        "@type": "Offer",
                        "priceCurrency": "USD",
                        "price": "<?php echo esc_html($product->get_price()); ?>",
                        "itemCondition": "http://schema.org/NewCondition",
                        "availability": "<?php echo ( $product->is_in_stock() )? 'http://schema.org/InStock' : 'http://schema.org/OutOfStock'; ?>",
                        "seller": {
                            "@type": "<?php echo esc_html($company_type); ?>",
                            "name": "<?php echo ( $site_owner )? esc_html($site_owner) : get_bloginfo('name', 'display'); ?>",
                            "telephone": "+<?php echo esc_html($meta_phone_number); ?>",
                            <?php if ( $company_type === 'LocalBusiness' ): ?>
                                "priceRange": "",
                            <?php endif; 
                            if($meta_address) :
                            ?>
                            "address": {
                                "@type": "PostalAddress",
                                "streetAddress": "<?php echo esc_html($address_street); ?>",
                                "addressLocality": "<?php echo esc_html($meta_address_city); ?>",
                                "addressRegion": "<?php echo esc_html($meta_address_state); ?>",
                                "postalCode": "<?php echo esc_html($meta_address_zip); ?>",
                                "addressCountry": "<?php echo esc_html($meta_address_country); ?>"
                            }
                        <?php endif; ?>
                        }
                    }
                }
                </script>
                <?php
            }
        }
    } // trait
} // if trait