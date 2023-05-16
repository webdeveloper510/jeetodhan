<?php

class Stripe_Express_Plaid_Setting_Controller
{
  public function __construct()
  {
    $this->namespace = IT_STRIPE_EXPRESS_REST_API . 'admin';
    $this->rest_base = 'setting/plaid';
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
          'callback'            => array($this, 'getSetting'),
          'permission_callback' => array( $this, 'verify_admin' )
        ),
        array(
          'methods'              => WP_REST_Server::EDITABLE,
          'callback'            => array($this, 'setSetting'),
          'permission_callback' => array( $this, 'verify_admin' )
        )
      )
    );
  }

  function verify_admin( WP_REST_Request $request ) {
		return Stripe_Express_Security_Util::admin_check($request);
	}

  public function getSetting()
  {
    $data = [
      'env' => get_option('stripe_express_plaid_env', 'sandbox'),
      'clientName' => get_option('stripe_express_plaid_client_name', ''),
      'clientID' => get_option('stripe_express_plaid_client_id', ''),
      'secret' => get_option('stripe_express_plaid_secret', ''),
    ];
    return new WP_REST_Response($data);
  }

  /**
   * @param $request WP_REST_Request
   *
   * @return array
   */
  public function setSetting($request)
  {
    Stripe_Express_Logger::info('start to saving setting');
    if (
      !isset( $request['env'] ) && !isset( $request['clientID'] ) && !isset($request['secret'])
    ) {
      return new WP_Error('rest_parameter', __( 'parameter missing.' ), array( 'status' => 400 ));
    }

    $postData = sanitize_post($request->get_params());

    update_option('stripe_express_plaid_env', $postData['env']);
    update_option('stripe_express_plaid_client_name', $postData['clientName']);
    update_option('stripe_express_plaid_client_id', $postData['clientID']);
    update_option('stripe_express_plaid_secret', $postData['secret']);
    Stripe_Express_Logger::info('save plaid setting success');
    return new WP_REST_Response(null);
  }
}
