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

            <div id="custom_sms_phone_shortcode">
                <div>
                    <b>' . esc_html( mo_( 'Phone Numbers:' ) ) . '</b>
                </div>
                <div>   
                    <input ' . esc_attr( $disabled ) . '
                        type ="text"
                        id="custom_sms_phone_numbers"
                        style="border:1px solid #ddd; height: 30px; width:100%; border-radius: 4px;
                        name="mo_phone_numbers"
                    value="" required>
                </div>    
            </div>';


echo '      <div id="custom_sms_template">
                <div style="margin-top:10px;">
                    <b>' . esc_html( mo_( 'SMS Template: ' ) ) . '</b>
                </div>
                <div style="margin-bottom:20px;">
                    <textarea ' . esc_attr( $disabled ) . ' 
                            id="custom_sms_msg"
                            style="border:1px solid #ddd; width: 100%;  height: 50px; border-radius: 4px;"
                            name="mo_customer_validation_custom_sms_msg"
                            >
                    </textarea>
                    <span id="characters">Remaining Characters : <span id="remaining"></span> </span>
                </div>
            </div>';

echo ' 
        </div>';
