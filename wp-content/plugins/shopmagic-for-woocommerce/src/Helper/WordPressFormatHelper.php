<?php
declare(strict_types=1);


namespace WPDesk\ShopMagic\Helper;

/**
 * Idea behind this helper is to facilitate various formatting methods that depends on WordPress.
 * Access should be static to lower complexity. It can be refactored in the future when DI container is introduced.
 */
final class WordPressFormatHelper {
	/**
	 * @var string
	 */
	public const MYSQL_DATE_FORMAT = 'Y-m-d';

	/**
	 * @var string
	 */
	public const MYSQL_DATETIME_FORMAT = 'Y-m-d G:i:s';
	/**
	 * @var string
	 */
	private const DATE_FORMAT = 'date_format';
	/**
	 * @var string
	 */
	private const Y_M_D = 'Y-m-d';
	/**
	 * @var string
	 */
	private const NOW = 'now';

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $date
	 */
	public static function format_wp_date( $date ): string {
		$wp_date_format = get_option( self::DATE_FORMAT, self::Y_M_D );

		return self::custom_format_wp_date( $date, $wp_date_format );
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $date
	 *
	 * @throws \Exception
	 */
	public static function custom_format_wp_date( $date, string $format ): string {
		$utc_stamp = self::convert_all_time_to_utc_stamp( $date );
		if ( $utc_stamp === false ) {
			return '';
		}

		$datetime = ( new \DateTimeImmutable( self::NOW, self::get_wp_timezone() ) )->setTimestamp( $utc_stamp );

		return date_i18n( $format, $datetime->getTimestamp() + $datetime->getOffset() );
	}

	public static function get_wp_timezone(): \DateTimeZone {
		if ( \function_exists( 'wp_timezone' ) ) {
			return wp_timezone();
		}

		// Copy-paste from WordPress function for WP <5.3 compatibility.
		$timezone_string = get_option( 'timezone_string' );

		if ( $timezone_string ) {
			return $timezone_string;
		}

		$offset  = (float) get_option( 'gmt_offset' );
		$hours   = (int) $offset;
		$minutes = ( $offset - $hours );

		$sign      = ( $offset < 0 ) ? '-' : '+';
		$abs_hour  = abs( $hours );
		$abs_mins  = abs( $minutes * 60 );
		$tz_offset = sprintf( '%s%02d:%02d', $sign, $abs_hour, $abs_mins );

		return new \DateTimeZone( $tz_offset );
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $datetime
	 *
	 * @return int|false
	 */
	public static function convert_all_time_to_utc_stamp( $datetime ) {
		if ( is_numeric( $datetime ) ) {
			return (int) $datetime;
		}

		if ( \is_string( $datetime ) ) {
			return strtotime( $datetime );
		}

		if ( $datetime instanceof \DateTimeInterface ) {
			return $datetime->getTimestamp();
		}

		return false;
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $datetime
	 */
	public static function format_wp_datetime( $datetime, string $datetime_format = '' ): string {
		if ( empty( $datetime_format ) ) {
			$wp_date_format  = get_option( self::DATE_FORMAT, self::Y_M_D );
			$wp_time_format  = get_option( 'time_format', 'G:i:s' );
			$datetime_format = sprintf( '%s %s', $wp_date_format, $wp_time_format );
		}

		return self::custom_format_wp_date( $datetime, $datetime_format );
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $datetime
	 */
	public static function format_wp_datetime_with_seconds( $datetime ): string {
		$wp_date_format  = get_option( self::DATE_FORMAT, self::Y_M_D );
		$wp_time_format  = get_option( 'time_format', 'G:i' );
		$datetime_format = sprintf( '%s %s:s', $wp_date_format, $wp_time_format );

		return self::custom_format_wp_date( $datetime, $datetime_format );
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $datetime
	 */
	public static function datetime_as_mysql( $datetime ): string {
		$utc_stamp = self::convert_all_time_to_utc_stamp( $datetime );
		if ( $utc_stamp === false ) {
			return '';
		}

		return ( new \DateTimeImmutable( self::NOW, new \DateTimeZone( 'UTC' ) ) )
			->setTimestamp( $utc_stamp )
			->format( self::MYSQL_DATETIME_FORMAT );
	}

	/**
	 * @param string|\WC_DateTime|\DateTimeInterface|int|null $datetime
	 */
	public static function date_as_mysql( $datetime ): string {
		$utc_stamp = self::convert_all_time_to_utc_stamp( $datetime );
		if ( $utc_stamp === false ) {
			return '';
		}

		return ( new \DateTimeImmutable( self::NOW, new \DateTimeZone( 'UTC' ) ) )
			->setTimestamp( $utc_stamp )
			->format( self::MYSQL_DATE_FORMAT );
	}

	public static function get_start_day_timestamp( \DateTimeInterface $date ): int {
		return ( new \DateTimeImmutable( self::NOW, $date->getTimezone() ) )
			->setTimestamp( $date->getTimestamp() )
			->setTime( 0, 0, 0 )
			->getTimestamp();
	}

	public static function get_end_day_timestamp( \DateTimeInterface $date ): int {
		return ( new \DateTimeImmutable( self::NOW, $date->getTimezone() ) )
			->setTimestamp( $date->getTimestamp() )
			->setTime( 23, 59, 59 )
			->getTimestamp();
	}
}
