<?php
/*
Plugin Name: Shopp Category Shipping Filters
Plugin URI: https://objectiv.co
Description:  Allows filtering of shipping options based on the categories cart items belong to.
Version: 2.0.1
Author: Clifton H. Griffin
Author URI: https://objectiv.co
*/

namespace ShoppCategoryShippingFilters;

define('SCSF_PATH', dirname(__FILE__));
define('SCSF_URL', plugins_url('/', __FILE__));
define('SCSF_VERSION', '2.0.0');

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Composer Include
 */
require dirname( __FILE__ ) . '/vendor/autoload.php';

/**
 * Autoloader
 */
require_once 'lib/autoload.php';

/* Main Plugin Class */
$Shopp_Category_Shipping_Filters = new App\Main();
$Shopp_Category_Shipping_Filters->run();

/*
 * Register hooks that are fired when the plugin is activated or deactivated.
 * When the plugin is deleted, the uninstall.php file is loaded.
 */
register_activation_hook( __FILE__, array( $Shopp_Category_Shipping_Filters, 'activate' ) );
register_deactivation_hook( __FILE__, array( $Shopp_Category_Shipping_Filters, 'deactivate' ) );

/* Start The Main Plugin Class */
add_action( 'plugins_loaded', array( $Shopp_Category_Shipping_Filters, 'run' ) );

/*----------------------------------------------------------------------------*
 * Dashboard and Administrative Functionality
 *----------------------------------------------------------------------------*/
if ( is_admin() && ! wp_doing_ajax() ) {
	add_action('shopp_init', function() {
		global $Shopp_Category_Shipping_Filters_Admin, $Shopp_Category_Shipping_Filters;

		$Shopp_Category_Shipping_Filters_Admin = new App\Admin\Main( $Shopp_Category_Shipping_Filters );
		$Shopp_Category_Shipping_Filters_Admin->run();
	});
}
