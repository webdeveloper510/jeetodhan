<?php
/**
 * /** The plugin main file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wpinstitut.com/
 * @since             1.0
 * @package           Competitions_for_woocommerce
 *
 * @wordpress-plugin
 * Plugin Name:       Competitions for WooCommerce
 * Plugin URI:        https://woocommerce.com/products/competitions-for-woocommerce/
 * Description:       Competitions for WooCommerce implements competitions (lucky draws / lotteries) product type in your WooCommerce webshop
 * Version:           1.2
 * Author:            WPInstitut
 * Author URI:        https://woocommerce.com/vendor/wpinstitut-com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       competitions_for_woocommerce
 * Domain Path:       /languages
 * WC requires at least: 4.0
 * WC tested up to: 8.0
 * Woo: 18734001141186:652b21ed64f7c85711b476664c3d0eb8
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_VERSION' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_VERSION', '1.2' );
}
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_DB_VERSION' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_DB_VERSION', '1.0.0' );
}
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_WP' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_WP', '4.0' );
}
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_PHP' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_PHP', '5.5' );
}
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_WC' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_MIN_WC', '4.0' );
}
if ( ! defined( 'COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_FILE' ) ) {
	define( 'COMPETITIONS_FOR_WOOCOMMERCE_PLUGIN_FILE', __FILE__ );
}

if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
	/**
	 * The code that runs during plugin activation.
	 * This action is documented in includes/class-competitions_for_woocommerce-activator.php
	 */
	function activate_competitions_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-competitions_for_woocommerce-activator.php';
		Competitions_For_Woocommerce_Activator::activate();
	}

	/**
	 * The code that runs during plugin deactivation.
	 * This action is documented in includes/class-competitions_for_woocommerce-deactivator.php
	 */
	function deactivate_competitions_for_woocommerce() {
		require_once plugin_dir_path( __FILE__ ) . 'includes/class-competitions_for_woocommerce-deactivator.php';
		Competitions_For_Woocommerce_Deactivator::deactivate();
	}

	register_activation_hook( __FILE__, 'activate_competitions_for_woocommerce' );
	register_deactivation_hook( __FILE__, 'deactivate_competitions_for_woocommerce' );

	/**
	 * The core plugin class that is used to define internationalization,
	 * admin-specific hooks, and public-facing site hooks.
	 */
	require plugin_dir_path( __FILE__ ) . 'includes/class-competitions_for_woocommerce.php';

	/**
	 * Begins execution of the plugin.
	 *
	 * Since everything within the plugin is registered via hooks,
	 * then kicking off the plugin from this point in the file does
	 * not affect the page life cycle.
	 *
	 * @since    2.0.0
	 */
	function run_competitions_for_woocommerce() {
		global $competitions_for_woocommerce;

		$competitions_for_woocommerce = CFW();
		CFW()->run();
	}

	add_action( 'woocommerce_init', 'run_competitions_for_woocommerce' );
	add_action( 'elementor_pro/init', 'competition_for_woocommerce_load_elementor_support');

	function CFW() {
		return Competitions_For_Woocommerce::instance();
	}



	function competition_for_woocommerce_load_elementor_support() {
		require_once plugin_dir_path(  __FILE__  ) . 'includes/elementor/competitions.php' ;
	}

} else {
	add_action( 'admin_notices', 'competitions_for_woocommerce_error_notice' );
	/**
	 * Display error message if WooCommerce isn't active.
	 */
	function competitions_for_woocommerce_error_notice() {
		global $current_screen;
		if ( 'plugins' === $current_screen->parent_base ) {
			echo '<div class="error"><p>Competitions for WooCommerce ';
			$adminurl = admin_url( 'plugin-install.php?tab=search&type=term&s=WooCommerce' );
			echo wp_kses_post( sprintf( __( 'requires <a href="http://www.woothemes.com/woocommerce/" target="_blank">WooCommerce</a> to be activated in order to work. Please install and activate <a href="#s" target="_blank">WooCommerce</a> first.', 'competitions-for-woocommerce' ), esc_url( $adminurl ) ) );
			echo '</p></div>';
		}
	}

	$custom_plugin = plugin_basename( __FILE__ );

	include_once ABSPATH . 'wp-admin/includes/plugin.php';

	if ( is_plugin_active( $custom_plugin ) ) {
		deactivate_plugins( $custom_plugin );
	}

	if ( isset( $_GET['activate'] ) ) {
		unset( $_GET['activate'] );
	}
}

if ( ! function_exists( 'woocommerce_quantity_input' ) ) {
	/**
	 * Output the quantity input for add to cart forms.
	 *
	 * @param  array           $args Args for the input.
	 * @param  WC_Product|null $product Product.
	 * @param  boolean         $echo Whether to return or echo|string.
	 *
	 * @return string
	 */

	function woocommerce_quantity_input( $args = array(), $product = null, $echo = true ) {
		if ( is_null( $product ) ) {
			$product = $GLOBALS['product'];
		}
		$defaults = array(
			'input_id'     => uniqid( 'quantity_' ),
			'input_name'   => 'quantity',
			'input_value'  => '1',
			'classes'      => apply_filters( 'woocommerce_quantity_input_classes', array( 'input-text', 'qty', 'text' ), $product ),
			'max_value'    => apply_filters( 'woocommerce_quantity_input_max', -1, $product ),
			'min_value'    => apply_filters( 'woocommerce_quantity_input_min', 0, $product ),
			'step'         => apply_filters( 'woocommerce_quantity_input_step', 1, $product ),
			'pattern'      => apply_filters( 'woocommerce_quantity_input_pattern', has_filter( 'woocommerce_stock_amount', 'intval' ) ? '[0-9]*' : '' ),
			'inputmode'    => apply_filters( 'woocommerce_quantity_input_inputmode', has_filter( 'woocommerce_stock_amount', 'intval' ) ? 'numeric' : '' ),
			'product_name' => $product ? $product->get_title() : '',
			'placeholder'  => apply_filters( 'woocommerce_quantity_input_placeholder', '', $product ),
			'readonly'     => false,
		);

		$args = apply_filters( 'woocommerce_quantity_input_args', wp_parse_args( $args, $defaults ), $product );

		// Apply sanity to min/max args - min cannot be lower than 0.
		$args['min_value'] = max( $args['min_value'], 0 );
		$args['max_value'] = 0 < $args['max_value'] ? $args['max_value'] : '';

		// Max cannot be lower than min if defined.
		if ( '' !== $args['max_value'] && $args['max_value'] < $args['min_value'] ) {
			$args['max_value'] = $args['min_value'];
		}
		$type = $args['min_value'] > 0 && $args['min_value'] === $args['max_value'] ? 'hidden' : 'number';
		$type = $args['readonly'] && 'hidden' !== $type ? 'text' : $type;
		/**
		 * Controls the quantity input's type attribute.
		 *
		 * @since 7.4.0
		 *
		 * @param string $type A valid input type attribute value, usually 'number' or 'hidden'.
		 */
		$args['type'] = apply_filters( 'woocommerce_quantity_input_type', $type );

		ob_start();

		if ( get_post_meta( $product->get_id() , '_competition_use_pick_numbers', true ) === 'yes' && 'yes' !== get_post_meta( $product->get_id() , '_competition_pick_numbers_random', true ) && 'qty_dip' !==$args['input_id'] ) {
			echo '<div class="quantity">
				<input type="hidden" id="' . esc_attr( $args['input_id'] ) . '" class="qty" name="' . esc_attr( $args['input_name'] ) . '" value="' . esc_attr($args['input_value']) . '" />
				' . esc_html( $args['input_value'] ) . '
			</div>';
		} else {
			wc_get_template( 'global/quantity-input.php', $args );
		}


		if ( $echo ) {
			echo wp_kses( ob_get_clean() , array( 'a' => array('href' => true, 'title' => true), 'label' => array('class' => array() , 'for' => array() ),  'div' => array( 'class' => array() ),'p' => array() , 'input' => array( 'type' => array(), 'name' => array(), 'value' => array(), 'checked' => array(), 'id' => array(), 'class' => array(), 'max' => array() , 'min' => array(), 'step' => array(), 'title' => array(), 'size' => array(), 'placeholder' => array(), 'inputmode' => array(), 'autocomplete' => array() ) ) );
		} else {
			return ob_get_clean();
		}
	}
}
