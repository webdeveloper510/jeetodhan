<?php

/**
 * The plugin bootstrap file
 *
 *
 * @link              https://wpgenie.org
 * @since             1.0
 * @package           woocommerce_lottery_progress_bar_in_loop
 *
 * @wordpress-plugin
 * Plugin Name:       WooCommere Lottery Progress Bar in Product Loop
 * Plugin URI:        https://wpgenie.org/
 * Description:       Progress bar in product loop for WooCommerce Lottery and Pick Number Mod addon.
 * Version:           1.0
 * Requires at least: 4.0
 * Tested up to: 	  7.5
 * Author:            wpgenie
 * Author URI:        https://wpgenie.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woocommerce_lottery_progress_bar_in_loop
 * Domain Path:       /languages
 * WC requires at least: 4.0
 * WC tested up to:  7.5
 *  
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;}



// Checks if the WooCommerce, WooCommerce Lottery and WooCommerce Lottery Pick Number are installed and active.
if (  	in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )  && 
		in_array( 'woocommerce-lottery/wc-lottery.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) //&&
		//in_array( 'woocommerce-lottery-pick-number/wc-lottery-pn.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) )
	) {

	// Comment out line below if you don't want progress bar to be displayed			
	add_action( 'woocommerce_after_shop_loop_item', 'wpgenie_pbinl_show_progress_bar_in_loop', 1 );

	// Comment out line below if you don't want countdown timer to be displayed
	add_action( 'woocommerce_after_shop_loop_item_title','wpgenie_pbinl_show_counter_in_loop', 15 );
	

	add_action( 'wp_enqueue_scripts', 'wpgenie_pbinl_customization_css', 1 );
	

} else {
	
	$plugin = plugin_basename( __FILE__ );
	if ( function_exists('is_plugin_active') && is_plugin_active( $plugin ) ) {
		deactivate_plugins( $plugin );
	}
	
	add_action( 'admin_notices', 'wc_lottery_customization_error_notice' );

	function wc_lottery_customization_error_notice() {

		global $current_screen;
		if ( $current_screen->parent_base == 'plugins' ) {
			echo '<div class="error"><p>WooCommere Lottery Progress Bar in Product Loop needs ' . __( 'requires <a href="https://codecanyon.net/item/woocommerce-lottery-wordpress-prizes-and-lotteries/15075983" target="_blank">WooCommerce Lottery</a> and <a href="https://wpgenie.org/product/woocommerce-lottery-pick-ticket-number-mod/" target="_blank">Pick Number Mod addon</a> to be activated first in order to work.', 'woocommerce_lottery_customization' ) . '</p></div>';
		}
	}
}



function wpgenie_pbinl_customization_css() {
	wp_enqueue_style('main-styles', plugin_dir_url( __FILE__ ) . 'pbinl-style.css', array(), '1.0');
}



function wpgenie_pbinl_show_counter_in_loop(){

	global $product;

	$time = '';

	if(!isset ($product))
		return;
	if('lottery' != $product->get_type())
		return;

	$timetext = __('Time left', 'wc_lottery');

	if(!$product->is_started()){
		$timetext = __('Starting in', 'wc_lottery');
		$counter_time = $product->get_seconds_to_lottery();
	} else{
		$counter_time = $product->get_seconds_remaining();
	}

	if($product->is_closed()){
		$time = '<span class="has-finished">'.__('Lottery finished','wc_lottery').'</span>';
	}
	echo $time;
}




function wpgenie_pbinl_show_progress_bar_in_loop (){
	global $product; 
	
	if ( method_exists( $product, 'get_type') && $product->get_type() == 'lottery' ) :
		$lottery_participants_count = !empty($product->get_lottery_participants_count()) ? $product->get_lottery_participants_count() : '0';

		$counter_time = $product->get_seconds_remaining();
		$dt1 = new DateTime('NOW');
		$dt2 = new DateTime("@$counter_time");
	?>
	<div class="ticket-info">
		<div class="lottery-days"><b><?php echo '<a class="cus_link"  href="'.get_permalink($product_id).'">'.'Buy'.'</a>'; ?></b> </div>
		<div class="lottery-remaining"><b><?php echo (int)($product->get_max_tickets() -  $lottery_participants_count); ?></b> remaining</div> 
		<div class="lottery-sold"><b><?php echo $lottery_participants_count ?></b> sold</div>
	</div>
		<div class="wcl-progress-meter <?php if($product->is_max_tickets_met()) echo 'full' ?>">
			<span class="zero"><?php echo $lottery_participants_count ?> / <?php echo $product->get_max_tickets(); ?> </span>
			<span class="max"></span>
			<progress  max="<?php echo $product->get_max_tickets(); ?>" value="<?php echo $lottery_participants_count ?>"  low="<?php echo $product->get_min_tickets(); ?>"></progress>
		</div>
	<?php endif;
}