<?php
/**
 * Load admin view for UltimateMemberRegistrationForm.
 *
 * @package miniorange-otp-verification/controller/
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Handler\Forms\UltimateMemberRegistrationForm;

$handler                = UltimateMemberRegistrationForm::instance();
$um_enabled             = $handler->is_form_enabled() ? 'checked' : '';
$um_hidden              = 'checked' === $um_enabled ? '' : 'hidden';
$um_enabled_type        = $handler->get_otp_type_enabled();
$um_forms               = admin_url() . 'edit.php?post_type=um_form';
$um_type_phone          = $handler->get_phone_html_tag();
$um_type_email          = $handler->get_email_html_tag();
$um_type_both           = $handler->get_both_html_tag();
$um_restrict_duplicates = $handler->restrict_duplicates() ? 'checked' : '';
$form_name              = $handler->get_form_name();
$um_button_text         = $handler->get_button_text();
$is_ajax_form           = $handler->is_ajax_form();
$is_ajax_mode_enabled   = $is_ajax_form ? 'checked' : '';
$um_otp_meta_key        = $handler->get_form_key();
$um_register_field_key  = $handler->get_phone_key_details();

get_plugin_form_link( $handler->get_form_documents() );
require_once MOV_DIR . 'views/forms/ultimatememberregistrationform.php';
