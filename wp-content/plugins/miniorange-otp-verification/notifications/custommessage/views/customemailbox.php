<?php
/**
 * Email shortcode view.
 *
 * @package miniorange-otp-verification/addons
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
echo '   <div id="custom_email_box">
            <table style="width:100%">
                <tr>
                    <td>
                        <b>' . esc_html( mo_( 'From ID:' ) ) . '</b>
                        <div>
                            <input  ' . esc_attr( $disabled ) . '
                                    id="custom_email_from_id"
                                    class=""
                                    style="border:1px solid #ddd; width:100%; height: 30px; border-radius: 4px;
                                    name="fromEmail"
                                    placeholder="' . esc_attr( mo_( 'Enter email address' ) ) . '"
                                    value = ""
                                    required/>
                        </div><br>
                        <b>' . esc_html( mo_( 'From Name:' ) ) . '</b>
                        <div >
                            <input  ' . esc_attr( $disabled ) . '
                                    id="custom_email_from_name"
                                    class=""
                                    style="border:1px solid #ddd; width:100%; height: 30px; border-radius: 4px;
                                    name="fromName"
                                    placeholder="' . esc_attr( mo_( 'Enter Name' ) ) . '"
                                    value = ""
                                    required/>
                        </div><br>
                        <b>' . esc_html( mo_( 'Subject:' ) ) . '</b>
                        <div >
                            <input  ' . esc_attr( $disabled ) . '
                                    id="custom_email_subject"
                                    class=""
                                    style="border:1px solid #ddd; width:100%; height: 30px; border-radius: 4px;
                                    name="subject"
                                    placeholder="' . esc_attr( mo_( 'Enter your OTP Email Subject' ) ) . '"
                                    value = ""
                                    required/>
                        </div><br>
                        <b>' . esc_html( mo_( 'To Email Address:' ) ) . '</b>
                        <div >
                            <input  ' . esc_attr( $disabled ) . '
                                    id="custom_email_to"
                                    class=""
                                    style="border:1px solid #ddd; width:100%; height: 30px; border-radius: 4px;
                                    name="toEmail"
                                    placeholder="' . esc_attr( mo_( 'Enter semicolon (;) to seperate email-addresses' ) ) . '"
                                    value = ""
                                    required/>
                        </div><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>' . esc_html( mo_( 'Email Template:' ) ) . '</b>';
						wp_editor( $content, $editor_id, $template_settings );
	echo '			</td>
                </tr>
            </table>
        </div>';
