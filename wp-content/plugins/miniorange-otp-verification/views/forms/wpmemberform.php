<?php
/**
 * Load admin view for WpMemberForm.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;

echo '	<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
	        <input  type="checkbox" 
	                ' . esc_attr( $disabled ) . ' 
	                id="wp_member_reg" 
	                class="app_enable" 
	                data-toggle="wp_member_reg_options" 
	                name="mo_customer_validation_wp_member_reg_enable" 
	                value="1"
	                ' . esc_attr( $wp_member_reg_enabled ) . ' />
            <strong>' . esc_html( $form_name ) . '</strong>';

echo '	    <div class="mo_registration_help_desc" ' . esc_attr( $wp_member_reg_hidden ) . ' id="wp_member_reg_options">
				<p>
				    <input  type="radio" 
				            ' . esc_attr( $disabled ) . ' 
				            id="wpmembers_reg_phone" 
				            class="app_enable" 
				            data-toggle="wpmembers_reg_phone_instructions" 
				            name="mo_customer_validation_wp_member_reg_enable_type" 
				            value="' . esc_attr( $wpm_type_phone ) . '"
					        ' . ( esc_attr( $wpmember_enabled_type ) === esc_attr( $wpm_type_phone ) ? 'checked' : '' ) . ' />
                    <strong>' . esc_html( mo_( 'Enable Phone Verification' ) ) . '</strong>
				</p>								
				<div ' . ( esc_attr( $wpmember_enabled_type ) !== esc_attr( $wpm_type_phone ) ? 'hidden' : '' ) . ' 
				     class="mo_registration_help_desc" 
				     id="wpmembers_reg_phone_instructions">			
					' . esc_html( mo_( 'Follow the following steps to enable Phone Verification for WP Member' ) ) . ':
					<ol>
						<li>
						    <a href="' . esc_url( $wpm_field_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' .
							esc_html( mo_( 'to see your list of the fields.' ) ) . '
                        </li>
						<li>' . esc_html( mo_( 'Enable the Phone field for your form and keep it required. Note the Phone Field Meta Key.' ) ) . '</li>
						<li>' . wp_kses( mo_( 'Create a new text field with meta key <i>validate_otp</i> where users can enter the validation code.' ), array( 'i' => array() ) ) . '</li>
						<li>' . esc_html( mo_( 'Enter the Phone Field Meta Key' ) );

								mo_draw_tooltip(
									MoMessages::showMessage( MoMessages::META_KEY_HEADER ),
									MoMessages::showMessage( MoMessages::META_KEY_BODY )
								);

								echo '					        : <input    class="mo_registration_table_textbox"
                                            id="mo_customer_validation_wp_member_reg_phone_field_key"
                                            name="mo_customer_validation_wp_member_reg_phone_field_key"
                                            type="text"
                                            value="' . esc_attr( $wpmember_field_key ) . '">
                        </li>
						<li>' . esc_html( mo_( 'Click on the Save Button to save your settings.' ) ) . '</li>						
					</ol>
				</div>
									
				<p>
				    <input  type="radio" 
				            ' . esc_attr( $disabled ) . ' 
				            id="wpmembers_reg_email" 
				            class="app_enable" 
				            data-toggle="wpmembers_reg_email_instructions" 
				            name="mo_customer_validation_wp_member_reg_enable_type" 
				            value="' . esc_attr( $wpm_type_email ) . '"
					        ' . ( esc_attr( $wpmember_enabled_type ) === esc_attr( $wpm_type_email ) ? 'checked' : '' ) . ' />
					<strong>' . esc_html( mo_( 'Enable Email Verification' ) ) . '</strong>
				</p>
										
                <div ' . ( esc_attr( $wpmember_enabled_type ) !== esc_attr( $wpm_type_email ) ? 'hidden' : '' ) . ' 
                     class="mo_registration_help_desc" 
                     id="wpmembers_reg_email_instructions">			
                        ' . esc_html( mo_( 'Follow the following steps to enable Email Verification for WP Member' ) ) . ':
                        <ol>
                            <li>
                                <a href="' . esc_url( $wpm_field_list ) . '" target="_blank">' . esc_html( mo_( 'Click Here' ) ) . '</a> ' .
									esc_html( mo_( 'to see your list of fields.' ) ) . '
                            </li>
                            <li>' . wp_kses( mo_( 'Create a new text field with meta key <i>validate_otp</i> where users can enter the validation code.' ), array( 'i' => array() ) ) . '</li>
                            <li>' . esc_html( mo_( 'Click on the Save Button to save your settings.' ) ) . '</li>
                        </ol>
                </div>					
            </div>
        </div>';
