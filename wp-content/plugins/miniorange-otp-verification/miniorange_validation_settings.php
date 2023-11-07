<?php //phpcs:ignore -- legacy plugin
/**
 * Plugin Name: Email Verification / SMS Verification / Mobile Verification
 * Plugin URI: http://miniorange.com
 * Description: Email & SMS OTP Verification for all forms. WooCommerce SMS Notification. PasswordLess Login. External Gateway for OTP Verification. 24/7 support.
 * Version: 5.0.0
 * Author: miniOrange
 * Author URI: http://miniorange.com
 * Text Domain: miniorange-otp-verification
 * Domain Path: /lang
 * WC requires at least: 2.0.0
 * WC tested up to: 5.6.0
 * License: MIT/Expat
 * License URI: https://docs.miniorange.com/mit-license
 *
 * @package miniorange-otp-verification
 */

use OTP\MoInit;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
define( 'MOV_PLUGIN_NAME', plugin_basename( __FILE__ ) );
$dir_name = substr( MOV_PLUGIN_NAME, 0, strpos( MOV_PLUGIN_NAME, '/' ) );
define( 'MOV_NAME', $dir_name );

/**
 * Update the notification settings option.
 *
 * @param string $option_name The name of the notification settings option.
 *
 * @return void
 */
function update_notification_settings_option( $option_name ) {
	$updated_option_name = $option_name . '_option';
	if ( empty( get_option( $updated_option_name ) ) && ! empty( get_option( $option_name ) ) ) {
		$notification_details = (array) get_option( $option_name );
		unset( $notification_details['__PHP_Incomplete_Class_Name'] );
		$notif_data = array();

		foreach ( $notification_details as $notification_name => $property ) {
			$new_property = (array) $property;
			unset( $new_property['__PHP_Incomplete_Class_Name'] );
			$notif_data[ $notification_name ] = $new_property;
		}
		update_option( $option_name, $notif_data );
	}
}

update_notification_settings_option( 'mo_wc_sms_notification_settings' );
update_notification_settings_option( 'mo_um_sms_notification_settings' );

require_once 'autoload.php';
MoInit::instance(); // initialize the main class.
