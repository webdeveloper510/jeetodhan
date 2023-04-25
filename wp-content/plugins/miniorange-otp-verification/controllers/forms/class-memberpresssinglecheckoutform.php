<?php
/**
 * Load admin view for MemberPressSingleCheckoutForm.
 *
 * @package miniorange-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Handler\Forms\MemberPressSingleCheckoutForm;

$handler                   = MemberPressSingleCheckoutForm::instance();
$mrp_single_registration   = $handler->is_form_enabled() ? 'checked' : '';
$mrp_single_default_hidden = 'checked' === $mrp_single_registration ? '' : 'hidden';
$mrp_single_default_type   = $handler->get_otp_type_enabled();
$mrp_single_field_key      = $handler->get_phone_key_details();
$mrp_single_fields         = admin_url() . 'admin.php?page=memberpress-options#mepr-fields';
$mrp_singlereg_phone_type  = $handler->get_phone_html_tag();
$mrp_singlereg_email_type  = $handler->get_email_html_tag();
$mrp_singlereg_both_type   = $handler->get_both_html_tag();
$form_name                 = $handler->get_form_name();
$mpr_single_anon_only      = $handler->bypass_for_logged_in_users() ? 'checked' : '';

get_plugin_form_link( $handler->get_form_documents() );
require_once MOV_DIR . 'views/forms/memberpresssinglecheckoutform.php';
