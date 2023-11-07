<?php
/**
 * Admin messagebar controller.
 *
 * @package miniorange-otp-verification/controllers
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use OTP\Helper\MoConstants;
use OTP\Helper\MoMessages;
use OTP\Objects\Tabs;
use OTP\Helper\MoUtility;

$request_uri    = remove_query_arg( array( 'addon', 'form', 'subpage' ), isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '' ); // phpcs:ignore -- false positive.
$register_msg   = MoMessages::showMessage( MoMessages::REGISTER_WITH_US, array( 'url' => $profile_url ) );
$activation_msg = MoMessages::showMessage( MoMessages::ACTIVATE_PLUGIN, array( 'url' => $profile_url ) );
$gateway_url    = add_query_arg( array( 'page' => $tab_details->tab_details[ Tabs::GATEWAY ]->menu_slug ), $request_uri );
$gateway_msg    = MoMessages::showMessage( MoMessages::CONFIG_GATEWAY, array( 'url' => $gateway_url ) );

require MOV_DIR . 'views/admin-messagebar.php';
