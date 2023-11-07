<?php
/**
 * Custom messages controller.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
use \OTP\Notifications\CustomMessage\Handler\CustomMessages;

$handler           = CustomMessages::instance();
$nonce             = $handler->get_nonce_value();
$post_url          = admin_post_url();
$content           = '';
$editor_id         = 'customEmailMsgEditor';
$template_settings = array(
	'media_buttons' => false,
	'textarea_name' => 'content',
	'editor_height' => '170px',
	'wpautop'       => false,
);

$subtab    = isset( $_GET['subpage'] ) ? sanitize_text_field( wp_unslash( $_GET['subpage'] ) ) : 'wcNotifSubTab'; //phpcs:ignore WordPress.Security.NonceVerification.Missing, WordPress.Security.NonceVerification.Recommended -- Reading GET parameter from the URL for checking the form name, doesn't require nonce verification.
$cm_hidden = 'customMsgSubTab' !== $subtab ? 'hidden' : '';

require MCM_DIR . 'views/custom.php';
