<?php
defined( 'ABSPATH' ) || exit;
/**
 *
 * Competition won emails are sent when a user wins the competition.
 *
 * @class 		WC_Email_SA_Outbid
 * @extends 	WC_Email
 */

class WC_Email_Competition_Win extends WC_Email {


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

		$this->id             = 'competition_win';
		$this->title          = __( 'Competition Win', 'competitions_for_woocommerce' );
		$this->description    = __( 'Competition won emails are sent when a user wins the competition.', 'competitions_for_woocommerce' );
		$this->template_html  = 'emails/competition_win.php';
		$this->template_plain = 'emails/plain/competition_win.php';
		$this->template_base  =  COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$this->customer_email = true;
		$this->subject        = __( 'competition won on {blogname}', 'competitions_for_woocommerce');
		$this->heading        = __( 'You have won the competition!', 'competitions_for_woocommerce');

		add_action( 'wc_competition_won_notification', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();
	}

	/**
	 * Trigger function.
	 *
	 * @return void
	 */
	public function trigger( $product_id ) {

		global $woocommerce;

		if ( ! $this->is_enabled() ) {
			return;
		}

		if ( $product_id ) {
			if ( 'publish' !== get_post_status( $product_id ) ) {
				return;
			}
			$product_data  = wc_get_product(  $product_id );
			$winning_users = get_post_meta( $product_id, '_competition_winners', true);
			if ( $product_data && !empty($winning_users)) {
				foreach ($winning_users as $user) {
					$this->object         = new WP_User( $user['userid'] );
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
