<?php
/**
 * Load admin view for common messages tab.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoUtility;
use OTP\Helper\MoMessages;

echo '  <div id="messagesSubTabContainer" class="mo-subpage-container ' . esc_attr( $common_msg_hidden ) . '">
			<div class="bg-white rounded-md">
				<form name="f" method="post" action="" id="mo_otp_verification_messages">
					<input type="hidden" name="option" value="mo_customer_validation_messages" />';
					wp_nonce_field( $nonce );
	echo '			<div class="mo-header">
						<p class="mo-heading flex-1">' . esc_html( mo_( 'Common Messages' ) ) . '</p>
						<input type="submit" name="save" id="ov_settings_button" ' . esc_attr( $disabled ) . '
									class="mo-button inverted" value="' . esc_attr( mo_( 'Save Settings' ) ) . '">
					</div>
					<div class="p-4 text-xs font-normal rounded-smooth bg-blue-50 border-b py-mo-4 px-mo-8" role="alert">
						NOTE: <a class="text-xs font-bold text-green-800" > ##email## and ##phone## </a> in the message body will be replaced by the user\'s email address and phone number respectively.
					</div>';

		echo '		<div class="mo-common-msg-table ">
						<div class="rounded-md items-center mo-common-msg-table-padding">
							<div id="mo_common_message_table">
								<div class=" w-full gap-mo-4 flex" id="original_msg_list_headings">
									<div class="flex-1 pl-mo-8 pt-mo-4">
										<h3 class="py-mo-1.5 font-heading font-semibold  text-md justify-center text-gray-900">Phone Messages</h3>
									</div>
								</div>';
foreach ( $phone_entries as $key => $value ) {
						echo '  <div class="w-full gap-mo-4 my-mo-6 flex" id="original_msg_list' . esc_attr( $key ) . '">
									<div class="flex-1 pl-mo-8">
										<p name="old_msg_list_' . esc_attr( $key ) . '" class="mb-mo-4" >' . esc_html( $value['old_msg'] ) . '</p>
									</div>
									<div class="flex-1 pr-mo-8">
										<div class="mo-input-wrapper">
											<label class="mo-input-label">' . esc_attr( $value['label'] ) . '</label>
											<textarea name="new_msg_list_' . esc_attr( $key ) . '" rows="3" maxlength="400" class="mo-textarea" id="new_msg_list_' . esc_attr( $key ) . '" >' . esc_html( $value['new_msg'] ) . '</textarea>
										</div>
									</div>
								</div>';
}
	echo '                      <div class="border-t w-full gap-mo-4 flex" id="original_msg_list_headings">
										<div class="flex-1 pl-mo-8 pt-mo-4">
											<h3 class="py-mo-1.5 font-heading font-semibold  text-md justify-center text-gray-900">Email Messages</h3>
										</div>
								</div>';
foreach ( $email_entries as $key => $value ) {
						echo '  <div class="w-full gap-mo-4 mt-mo-6 flex" id="original_msg_list' . esc_attr( $key ) . '">
									<div class="flex-1 pl-mo-8">
										<p name="old_msg_list_' . esc_attr( $key ) . '" class="mb-mo-4" >' . esc_html( $value['old_msg'] ) . '</p>
									</div>
									<div class="flex-1 pr-mo-8">
										<div class="mo-input-wrapper">
											<label class="mo-input-label">' . esc_attr( $value['label'] ) . '</label>
											<textarea name="new_msg_list_' . esc_attr( $key ) . '" rows="3" maxlength="400" class="mo-textarea" id="new_msg_list_' . esc_attr( $key ) . '" >' . esc_html( $value['new_msg'] ) . '</textarea>
										</div>
									</div>
								</div>';
}

	echo '                      <div class="border-t w-full gap-mo-4 flex" id="original_msg_list_headings">
										<div class="flex-1 pl-mo-8 pt-mo-4">
											<h3 class="py-mo-1.5 font-heading font-semibold  text-md justify-center text-gray-900">Custom Messages</h3>
										</div>
								</div>';
foreach ( $custom_entries as $key => $value ) {
						echo '  <div class="w-full gap-mo-4 mt-mo-6 flex" id="original_msg_list' . esc_attr( $key ) . '">
									<div class="flex-1 pl-mo-8">
										<p name="old_msg_list_' . esc_attr( $key ) . '" class="mb-mo-4" >' . esc_html( $value['old_msg'] ) . '</p>
									</div>
									<div class="flex-1 pr-mo-8">
										<div class="mo-input-wrapper">
											<label class="mo-input-label">' . esc_attr( $value['label'] ) . '</label>
											<textarea name="new_msg_list_' . esc_attr( $key ) . '" rows="3" maxlength="400" class="mo-textarea" id="new_msg_list_' . esc_attr( $key ) . '" >' . esc_html( $value['new_msg'] ) . '</textarea>
										</div>
									</div>
								</div>';
}

echo '				
								
							</div>
						</div>
					</div>
				</div>
					<div class="mo-section-footer rounded-tr-md rounded-tl-md border-t">
						<p class="grow text-m py-mo-4 px-mo-8"><strong>If you are unable to locate your message in the list, kindly choose the message from the dropdown below:</strong></p>
						<div id="mo_original_msg_list" class=" flex gap-mo-4 w-full px-mo-4 pb-mo-4">
							<input type="hidden" name="selected_msg_name" id="selected_message" value="' . esc_attr( key( $reduced_msg_list ) ) . '" />
							<div class="w-half py-mo-2 w-[75%] pl-mo-4">';
echo '    						<select class="w-full px-mo-8" name="original_msg_dropdown" id="original_msg_dropdown" style="max-width: 100%;">';
foreach ( $reduced_msg_list as $key => $value ) {
									echo '<option class="selected_msg" value="' . esc_attr( $key ) . '" name="' . esc_attr( $value ) . '">' . esc_html( $value ) . '</option>';
}
echo ' 							</select>
							</div>
							<div class="w-half pb-mo-4" style="float:left;">
								<input type="button" ' . esc_attr( $disabled ) . '  name="save" id="moAddNewMessage" class="mo-button primary inverted" value="Replace this message" />';
								wp_nonce_field( 'addmsgnonce', 'mo_add_message_nonce' );
echo '					    </div>
						</div>
					</div>
				</form>
			</div>
		</div>';
