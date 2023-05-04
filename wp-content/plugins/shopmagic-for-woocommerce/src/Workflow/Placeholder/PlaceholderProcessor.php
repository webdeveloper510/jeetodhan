<?php

declare( strict_types=1 );

namespace WPDesk\ShopMagic\Workflow\Placeholder;

use WPDesk\ShopMagic\Workflow\Event\DataLayer;

/**
 * Process string and delegate any variable creation to subsequent classes.
 */
final class PlaceholderProcessor {
	private const PARAM_SEPARATOR       = ',';
	private const PARAM_VALUE_SEPARATOR = ':';
	private const PARAM_VALUE_WRAP      = "'";
	private const PARAMS_SEPARATOR      = '|';

	private const PLACEHOLDER_REGEX = '/{{[ ]*([^}]+)[ ]*}}/';

	/** @var DataLayer */
	private $data_layer;

	/** @var PlaceholdersList */
	private $placeholders_list;

	public function __construct( PlaceholdersList $placeholders_list ) {
		$this->placeholders_list = $placeholders_list;
	}

	public function set_data_layer( DataLayer $data_layer ): void {
		$this->data_layer = $data_layer;
	}

	/**
	 * @return string|string[]|null
	 */
	public function process( string $string ): string {
		$replacement_count = 0;
		do {
			$string = preg_replace_callback(
				self::PLACEHOLDER_REGEX,
				function ( $full_placeholder ): string {
					@list( $placeholder_slug, $params_string ) = array_map( //phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
						'trim',
						explode( self::PARAMS_SEPARATOR, $full_placeholder[1] ?? '', 2 )
					);

					// @todo this check is not enough - we have to know if placeholder can be actually handled at this point.
					if ( isset( $this->placeholders_list[ $placeholder_slug ] ) ) {
						$placeholder = $this->placeholders_list[ $placeholder_slug ];
						$placeholder->set_provided_data( $this->data_layer );

						return $placeholder->value( $this->extract_parameters( $params_string ) );
					}

					return '';
				},
				$string,
				1,
				$replacement_count
			);
		} while ( $replacement_count > 0 );

		return $string;
	}

	/**
	 * @param string|mixed $params_string
	 *
	 * @return array<string, string>
	 */
	private function extract_parameters( ?string $params_string ): array {
		if ( $params_string === null ) {
			return [];
		}

		if ( trim( $params_string ) === '' ) {
			return [];
		}

		$params = [];
		$pos    = - 1;
		do {
			$pos ++;
			$param_separator_pos   = strpos( $params_string, self::PARAM_VALUE_SEPARATOR, $pos );
			$param_name            = trim( substr( $params_string, $pos, $param_separator_pos - $pos ) );
			$param_value_start_pos = strpos( $params_string, self::PARAM_VALUE_WRAP, $param_separator_pos );
			$param_value_end_pos   = strpos( $params_string, self::PARAM_VALUE_WRAP, $param_value_start_pos + 1 );
			$param_value           = trim( substr( $params_string,
				$param_value_start_pos + 1,
				$param_value_end_pos - $param_value_start_pos - 1 ) );
			$params[ $param_name ] = $param_value;
			$pos                   = strpos( $params_string, self::PARAM_SEPARATOR, $param_value_end_pos );
		} while ( $pos !== false );

		return $params;
	}
}
