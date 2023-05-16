<?php

class Stripe_Express_Shortcodes
{
    function register_shortcode( $atts )
    {
        global  $wpdb ;
        if ( !isset( $atts['id'] ) ) {
            return '<div>stripe-express: id is required.</div>';
        }
        $id = sanitize_text_field( $atts['id'] );
        $presql = $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'stripe_express_elements WHERE id=%s ORDER BY id DESC LIMIT 0,1', $id );
        $config = $wpdb->get_row( $presql, ARRAY_A );
        if ( !$config ) {
            return '<div>[stripe-express ${id}/] not found id: ' . $id . '</div>';
        }
        // Fetch price detail from stripe
        $paymentConfig = $config['paymentConfig'];
        $uiConfig = ( isset( $atts['uiConfig'] ) ? $atts['uiConfig'] : $config['uiConfig'] );
        $apiKey = ( get_option( 'stripe_express_mode' ) == 'test' ? get_option( 'stripe_express_test_key' ) : get_option( 'stripe_express_live_key' ) );
        $objectConfig = array(
            'apiKey'        => $apiKey,
            'theme'         => get_option( 'stripe_express_theme', '' ),
            'baseUrl'       => rest_url( IT_STRIPE_EXPRESS_REST_API . 'stripehook' ),
            'successUrl'    => esc_url_raw( get_option( 'stripe_express_success_url' ) ),
            'cancelUrl'     => esc_url_raw( get_option( 'stripe_express_cancel_url' ) ),
            'currency'      => get_option( 'stripe_express_currency' ),
            'language'      => get_option( 'stripe_express_language' ),
            'paymentConfig' => $paymentConfig,
            'uiConfig'      => $uiConfig,
        );
        // End getting
        $type = ( isset( $atts['type'] ) ? $atts['type'] : $config['type'] );
        $object_id = 'wp_stripe_express_object_' . uniqid();
        wp_enqueue_style( 'wp-stripe-express-elements' );
        wp_enqueue_script( 'wp-stripe-express-elements' );
        wp_localize_script( 'wp-stripe-express-elements', $object_id, $objectConfig );
        $theme = get_option( 'stripe_express_theme' );
        if ( !empty($theme) ) {
            wp_enqueue_style( 'wp-stripe-express-elements-theme' );
        }
        return '<div class="wp-stripe-express-shortcode" data-id="' . $object_id . '" data-type="' . $type . '"></div>';
    }
    
    function register_receipt_shortcode( $atts )
    {
        $atts = shortcode_atts( array(
            'hidden'              => 'false',
            'hide-thank-you'      => 'false',
            'hide-payment-detail' => 'false',
            'hide-billing-detail' => 'false',
            'hide-receipt-link'   => 'false',
        ), $atts, 'wp-stripe-express-receipt' );
        $session_id = $_GET['session_id'];
        if ( '' === trim( $session_id ) ) {
            return __( 'Invalid shortcode name: Empty session ID.' );
        }
        try {
            $stripe = new \Stripe\StripeClient( Stripe_Express_Stripe_Controller::getKey() );
            $session = $stripe->checkout->sessions->retrieve( $session_id, [
                'expand' => [ 'customer', 'payment_intent.payment_method' ],
            ] );
            $customer = $session->customer;
            $paymentIntent = $session->payment_intent;
            $placeholder = Stripe_Express_Utils::get_receipt_placeholders( $customer, $paymentIntent );
            wp_enqueue_script( 'wp-stripe-express-receipt', IT_STRIPE_EXPRESS_URL . '/includes/assets/js/receipt.js' );
            wp_localize_script( 'wp-stripe-express-receipt', 'wp_stripe_express_object_receipt', $placeholder );
        } catch ( Exception $ex ) {
            Stripe_Express_Logger::error( 'retrieve billing info' . $ex->getMessage() );
            return $ex->getMessage();
        }
        
        if ( !isset( $atts['hidden'] ) || $atts['hidden'] == 'false' ) {
            $hideThankYou = $atts['hide-thank-you'] == 'true';
            $hidePaymentDetail = $atts['hide-payment-detail'] == 'true';
            $hideBillingDetail = $atts['hide-billing-detail'] == 'true';
            $hideReceiptLink = $atts['hide-receipt-link'] == 'true';
            require_once IT_STRIPE_EXPRESS_DIR . '/templates/confirmation.php';
        }
    
    }

}