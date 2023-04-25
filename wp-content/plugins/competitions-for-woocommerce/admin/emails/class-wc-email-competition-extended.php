<?php

defined( 'ABSPATH' ) || exit;

/**
 * Competition extended emails
 *
 * @class 		WC_Email_SA_Outbid
 * @extends 	WC_Email
 */

class WC_Email_Competition_Extended extends WC_Email {

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

		$this->id             = 'competition_extended';
		$this->title          = __( 'Competition Extended', 'competitions_for_woocommerce' );
		$this->description    = __( 'Competition extended emails are sent to users when competition is extended and user is participating in it.', 'competitions_for_woocommerce' );
		$this->template_html  = 'emails/competition_extended.php';
		$this->template_plain = 'emails/plain/competition_extended.php';
		$this->template_base  = COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$this->customer_email = true;
		$this->subject        = __( 'competition extended on {blogname}', 'competitions_for_woocommerce');
		$this->heading        = __( 'competition has been extended!', 'competitions_for_woocommerce');

		add_action( 'woocommerce_competition_do_extend_notification', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Trigger function.
	 *
	 * @return void
	 */
	public function trigger( $product_id ) {


		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( $product_id ) {
			$product_data        = wc_get_product(  $product_id );
			$participants        = $product_data->get_competition_participants();
			$unique_participants = array_unique($participants);
			if ( $product_data && !empty($unique_participants)) {
				foreach ($unique_participants as $user) {
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
			$this->template_plain, array(
				'email_heading' => $this->get_heading(),
				'blogname'      => $this->get_blogname(),
				'product_id'    => $this->competition_id,
				'email'         => $this,
			) );
		return ob_get_clean();
	}
}
