<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Stripe_Express_Element_Controller extends WP_REST_Controller
{

  public function __construct()
  {
    global $wpdb;
    $this->namespace     = IT_STRIPE_EXPRESS_REST_API . 'admin';
    $this->rest_base = 'element';
    $this->table_name = $wpdb->prefix . 'stripe_express_elements';
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
          'methods'             => WP_REST_Server::READABLE,
          'callback'            => array($this, 'get_items'),
          'permission_callback' => array( $this, 'verify_admin' ),
        ),
        array(
          'methods'             => WP_REST_Server::CREATABLE,
          'callback'            => array($this, 'update_item'),
          'permission_callback' => array( $this, 'verify_admin' ),
        )
      )
    );

    register_rest_route(
      $this->namespace,
      '/' . $this->rest_base . '/(?P<id>[\d]+)',
      array(
        array(
          'methods'              => WP_REST_Server::READABLE,
          'callback'            => array($this, 'get_item'),
          'permission_callback' => array( $this, 'verify_admin' ),
        ),
        array(
          'methods'             => WP_REST_Server::EDITABLE,
          'callback'            => array($this, 'update_item'),
          'permission_callback' => array( $this, 'verify_admin' ),
        ),
        array(
          'methods'            => WP_REST_Server::DELETABLE,
          'callback'          => array($this, 'delete_item'),
          'permission_callback' => array( $this, 'verify_admin' ),
        )
      )
    );
  }

  function verify_admin( WP_REST_Request $request ) {
		return Stripe_Express_Security_Util::admin_check($request);
	}

  /**
   * Retrieves a collection of posts.
   *
   * @since 4.7.0
   *
   * @param WP_REST_Request $request Full details about the request.
   * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
   */
  public function get_items($request)
  {
    global $wpdb;
    $results = $wpdb->get_results('SELECT * FROM ' . $this->table_name . ' ORDER BY id DESC');
    $data = array(
      'pageSize' => count($results),
      'total' => count($results),
      'list' => $results,
    );
    return new WP_REST_Response($data);
  }

  /**
   * Grabs the five most recent posts and outputs them as a rest response.
   *
   * @param WP_REST_Request $request Current request.
   */
  public function get_item($request)
  {
    global $wpdb;
    $id = intval(sanitize_text_field($request['id']));
    if($id) {
      $item = $wpdb->get_row($wpdb->prepare('SELECT * FROM ' . $this->table_name . ' WHERE id = %d', $id));
      if ($item) {
        return new WP_REST_Response($item);
      }
    }
    return new WP_REST_Response(array());
  }

  public function update_item($request)
  {
    global $wpdb;
    if (!isset($request['type']) || !isset($request['paymentConfig'])) {
      return new WP_Error('rest_parameter', __('parameter missing.'), array('status' => 400));
    }

    $postData = sanitize_post($request->get_params());
    Stripe_Express_Logger::info('update/insert element', $postData);

    try {
      $data = array(
        'type' => $postData['type'], // 'one-time' , // form
        'uiConfig' => isset($postData['uiConfig']) ? $postData['uiConfig'] : '', //'{}', // map saved
        'paymentConfig' => $postData['paymentConfig'], //'{}', //map
        'createAt' => time(),
      );
  
      if (isset($postData['id'])) {
        $wpdb->update($this->table_name, $data, array('id' => $postData['id'])) ? 200 : 400;
        return new WP_REST_Response($postData['id']);
      } else {
        $wpdb->insert($this->table_name, $data) ? 200 : 400;
        return new WP_REST_Response($wpdb->insert_id);
      }
    }
    catch(Exception $ex) {
      Stripe_Express_Logger::error('update_error ' . $ex->getMessage());
      return new WP_Error('update_error', __($ex->getMessage()), array('status' => 400));
    }
  }

  public function delete_item($request)
  {
    global $wpdb;
    $id = intval(sanitize_text_field($request['id']));
    $ret = 0;
    if ($id) {
      Stripe_Express_Logger::info('remove element by ' . + $id);
      $ret = $wpdb->query($wpdb->prepare('DELETE FROM ' . $this->table_name . ' WHERE id = %d', $id));
    }
    return $ret ?
      new WP_REST_Response(null) :
      new WP_Error('rest_parameter', __('delete failed.'), array('status' => 400));;
  }
}
