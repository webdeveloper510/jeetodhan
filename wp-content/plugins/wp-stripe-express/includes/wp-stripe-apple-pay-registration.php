<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Stripe_Express_Apple_Pay_Registration {
  public function __construct() {
    add_action( 'init', array( $this, 'add_domain_association_rewrite_rule' ) );
		add_filter( 'query_vars', array( $this, 'whitelist_domain_association_query_param' ), 10, 1 );
		add_action( 'parse_request', array( $this, 'parse_domain_association_request' ), 10, 1 );
  }

  /**
	 * Adds a rewrite rule for serving the domain association file from the proper location.
	 */
	public function add_domain_association_rewrite_rule() {
		$regex    = '^\.well-known\/apple-developer-merchantid-domain-association$';
		$redirect = 'index.php?apple-developer-merchantid-domain-association=stripe-express';

		add_rewrite_rule( $regex, $redirect, 'top' );
  }
  
  /**
	 * Add to the list of publicly allowed query variables.
	 *
	 * @param  array $query_vars - provided public query vars.
	 * @return array Updated public query vars.
	 */
	public function whitelist_domain_association_query_param( $query_vars ) {
		$query_vars[] = 'apple-developer-merchantid-domain-association';
		return $query_vars;
	}

	/**
	 * Serve domain association file when proper query param is provided.
	 *
	 * @param WP WordPress environment object.
	 */
	public function parse_domain_association_request( $wp ) {
		if (
			! isset( $wp->query_vars['apple-developer-merchantid-domain-association'] ) ||
			'stripe-express' !== $wp->query_vars['apple-developer-merchantid-domain-association']
		) {
			return;
		}

		$path = IT_STRIPE_EXPRESS_DIR . '/apple-developer-merchantid-domain-association';
		header( 'Content-Type: application/octet-stream' );
		header("Content-Disposition: attachment; filename=apple-developer-merchantid-domain-association");
		echo esc_html( file_get_contents( $path ) );
		exit;
	}
}

new Stripe_Express_Apple_Pay_Registration();