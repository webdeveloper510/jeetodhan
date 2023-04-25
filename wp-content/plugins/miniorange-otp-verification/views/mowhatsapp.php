<?php
/**
 * Load admin view for WhatsApp Tab.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use OTP\Helper\MoUtility;

echo '	<div class="mo_registration_divided_layout mo-otp-full">
				<div id="whatsappTable" class="mo_registration_table_layout mo-otp-center">
				<div style="display:flex">
											<img class = "mo_support_form_new_feature mo_otp_new_feature_class" style="height:50px;width:50px;margin-top:10px"src="' . esc_url( MOV_URL ) . 'includes/images/mowhatsapp.png">
									<h2 style="margin-top:30px">&nbsp&nbsp' . esc_html( mo_( 'WHATSAPP FOR OTP VERIFICATION AND NOTIFICATIONS' ) ) . '</h2>
									</div>
									<hr>

				    <table style="width:100%">
						<form name="f" method="post" action="" id="mo_whatsapp_settings">';
						wp_nonce_field( 'whatsappnonce', 'mo_whatsapp_nonce' );
						echo ' <tr>
								<td class="mo_otp_note" style="background-color: #bffc6b">' . esc_html( mo_( 'This feature allows you to configure WhatsApp for OTP Verification as well as sending notifications and alerts via WhatsApp.' ) ) . '
                                </td>
							</tr>';

			$html = '<tr>
							 <td style="padding-left:6%">
							 <ul style="list-style-type:disc">
							 <li> This is a monthly subscription module with <b>1000 Free messages over WhatsApp every month</b>.</li>
							 <li> You can use your own WhatsApp Business account for sending OTP and Notifications. </li>
							 <li> Instant Notifications and OTP codes sent via WhatsApp.</li>
							 <li> No Coding required, easy and seamless set up process.</li>
							 </ul>
							 </td>

							</tr>
							 <td><hr><b>' . wp_kses( mo_( 'Please reach out to us for enabling WhatsApp on your WordPress site : <a style="cursor:pointer;" onClick="otpSupportOnClick(\'Hi! I am interested in using WhatsApp for my website, can you please help me with more information?\');"><u>Contact for WhatsApp</u></a>' ), MoUtility::mo_allow_html_array() ) . '
                                </b>
                             </td>';

				$html = apply_filters( 'mo_whatsapp_view', $html );// hook to add whatsapp premium plugin.

				$html_test_config = '<table class="" style="width: 100%;">
                                    <tr>
                                        <td><br>
                                        <div class = "test-configuration" id="wa_test_configuration">
                                        <b>Test WhatsApp OTP Verification:</b><br><br>
                                        <div class="">
                                            <label>Phone Number:</label>
                                            <input type="text" id="wa_test_configuration_phone" name="wa_test_configuration_phone"  placeholder="+1xxxxxxxxxx">
                                            <span style="float:right;margin-top:-10px;">
                                                <input 	type="button" 
                                                        name="mo_gateway_submit" ' . esc_attr( $whatsapp_disabled ) . '
                                                        id="whatsapp_gateway_submit"
                                                        value="Send OTP Over WhatsApp"
                                                        class="button button-primary button-large" style="margin-top: 9px;"/>
                                            </span>
                                                
                                            </div><br>
                                            <div name="mo_test_config_hide_response" style="display:none;" id="test_config_hide_response" >
                                                <b>Gateway Response:</b><br><br>
                                                <div>					
                                                    <textarea readonly' . esc_attr( $whatsapp_disabled ) . ' id="test_config_response"
                                                            class="mo_registration_table_textbox" 
                                                            name="mo_test_configuration_response" 
                                                            rows="3" style="height:120px;" placeholder="Your Gateway Response" required;
                                                        ></textarea>
                                                    <br>
                                                </div>
                                            </div>
                                            <br>
                                        </td>
                                    </tr>
                            </table>

                            </div>
                </form>	
					</table>
				</div>
			</div>';

			$html .= $html_test_config;
			echo wp_kses( $html, MoUtility::mo_allow_html_array() );
