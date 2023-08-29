<?php
if ( !defined('ABSPATH') ){ die(); } //Exit if accessed directly

if ( !trait_exists('SiteOptions') ){
	trait SiteOptions {
		public function hooks(){
			add_action( 'acf/init', array($this,'ltg_acf_theme_options_metabox') );
		}

		function ltg_acf_theme_options_metabox() {
			if ( ! function_exists( 'acf_add_options_page' ) )
					return;
			
			// REGISTER GENERAL SETTINGS
			acf_add_options_page(array(
				'page_title' 	=> 'General Settings',
				'menu_title'	=> 'Site Settings',
				'menu_slug' 	=> 'site-general-settings',
				'capability'	=> 'edit_posts',
				'redirect'		=> false,
				// 'icon_url' 		=> '',
			));
				
			// general settings
			if( function_exists('acf_add_local_field_group') ):
				acf_add_local_field_group(array(
					'key' => 'group_site_settings_id',
					'title' => 'Site Settings',
					'fields' => array(
						// GLOBAL
						array(
							'key' => 'field_61c8a06cf8c3d',
							'label' => 'Global',
							'type' => 'tab',
							'placement' => 'left',
							'endpoint' => 0,
						),
						array(
							'key' => 'google_code',
							'label' => 'Google Code',
							'name' => 'google_code',
							'type' => 'text',
						),
						array(
							'key' => 'gtm',
							'label' => 'Tracking Code Type',
							'name' => 'gtm',
							'type' => 'true_false',
							'instructions' => 'Use Google Tag Manager tracking code?',
							'default_value' => 0,
							'ui' => 1,
						),

						// SOCIAL MEDIA
						array(
							'key' => 'field_61c8a1c16f73e',
							'label' => 'Social Media',
							'name' => '',
							'type' => 'tab',
							'placement' => 'left',
							'endpoint' => 0,
						),
						array(
							'key' => 'social_f',
							'label' => 'Social Profiles - Facebook',
							'name' => 'social_f',
							'type' => 'url',
						),
						array(
							'key' => 'social_t',
							'label' => 'Social Profiles - Twitter',
							'name' => 'social_t',
							'type' => 'url',
						),array(
							'key' => 'social_l',
							'label' => 'Social Profiles - LinkedIn',
							'name' => 'social_l',
							'type' => 'url',
						),array(
							'key' => 'social_y',
							'label' => 'Social Profiles - YouTube',
							'name' => 'social_y',
							'type' => 'url',
						),array(
							'key' => 'social_i',
							'label' => 'Social Profiles - Instagram',
							'name' => 'social_i',
							'type' => 'url',
						),array(
							'key' => 'social_p',
							'label' => 'Social Profiles - Pinterest',
							'name' => 'social_p',
							'type' => 'url',
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'options_page',
								'operator' => '==',
								'value' => 'site-general-settings',
							),
						),
					),
					'menu_order' => 0,
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'active' => true,
					'show_in_rest' => 0,
				));

				// REGISTER ADMIN SETTINGS
				acf_add_options_sub_page(array(
					'page_title' 	=> 'Admin Settings',
					'menu_title'	=> 'Admin',
					'parent_slug'	=> 'site-general-settings',
				));

				// admin settings
				acf_add_local_field_group(array(
					'key' => 'group_admin_settings_id',
					'title' => 'Admin Options',
					'fields' => array(
						array(
							'key' => 'field_61c8add908850',
							'label' => 'Theme Colors - Primary',
							'name' => 'ltg_setting_colors_primary',
							'type' => 'color_picker',
							'default_value' => '#1E4079',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae119989b',
							'label' => 'Theme Colors - Secondary',
							'name' => 'ltg_setting_colors_secondary',
							'type' => 'color_picker',
							'default_value' => '#81BC09',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae1f9989c',
							'label' => 'Theme Colors - Tertiary',
							'name' => 'ltg_setting_colors_tertiary',
							'type' => 'color_picker',
							'default_value' => '#81BC09',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae339989d',
							'label' => 'Theme Colors - Black',
							'name' => 'ltg_setting_colors_black',
							'type' => 'color_picker',
							'default_value' => '#000000',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae409989e',
							'label' => 'Theme Colors - White',
							'name' => 'ltg_setting_colors_white',
							'type' => 'color_picker',
							'default_value' => '#ffffff',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae4e9989f',
							'label' => 'Theme Colors - Gray Light',
							'name' => 'ltg_setting_colors_gray',
							'type' => 'color_picker',
							'default_value' => '#eeeeee',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
						array(
							'key' => 'field_61c8ae5b998a0',
							'label' => 'Theme Colors - Gray Dark',
							'name' => 'ltg_setting_colors_gray_dark',
							'type' => 'color_picker',
							'default_value' => '#aaaaaa',
							'enable_opacity' => 0,
							'return_format' => 'string',
						),
					),
					'location' => array(
						array(
							array(
								'param' => 'options_page',
								'operator' => '==',
								'value' => 'acf-options-admin',
							),
						),
					),
					'menu_order' => 0,
					'label_placement' => 'top',
					'instruction_placement' => 'label',
					'active' => true,
					'show_in_rest' => 0,
				));
			endif;
		}

		public function get_ltg_option( $key = '', $default = false ) {
			return get_option('options_'.$key);
		}
	}
}