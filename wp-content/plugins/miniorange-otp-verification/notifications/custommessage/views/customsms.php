<?php
/**
 * SMS form.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Helper\MoUtility;
echo ' 
			<form name="f" method="post" action="' . esc_url( $post_url ) . '">
				<input type="hidden" name="action" value="mo_customer_validation_admin_custom_phone_notif" />
					';
					wp_nonce_field( $nonce, 'mosecurity' );
echo '					
					<div class="mo-header">
						<p class="mo-heading flex-1">' . esc_html( mo_( 'Send Custom SMS Message' ) ) . '</p>
						<input type="submit" name="save"
									class="mo-button inverted" id="save" ' . esc_attr( $disabled ) . ' value="' . esc_attr( mo_( 'Send Message' ) ) . '">
					</div>
					<div id="custom_sms_box" class="px-mo-32 border-b">
						<div class="w-full">
							<div class="flex flex-col my-mo-8 gap-mo-4">
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_html( mo_( 'Phone Numbers' ) ) . '</label>
									<input  ' . esc_attr( $disabled ) . ' class=" mo-input w-full" id="custom_email_from_id" placeholder="' . esc_attr( mo_( 'Enter semicolon(;) to separate the Phone Numbers' ) ) . '" type="text" name="mo_phone_numbers"  required="" >
								</div>
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_attr( mo_( 'Message' ) ) . '</label>
									<textarea ' . esc_attr( $disabled ) . ' id="custom_sms_msg" name="mo_customer_validation_custom_sms_msg" rows="3" class="mo-textarea mo_remaining_characters" >' . esc_html( mo_( 'You have received a message from {#var#}' ) ) . '</textarea>
								</div>
								<span id="characters">Remaining Characters : <span id="remaining_custom_sms_msg"></span> </span>

								<div class="mo_otp_note" hidden>
									' . wp_kses(
										mo_(
											'<li>For Template 1 : <b><u>You have received a message from</u></b> WordPress.domain.com. Please check your dashboard for account status.</li>
										<li>For Template 2 : <b><u>Hello</u></b> David, thank you for creating an account with us.</i></li><b>Highlighted text in the examples above are compulsory in the message body.</b>'
										),
										MoUtility::mo_allow_html_array()
									) . '
								</div>
								<div class="mo_otp_note">
									
									<b>For Indian customers</b>:<br> To modify the SMS templates you need to register the template on the DLT portal. You can read more about the DLT registration process here: <u><i><a href="https://plugins.miniorange.com/dlt-registration-process-for-sending-sms" target="_blank" >DLT Registration</a></i></u>.
									<br><br>
									<b>If you wish to customize the Template, contact us at <a style="cursor:pointer;" onClick="otpSupportOnClick();"><u> otpsupport@xecurify.com</u></a></b>.
								</div>
								<div class="mo_otp_note">
									' . wp_kses( mo_( '<b>Note : Do not use more than 5 Phone numbers at a time or your account might end up getting blocked for security purposes.</b>' ), MoUtility::mo_allow_html_array() ) . '
								</div>
							</div>
						</div>
					</div>
					</form>';


		$html2 = '	<div class="mo-input-wrapper">
						<label class="mo-input-label">' . esc_attr( mo_( 'Message' ) ) . '</label>
						<textarea id="custom_sms_msg" placeholder="' . esc_attr( mo_( 'Enter OTP SMS Message' ) ) . '" name="mo_customer_validation_custom_sms_msg" rows="3" class="mo-textarea mo_remaining_characters" ></textarea>
					</div>
					<span id="characters">Remaining Characters : <span id="remaining_custom_sms_msg"></span> </span>
					<div class="mo_otp_note">
						' . wp_kses(
							mo_(
								'You can have new line characters in your sms text body.
								To enter a new line character use the <b><i>%0a</i></b> symbol.
								To enter a "#" character you can use the <b><i>%23</i></b> symbol.
								To see a complete list of special characters that you can send in a
								SMS check with your gateway provider.'
							),
							MoUtility::mo_allow_html_array()
						) . '
					</div>';
