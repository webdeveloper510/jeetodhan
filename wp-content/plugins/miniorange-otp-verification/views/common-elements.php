<?php
/**
 * Load user view for admin panel.
 *
 * @package miniorange-otp-verification/views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

use OTP\Helper\CountryList;
use OTP\Helper\FormList;
use OTP\Helper\GatewayFunctions;
use OTP\Helper\MoUtility;
use OTP\Helper\Templates\DefaultPopup;
use OTP\Helper\Templates\ErrorPopup;
use OTP\Helper\Templates\ExternalPopup;
use OTP\Helper\Templates\UserChoicePopup;
use OTP\Objects\TabDetails;
use OTP\Objects\Tabs;

/**
 * This displays a link next to the name of each of the forms under the
 * forms tab so that user can see if the form in question is the correct
 * form.
 * Also adds A link to Guide and Video Tutorial if any.
 *
 * @param  array $formalink -   array of the link to the forms main page['formLink'],
 *                              guide Link['guideLink] and Video Tutotial['videoLink].
 */
function get_plugin_form_link( $formalink ) {
	if ( MoUtility::sanitize_check( 'formLink', $formalink ) ) {
		echo '<a    class="dashicons mo-form-links dashicons-feedback mo_form_icon"
                    href="' . esc_url( $formalink['formLink'] ) . '"
                    title="' . esc_attr( $formalink['formLink'] ) . '"
                    id="formLink"  
                    target="_blank">' .
				'<span class="mo-link-text">' . esc_html( mo_( 'FormLink' ) ) . '</span>' .
			'</a>';
	}
	if ( MoUtility::sanitize_check( 'guideLink', $formalink ) ) {
		echo '<a    class="dashicons mo-form-links dashicons-book-alt mo_book_icon"
                    href="' . esc_url( $formalink['guideLink'] ) . '"
                    title="Instruction Guide"
                    id="guideLink" 
                    target="_blank">' .
				'<span class="mo-link-text">' . esc_html( mo_( 'Setup Guide' ) ) . '</span>' .
			'</a>';
	}
	if ( MoUtility::sanitize_check( 'videoLink', $formalink ) ) {
		echo '<a    class="dashicons mo-form-links dashicons-video-alt3 mo_video_icon"
                    href="' . esc_url( $formalink['videoLink'] ) . '"
                    title="Tutorial Video"
                    id="videoLink"  
                    target="_blank">' .
				'<span class="mo-link-text">' . esc_html( mo_( 'Video Tutorial' ) ) . '</span>' .
			'</a>';
	}
	echo '<br/><br/>';
}


/**
 * Display a tooltip with the appropriate header and message on the page
 *
 * @param  string $header  - the header of the tooltip.
 * @param  string $message - the body of the tooltip message.
 */
function mo_draw_tooltip( $header, $message ) {
	echo '        <span class="tooltip">
            <span class="dashicons dashicons-editor-help"></span>
            <span class="tooltiptext">
                <span class="header"><b><i>' . esc_html( mo_( $header ) ) . '</i></b></span><br/><br/>
                <span class="body">' . esc_html( mo_( $message ) ) . '</span>
            </span>
          </span>';
}


/**
 * This is used to display extra post data as hidden fields in the verification
 * page so that it can used later on for processing form data after verification
 * is complete and successful.
 *
 * @param array $data - the data posted by the user using the form.
 * @return string
 */
function extra_post_data( $data = null ) {
	$ignore_fields = array(
		'moFields'          => array(
			'option',
			'mo_otp_token',
			'miniorange_otp_token_submit',
			'miniorange-validate-otp-choice-form',
			'submit',
			'mo_customer_validation_otp_choice',
			'register_nonce',
			'timestamp',
		),
		'loginOrSocialForm' => array(
			'user_login',
			'user_email',
			'register_nonce',
			'option',
			'register_tml_nonce',
			'mo_otp_token',
		),
	);

	$extra_post_data      = '';
	$login_or_social_form = false;
	$login_or_social_form = apply_filters( 'is_login_or_social_form', $login_or_social_form );
	$fields               = ! $login_or_social_form ? 'moFields' : 'loginOrSocialForm';
	foreach ( $_POST as $key => $value ) {// phpcs:ignore WordPress.Security.NonceVerification.Missing -- No need for nonce verification as the function is called on third party plugin hook.
		$extra_post_data .= ! in_array( $key, $ignore_fields[ $fields ], true ) ? get_hidden_fields( $key, $value ) : '';
	}
	return $extra_post_data;
}

/**
 * Show hidden fields. Makes hidden input fields on the page.
 *
 * @param  string $key   - the name attribute of the hidden field.
 * @param  string $value - the value of the input field.
 * @return string
 */
function get_hidden_fields( $key, $value ) {
	if ( 'wordfence_userDat' === $key ) {
		return;
	}
	$hidden_val = '';
	if ( is_array( $value ) ) {
		foreach ( $value as $t => $val ) {
			$hidden_val .= get_hidden_fields( $key . '[' . $t . ']', $val );
		}
	} else {
		$hidden_val .= '<input type="hidden" name="' . $key . '" value="' . $value . '" />';
		return $hidden_val;
	}
}


/**
 * The HTML code to display the OTP Verification pop up with appropriate messaging
 * and hidden fields for later processing.
 *
 * @param string $user_login the username posted by the user.
 * @param string $user_email the email posted by the user.
 * @param string $phone_number the phone number posted by the user.
 * @param string $message message posted by the user.
 * @param string $otp_type the verification type.
 * @param string $from_both any extra data posted by the user.
 */
function miniorange_site_otp_validation_form( $user_login, $user_email, $phone_number, $message, $otp_type, $from_both ) {
	if ( ! headers_sent() ) {
		header( 'Content-Type: text/html; charset=utf-8' );
	}
	$error_popup_handler   = ErrorPopup::instance();
	$default_popup_handler = DefaultPopup::instance();
	$html_content          = MoUtility::is_blank( $user_email ) && MoUtility::is_blank( $phone_number ) ?
					apply_filters( 'mo_template_build', '', $error_popup_handler->get_template_key(), $message, $otp_type, $from_both )
					: apply_filters( 'mo_template_build', '', $default_popup_handler->get_template_key(), $message, $otp_type, $from_both );
	echo wp_kses( mo_( $html_content ), MoUtility::mo_allow_html_array() );
	exit();
}


/**
 * Display the user choice popup where user can choose between email or
 * sms verification.
 *
 * @param string $user_login the username posted by the user.
 * @param string $user_email the email posted by the user.
 * @param string $phone_number the phone number posted by the user.
 * @param string $message message posted by the user.
 * @param string $otp_type the verification type.
 */
function miniorange_verification_user_choice( $user_login, $user_email, $phone_number, $message, $otp_type ) {
	if ( ! headers_sent() ) {
		header( 'Content-Type: text/html; charset=utf-8' );
	}
	$user_choice_popup = UserChoicePopup::instance();
	$htmlcontent       = apply_filters( 'mo_template_build', '', $user_choice_popup->get_template_key(), $message, $otp_type, true );
	echo wp_kses( mo_( $htmlcontent ), MoUtility::mo_allow_html_array() );
	exit();
}


/**
 * Display the popup where user has to enter his phone number and then
 * validate the OTP sent to it. This phone number is later stored in the
 *
 * @param string $go_back_url the redirection url on click of go back button.
 * @param string $user_email the email posted by the user.
 * @param string $message message posted by the user.
 * @param string $form the form details posted by the user.
 * @param string $usermeta the user meta.
 * database.
 */
function mo_external_phone_validation_form( $go_back_url, $user_email, $message, $form, $usermeta ) {
	if ( ! headers_sent() ) {
		header( 'Content-Type: text/html; charset=utf-8' );
	}
	$external_pop_up = ExternalPopup::instance();
	$htmlcontent     = apply_filters( 'mo_template_build', '', $external_pop_up->get_template_key(), $message, null, false );

	wp_print_scripts( 'jquery' );
	echo wp_kses( mo_( $htmlcontent ), MoUtility::mo_allow_html_array() );
	exit();
}

/**
 * Display a dropdown on the page with list of all plugins that are supported.
 */
function get_otp_verification_form_dropdown() {
	$count        = 0;
	$form_handler = FormList::instance();
	$tab_details  = TabDetails::instance();
	$request_uri  = isset( $_SERVER['REQUEST_URI'] ) ? esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ) ) : '';
	echo '
        <div class="modropdown" id="modropdown">
            <span class="dashicons dashicons-search"></span>
                <input type="text" id="searchForm" class="dropbtn" placeholder="' . esc_attr( mo_( 'Search and select your Form.' ) ) . '" />
            <div class="modropdown-content" id="formList">';

	foreach ( $form_handler->get_list() as $key => $form ) {
		$count++;
		$class_name = get_mo_class( $form );
		$class_name = $form->is_form_enabled() ? 'configured_forms#' . $class_name : $class_name . '#' . $class_name;
		$url        = add_query_arg(
			array(
				'page' => $tab_details->tab_details[ Tabs::FORMS ]->menu_slug,
				'form' => $class_name,
			),
			$request_uri
		); if ( ! $form->is_add_on_form() ) {
			echo '<div class="search_box">';
			echo '<a class="mo_search"';
			echo ' href="' . esc_url( $url ) . '" ';
			echo ' data-value="' . esc_attr( $form->get_form_name() ) . '" data-form="' . esc_attr( $class_name ) . '">';
			echo ' <span class="';
			echo $form->is_form_enabled() ? 'enabled">' : '">';
			echo esc_attr( $count ) . '.&nbsp';
			echo $form->is_form_enabled() ? '(  ENABLED  )' : '';
			echo wp_kses(
				$form->get_form_name(),
				array(
					'b'    => array(),
					'span' => array(
						'style' => array(),
					),
				)
			) . '</span></a></div>';

		}
	}
	echo ' </div>
        </div>';
}


/**
 * Display a dropdown with country and it's respective country code.
 */
function get_country_code_dropdown() {
	echo '<select name="default_country_code" id="mo_country_code">';
	echo '<option value="" disabled selected="selected">
            --------- ' . esc_html( mo_( 'Select your Country' ) ) . ' -------
          </option>';
	foreach ( CountryList::get_countrycode_list() as $key => $country ) {
		echo '<option data-countrycode="' . esc_attr( $country['countryCode'] ) . ' " value="' . esc_attr( $key ) . ' "';
		echo CountryList::is_country_selected( esc_attr( $country['countryCode'] ), esc_attr( $country['alphacode'] ) ) ? 'selected' : '';
		echo '>' . esc_attr( $country['name'] ) . '</option>';
	}
	echo '</select>';
}


/**
 * Display a multiselect dropdown to select countries to show in the
 * dropdown.
 *
 * @todo : This is for a future plugin update which allows user to select list of countries to be shown in the dropdown
 */
function get_country_code_multiple_dropdown() {
	echo '<select multiple size="5" name="allow_countries[]" id="mo_country_code">';
	echo '<option value="" disabled selected="selected">
            --------- ' . esc_html( mo_( 'Select your Countries' ) ) . ' -------
          </option>';

	echo '</select>';
}


/**
 * Loop through and show only configured form list
 *
 * @param string $controller -controller attributes.
 * @param string $disabled  -disabled attributes.
 * @param string $page_list  -List of pages.
 */
function show_configured_form_details( $controller, $disabled, $page_list ) {

	$form_handler = FormList::instance();

	foreach ( $form_handler->get_list() as $form ) {
		if ( $form->is_form_enabled() && ! $form->is_add_on_form() ) {
			$namespace_class = get_class( $form );
			$class_name      = substr( $namespace_class, strrpos( $namespace_class, '\\' ) + 1 );
			include $controller . 'forms/class-' . strtolower( $class_name ) . '.php';
			echo '<br/>';
		}
	}
}


/**
 * This function is used to show a multi-select dropdown of WooCommerce
 * Checkout Page.
 *
 * @param string $disabled  -disabled attributes.
 * @param array  $checkout_payment_plans -checkout payment plans.
 */
function get_wc_payment_dropdown( $disabled, $checkout_payment_plans ) {
	if ( ! is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		echo esc_html( mo_( '[ Please activate the WooCommerce Plugin ]' ) );
		return;
	}
	$payment_plans = WC()->payment_gateways->payment_gateways();  // phpcs:ignore intelephense.diagnostics.undefinedFunctions -- Default function of Woocommerce
	echo '<select multiple size="5" name="wc_payment[]" id="wc_payment">';
	echo '<option value="" disabled>' . esc_html( mo_( 'Select your Payment Methods' ) ) . '</option>';
	foreach ( $payment_plans as $payment_plan ) {
		echo '<option ';
		if ( $checkout_payment_plans && array_key_exists( $payment_plan->id, $checkout_payment_plans ) ) {
			echo 'selected';
		} elseif ( ! $checkout_payment_plans ) {
			echo 'selected';
		}
		echo ' value="' . esc_attr( $payment_plan->id ) . ' ">' . esc_html( $payment_plan->title ) . '</option>';
	}
	echo '</select>';
}


/**
 * This function is called to generate the form details fields for a form.
 *
 * @param array  $form_details the details posted by the user.
 * @param string $show_verify_field show verify fields.
 * @param string $show_email_and_phone_field show email and phone field.
 * @param string $disabled disabled attribute.
 * @param string $key the name attribute of the hidden field.
 * @param string $form_name the name of the form.
 * @param string $key_type the type of the key.
 * @return mixed
 */
function get_multiple_form_select( $form_details, $show_verify_field, $show_email_and_phone_field, $disabled, $key, $form_name, $key_type ) {

	$row_template = "<div id='row{FORM}{KEY}_{INDEX}'>
                            %s : 
                            <input 	id='{FORM}_form_{KEY}_{INDEX}' 
                                    class='field_data' 
                                    name='{FORM}_form[form][]' 
                                    type='text' 
                                    value='{FORM_ID_VAL}'>
                                    {EMAIL_AND_PHONE_FIELD}
                                    {VERIFY_FIELD}
                        </div>";

	$email_and_phone_field = " <span {HIDDEN1}>
                                    %s: 
                                    <input  id='{FORM}_form_email_{KEY}_{INDEX}' 
                                            class='field_data' 
                                            name='{FORM}_form[emailkey][]' 
                                            type='text' 
                                            value='{EMAIL_KEY_VAL}'>
                                </span>
                                <span {HIDDEN2}>
                                    %s: 
                                    <input  id='{FORM}_form_phone_{KEY}_{INDEX}' 
                                            class='field_data'  
                                            name='{FORM}_form[phonekey][]' 
                                            type='text' value='{PHONE_KEY_VAL}'>
                                </span>";

	$verify_field = "<span>
                            %s: 
                            <input 	class='field_data' 
                                    id='{FORM}_form_verify_{KEY}_{INDEX}' 
                                    name='{FORM}_form[verifyKey][]' 
                                    type='text' value='{VERIFY_KEY_VAL}'>
                        </span>";

	$verify_field = $show_verify_field ? $verify_field : '';

	$email_and_phone_field = $show_email_and_phone_field ? $email_and_phone_field : '';

	$row_template = MoUtility::replace_string(
		array(
			'VERIFY_FIELD'          => $verify_field,
			'EMAIL_AND_PHONE_FIELD' => $email_and_phone_field,
		),
		$row_template
	);

	$row_template = sprintf(
		$row_template,
		mo_( 'Form ID' ),
		mo_( 'Email Field' . $key_type ),
		mo_( 'Phone Field' . $key_type ),
		mo_( 'Verification Field' . $key_type )
	);

	$counter = 0;
	if ( MoUtility::is_blank( $form_details ) ) {
		$details = array(
			'KEY'            => $key,
			'INDEX'          => 0,
			'FORM'           => $form_name,
			'HIDDEN1'        => 2 === $key ? 'hidden' : '',
			'HIDDEN2'        => 1 === $key ? 'hidden' : '',
			'FORM_ID_VAL'    => '',
			'EMAIL_KEY_VAL'  => '',
			'PHONE_KEY_VAL'  => '',
			'VERIFY_KEY_VAL' => '',
		);
		echo wp_kses(
			MoUtility::replace_string( $details, $row_template ),
			array(
				'div'   => array( 'id' => array() ),
				'input' => array(
					'id'    => array(),
					'class' => array(),
					'name'  => array(),
					'type'  => array(),
					'value' => array(),
				),
				'span'  => array(
					'hidden' => array(),
				),
			)
		);
	} else {
		foreach ( $form_details as $form_key => $form_detail ) {
			$details = array(
				'KEY'            => $key,
				'INDEX'          => $counter,
				'FORM'           => $form_name,
				'HIDDEN1'        => 2 === $key ? 'hidden' : '',
				'HIDDEN2'        => 1 === $key ? 'hidden' : '',
				'FORM_ID_VAL'    => $show_email_and_phone_field ? $form_key : $form_detail,
				'EMAIL_KEY_VAL'  => $show_email_and_phone_field ? $form_detail['email_show'] : '',
				'PHONE_KEY_VAL'  => $show_email_and_phone_field ? $form_detail['phone_show'] : '',
				'VERIFY_KEY_VAL' => $show_verify_field ? $form_detail['verify_show'] : '',
			);
			echo wp_kses(
				MoUtility::replace_string( $details, $row_template ),
				array(
					'div'   => array( 'id' => array() ),
					'input' => array(
						'id'    => array(),
						'class' => array(),
						'name'  => array(),
						'type'  => array(),
						'value' => array(),
					),
					'span'  => array(
						'hidden' => array(),
					),
				)
			);
			$counter++;
		}
	}
	$result['counter'] = $counter;
	return $result;
}

/**
 * This function is used to generate the scripts necessary to add or remove
 * fields for taking form details from the admin.
 *
 * @param string $show_verify_field show verify fields.
 * @param string $show_email_and_phone_field show email and phone field.
 * @param string $form_name the name of the form.
 * @param string $key_type the type of the key.
 * @param string $counters the counters.
 */
function multiple_from_select_script_generator( $show_verify_field, $show_email_and_phone_field, $form_name, $key_type, $counters ) {
	$row_template = "<div id='row{FORM}{KEY}_{INDEX}'>
                            %s : 
                            <input  id='{FORM}_form_{KEY}_{INDEX}' 
                                    class='field_data' 
                                    name='{FORM}_form[form][]' 
                                    type='text' 
                                    value=''> 
                                    {EMAIL_AND_PHONE_FIELD}{VERIFY_FIELD} 
                        </div>";

	$verify_field          = "<span> %s:
                            <input 	class='field_data' 
                                    id='{FORM}_form_verify_{KEY}_{INDEX}' 
                                    name='{FORM}_form[verifyKey][]' 
                                    type='text' value=''>
                        </span>";
	$email_and_phone_field = "<span class='{HIDDEN1}'> %s:
                                    <input 	id='{FORM}_form_email_{KEY}_{INDEX}' 
                                            class='field_data' 
                                            name='{FORM}_form[emailkey][]' 
                                            type='text' value=''>
                                </span>
                                <span class='{HIDDEN2}'> %s: 
                                    <input 	id='{FORM}_form_phone_{KEY}_{INDEX}' 
                                            class='field_data'  
                                            name='{FORM}_form[phonekey][]' 
                                            type='text' 
                                            value=''>
                                </span>";

	$verify_field          = $show_verify_field ? $verify_field : '';
	$email_and_phone_field = $show_email_and_phone_field ? $email_and_phone_field : '';

	$row_template = MoUtility::replace_string(
		array(
			'VERIFY_FIELD'          => $verify_field,
			'EMAIL_AND_PHONE_FIELD' => $email_and_phone_field,
		),
		$row_template
	);

	$row_template = sprintf(
		$row_template,
		mo_( 'Form ID' ),
		mo_( 'Email Field' . $key_type ),
		mo_( 'Phone Field' . $key_type ),
		mo_( 'Verification Field' . $key_type )
	);

	$row_template = trim( preg_replace( '/\s\s+/', ' ', $row_template ) );

	$script_template = '<script>
                                var {FORM}_counter1, {FORM}_counter2, {FORM}_counter3;
                                jQuery(document).ready(function(){  
                                    {FORM}_counter1 = ' . $counters[0] . '; {FORM}_counter2 = ' . $counters[1] . '; {FORM}_counter3 = ' . $counters[2] . "; 
                                });
                            </script>
                            <script>
                                function add_{FORM}( t, n )
                                {
                                    var count = this['{FORM}_counter'+n];
                                    var hidden1='',hidden2='',both='';
                                    var html = \"" . $row_template . "\";
                                    if(n===1) hidden2 = 'hidden';
                                    if(n===2) hidden1 = 'hidden';
                                    if(n===3) both = 'both_';
                                    count++;
                                    html = html.replace('{KEY}', n).replace('{INDEX}',count).replace('{HIDDEN1}',hidden1).replace('{HIDDEN2}',hidden2);
									if(count!==0) {
                                        \$mo(html.replace('{KEY}', n).replace('{INDEX}',count).replace('{HIDDEN1}',hidden1).replace('{HIDDEN2}',hidden2)).insertAfter(\$mo('#row{FORM}'+n+'_'+(count-1)+''));
                                    }
                                    this['{FORM}_counter'+n]=count;
                                }
                            
                                function remove_{FORM}( n )
                                {
                                    var count =   Math.max(this['{FORM}_counter1'],this['{FORM}_counter2'],this['{FORM}_counter3']);
                                    if(count !== 0) {
                                        \$mo('#row{FORM}1_' + count).remove();
                                        \$mo('#row{FORM}2_' + count).remove();
                                        \$mo('#row{FORM}3_' + count).remove();
                                        count--;
                                        this['{FORM}_counter3']=this['{FORM}_counter1']=this['{FORM}_counter2']=count;
                                    }       
                                }
                            </script>";
	$script_template = MoUtility::replace_string( array( 'FORM' => $form_name ), $script_template );
	echo wp_kses(
		$script_template,
		array(
			'div'    => array(
				'name'   => array(),
				'id'     => array(),
				'class'  => array(),
				'title'  => array(),
				'style'  => array(),
				'hidden' => array(),
			),
			'script' => array(),
			'span'   => array(
				'class'  => array(),
				'title'  => array(),
				'style'  => array(),
				'hidden' => array(),
			),
			'input'  => array(
				'type'        => array(),
				'id'          => array(),
				'name'        => array(),
				'value'       => array(),
				'class'       => array(),
				'size '       => array(),
				'tabindex'    => array(),
				'hidden'      => array(),
				'style'       => array(),
				'placeholder' => array(),
				'disabled'    => array(),
			),
		)
	);
}


/**
 * Shows AddonList
 * Mostly used on the Views Section of the plugin
 */
function show_addon_list() {
	$gateway = GatewayFunctions::instance();
	$gateway->show_addon_list();
}
