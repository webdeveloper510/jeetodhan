<?php
/**
 * Email form view.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '
			<form name="f" method="post" action="' . esc_url( $post_url ) . '">
					<input type="hidden" name="action" value="mo_customer_validation_admin_custom_email_notif" />';
					wp_nonce_field( $nonce, 'mosecurity' );
echo '					<div class="mo-header">
						<p class="mo-heading flex-1">' . esc_html( mo_( 'Send Custom Email Message' ) ) . '</p>
						<input type="submit" name="save"
									class="mo-button inverted" id="save" ' . esc_attr( $disabled ) . ' value="' . esc_attr( mo_( 'Send Message' ) ) . '">
					</div>
					<div id="custom_email_box" class="px-mo-32">
						<div class="w-full pb-mo-8">
							<div class="flex my-mo-8 gap-mo-4">
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_html( mo_( 'From ID' ) ) . '</label>
									<input  ' . esc_attr( $disabled ) . ' class=" mo-input w-full" id="custom_email_from_id" placeholder="' . esc_attr( mo_( 'Enter email address' ) ) . '" type="text" name="fromEmail" >
								</div>
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_html( mo_( 'From Name' ) ) . '</label>
									<input  ' . esc_attr( $disabled ) . ' class=" mo-input w-full" id="custom_email_from_name" placeholder="' . esc_attr( mo_( 'Enter Name' ) ) . '" type="text" name="fromName" >
								</div>
							</div>
							<div class="mo-input-wrapper">
								<label class="mo-input-label">' . esc_html( mo_( 'subject' ) ) . '</label>
								<input  ' . esc_attr( $disabled ) . ' class="mo-input w-full" id="custom_email_subject" placeholder="' . esc_attr( mo_( 'Enter your OTP Email Subject' ) ) . '" type="text" name="subject" >
							</div>
							<div class="mo-input-wrapper my-mo-8">
								<label class="mo-input-label">' . esc_html( mo_( 'To Email Address' ) ) . '</label>
								<input  ' . esc_attr( $disabled ) . ' class="mo-input w-full" id="custom_email_to" placeholder="' . esc_attr( mo_( 'Enter semicolon (;) separate the email-addresses.' ) ) . '" type="text" name="toEmail" >
							</div>
								<b>' . esc_html( mo_( 'Body:' ) ) . '</b>';
								wp_editor( $content, $editor_id, $template_settings );
			echo '			
						</div>
					</div>';
echo '</form>

	<div id="custom_msg_shortcode" class=" border-t">
		<div class="w-full flex gap-mo-8 m-mo-4 px-mo-8">
			<div class="flex-1 pr-mo-8">
				<h5 class="mo-heading">' . esc_html( mo_( 'Phone Shortcode' ) ) . '</h5>
				<p class="mo-caption mt-mo-2">' . esc_html( mo_( 'You can use this shortcode to show custom SMS forms on your frontend. Users can use this form to send custom messages.' ) ) . '</p>
				<div class="mo_otp_note">
					' . esc_html( mo_( 'Only logged in users can send Messages.' ) ) . '
				</div>
			</div>
			<div class="flex-1 pt-mo-8">
				<div class="text-lg">
					<b>[mo_custom_sms]</b>
				</div>
			</div>
		</div>
		<div class="w-full flex gap-mo-8 m-mo-4 px-mo-8">
			<div class="flex-1 pr-mo-8">
				<h5 class="mo-heading">' . esc_html( mo_( 'Email Shortcode' ) ) . '</h5>
				<p class="mo-caption mt-mo-2">' . esc_html( mo_( 'You can use this shortcode to show custom email forms on your frontend. Users can use this form to send custom messages.' ) ) . '</p>
				<div class="mo_otp_note">
					' . esc_html( mo_( 'Only logged in users can send Messages.' ) ) . '
				</div>
			</div>
			<div class="flex-1 pt-mo-8">
				<div class="text-lg">
					<b>[mo_custom_email]</b>
				</div>
			</div>
		</div>
	</div>';
