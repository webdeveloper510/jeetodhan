<?php
/**
 * Load admin view for WooCommerceFrontendManagerFormFree.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

echo '<div class="center"><strong>' . wp_kses(
	$form_name,
	array(
		'b'    => array(),
		'span' => array( 'style' => array() ),
	)
) . '</strong></div>';
echo '<div class="mo_otp_note">
                            ' . wp_kses(
	mo_( 'The <b>WooCommerce Frontend Manager</b> plugin has been separately integated to provide users with Phone verification or Email Verification via OTP on the WCFM Vendor Registration and WCFM Vendor Membership Forms.<br>To get access to this premium feature, please kindly contact us at <a style="cursor:pointer;" onClick="otpSupportOnClick();"><u> otpsupport@xecurify.com</u></a> ' ),
	array(
		'b'  => array(),
		'a'  => array(
			'style'   => array(),
			'onclick' => array(),
		),
		'br' => array(),
		'u'  => array(),
	)
) . '
                        </div>';
