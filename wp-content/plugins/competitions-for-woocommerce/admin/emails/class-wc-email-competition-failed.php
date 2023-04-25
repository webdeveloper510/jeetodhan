<?php
defined( 'ABSPATH' ) || exit;

/**
 * Admin competition faild mail
 *
 * Admin competition faild mail s are sent when competition is finished and failed.
 *
 * @class 		WC_Email_competition_Failed
 * @extends 	WC_Email
 */

class WC_Email_Competition_Failed extends WC_Email {


	/**
	 * Competition id
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	private $competition_id;


	/**
	 * Reason id
	 *
	 * @since    1.0.0
	 * @var      string
	 */
	private $reason;

	/**
	 * Constructor
 *
	 * @return void
	 */
	public function __construct() {

		global $wc_competition;

		$this->id             = 'competition_fail';
		$this->title          = __( 'Competition Fail', 'competitions_for_woocommerce' );
		$this->description    = __( 'Competition Fail emails are sent when competition fails.', 'competitions_for_woocommerce' );
		$this->template_html  = 'emails/competition_fail.php';
		$this->template_plain = 'emails/plain/competition_fail.php';
		$this->template_base  = COMPETITIONS_FOR_WOOCOMMERCE_ABSPATH . 'templates/';
		$this->subject        = __( 'competition Failed on {blogname}', 'competitions_for_woocommerce');
		$this->heading        = __( 'No interest in this competition!', 'competitions_for_woocommerce');

		add_action( 'wc_competition_fail', array( $this, 'trigger' ) );

		// Call parent constructor
		parent::__construct();

		// Other settings
		$this->recipient = $this->get_option( 'recipient' );

		if ( ! $this->recipient ) {
				$this->recipient = get_option( 'admin_email' );
		}
	}
	/**
	 * Trigger function.
	 *
	 * @return void
	 */
	public function trigger( $args ) {

		if ( $args ) {
			$args = wp_parse_args( $args);
			extract( $args );
			$this->competition_id = $competition_id;
			$this->object         = wc_get_product(  $competition_id );
			$this->reason         = $reason;
		}

		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
		}

		$this->send( $this->get_recipient(), $this->get_subject(), $this->get_content(), $this->get_headers(), $this->get_attachments() );
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
		wc_get_template( $this->template_html, array(
					'email_heading' => $this->get_heading(),
					'blogname'      => $this->get_blogname(),
					'product_id'    => $this->competition_id,
					'email'         => $this,
			) );
		return ob_get_clean();
	}
	/**
	 * Initialise Settings Form Fields
	 *
	 * @return void
	 */
	public function init_form_fields() {
		$this->form_fields = array(
			'enabled' => array(
					'title' 		=> __( 'Enable/Disable', 'woocommerce' ),
					'type' 		=> 'checkbox',
					'label' 		=> __( 'Enable this email notification', 'woocommerce' ),
					'default' 		=> 'yes'
			),
			'recipient' => array(
					'title' 		=> __( 'Recipient(s)', 'woocommerce' ),
					'type' 		=> 'text',
					/* translators: 1) default email adress */
					'description' 	=> sprintf( __( 'Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'woocommerce' ), esc_attr( get_option('admin_email') ) ),
					'placeholder' 	=> '',
					'default' 		=> ''
			),
			'subject' => array(
					'title' 		=> __( 'Subject', 'woocommerce' ),
					'type' 		=> 'text',
					/* translators: 1) default subject */
					'description' 	=> sprintf( __( 'This controls the email subject line. Leave blank to use the default subject: <code>%s</code>.', 'woocommerce' ), $this->subject ),
					'placeholder' 	=> '',
					'default' 		=> ''
			),
			'heading' => array(
					'title' 		=> __( 'Email Heading', 'woocommerce' ),
					'type' 		=> 'text',
					/* translators: 1) default heading */
					'description' 	=> sprintf( __( 'This controls the main heading contained within the email notification. Leave blank to use the default heading: <code>%s</code>.', 'woocommerce' ), $this->heading ),
					'placeholder' 	=> '',
					'default' 		=> ''
			),
			'email_type' => array(
					'title' 		=> __( 'Email type', 'woocommerce' ),
					'type' 		=> 'select',
					'description' 	=> __( 'Choose which format of email to send.', 'woocommerce' ),
					'default' 		=> 'html',
					'class'		=> 'email_type',
					'options'		=> array(
							'plain'	=> __( 'Plain text', 'woocommerce' ),
							'html' 	=> __( 'HTML', 'woocommerce' ),
							'multipart'	=> __( 'Multipart', 'woocommerce' ),
					)
			)
		);
	}
}
