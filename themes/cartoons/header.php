<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <?php
    esc_url(get_template_part('inc/metadata'));
    wp_head();
    ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
<header class="header-wrap" role="banner">

  <div class="header container wide">

    <div class="logo">
        <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('name'); ?>">
            <?php echo esc_url(get_template_part('assets/svg/logo.svg')); ?>
        </a>
    </div>

    <!-- choose here - https://jonsuh.com/hamburgers -->
    <button class="hamburger hamburger--collapse" type="button" aria-label="Menu" aria-controls="navigation">
      <span class="hamburger-box">
        <span class="hamburger-inner"></span>
      </span>
    </button>

    <div class="nav-wrap">
        <?php
        echo '<nav aria-label="Primary Navigation" role="navigation">';
        if (has_nav_menu('primary')) {
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'main-nav nav',
                    'items_wrap'     => '<ul id="%1$s" class="%2$s" role="menubar">%3$s</ul>',
                )
            );
        }
        echo '</nav>';

        $homeId = get_option('page_on_front');
        $social_array = array(
            'opensea' => 'O',
            'twitter' => 'T',
            'discord' => 'D',
            'instagram' => 'I'
        );

        $social_media = get_field('social_media',$homeId);

        if($social_media) :
        echo '<ul class="social-nav nav">';
            foreach($social_array as $key=>$social) :
                $social_link = $social_media['social_'.$key];
                if($social_link) :
                    echo '<li><a class="'.esc_attr($social).'" target="_blank" href="'.esc_url($social_link).'"><span>'.esc_html($social).'</span></a></li>';
                endif;
            endforeach;
           echo '</ul>';
        endif;
        ?>
    </div>

    </div><!-- container -->

</header><!-- header -->

<a name="maincontent" id="maincontent"></a>

<main role="main" class="content-overflow">