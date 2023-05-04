<?php
declare(strict_types=1);

namespace WPDesk\ShopMagic\Helper;

use DomainException;
use ShopMagicVendor\WPDesk\View\Resolver\ChainResolver;
use ShopMagicVendor\WPDesk\View\Resolver\DirResolver;
use ShopMagicVendor\WPDesk\View\Resolver\WPThemeResolver;

/**
 * Static factory method wrapper for easier use of templates across app and extensions.
 */
final class TemplateResolver extends ChainResolver {
	/**
	 * @var string
	 */
	public const THEME_DIR = 'shopmagic';

	/** @var ?string */
	private static $root_path;

	public static function set_root_path( string $root_path ): void {
		self::$root_path = $root_path;
	}

	public static function for_placeholder( string $subdir = '' ): \WPDesk\ShopMagic\Helper\TemplateResolver {
		return self::for_public( 'placeholder' . DIRECTORY_SEPARATOR . $subdir );
	}

	public static function for_public( string $relative_path = '' ): \WPDesk\ShopMagic\Helper\TemplateResolver {
		if ( empty( self::$root_path ) ) {
			throw new DomainException( 'Template root path not set!' );
		}

		return new self(
			new WPThemeResolver( self::THEME_DIR . DIRECTORY_SEPARATOR . $relative_path ),
			new WPThemeResolver( self::THEME_DIR ), // backward compatibility.
			new DirResolver( self::$root_path . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . $relative_path )
		);
	}

}
