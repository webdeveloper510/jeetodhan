<?php
defined( 'ABSPATH' ) || exit;

/**
 *
 * Competition won emails are sent when a user wins the competition.
 *
 * @class 		WC_Email_SA_Outbid
 * @extends 	WC_Email
 */

class WC_Email_Competition_No_Luck extends WC_Email {

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

		$this->id             = 'competition_no_luck';
		$this->title          = __( 'Competition No Luck', 'competitions_for_woocommerce' );
		$this->description    = __( 'Competition no luck emails are sent to users that did not win competition but are participating in it.', 'competitions_for_woocommerce' );
		$this->template_html  = 'emails/competition_no_luck.php';
		$this->template_plain = 'emails/plain/competition_no_luck.php';
		$this->template_base  = COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$this->customer_email = true;
		$this->subject        = __( 'No luck on {blogname}', 'competitions_for_woocommerce');
		$this->heading        = __( 'Better luck next time!', 'competitions_for_woocommerce');

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

		if ( !$this->is_enabled() ) {
			return;
		}

		if ( $product_id ) {

			if ( 'publish' !== get_post_status( $product_id ) ) {
				return;
			}
			$winning_users_ids = array();
			$product_data      = wc_get_product(  $product_id );
			$winning_users     =  get_post_meta( $product_id, '_competition_winners', true);

			if ( $winning_users ) {
				foreach ( $winning_users as  $winning_user ) {
					$winning_users_ids[] = $winning_user['userid'];
				}
			}
			$participants          =  $product_data->get_competition_participants();
			$no_luck_users         = array_diff($participants, $winning_users_ids);
			$uniquep_no_luck_users = array_unique($no_luck_users);


			if ( $product_data && !empty($uniquep_no_luck_users)) {

				foreach ($uniquep_no_luck_users as $user) {
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
