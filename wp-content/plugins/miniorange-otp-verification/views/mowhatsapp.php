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
use OTP\Helper\MoConstants;


$circle_icon = '
	<svg class="min-w-[8px] min-h-[8px]" width="8" height="8" viewBox="0 0 18 18" fill="none">
		<circle id="a89fc99c6ce659f06983e2283c1865f1" cx="9" cy="9" r="7" stroke="rgb(99 102 241)" stroke-width="4"></circle>
	</svg>
	';

$whatsapp_view = '
	<div id="mo-new-pricing-page" class="mo-new-pricing-page mt-mo-4 bg-white rounded-md">

		<!--  TABS  -->
		<div class="mo-tab-container" style="padding-top: 10px; padding-bottom: 20px;">
			<h2 style=" font-size:1.300rem;" class="mo-heading pl-mo-4">' . esc_html( mo_( 'WhastApp For OTP Verification And Notifications' ) ) . '</h2>          
		</div>

		<!--  TABS CONTENT  -->
		<div id="whatsapp-tab-content">
			<!--  TEST GATEWAY AND PRICING SECTION  -->
			<section id="mo_otp_plans_pricing_table">
				<div hidden>
					<div class="whatsapp-test-configuration">

						<div class="mo-title flex-1" style="width:50%;" >
							<p class="mo_wa_note" style="">' . esc_html( mo_( 'This feature allows you to configure WhatsApp for OTP Verification as well as sending SMS notifications and alerts via WhatsApp.' ) ) . '
							</p>
						</div>
						<form name="f" method="post" action="" id="mo_whatsapp_settings" hidden >
							<input type="hidden" id="mo_admin_actions" name="mo_admin_actions" value="' . wp_create_nonce( 'mo_admin_actions' ) . '"/>

							<div class="whatsapp-test-configuration pr-mo-10 border-cbd5e1" id="wa_test_configuration" >

								<span class="tooltip">
									<input 	class="w-full mo-button inverted "  type="button"
									name="mo_gateway_submit" ' . esc_attr( $whatsapp_disabled ) . '
									id="test_whatsapp_otp"
									value="Test WhatsApp" />';
if ( ! $tooltip_disabled ) {

	$whatsapp_view .= ' 			<span class="tooltiptext" style="background-color:#EFF6FF; color:black; margin-top:5px; width: 180px;">
										<span class="body">' . esc_html( mo_( 'Register with miniOrange before testing WhatsApp OTP.' ) ) . '</span>
									</span>';
}
$whatsapp_view .= ' 			</span>
							</div>
						</form>

					</div>
				</div>
				<div class="mo-section-header bg-slate-100">
						<h4 id="mo-section-heading" class="mo-heading">WhatsApp Plans:</h4>
					</div>

					<div class="mo-whatsapp-snippet-grid">
						<div class="mo-whatsapp-card" style="border:none;" >
							<div>
								<h5>Use miniOrange Business Account</h5>
									<div class="my-mo-4 flex gap-mo-1">
										<h1 class="m-mo-0">$99</h1><span style="margin-top:1%"> + (transaction-based pricing)</span>
									</div>
							</div> 

							<ul class="mt-mo-4 grow" >

								<li class="feature-snippet">
									<p class="border rounded-smooth p-mo-4 bg-slate-50 text-xs">
									<span><b>Note:</b> Need to purchase WhatsApp transactions from <b>miniOrange</b>.</span></p>
								</li>

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Use the default miniOrange Business account.</p>
								</li>
								
								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Country-based transactions pricing.</p>
								</li>

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">WhatsApp OTP Verification and notification.</p>
								</li> 

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Fallback to SMS OTP for non-WhatsApp numbers.</p>
								</li>

							</ul>

							<a class="w-full mo-button medium primary"  onclick="otpSupportOnClick(\'Hi! I am interested in using WhatsApp for my website and want to use miniOrange business account, can you please provide more information?\');">Upgrade Now</a><br>
						</div>

						<div class="mo-whatsapp-card mr-mo-4">
							<div>
								<h5>Use Personal Business Account</h5>
									<div class="my-mo-4 flex gap-mo-1">
										<h1 class="m-mo-0">$99</h1><span style="margin-top:1%"> + (transaction-based pricing)</span>
									</div>
							</div>    
							
							<ul class="mt-mo-4 grow">

								<li class="feature-snippet">
									<p class="border p-mo-4 bg-slate-50 text-xs">
									<span><b>Note:</b> Need to purchase WhatsApp transactions from <b>Meta(Facebook)</b>.
								</li> 

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Use your personal Business account.</p>
								</li>

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Meta handles transactions pricing.</p>
								</li>

								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">WhatsApp OTP Verification and notification.</p>
								</li> 
								
								<li class="wa-feature-snippet">
									<span class="mt-mo-1">' . wp_kses( $circle_icon, MoUtility::mo_allow_svg_array() ) . '</span>
									<p class="m-mo-0">Fallback to SMS OTP for non-WhatsApp numbers.</p>
								</li>

							</ul>

							<a class="w-full mo-button medium primary"  onclick="otpSupportOnClick(\'Hi! I am interested in using WhatsApp for my website and want to use my own business account, can you please share the payment link?\');">Upgrade Now</a><br>
						</div>

					</div>   
			</section> 
		</div>
	</div>';

$whatsapp_view = apply_filters( 'wa_premium_view', $whatsapp_view );

echo wp_kses(
	$whatsapp_view,
	array(
		'div'      => array(
			'name'   => array(),
			'id'     => array(),
			'class'  => array(),
			'title'  => array(),
			'style'  => array(),
			'hidden' => array(),
		),
		'span'     => array(
			'class'  => array(),
			'title'  => array(),
			'style'  => array(),
			'hidden' => array(),
		),
		'textarea' => array(
			'id'          => array(),
			'class'       => array(),
			'name'        => array(),
			'row'         => array(),
			'style'       => array(),
			'placeholder' => array(),
			'readonly'    => array(),
		),
		'input'    => array(
			'type'          => array(),
			'id'            => array(),
			'name'          => array(),
			'value'         => array(),
			'class'         => array(),
			'tabindex'      => array(),
			'hidden'        => array(),
			'style'         => array(),
			'placeholder'   => array(),
			'disabled'      => array(),
			'data-toggle'   => array(),
			'data-previous' => array(),
			'checked'       => array(),
		),
		'strong'   => array(),
		'form'     => array(
			'name'   => array(),
			'method' => array(),
			'action' => array(),
			'id'     => array(),
			'hidden' => array(),
		),
		'a'        => array(
			'onclick' => array(),
			'class'   => array(),
		),
		'p'        => array(
			'class' => array(),
			'style' => array(),
		),
		'li'       => array(
			'class'  => array(),
			'hidden' => array(),
		),
		'section'  => array(
			'id' => array(),
		),
		'label'    => array(
			'class' => array(),
		),
		'ul'       => array(
			'class' => array(),
		),
		'h1'       => array(
			'class' => array(),
		),
		'h2'       => array(
			'class' => array(),
			'style' => array(),
		),
		'h4'       => array(
			'class' => array(),
			'style' => array(),
		),
		'h5'       => array(
			'class' => array(),
			'style' => array(),
		),
		'svg'      => array(
			'class'   => true,
			'width'   => true,
			'height'  => true,
			'viewbox' => true,
			'fill'    => true,
		),
		'circle'   => array(
			'id'           => true,
			'cx'           => true,
			'cy'           => true,
			'cz'           => true,
			'r'            => true,
			'stroke'       => true,
			'stroke-width' => true,
		),
		'g'        => array(
			'fill' => true,
			'id'   => true,
		),
		'path'     => array(
			'd'              => true,
			'fill'           => true,
			'id'             => true,
			'stroke'         => true,
			'stroke-width'   => true,
			'stroke-linecap' => true,
		),
	)
);

echo '
	<div id="whatsapp_test_pop_up" style="display:none;">
		<div id="mo_notice_modal" name="mo_test_whatsapp">
			<div class="mo_customer_validation-modal-backdrop ">
			</div>

			<div id="popup-modal" class="mo-popup-modal">
                <div id="whatsapp_show_popup" class="mo-popup-modal-wrapper">
				 	<div class="mo-popup-header-wrapper" style="border-bottom: 1px groove; background-color:#d1f7d9;">

                        <div class="mo-popup-text-wrapper mo-center" style="color:black;">
                            ' . esc_html( mo_( 'Test WhatsApp OTP' ) ) . '
                        </div>

                        <button type="button" id="mo_close_wp_pop_up_button" class="mo-popup-close-button" data-modal-hide="staticModal">
                            <svg class="w-mo-6 h-mo-6" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </div>

					<div class="px-mo-5" style="background-color: white;">
						<div class="py-mo-2 rounded-lg ">
							<div class="p-mo-4 text-xs font-semibold rounded-lg bg-blue-50" role="alert">
							Enter the below details to test the WhatsApp OTP on the Entered Phone number.
						</div>
                	</div>

					<div class="pt-mo-4">
								<div class="mo-input-wrapper">
									<label class="mo-input-label">' . esc_html( mo_( 'Phone Number' ) ) . '</label>
									<input class=" mo-form-input" style="width:300px;" id="wa_test_configuration_phone" placeholder="Enter Phone Number with country code." type="text" name="wa_test_configuration_phone" >
								</div>
					</div>

					<div class="pt-mo-4">
						<div class="mo-input-wrapper">
							<label class="mo-input-label">' . esc_html( mo_( 'miniOrange Email Address' ) ) . '</label>
							<input type="email" class="mo-form-input" style="width:300px;" id="wa_test_configuration_email_address" placeholder="Enter Registered email address." type="text" name="wa_test_configuration_email_address" >
						</div>
					</div>

					<div class="pt-mo-4">
						<div class="mo-input-wrapper">
							<label class="mo-input-label">' . esc_html( mo_( 'miniOrange Password' ) ) . '</label>
							<input class=" mo-form-input" type="password" style="width:300px;" id="wa_test_configuration_password" placeholder="Enter miniOrange accounts password." type="text" name="wa_test_configuration_password" />
						</div>
					</div>

					<div  name="mo_test_config_hide_response"  class="vfb-item" id="test_config_response" style="width:100%; display: none; padding: 10px 20px;border-radius: 10px; margin-top: 16px;"></div>

					<div class="my-mo-4">
						<input 	class="w-full mo-button inverted "  type="button"
							name="mo_gateway_submit" ' . esc_attr( $whatsapp_disabled ) . '
							id="whatsapp_gateway_submit"
							value="Send WhatsApp OTP"/>
					</div>
				</div>
			</div>
		</div>
	</div>';




