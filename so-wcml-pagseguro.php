<?php
/**
 * Plugin Name: SO WCML PagSeguro
 * Plugin URI: http://github.com/senlin/so-wcml-pagseguro
 * Description: Fork of WooCommerce PagSeguro plugin. The original plugin is not suitable when used with WCML (WooCommerce Multilingual); unfortunately author is not cooperative to make his plugin suitable for use in a multilingual environment, hence the reason to fork his plugin and remove the unnecessary errors it throws when used in such an environment.
 * Author: Forked by Piet Bos, Original work by Claudio Sanches, Gabriel Reguly
 * Version: 20141214 (fork of 2.7.4)
 * License: GPLv2 or later
 * Text Domain: woocommerce-pagseguro
 * Domain Path: languages/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * This function checks whether WPML is active (WPML needs to be active for this to have any use)
 * and gives a warning message with link to WPML if it is not active.
 *
 * modified using http://wpengineer.com/1657/check-if-required-plugin-is-active/ and the _no_wpml_warning function
 *
 * @since 20141214
 */

$plugins = get_option( 'active_plugins' );

$required_plugin = 'sitepress-multilingual-cms/sitepress.php';

// multisite throws the error message by default, because the plugin is installed on the network site, therefore check for multisite
if ( ! in_array( $required_plugin , $plugins ) && ! is_multisite() ) {

	add_action( 'admin_notices', 'so_no_wpml_warning' );

}

if ( ! function_exists( 'so_no_wpml_warning' ) ) {
	function so_no_wpml_warning() {
	    
	    // display the warning message
	    echo '<div class="message error"><p>';
	    
	    printf( __( 'The <strong>SO WCML PagSeguro plugin</strong> only works if you have the <a href="%s">WPML</a> plugin installed.', 'so-wcml-pagseguro' ), 
	        'http://senl.in/buyWPML' );
	    
	    echo '</p></div>';
	    
	    // and deactivate the plugin
	    deactivate_plugins( plugin_basename( __FILE__ ) );
	}
}

if ( ! class_exists( 'WC_PagSeguro' ) ) :

/**
 * WooCommerce PagSeguro main class.
 */
class WC_PagSeguro {

	/**
	 * Plugin version.
	 *
	 * @var string
	 */
	const VERSION = '2.7.4';

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin public actions.
	 */
	private function __construct() {
		// Load plugin text domain
		add_action( 'init', array( $this, 'load_plugin_textdomain' ) );

		// Checks with WooCommerce is installed.
		if ( class_exists( 'WC_Payment_Gateway' ) ) {
			$this->includes();

			add_filter( 'woocommerce_payment_gateways', array( $this, 'add_gateway' ) );
			add_filter( 'woocommerce_available_payment_gateways', array( $this, 'hides_when_is_outside_brazil' ) );
		} else {
			add_action( 'admin_notices', array( $this, 'woocommerce_missing_notice' ) );
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Get templates path.
	 *
	 * @return string
	 */
	public static function get_templates_path() {
		return plugin_dir_path( __FILE__ ) . 'templates/';
	}

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 */
	public function load_plugin_textdomain() {
		$locale = apply_filters( 'plugin_locale', get_locale(), 'woocommerce-pagseguro' );

		load_textdomain( 'woocommerce-pagseguro', trailingslashit( WP_LANG_DIR ) . 'woocommerce-pagseguro/woocommerce-pagseguro-' . $locale . '.mo' );
		load_plugin_textdomain( 'woocommerce-pagseguro', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
	}

	/**
	 * Includes.
	 *
	 * @return void
	 */
	private function includes() {
		include_once 'includes/class-wc-pagseguro-xml.php';
		include_once 'includes/class-wc-pagseguro-api.php';
		include_once 'includes/class-wc-pagseguro-gateway.php';
	}

	/**
	 * Add the gateway to WooCommerce.
	 *
	 * @param   array $methods WooCommerce payment methods.
	 *
	 * @return  array          Payment methods with PagSeguro.
	 */
	public function add_gateway( $methods ) {
		$methods[] = 'WC_PagSeguro_Gateway';

		return $methods;
	}

	/**
	 * WooCommerce fallback notice.
	 *
	 * @return  string
	 */
	public function woocommerce_missing_notice() {
		echo '<div class="error"><p>' . sprintf( __( 'WooCommerce PagSeguro Gateway depends on the last version of %s to work!', 'woocommerce-pagseguro' ), '<a href="http://wordpress.org/extend/plugins/woocommerce/">' . __( 'WooCommerce', 'woocommerce-pagseguro' ) . '</a>' ) . '</p></div>';
	}

	/**
	 * Hides the PagSeguro with payment method with the customer lives outside Brazil.
	 *
	 * @param   array $available_gateways Default Available Gateways.
	 *
	 * @return  array                     New Available Gateways.
	 */
	public function hides_when_is_outside_brazil( $available_gateways ) {

		// Remove PagSeguro gateway.
		if ( isset( $_REQUEST['country'] ) && 'BR' != $_REQUEST['country'] ) {
			unset( $available_gateways['pagseguro'] );
		}

		return $available_gateways;
	}
}

add_action( 'plugins_loaded', array( 'WC_PagSeguro', 'get_instance' ), 0 );

endif;
