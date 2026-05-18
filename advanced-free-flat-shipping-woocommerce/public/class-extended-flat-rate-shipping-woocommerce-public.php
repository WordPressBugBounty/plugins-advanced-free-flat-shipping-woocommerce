<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class Extended_Flat_Rate_Shipping_Woocommerce_Public {

	private $plugin_name;
	
	private $version;

	public $shipping_method;
	
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'woocommerce_shipping_init', array( $this, 'initShippingMethod' ) );

		add_action( 'woocommerce_shipping_methods', array( $this, 'registerShippingMethod' ) );

		/**
		 * we have to force it to non react based page for cod setting so we can inject our shipping method in cod shipping settings. Because currently woocommerce is not providing any filter to add custom shipping method in cod settings in react based page.
		 */
		add_filter( 'experimental_woocommerce_admin_payment_reactify_render_sections', array( $this, 'force_legacy_setting_page' ) );
		add_filter( 'woocommerce_settings_api_form_fields_cod', array( $this, 'add_cod_settings' ) );

	}

	public function registerShippingMethod( $methods ) {

		if ( class_exists( 'Efrs_Shipping_Method' ) ) {
			$methods[] = 'Efrs_Shipping_Method';
		}

		return $methods;
	}

	public function initShippingMethod() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-efrs-shipping-methods.php';
		$this->shipping_method = new Efrs_Shipping_Method();
	}

	
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/extended-flat-rate-shipping-woocommerce-public.css', array(), $this->version, 'all' );

	}

	
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/extended-flat-rate-shipping-woocommerce-public.js', array( 'jquery' ), $this->version, false );

	}

	function force_legacy_setting_page( $sections ) {
		if(!is_array($sections)){
			return $sections;
		}
		
		return array_diff( $sections, array( 'cod' ) );
	} 

	function add_cod_settings( $fields ) {
	
		if ( isset( $fields['enable_for_methods']['options']['Extended Flat Rate Shipping'] ) ) {
			$shipping_methods = get_posts(array(
				'post_type'   => 'pi_shipping_method',
				'posts_per_page' => -1
			));
			if(is_array($shipping_methods)){
				foreach($shipping_methods as $method){
					$fields['enable_for_methods']['options']['Extended Flat Rate Shipping']['pisol_extended_flat_shipping:'.$method->ID] = $method->post_title;
				}
			}
		}

		return $fields;
	} 

}

if(!function_exists('pisol_hideShippingMethodInBackendMenu')){
function pisol_hideShippingMethodInBackendMenu( $section){
	unset($section['pisol_extended_flat_shipping']);
	return $section ;
}
add_filter('woocommerce_get_sections_shipping','pisol_hideShippingMethodInBackendMenu',10);
}