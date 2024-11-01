<?php
/**
 * Created by PhpStorm.
 * User: clifgriffin
 * Date: 7/18/17
 * Time: 12:07 PM
 */

namespace ShoppCategoryShippingFilters\App\Admin;

class Main {
	var $plugin_instance;
	var $active_shipping_modules;

	public function __construct( $plugin ) {
		$this->plugin_instance = $plugin;

		// silence is golden
	}

	public function run() {
		$this->active_shipping_modules = $this->plugin_instance->get_active_shipping_modules();

		add_action('admin_menu', array($this, 'admin_menu'), 100 );
		add_action('admin_enqueue_scripts', array($this, 'scripts') );
	}

	function admin_menu() {
		add_submenu_page( "shopp-orders", "Shopp Category Shipping Filters", "Shipping Filters", "shopp_settings_shipping", "shopp-category-shipping-filters", array($this, "admin_page") );
	}

	function scripts() {
	    if ( isset($_GET['page']) && $_GET['page'] == "shopp-category-shipping-filters" ) {
		    wp_register_script(  'scsf-select2', SCSF_URL . 'assets/js/select2/dist/js/select2.min.js', array(), '4.0.3' );
		    wp_enqueue_script('scsf-select2');

		    wp_register_style( 'scsf-select2-css', SCSF_URL . 'assets/js/select2/dist/css/select2.min.css', false, '4.0.3' );
		    wp_enqueue_style( 'scsf-select2-css' );

		    wp_register_script( 'scsf-admin', SCSF_URL . 'assets/js/shopp-category-shipping-filters.js', array('jquery', 'scsf-select2'), '1.0.0' );
		    wp_enqueue_script('scsf-admin');
        }
	}

	/**
	 * Render Settings View
	 */
	function admin_page() {
		$categories = shopp_product_categories();
		?>
		<div class="wrap">
			<h2>Shopp Category Shipping Filters</h2>

			<form name="settings" id="mg_gwp" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
				<?php $this->plugin_instance->the_nonce(); ?>

				<table class="form-table">
					<tbody>
					<?php foreach( $this->active_shipping_modules as $id => $module ): $shipping = shopp_setting($id); ?>
					<tr>
						<th scope="row" valign="top">
							<?php echo $module['label']; ?>
						</th>
						<td>
                            <p style="margin-bottom: 20px;">
                                <label>
                                    <select class="scsf-select2" type="text" name="<?php echo $this->plugin_instance->get_field_name("catshow"); ?>[<?php echo $id; ?>][]" multiple="multiple">
                                        <?php foreach( $categories as $cat ): $selected = ''; ?>
                                            <?php if ( in_array( $cat->term_id, $this->plugin_instance->get_setting("catshow")[$id] ) ) $selected = "selected='selected'"; ?>
                                            <option value="<?php echo $cat->term_id; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
                                        <?php endforeach; ?>
                                    </select><br/>
                                    Show only for these product categories.
                                </label>
                            </p>

                            <p>
                                <label>
                                    <select class="scsf-select2" type="text" name="<?php echo $this->plugin_instance->get_field_name("cathide"); ?>[<?php echo $id; ?>][]" multiple="multiple">
										<?php foreach( $categories as $cat ): $selected = ''; ?>
											<?php if ( in_array( $cat->term_id, $this->plugin_instance->get_setting("cathide")[$id] ) ) $selected = "selected='selected'"; ?>
                                            <option value="<?php echo $cat->term_id; ?>" <?php echo $selected; ?>><?php echo $cat->name; ?></option>
										<?php endforeach; ?>
                                    </select><br/>
                                    Hide for these product categories.
                                </label>
                            </p>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>

				<?php submit_button('Save'); ?>
			</form>
		</div>
		<?php
	}
}
