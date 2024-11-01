<?php
namespace ShoppCategoryShippingFilters\App;

/**
 * Class Main
 * @package Objectiv\App
 */
class Main extends \WordPress_SimpleSettings {
	var $prefix = '_scsf';

	public function __construct() {
		parent::__construct();

		// silence is golden
	}

	public function run() {
		add_action('shopp_calculate_shipping', array($this, 'filter_shipping_options'), 100, 2);
	}

	public function activate() {
		// silence is golden
	}

	public function deactivate() {
		// silence is golden
	}

	/**
	 * Adapted from System.php 322-360 v1.3.x
	 */
	function get_active_shipping_modules() {
		$Shipping = \Shopp::object()->Shipping;
		$active = shopp_setting('active_shipping');
		$shiprates = [];

		foreach ( $Shipping->active as $module_name => $module ) {

			if ( ! array_key_exists( $module_name, $active ) ) {
				continue;
			} // Not an activated shipping module, go to the next one

			// Setup shipping service shipping rate entries and settings
			if ( ! is_array( $active[ $module_name ] ) ) {
				$shiprates[ $module_name ] = array('module' => $module_name );
				$shiprates[ $module_name ]['label'] = $Shipping->modules[$module_name]->name;

				continue;
			}

			// Setup shipping calcualtor shipping rate entries and settings
			foreach ( $active[ $module_name ] as $id => $m ) {
				$setting               = "$module_name-$id";
				$shiprates[ $setting ] = array('module' => $setting );

				$module_setting = shopp_setting($setting);
				$shiprates[ $setting ]['label'] = $module_setting['label'];
			}
		}

		return $shiprates;
	}

	function filter_shipping_options(&$options, $Order) {
		$shipping_modules = $this->get_active_shipping_modules();
		$cart_categories = array();

		if ( shopp('cart','has-items') ) {
			while ( shopp('cart','items') ) {
				$categories = wp_get_post_terms( shopp('cartitem','get-product'), 'shopp_category' );

				foreach($categories as $cat) {
					$cart_categories[] = $cat->term_id;
				}
			}
		}

		foreach ( $shipping_modules as $module => $sm ) {
			$show_categories = $this->get_setting('catshow')[ $module ];
			$hide_categories = $this->get_setting('cathide')[ $module ];

			// If we have show categories but none of the items in the cart are in those categories, remove options
			if ( ! empty($show_categories) && empty( array_intersect( $cart_categories, $show_categories ) ) ) {
				$options = $this->remove_shipping_options($module, $options);

				continue;
			}

			// If we have hide categories and one or more items in the cart are in those categories, remove options
			if ( ! empty($hide_categories) && ! empty( array_intersect( $cart_categories, $hide_categories ) ) ) {
				$options = $this->remove_shipping_options($module, $options);

				continue;
			}
		}
	}

	function remove_shipping_options( $module, $options ) {
		reset($options);

		foreach ( $options as $key => $option )  {
			if ( stripos($key, $module) !== false ) {
				unset($options[$key]);
			}
		}

		return $options;
	}
}
