<?php
/**
 * Load admin view for WooCommerceFrontendManagerFormFree.
 *
 * @package miniorange-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Handler\Forms\WooCommerceFrontendManagerFormFree;

$handler   = WooCommerceFrontendManagerFormFree::instance();
$form_name = $handler->get_form_name();

get_plugin_form_link( $handler->get_form_documents() );
require_once MOV_DIR . 'views/forms/woocommercefrontendmanagerformfree.php';
