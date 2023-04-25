<?php
/**
 * Loads Design popup admin view.
 *
 * @package miniorange-otp-verification
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\Template;


$default_popup = DefaultPopup::instance();

$user_choice_popup = UserChoicePopup::instance();

$external_popup = ExternalPopup::instance();

$error_popup_instance = ErrorPopup::instance();

$nonce = $default_popup->get_nonce_value();




$default_template_type    = $default_popup->get_template_key();
$userchoice_template_type = $user_choice_popup->get_template_key();
$external_template_type   = $external_popup->get_template_key();
$error_template_type      = $error_popup_instance->get_template_key();


$email_templates         = maybe_unserialize( get_mo_option( 'custom_popups' ) );
$custom_default_popup    = $email_templates[ $default_popup->get_template_key() ];
$custom_external_popup   = $email_templates[ $external_popup->get_template_key() ];
$custom_userchoice_popup = $email_templates[ $user_choice_popup->get_template_key() ];
$error_popup             = $email_templates[ $error_popup_instance->get_template_key() ];


$common_template_settings = Template::$template_editor;


$editor_id         = $default_popup->get_template_editor_id();
$template_settings = array_merge(
	$common_template_settings,
	array(
		'textarea_name' => $editor_id,
		'editor_height' => 400,
	)
);


$editor_id2         = $user_choice_popup->get_template_editor_id();
$template_settings2 = array_merge(
	$common_template_settings,
	array(
		'textarea_name' => $editor_id2,
		'editor_height' => 400,
	)
);


$editor_id3         = $external_popup->get_template_editor_id();
$template_settings3 = array_merge(
	$common_template_settings,
	array(
		'textarea_name' => $editor_id3,
		'editor_height' => 400,
	)
);


$editor_id4         = $error_popup_instance->get_template_editor_id();
$template_settings4 = array_merge(
	$common_template_settings,
	array(
		'textarea_name' => $editor_id4,
		'editor_height' => 400,
	)
);




$loaderimgdiv = str_replace( '{{CONTENT}}', "<img src='" . MOV_LOADER_URL . "'>", $default_popup->pane_content );


$previewpane = "<span style='font-size: 1.3em;'>" .
					'PREVIEW PANE<br/><br/>' .
			'</span>' .
			'<span>' .
					'Click on the Preview button above to check how your popup would look like.' .
				'</span>';
$previewpane = str_replace( '{{MESSAGE}}', $previewpane, $default_popup->message_div );
$message     = str_replace( '{{CONTENT}}', $previewpane, $default_popup->pane_content );

require_once MOV_DIR . 'views/design.php';
