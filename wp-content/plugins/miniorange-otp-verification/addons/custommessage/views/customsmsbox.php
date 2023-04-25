<?php
/**
 * Custom SMS notifications view.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Helper\MoUtility;

echo ' <div id="custom_sms_box">
            <table style="width:100%">
                <tr>
                    <td>
                        <b>' . esc_html( mo_( 'Phone Numbers:' ) ) . '</b>
                        <input ' . esc_attr( $disabled ) . '
                                class="mo_registration_table_textbox"
                                style="border:1px solid #ddd"
                                name="mo_phone_numbers"
                                placeholder="' . esc_attr( mo_( 'Enter semicolon(;) separated Phone Numbers' ) ) . '"
                            value="" required="">
                        <br/><br/>
                    </td>
                </tr>';


echo '<tr>
                <td>
                <b>' . esc_html( mo_( 'Choose Template: ' ) ) . '</b>
                 <input type="radio" ' . esc_attr( $disabled ) . ' class="mo_custom_message_enable" id="mo_custom_msg_template1" checked="checked" name="mo_customer_validation_custom_message_template1" value="Template1">
                                    <label for="mo_custom_msg_template1">Template 1</label>&nbsp


                 <input type="radio" ' . esc_attr( $disabled ) . ' class="mo_custom_message_enable" id="mo_custom_msg_template2" name="mo_customer_validation_custom_message_template2" style="display: none;" value="Template2">
                                    <label for="mo_custom_msg_template2" hidden>Template 2</label>&nbsp <br><br>

                </td>
                </tr>
                <tr>
                    <td>
                        <b>' . esc_html( mo_( 'Message' ) ) . '</b>
                        <span id="characters">Remaining Characters : <span id="remaining"></span> </span>
                        <textarea ' . esc_attr( $disabled ) . ' 
                            id="custom_sms_msg" 
                            class="mo_registration_table_textbox" required
                            name="mo_customer_validation_custom_sms_msg"/>You have received a message from {#var#}</textarea>

                           <div class="mo_otp_note">
                            ' . wp_kses( mo_( '<b>Note :<br> 1) Only {##var##} of the template is editable. Do not replace the other fixed values.<br>2) Do not use more than 5 Phone numbers at a time or your account might end up getting blocked for security purposes.</b>' ), MoUtility::mo_allow_html_array() ) . '
                        </div>
                        <div class="mo_otp_note" hidden>
                            ' . wp_kses(
								mo_(
									'<li>For Template 1 : <b><u>You have received a message from</u></b> WordPress.domain.com. Please check your dashboard for account status.</li>
                                <li>For Template 2 : <b><u>Hello</u></b> David, thank you for creating an account with us.</i></li><b>Highlighted text in the examples above are compulsory in the message body.</b>'
								),
								MoUtility::mo_allow_html_array()
							) . '
                        </div>
                        <div class="mo_otp_note"><b>If you wish to customize the Template, contact us at <a style="cursor:pointer;" onClick="otpSupportOnClick();"><u> otpsupport@xecurify.com</u></a></b>.
                        </div>
                    </td>
                </tr>';


$html2 = '<tr>
                    <td>
                        <b>' . esc_html( mo_( 'Message' ) ) . '</b>
                        <span id="characters">Remaining Characters : <span id="remaining"></span> </span>
                        <textarea ' . esc_attr( $disabled ) . ' 
                            id="custom_sms_msg" 
                            class="mo_registration_table_textbox"
                            name="mo_customer_validation_custom_sms_msg"
                            placeholder="' . esc_attr( mo_( 'Enter OTP SMS Message' ) ) . '"
                            required/></textarea>
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
                        </div>
                    </td>
                </tr>';



echo ' </table>
        </div>';
