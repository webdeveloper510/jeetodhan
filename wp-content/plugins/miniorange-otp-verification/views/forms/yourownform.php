<?php
/**
 * Load admin view for YourOwnForm.
 *
 * @package miniorange-otp-verification/views/forms
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\MoUtility;

echo '		<div class="mo_otp_form w-full" id="' . esc_attr( get_mo_class( $handler ) ) . '">
                <div style="color: darkblue;background: lightblue;padding:10px;border-radius:5px"> 
                    <span > This feature is introduced to show that the plugin works even with forms that are not yet integrated. Some of the features of OTP verification will not work with this custom form, hence it is advisable to not compromise with security of your form since errors won\'t be handled.<br>Please contact us for full integration of your form at <a style="cursor:pointer;" onClick="otpSupportOnClick();" style="color:darkblue"><b><u>otpsupport@xecurify.com</u></b></a></span>                
                </div>
                <br>
		        <input  type="checkbox" ' . esc_attr( $disabled ) . ' 
                        id="custom_form_contact" 
                        class="app_enable" 
                        data-toggle="custom_form_contact_options" 
                        name="mo_customer_validation_custom_form_contact_enable" 
                        value="1" ' . esc_attr( $custom_form_enabled ) . ' /><strong>' . wp_kses( $form_name, MoUtility::mo_allow_html_array() ) . '</strong>';

echo '			<div class="mo_registration_help_desc" id="custom_form_contact_options">
                    <b>' . esc_html( mo_( 'Choose between Phone or Email Verification' ) ) . '</b>
                    <div>
                        <input type="radio" ' . esc_attr( $disabled ) . ' id="custom_form_contact_email" class="app_enable" 
                        data-toggle="custom_form_contact_email_instructions" name="mo_customer_validation_custom_form_enable_type" 
                        value="' . esc_attr( $custom_form_type_email ) . '"
                        ' . ( esc_attr( $custom_form_enabled_type ) === esc_attr( $custom_form_type_email ) ? 'checked' : '' ) . ' /><strong>
                        ' . esc_html( mo_( 'Enable Email verification' ) ) . '</strong>
                    </div>
                    <div ' . ( esc_attr( $custom_form_enabled_type ) !== esc_attr( $custom_form_type_email ) ? 'hidden' : '' ) . ' class="mo_registration_help_desc_internal" 
                            id="custom_form_contact_email_instructions" >
                            ' . esc_html( mo_( 'Follow the below steps to enable Email Verification for' ) ) . '
                            Your own form: 
                                        <div class="mo_otp_note">
                                            <span ><b>NOTE: Choosing your selector</b><br><li> Element\'s id selector looks like \'<b>#element_id</b>\'</li><li> Element\'s class selector looks like \'<b>.element_class</b>\' </li><li> Element\'s name selector is \'<b>input[name=\'element_name\']</b>\' </li> 
                                            </span>
                                        </div>
                            <ol>
                            <li>Find your form\'s submit button selector through browser\'s console.
                            </li>
                                <li>
                                    ' . esc_html( mo_( 'Enter the Submit button selector below: ' ) ) . ' 
                                    <span class="tooltip">
                                        <span class="dashicons dashicons-editor-help"></span>
                                        <span class="tooltiptext" style="background-color:lightgrey;color:#606060">
                                            <span class="header" style="color:black">Trouble finding your forms Submit button selector?</span><hr>
                                            <span class="body">Selector is an unique "id", "name" or "class" of an element. You can find the selector while adding the desired field in your form or by using your browsers inspector.Ex: <b>#submit_button_id</b>
                                            </span>
                                        </span>
                                    </span>
                                    <div class="ml-mo-4 mt-mo-4" >
                                        <div class="mo-input-wrapper">
                                            <label class="mo-input-label">' . esc_html( mo_( 'Submit button selector' ) ) . '</label>
                                            <input type="hidden" name="custom_form[form][]" value="1"/>
                                            <input class=" mo-form-input w-[30%]" id = "mo_customer_validation_custom_form_submit_id" 
                                                placeholder="Enter your form\'s Submit button selector" 
                                                value="' . esc_attr( mo_( $custom_form_submit_selector ) ) . '" 
                                                type="text" name="custom_form[email][submit_id]" >
                                        </div> 
                                    </div>
                                </li>
                                <li>Find your form\'s Email Field selector through browser\'s console which you want to verify.  </li>
                                <li>
                                    ' . esc_html( mo_( 'Enter the Email field selector below: ' ) ) . ' 
                                    <span class="tooltip">
                                        <span class="dashicons dashicons-editor-help"></span>
                                        <span class="tooltiptext" style="background-color:lightgrey;color:#606060">
                                            <span class="header" style="color:black">Trouble finding your forms Email field selector?</span><hr>
                                            <span class="body">You need to provide the unique selector of the field you want to verify. You can find the selector while adding the desired field in your form or by using your browsers inspector. Ex: <b>#email_field_id</b>  
                                            </span>
                                        </span>
                                    </span>
                                    <div class="ml-mo-4 mt-mo-4" >
                                        <div class="mo-input-wrapper">
                                            <label class="mo-input-label">' . esc_html( mo_( 'Email Field selector' ) ) . '</label>
                                            <input class=" mo-form-input w-[50%]"
                                                placeholder="Enter your form\'s Email Field selector" 
                                                value="' . esc_attr( mo_( $custom_form_field_selector ) ) . '" 
                                                type="text" name="custom_form[email][field_id]" >
                                        </div> 
                                    </div>
                                </li>
                                
                                <li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
                            </ol>
                    </div>
                    <div><input type="radio" ' . esc_attr( $disabled ) . ' id="custom_form_contact_phone" class="app_enable" data-toggle="custom_form_contact_phone_instructions" name="mo_customer_validation_custom_form_enable_type" value="' . esc_attr( $custom_form_type_phone ) . '"
                        ' . ( $custom_form_enabled_type === $custom_form_type_phone ? 'checked' : '' ) . ' /><strong>' . esc_html( mo_( 'Enable Phone verification' ) ) . '</strong>
                    </div>
                    <div ' . ( $custom_form_enabled_type !== $custom_form_type_phone ? 'hidden' : '' ) . ' class="mo_registration_help_desc_internal" id="custom_form_contact_phone_instructions" >
                            ' . esc_html( mo_( 'Follow the following steps to enable Phone Verification for Your Own Form' ) ) . ': 
                                <div class="mo_otp_note">
                                    <span ><b>NOTE: Choosing your selector</b><br><li> Element\'s id selector looks like \'<b>#element_id</b>\'</li><li> Element\'s class selector looks like \'<b>.element_class</b>\' </li><li> Element\'s name selector is \'<b>input[name=\'element_name\']</b>\' </li> 
                                    </span>
                                </div>
                            <ol>
                                <li>Find your form\'s submit button selector through browser\'s console. </li>
                                <li>
                                    ' . esc_html( mo_( 'Enter the Submit button selector below: ' ) ) . ' 
                                     <span class="tooltip">
                                        <span class="dashicons dashicons-editor-help"></span>
                                        <span class="tooltiptext" style="background-color:lightgrey;color:#606060">
                                            <span class="header" style="color:black">Trouble finding your forms Submit button selector?</span><hr>
                                            <span class="body">Selector is an unique "id", "name" or "class" of an element. You can find the selector while adding the desired field in your form or by using your browsers inspector. 
                                            </span>
                                        </span>
                                    </span>
                                    <div class="ml-mo-4 mt-mo-4" >
                                        <div class="mo-input-wrapper">
                                            <label class="mo-input-label">' . esc_html( mo_( 'Submit button selector' ) ) . '</label>
                                            <input type="hidden" name="custom_form[form][]" value="1"/>
                                            <input class=" mo-form-input w-[30%]" id = "mo_customer_validation_custom_form_submit_id" 
                                                placeholder="Enter your form\'s Submit button selector" 
                                                value="' . esc_attr( mo_( $custom_form_submit_selector ) ) . '" 
                                                type="text" name="custom_form[phone][submit_id]" >
                                        </div> 
                                    </div>
                                </li>
                                <li>Find your form\'s Phone Field selector through browser\'s console which you want to verify.  </li>
                                <li>
                                    ' . esc_html( mo_( 'Enter the Phone Field selector below: ' ) ) . ' 
                                    <span class="tooltip">
                                        <span class="dashicons dashicons-editor-help"></span>
                                        <span class="tooltiptext" style="background-color:lightgrey;color:#606060">
                                            <span class="header" style="color:black">Trouble finding your forms Phone field selector?</span><hr>
                                            <span class="body">You need to provide the unique selector of the field you want to verify. You can find the selector while adding the desired field in your form or by using your browsers inspector.
                                            </span>
                                        </span>
                                    </span>
                                    <div class="ml-mo-4 mt-mo-4" >
                                        <div class="mo-input-wrapper">
                                            <label class="mo-input-label">' . esc_html( mo_( 'Phone Field selector' ) ) . '</label>
                                            <input class=" mo-form-input w-[30%]"
                                                placeholder="Enter your form\'s Phone Field selector" 
                                                value="' . esc_attr( mo_( $custom_form_field_selector ) ) . '" 
                                                type="text" name="custom_form[phone][field_id]" >
                                        </div> 
                                    </div>
                                </li>
                                
                                <li>' . esc_html( mo_( 'Click on the Save Button to save your settings' ) ) . '</li>
                            </ol>
                    </div>
                    <div class="ml-mo-4 mt-mo-2" >
                        <div class="mo-input-wrapper">
                            <label class="mo-input-label">' . esc_html( mo_( 'Verify OTP Button Text' ) ) . '</label>
                            <input class=" mo-form-input" 
                                placeholder="Enter the verification button text" 
                                value="' . esc_attr( $button_text ) . '" 
                                type="text" name="mo_customer_validation_custom_form_button_text" >
                        </div> 
                    </div>
                </div>
            </div>';
