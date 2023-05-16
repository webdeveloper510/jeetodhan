<?php

class Stripe_Express_Stripe_Controller
{
    const  ONETIME_LINK = 'ONE_TIME_LINK' ;
    const  CHECKOUT_RECURRING_LINK = 'CHECKOUT_RECURRING_LINK' ;
    public function __construct()
    {
        $this->namespace = IT_STRIPE_EXPRESS_REST_API . 'stripehook';
        $this->rest_base = '';
        $this->stripe_setting = [
            'apiVersion'     => '2019-03-14',
            'publishableKey' => Stripe_Express_Stripe_Controller::getKey(),
            'secretKey'      => Stripe_Express_Stripe_Controller::getKey( true ),
            'webhookSecret'  => get_option( 'stripe_express_webhook_secret' ),
        ];
        $this->plaid_setting = [
            'env'        => get_option( 'stripe_express_plaid_env', 'sandbox' ),
            'clientName' => get_option( 'stripe_express_plaid_client_name', '' ),
            'clientID'   => get_option( 'stripe_express_plaid_client_id', '' ),
            'secret'     => get_option( 'stripe_express_plaid_secret', '' ),
        ];
    }
    
    /**
     * Registers the routes for the objects of the controller.
     *
     * @since 4.7.0
     *
     * @see register_rest_route()
     */
    public function register_routes()
    {
        register_rest_route( $this->namespace, 'checkout-session', array( array(
            'methods'             => WP_REST_Server::CREATABLE,
            'callback'            => array( $this, 'create_checkout_session' ),
            'permission_callback' => '__return_true',
        ) ) );
        register_rest_route( $this->namespace, 'checkout-session', array( array(
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => array( $this, 'get_checkout_session' ),
            'permission_callback' => array( $this, 'verify_access' ),
        ) ) );
    }
    
    public function verify_access( \WP_REST_Request $request )
    {
        return true;
    }
    
    public static function getKey( $isSecrete = true )
    {
        $mode = get_option( 'stripe_express_mode' );
        
        if ( $mode == 'test' ) {
            $apiKey = ( $isSecrete ? get_option( 'stripe_express_test_secret' ) : get_option( 'stripe_express_test_key' ) );
        } else {
            $apiKey = ( $isSecrete ? get_option( 'stripe_express_live_secret' ) : get_option( 'stripe_express_live_key' ) );
        }
        
        return $apiKey;
    }
    
    function send_payment_success_email( $intent, $charge )
    {
        $placeholders = Stripe_Express_Utils::get_stripe_success_placeholders( $intent, $charge );
        $email = Stripe_Express_Mailer::get_emails()['wse_email_pay_success'];
        $email->set_placeholders( $placeholders )->trigger();
        $invoice_email = Stripe_Express_Mailer::get_emails()['wse_email_invoice'];
        $invoice_email->set_placeholders( $placeholders )->trigger( $placeholders['{customer_email}'] );
    }
    
    function send_payment_failed_email( $intent )
    {
        // Send an email to the customer asking them to retry their order
        $placeholders = Stripe_Express_Utils::get_stripe_failed_placeholders( $intent );
        $email = Stripe_Express_Mailer::get_emails()['wse_email_pay_fail'];
        $email->set_placeholders( $placeholders )->trigger();
    }
    
    public function create_checkout_session( WP_REST_Request $request )
    {
        $postData = sanitize_post( $request->get_params() );
        Stripe_Express_Logger::info( 'create_checkout_session recevied data', $postData );
        try {
            $checkout = $this->create_checkout_session_core( $postData, $request );
            return new WP_REST_Response( array(
                'sessionId' => $checkout->id,
            ) );
        } catch ( Exception $ex ) {
            Stripe_Express_Logger::error( 'stripe_error ' . $ex->getMessage() );
            return new WP_Error( 'stripe_error', __( $ex->getMessage() ), array(
                'status' => 400,
            ) );
        }
    }
    
    public function get_checkout_session( WP_REST_Request $request )
    {
        $sessionId = sanitize_text_field( $request->get_param( 'id' ) );
        $stripe = new \Stripe\StripeClient( $this->stripe_setting['publishableKey'] );
        try {
            Stripe_Express_Logger::info( 'retrieve stripe session ' . $sessionId );
            $rst = $stripe->checkout->sessions->retrieve( $sessionId );
            return new WP_REST_Response( $rst );
        } catch ( Exception $ex ) {
            Stripe_Express_Logger::error( 'stripe_error ' . $ex->getMessage() );
            return new WP_Error( 'stripe_error', __( $ex->getMessage() ), array(
                'status' => 400,
            ) );
        }
    }
    
    protected function get_stripe_customer_by_email( $email )
    {
        $stripe = $this->get_stripe_instance();
        $customers = $stripe->customers->all( [
            'limit' => 1,
            'email' => $email,
            [
            'expand' => [ 'data.sources' ],
        ],
        ] );
        if ( count( $customers ) ) {
            return $customers->data[0];
        }
        return null;
    }
    
    protected function get_stripe_instance()
    {
        return new \Stripe\StripeClient( $this->stripe_setting['publishableKey'] );
    }
    
    protected function get_plaid_instance()
    {
        return new \TomorrowIdeas\Plaid\Plaid( $this->plaid_setting['clientID'], $this->plaid_setting['secret'], $this->plaid_setting['env'] );
    }
    
    private function create_checkout_session_core( $postData, $request )
    {
        $successURL = $postData['successUrl'];
        $cancelURL = $postData['cancelUrl'];
        $itemModel = $postData['item'];
        $paymentMethodTypes = $postData['paymentMethodTypes'];
        if ( empty($successURL) ) {
            $successURL = esc_url_raw( get_option( 'stripe_express_success_url' ) );
        }
        if ( empty($cancelUrl) ) {
            $cancelURL = esc_url_raw( get_option( 'stripe_express_cancel_url' ) );
        }
        if ( empty($itemModel['description']) ) {
            unset( $itemModel['description'] );
        }
        $config = array(
            'success_url'          => add_query_arg( 'session_id', '{CHECKOUT_SESSION_ID}', esc_url_raw( $successURL ) ),
            'cancel_url'           => esc_url_raw( $cancelURL ),
            'mode'                 => ( $postData['mode'] ? $postData['mode'] : 'payment' ),
            'payment_method_types' => ( $paymentMethodTypes ? $paymentMethodTypes : [ 'card' ] ),
            'line_items'           => array( $itemModel ),
        );
        // if (isset($request['paymentMethodTypes'])) {
        //   $config['payment_method_types'] = $postData['paymentMethodTypes'];
        // }
        if ( in_array( 'wechat_pay', $config['payment_method_types'] ) ) {
            $config['payment_method_options'] = [
                'wechat_pay' => [
                'client' => "web",
            ],
            ];
        }
        if ( isset( $request['email'] ) ) {
            $config['customer_email'] = sanitize_email( $postData['email'] );
        }
        if ( isset( $request['billingAddressCollection'] ) && $request->get_param( 'billingAddressCollection' ) ) {
            $config['billing_address_collection'] = 'required';
        }
        if ( isset( $request['shippingAddressCollection'] ) && $request->get_param( 'shippingAddressCollection' ) ) {
            $config['shipping_address_collection'] = [
                'allowed_countries' => [
                'AU',
                'BE',
                'BR',
                'CA',
                'CN',
                'DE',
                'ES',
                'FR',
                'GB',
                'MY',
                'IT',
                'JP',
                'SG',
                'TW',
                'US'
            ],
            ];
        }
        if ( isset( $request['metadata'] ) ) {
            $config['metadata'] = $postData['metadata'];
        }
        if ( isset( $request['submitType'] ) ) {
            $config['submit_type'] = $postData['submitType'];
        }
        if ( isset( $request['allowPromotionCodes'] ) ) {
            $config['allow_promotion_codes'] = boolval( $postData['allowPromotionCodes'] );
        }
        if ( isset( $request['allowTermsOfService'] ) ) {
            $config['consent_collection'] = array(
                'terms_of_service' => ( boolval( $postData['allowTermsOfService'] ) ? 'required' : 'none' ),
            );
        }
        
        if ( isset( $request['automaticTax'] ) ) {
            $config['automatic_tax'] = array(
                'enabled' => boolval( $request['automaticTax'] ),
            );
            $config['tax_id_collection'] = array(
                'enabled' => true,
            );
        }
        
        if ( $config['mode'] == 'payment' ) {
            $config['payment_intent_data'] = array(
                'description' => ( $itemModel['price_data']['product_data']['description'] ?: '' ),
                'metadata'    => ( $config['metadata'] ?: array() ),
            );
        }
        if ( $config['mode'] == 'subscription' ) {
            $config['subscription_data'] = array(
                'metadata' => ( $config['metadata'] ?: array() ),
            );
        }
        Stripe_Express_Logger::info( 'create stripe session', $config );
        $stripe = new \Stripe\StripeClient( $this->stripe_setting['publishableKey'] );
        $checkout = $stripe->checkout->sessions->create( $config );
        return $checkout;
    }

}