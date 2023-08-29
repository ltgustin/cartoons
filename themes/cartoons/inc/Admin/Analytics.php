<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('Analytics') ){
    trait Analytics {
        public function hooks(){
            add_action('wp_head', array($this,'ltg_gtm_data_and_dataLayer'));
            add_action('wp_body_open', array($this,'ltg_gtm_body_code'), 4);
        }

        /* - - - - - - - - - - - - - - - - - - - - - - - - - -
        /* DATA LAYER AND GTM CODE
        */
        public function ltg_gtm_data_and_dataLayer() {
            /* DATA LAYER */
            global $wp_query;

            $dataLayer = array();

            $dataLayer['ltg_gtm_PageTitle'] = get_the_title();
            $dataLayer['ltg_gtm_PageURL'] = get_permalink();

            if (is_singular()) {
                $dataLayer['ltg_gtm_PagePostType'] = get_post_type();
                $dataLayer['ltg_gtm_PageTemplate'] = "single";
                // cats
                $_post_cats = get_the_category();
                if ($_post_cats) {
                    foreach ($_post_cats as $_cat) {
                        $dataLayer['ltg_gtm_PageCategory'] = $_cat->slug;
                    }
                }
                // tags
                $_post_tags = get_the_tags();
                if ($_post_tags) {
                    foreach ($_post_tags as $_tag) {
                        $dataLayer['ltg_gtm_PageTags'] = $_tag->slug;
                    }
                }
            } //isSingluar

            if(class_exists( 'woocommerce' ) && is_product()) :
                global $post;
                $product = new WC_Product($post->ID);
                $product_stock = ($product->is_in_stock() ? 'in stock' : 'out of stock');
                $product_image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full');
                $product_desc = $this->ltg_excerpt(25);

                $dataLayer['ltg_gtm_ProductName'] = get_the_title();
                $dataLayer['ltg_gtm_ProductPrice'] = $product->get_price().' '.get_woocommerce_currency();
                $dataLayer['ltg_gtm_ProductSKU'] = $product->get_sku();
                $dataLayer['ltg_gtm_ProductStock'] = $product_stock;
                $dataLayer['ltg_gtm_ProductImage'] = $product_image[0];
                $dataLayer['ltg_gtm_ProductDescription'] = $product_desc;
                $dataLayer['ltg_gtm_ProductURL'] = get_the_permalink();
                $dataLayer['ltg_gtm_ProductBrand'] = ltg()->get_ltg_option('meta_site_owner');
            endif;

            echo '<!-- begin GTM Data Layer -->';
            echo '<script>';
            echo 'window.dataLayer = window.dataLayer || [];';
            echo 'window.dataLayer.push({';
            foreach ($dataLayer as $key => $val) :
                echo "'" . esc_html($key) . "':'" . esc_html($val) . "',";
            endforeach;
            echo '});';
            echo '</script>';
            echo '<!-- end GTM Data Layer -->';

            /* ANALYTICS TIME */
            if( ltg()->get_ltg_option('google_code') ):
                if( ltg()->get_ltg_option('gtm') ){
                    ?>
                    <!-- Google Tag Manager -->
                    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
                    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
                    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
                    })(window,document,'script','dataLayer','<?php echo esc_html(ltg()->get_ltg_option('google_code')); ?>');</script>
                    <!-- End Google Tag Manager -->
                    <?php
                } else {
                    ?>
                    <!-- Global site tag (gtag.js) - Google Analytics -->
                    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_html(ltg()->get_ltg_option('google_code')); ?>"></script>
                    <script>
                    window.dataLayer = window.dataLayer || [];
                    function gtag(){dataLayer.push(arguments);}
                    gtag('js', new Date());
                    gtag('config', '<?php echo esc_html(ltg()->get_ltg_option('google_code')); ?>');
                    </script>
                    <?php
                }

            endif;
        }
        
        public function ltg_gtm_body_code() {
            if( ltg()->get_ltg_option('google_code') && ltg()->get_ltg_option('gtm') ): ?>
                <!-- Google Tag Manager (noscript) -->
                <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo esc_html(ltg()->get_ltg_option('google_code')); ?>"
                height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
                <!-- End Google Tag Manager (noscript) -->
            <?php endif; 
        }
    } // trait
} // if trait