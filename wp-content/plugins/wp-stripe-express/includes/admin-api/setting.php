<?php

class Stripe_Express_Setting_Controller
{
  public function __construct()
  {
    $this->namespace = IT_STRIPE_EXPRESS_REST_API . 'admin';
    $this->rest_base = 'setting/stripe';
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
    register_rest_route(
      $this->namespace,
      '/' . $this->rest_base,
      array(
        array(
          'methods'              => WP_REST_Server::READABLE,
          'callback'            => array($this, 'getStripeSetting'),
          'permission_callback' => array( $this, 'verify_admin' )
        ),
        array(
          'methods'              => WP_REST_Server::EDITABLE,
          'callback'            => array($this, 'setStripeSetting'),
          'permission_callback' => array( $this, 'verify_admin' )
        )
      )
    );
  }

  function verify_admin( WP_REST_Request $request ) {
		return Stripe_Express_Security_Util::admin_check($request);
	}

  public function getStripeSetting()
  {
    $data = [
      'mode' => get_option('stripe_express_mode', 'test'),
      'currency' => get_option('stripe_express_currency', 'usd'),
      'liveKey' => get_option('stripe_express_live_key', ''),
      'liveSecret' => get_option('stripe_express_live_secret', ''),
      'testKey' => get_option('stripe_express_test_key', ''),
      'testSecret' => get_option('stripe_express_test_secret', ''),
      'webhookSecret' => get_option('stripe_express_webhook_secret', ''),
      'successUrl' =>esc_url_raw(get_option('stripe_express_success_url', home_url())),
      'cancelUrl' =>esc_url_raw(get_option('stripe_express_cancel_url', home_url())),
      'webhook' => get_option('stripe_express_webhook', $this->webhook_generate()), // auto generate and show in the dashboard
      'debug' => boolval(get_option('stripe_express_debug', false)),
      'keepData' => boolval(get_option('stripe_express_keep_data', false)),
      'language' => get_option('stripe_express_language', 'auto'),
      'theme' => get_option('stripe_express_theme', ''),
    ];
    return new WP_REST_Response($data);
  }

  /**
   * @param $request WP_REST_Request
   *
   * @return array
   */
  public function setStripeSetting($request)
  {
    Stripe_Express_Logger::info('start to saving setting');
    if (
      !isset( $request['mode'] ) && !isset( $request['currency'] )
      && !isset( $request['liveKey'] ) && !isset($request['liveSecret'])
      && !isset($request['testKey']) && !isset($request['testSecret'])
    ) {
      return new WP_Error('rest_parameter', __( 'parameter missing.' ), array( 'status' => 400 ));
    }

    $postData = sanitize_post($request->get_params());

    update_option('stripe_express_mode', $postData['mode']);
    update_option('stripe_express_currency', $postData['currency']);
    update_option('stripe_express_live_key', $postData['liveKey']);
    update_option('stripe_express_live_secret', $postData['liveSecret']);
    update_option('stripe_express_test_key', $postData['testKey']);
    update_option('stripe_express_test_secret', $postData['testSecret']);
    if(isset($request['webhookSecret'])) {
      update_option('stripe_express_webhook_secret', $postData['webhookSecret']);
    }
    if(isset($request['successUrl'])) {
      update_option('stripe_express_success_url', $postData['successUrl']);
    }
    if(isset($request['cancelUrl'])) {
      update_option('stripe_express_cancel_url', $postData['cancelUrl']);
    }
    update_option('stripe_express_debug', $postData['debug']);
    update_option('stripe_express_keep_data', $postData['keepData']);
    update_option('stripe_express_language', $postData['language']);
    update_option('stripe_express_theme', $postData['theme']);

    Stripe_Express_Logger::info('save setting success');
    return new WP_REST_Response(null);
  }

  private function webhook_generate()
  {
    return rest_url(IT_STRIPE_EXPRESS_REST_API . 'stripehook/webhook');
  }
}
