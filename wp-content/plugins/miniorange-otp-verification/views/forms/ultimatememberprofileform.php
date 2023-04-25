<?php
/**
 * Load admin view for Ultimate Member Profile form.
 *
 * @package miniorange-otp-verification/views
 */

use OTP\Helper\MoMessages;
use OTP\Helper\MoUtility;

echo '		<div class="mo_otp_form" id="' . esc_attr( get_mo_class( $handler ) ) . '">
		            <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
		                    id="um_ac_default" 
		                    data-toggle="um_ac_default_options" 
                            class="app_enable" 
                            name="mo_customer_validation_um_profile_enable" 
                            value="1" ' . esc_attr( $um_acc_enabled ) . ' />
                    <strong>' . esc_html( $form_name ) . '</strong>';

echo '		    <div class="mo_registration_help_desc" 
                     ' . esc_attr( $um_acc_hidden ) . ' 
                     id="um_ac_default_options">
                        <b>' . esc_html( mo_( 'Choose the Pages you want to verify. Users will be asked verify their phone or email on update.' ) ) . '
                        </b>		
                        <p>
                            <input  type ="radio" ' . esc_attr( $disabled ) . ' 
                                    id ="um_ac_page" 
                                    class="app_enable" 
                                    name = "mo_customer_validation_um_profile_enable_type" 
                                    value= "' . esc_attr( $um_acc_type_email ) . '" 
                                    ' . ( esc_attr( $um_acc_enabled_type ) === esc_attr( $um_acc_type_email ) ? 'checked' : '' ) . '/>
                            <strong>' . esc_html( mo_( 'Account Page' ) ) . '</strong>
                            <i>' . esc_html( mo_( '( Email Verification )' ) ) . '</i> 
                        </p>
    
                        <p>
                            <input  type ="radio" ' . esc_attr( $disabled ) . ' 
                                    id ="um_profile_page" 
                                    class="app_enable" 
                                    name = "mo_customer_validation_um_profile_enable_type" 
                                    value= "' . esc_attr( $um_acc_type_phone ) . '"
                                    data-toggle="um_profile_phone_instructions" 
                                    ' . ( esc_attr( $um_acc_enabled_type ) === esc_attr( $um_acc_type_phone ) ? 'checked' : '' ) . '/>
                            <strong>' . esc_html( mo_( 'Profile Page' ) ) . '</strong>
                            <i>' . esc_html( mo_( '( Mobile Number Verification )' ) ) . '</i>
                            
                            <div    ' . ( esc_attr( $um_acc_enabled_type ) !== esc_attr( $um_acc_type_phone ) ? 'hidden' : '' ) . ' 
                                    id="um_profile_phone_instructions" 
                                    class="mo_registration_help_desc">
                                ' . esc_html( mo_( 'Follow the following steps to add a user phone number in the database' ) ) . ':
                                
                                <ol>
                                    <li>' . esc_html( mo_( 'Enter the phone User Meta Key' ) );

									mo_draw_tooltip(
										MoMessages::showMessage( MoMessages::META_KEY_HEADER ),
										MoMessages::showMessage( MoMessages::META_KEY_BODY )
									);

									echo '							: <input    class="mo_registration_table_textbox"
                                                id="mo_customer_validation_um_profile_phone_key_1_0"
                                                name="mo_customer_validation_um_profile_phone_key"
                                                type="text"
                                                value="' . esc_attr( $um_profile_field_key ) . '">
                                    <div class="mo_otp_note">
                                        ' . esc_html(
													mo_(
														"If you don't know the metaKey against which the phone " .
														'number is stored for all your users then put the default value as phone.'
													)
												) . '
                                    </div>
                                    <li>' . esc_html( mo_( 'Click on the Save Button to save your settings.' ) ) . '</li>
                                </ol>
                            
                                <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                                        id="um_profile_admin" 
                                        name="mo_customer_validation_um_profile_restrict_duplicates"	
                                        value="1"
                                        ' . esc_attr( $um_acc_restrict_duplicates ) . ' />
                                <strong>
                                    ' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '
                                </strong>
                            </div>                                
                        </p>
                        
                        <p>
                            <input  type="radio" ' . esc_attr( $disabled ) . ' 
                                    id="um_profile_both" 
                                    class="app_enable" 
                                    name="mo_customer_validation_um_profile_enable_type" 
                                    value="' . esc_attr( $um_acc_type_both ) . '" 
                                    data-toggle="um_profile_both_instructions" 
                                    ' . ( esc_attr( $um_acc_enabled_type ) === esc_attr( $um_acc_type_both ) ? 'checked' : '' ) . '/>
                            <strong>' . esc_html( mo_( 'Both Account and Profile Pages' ) ) . '</strong>
                            <i>' . esc_html( mo_( '( Both Email and Mobile Number Verification )' ) ) . '</i>
                                
                            <div    ' . ( esc_attr( $um_acc_enabled_type ) !== esc_attr( $um_acc_type_both ) ? 'hidden' : '' ) . ' 
                                    id="um_profile_both_instructions" 
                                    class="mo_registration_help_desc">
                                ' . esc_html( mo_( 'Follow the following steps to add a users phone number in the database' ) ) . ':  
                                    <ol>
                                        <li>' . esc_html( mo_( 'Enter the phone User Meta Key' ) );

										mo_draw_tooltip(
											MoMessages::showMessage( MoMessages::META_KEY_HEADER ),
											MoMessages::showMessage( MoMessages::META_KEY_BODY )
										);

										echo '							: <input    class="mo_registration_table_textbox"
                                                    id="mo_customer_validation_um_profile_phone_key_2_0"
                                                    name="mo_customer_validation_um_profile_phone_key"
                                                    type="text"
                                                    value="' . esc_attr( $um_profile_field_key ) . '">
                                        <div class="mo_otp_note" >
                                            ' . esc_attr(
														mo_(
															"If you don't know the metaKey against which the phone " .
															'number is stored for all your users then put the default value as phone.'
														)
													) . '
                                        </div>
                                        <li>' . esc_html( mo_( 'Click on the Save Button to save your settings.' ) ) . '</li>
                                    </ol>                            
                                <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                                        id="um_profile_admin1" 
                                        name="mo_customer_validation_um_profile_restrict_duplicates"	
                                        value="1" 
                                        ' . esc_attr( $um_acc_restrict_duplicates ) . ' />
                                <strong>
                                    ' . esc_html( mo_( 'Do not allow users to use the same phone number for multiple accounts.' ) ) . '
                                </strong>
                            </div>					
        			    </p>
                        <p>
                             <i><b>' . esc_html( mo_( 'Verification Button text' ) ) . ':</b></i>
                             <input class="mo_registration_table_textbox" 
                                    name="mo_customer_validation_um_profile_button_text" 
                                    data-toggle="um_both_instructions"
                                    type="text" 
                                    value="' . esc_attr( $um_acc_button_text ) . '">
                        </p>
                            
                </div>
		    </div>';
