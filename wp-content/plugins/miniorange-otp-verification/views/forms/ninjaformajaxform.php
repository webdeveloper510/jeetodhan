<?php
/**
 * Load admin view for Ninja form.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoUtility;


echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '"><input type="checkbox" ' . esc_attr( $disabled ) . ' id="ninja_form" class="app_enable" data-toggle="ninja_ajax_form_options" name="mo_customer_validation_nja_enable" value="1"
										' . esc_attr( $ninja_ajax_form_enabled ) . ' /><strong>' . esc_html( $form_name ) . '</strong>';

echo '							<div class="mo_registration_help_desc" ' . esc_attr( $ninja_ajax_form_hidden ) . ' id="ninja_ajax_form_options">
									<p><input type="radio" ' . esc_attr( $disabled ) . ' id="ninja_ajax_form_email" class="app_enable" data-toggle="nfae_instructions" name="mo_customer_validation_nja_enable_type" value="' . esc_attr( $ninja_ajax_form_type_email ) . '"
										' . ( esc_attr( $ninja_ajax_form_enabled_type ) === esc_attr( $ninja_ajax_form_type_email ) ? 'checked' : '' ) . ' />
										<strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
									</p>
									<div ' . ( esc_attr( $ninja_ajax_form_enabled_type ) !== esc_attr( $ninja_ajax_form_type_email ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" id="nfae_instructions" >
											' . esc_html( mo_( 'Follow the following steps to enable Email Verification for' ) ) . ' Ninja Form:
											<ol>
												<li><a href="' . esc_url( $ninja_ajax_form_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( ' to see your list of forms' ) ) . '</li>
												<li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your ninja form.' ), array( 'b' => array() ) ) . '</li>
												<li>' . esc_html( mo_( 'Add an Email Field to your form. Note the Field Key of the email field. You will need to enable Dev Mode for this.' ) ) . '</li>
												<li>' . esc_html( mo_( 'Add an Verification Field to your form where users will enter the OTP received. Note the Field Key of the verification field.' ) ) . '</li>
												<li>' . wp_kses( mo_( 'Please set the Verification Field as <b>required</b>.' ), array( 'b' => array() ) ) . '</li>
												<li>' . esc_html( mo_( 'Enter your Form ID, the Email Field Key and the Verification Field Key below' ) ) . ':<br>
													<br/>' . esc_html( mo_( 'Add Form ' ) ) . ': <input type="button"  value="+" ' . esc_attr( $disabled ) . ' onclick="add_ninja_ajax(\'email\',1);" class="button button-primary" />&nbsp;
													<input type="button" value="-" ' . esc_attr( $disabled ) . ' onclick="remove_ninja_ajax(1);" class="button button-primary" /><br/><br/>';

													$form_results = get_multiple_form_select( $ninja_ajax_form_otp_enabled, true, true, $disabled, 1, 'ninja_ajax', 'Key' );
													$counter1     = ! MoUtility::is_blank( $form_results['counter'] ) ? max( $form_results['counter'] - 1, 0 ) : 0;

echo '											</li>
												<li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
											</ol>
									</div>
									<p><input type="radio" ' . esc_attr( $disabled ) . ' id="ninja_ajax_form_phone" class="app_enable" data-toggle="nfap_instructions" name="mo_customer_validation_nja_enable_type" value="' . esc_attr( $ninja_ajax_form_type_phone ) . '"
										' . ( esc_attr( $ninja_ajax_form_enabled_type ) === esc_attr( $ninja_ajax_form_type_phone ) ? 'checked' : '' ) . ' />
										<strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
									</p>
									<div ' . ( esc_attr( $ninja_ajax_form_enabled_type ) !== esc_attr( $ninja_ajax_form_type_phone ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc" id="nfap_instructions" >
											' . esc_html( mo_( 'Follow the following steps to enable Phone Verification for Ninja Form' ) ) . ':
											<ol>
												<li><a href="' . esc_url( $ninja_ajax_form_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' . esc_html( mo_( ' to see your list of forms' ) ) . '</li>
												<li>' . wp_kses( mo_( 'Click on the <b>Edit</b> option of your ninja form.' ), array( 'b' => array() ) ) . '</li>
												<li>' . esc_html( mo_( 'Add an Phone Field to your form. Note the Field Key of the phone field. You will need to enable Dev Mode for this.' ) ) . '</li>
												<li>' . esc_html( mo_( 'Make sure you have set the Input Mask type to None for the phone field.' ) ) . '</li>
												<li>' . esc_html( mo_( 'Add an Verification Field to your form where users will enter the OTP received. Note the Field Key of the verification field.' ) ) . '</li>
												<li>' . wp_kses( mo_( 'Please set the Verification Field and Phone Field as <b>required</b>.' ), array( 'b' => array() ) ) . '</li>
												<li>' . esc_html( mo_( 'Enter your Form ID, the Phone Field Key and the Verification Field Key below' ) ) . ':<br>
													<br/>' . esc_html( mo_( 'Add Form ' ) ) . ': <input type="button"  value="+" ' . esc_attr( $disabled ) . ' onclick="add_ninja_ajax(\'phone\',2);" class="button button-primary" />&nbsp;
													<input type="button" value="-" ' . esc_attr( $disabled ) . ' onclick="remove_ninja_ajax(2);" class="button button-primary" /><br/><br/>';

													$form_results = get_multiple_form_select( $ninja_ajax_form_otp_enabled, true, true, $disabled, 2, 'ninja_ajax', 'Key' );
													$counter2     = ! MoUtility::is_blank( $form_results['counter'] ) ? max( $form_results['counter'] - 1, 0 ) : 0;
echo '											</li>
												<li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
											</ol>
									</div>
									<p style="margin-left:2%;">
                                        <i><b>' . esc_html( mo_( 'Verification Button text' ) ) . ':</b></i>
                                        <input class="mo_registration_table_textbox" name="mo_customer_validation_nja_button_text" type="text" value="' . esc_attr( $button_text ) . '">
                                    </p>
								</div>
							</div>';

							multiple_from_select_script_generator( true, true, 'ninja_ajax', 'Key', array( $counter1, $counter2, 0 ) );

