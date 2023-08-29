<?php
if ( !defined('ABSPATH') ){ exit; } //Exit if accessed directly

if ( !class_exists('ltg') ){
	require_once get_template_directory() . '/inc/Assets.php';
	require_once get_template_directory() . '/inc/Admin/Admin.php';
	require_once get_template_directory() . '/inc/Admin/Analytics.php';
    require_once get_template_directory() . '/inc/Admin/Functions.php';
    require_once get_template_directory() . '/inc/Admin/Functions_Custom.php';
	require_once get_template_directory() . '/inc/Gutenberg/Gutenberg.php';
	require_once get_template_directory() . '/inc/Ecommerce.php';

	/* - - - - - - - - - - - - - - - - - - - - - - - - - -
	/* CLASSES
	*/
	$class_path = get_template_directory() . "/inc/PostTypes";
	foreach (glob($class_path . "/*.php") as $filename) {
		if( substr(basename($filename),0,1) === "_" ) continue;
		include $filename;
		preg_match('/(\w+)\.php/',$filename,$class_name);
		if($class_name = $class_name[1])$$class_name = new $class_name;
	}
	$vendor_path = get_template_directory() . "/inc/Vendor";
	foreach (glob($vendor_path . "/*.php") as $filename) {
		if( substr(basename($filename),0,1) === "_" ) continue;
		include $filename;
	}

	class ltg {
		use Assets { Assets::hooks as AssetsHooks; }
		use Admin { Admin::hooks as AdminHooks; }
		use Functions { Functions::hooks as FunctionsHooks; }
		use Functions_Custom { Functions_Custom::hooks as Functions_CustomHooks; }
        use Analytics { Analytics::hooks as AnalyticsHooks; }
		use Gutenberg { Gutenberg::hooks as GutenbergHooks; }
		use Ecommerce { Ecommerce::hooks as EcommerceHooks; }

		private static $instance;

		//Get active instance
		public static function instance(){
			if ( !self::$instance ){
				self::$instance = new ltg();
				self::$instance->hooks();
			}

			return self::$instance;
		}

		//Run action and filter hooks
		private function hooks(){
			$this->AssetsHooks();
			$this->FunctionsHooks();
			$this->Functions_CustomHooks();
			$this->AnalyticsHooks();
			$this->GutenbergHooks();

			if ( is_admin() || is_admin_bar_showing() ){
				$this->AdminHooks();
			}

			if ( class_exists( 'woocommerce' ) ) {
				$this->EcommerceHooks();
			}
		}
	}
}

function ltg(){
	return ltg::instance();
}
add_action('init', 'ltg', 1);