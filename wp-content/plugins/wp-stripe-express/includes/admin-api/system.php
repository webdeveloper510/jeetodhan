<?php

class Stripe_Express_System_Controller extends WP_REST_Controller
{

  public function __construct()
  {
    $this->namespace     = IT_STRIPE_EXPRESS_REST_API . 'admin';
    $this->rest_base_log = 'system/logs';
    $this->rest_base_demo = 'system/demo';
    $this->logFolder = IT_STRIPE_EXPRESS_LOG_FOLDER;
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
      '/' . $this->rest_base_log,
      array(
        array(
          'methods'             => WP_REST_Server::READABLE,
          'callback'            => array($this, 'get_items_log'),
          'permission_callback' => array( $this, 'verify_admin' )
        )
      )
    );

    register_rest_route(
      $this->namespace,
      '/' . $this->rest_base_log . '/(?P<name>.+)',
      array(
        array(
          'methods'              => WP_REST_Server::READABLE,
          'callback'            => array($this, 'get_item_log'),
          'permission_callback' => array( $this, 'verify_admin' ),
        ),
        array(
          'methods'            => WP_REST_Server::DELETABLE,
          'callback'          => array($this, 'delete_item_log'),
          'permission_callback' => array( $this, 'verify_admin' ),
        )
      )
    );

    register_rest_route(
      $this->namespace,
      '/' . $this->rest_base_demo . '/create-demo-page',
      array(
        array(
          'methods'             => WP_REST_Server::CREATABLE,
          'callback'            => array($this, 'create_demo_page'),
          'permission_callback' => array( $this, 'verify_admin' )
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
  public function get_items_log($request)
  {
    if (file_exists($this->logFolder)) {
      $logFiles = array_slice(scandir($this->logFolder), 2);
      rsort($logFiles, SORT_STRING);
      return new WP_REST_Response(array(
        'list' => $logFiles
      ));
    } 
    return new WP_REST_Response(array());
  }

  /**
   * Grabs the five most recent posts and outputs them as a rest response.
   *
   * @param WP_REST_Request $request Current request.
   */
  public function get_item_log($request)
  {
    $filePath = $this->logFolder . '/' . sanitize_text_field($request['name']) . '.log';
    if(file_exists($filePath)) {
      return new WP_REST_Response(array(
        'content'=>file_get_contents($filePath),
      ));
    }
    return new WP_Error('rest_parameter', __('file not exists.'), array('status' => 400));
  }

  public function delete_item_log($request)
  {
    $filePath = $this->logFolder . '/' . sanitize_text_field($request['name']) . '.log';
    if(file_exists($filePath)) {
      unlink($filePath);
      return new WP_REST_Response('ok');
    }
    return new WP_Error('rest_parameter', __('file not exists.'), array('status' => 400));
  }

  public function create_demo_page($request)
  {
    try {
      $postData = sanitize_post($request->get_params());
      $demo_page = array(
        'post_title'    => wp_strip_all_tags( $postData['title'] ),
        'post_content'  => $postData['content'],
        'post_type'     => 'page',
      );
      $id = wp_insert_post( $demo_page, FALSE );
      $pageUrl = get_permalink( $id );
      return new WP_REST_Response($pageUrl);
    }
    catch(Exception $ex) {
      Stripe_Express_Logger::error('create_demo_error ' . $ex->getMessage());
      return new WP_Error('update_error', __($ex->getMessage()), array('status' => 400));
    }
  }
}
