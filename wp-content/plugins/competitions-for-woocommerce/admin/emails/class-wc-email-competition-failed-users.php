<?php

defined( 'ABSPATH' ) || exit;

/**
 * Competition fail users emails
 *
 * Competition fail users emails are sent to al participants when  lotery faild.
 *
 * @class 		WC_Email_SA_Outbid
 * @extends 	WC_Email
 */

class WC_Email_Competition_Fail_Users extends WC_Email {

	/**
	 * Competition id
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	private $competition_id;


	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct() {

		global $wc_competition;

		$this->id             = 'competition_fail_users1';
		$this->title          = __( 'Competition Fail For Customers', 'competitions_for_woocommerce' );
		$this->description    = __( 'Competition Fail emails are sent when competition fails to users that participated.', 'competitions_for_woocommerce' );
		$this->customer_email = true;
		$this->template_html  = 'emails/competition_fail_users.php';
		$this->template_plain = 'emails/plain/competition_fail_users.php';
		$this->template_base  = COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$this->subject        = __( 'competition Failed on {blogname}', 'competitions_for_woocommerce');
		$this->heading        = __( 'Better luck next time!', 'competitions_for_woocommerce');

		add_action( 'wc_competition_fail', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Trigger function.
	 *
	 * @return void
	 */
	public function trigger( $args ) {

		if ( ! $this->is_enabled() ) {
			return;
		}


		if ( $args ) {
			$product_id = $args[ 'competition_id' ];
			if ( 'publish' !== get_post_status( $product_id )  ) {
				return;
			}

			$product_data         = wc_get_product(  $product_id );
			$participants         =  $product_data->get_competition_participants();
			$uniquep_participants = array_unique($participants);


			if ( $product_data && !empty($uniquep_participants)) {

				foreach ($uniquep_participants as $user) {
					$this->object         = new WP_User( $user );
					$this->recipient      = $this->object->user_email;
					$this->competition_id = $product_id;
					$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
				}
			}

		}
	}
	/**
	 * Get_content_html function.
	 *
	 * @return string
	 */
	public function get_content_html() {
		ob_start();
		wc_get_template(
			$this->template_html, array(
					'email_heading' => $this->get_heading(),
					'blogname'      => $this->get_blogname(),
					'product_id'    => $this->competition_id,
					'email'         => $this,
			) );
		return ob_get_clean();
	}
	/**
	 * Get_content_plain function.
	 *
	 * @return string
	 */
	public function get_content_plain() {
		ob_start();
		wc_get_template(
			$this->template_html, array(
					'email_heading' => $this->get_heading(),
					'blogname'      => $this->get_blogname(),
					'product_id'    => $this->competition_id,
					'email'         => $this,
			) );
		return ob_get_clean();
	}
}
