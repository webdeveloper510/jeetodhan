<?php
/**
 * Custom messages main controller.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use \OTP\Notifications\CustomMessage\Handler\CustomMessages;


$handler       = CustomMessages::instance();
$registerd     = $handler->moAddOnV();
$disabled      = ! $registerd ? 'disabled' : '';
$get_user      = wp_get_current_user();
$cm_controller = MCM_DIR . 'controllers/';
$req_url       = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : ''; // phpcs:ignore -- false positive.
$addon         = add_query_arg( array( 'page' => 'addon' ), remove_query_arg( 'addon', $req_url ) );

require $cm_controller . 'custom.php';

