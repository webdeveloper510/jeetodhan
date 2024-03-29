<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'i2179310_wp2' );

/** Database username */
define( 'DB_USER', 'i2179310_wp2' );

/** Database password */
define( 'DB_PASSWORD', 'G.BEIb0AIUrCNMWcwxN12' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'YZ26fir7s6mDOt7FoSzoi20nbYpPifnqOLxmSXQa87NPq5RpsSGJbfdLD3fQA2Vk');
define('SECURE_AUTH_KEY',  '3Cp3yxR9cWgE6HgEgCqfmmWSxF1ssURqBGKNumeaqxic9X3YHIiSNZ9vPGroSuyI');
define('LOGGED_IN_KEY',    'S1wVk99Tu6878ebCarBZm3ddxzaTJSRpScyi6CfSsOV5T2GfSzkvZXtRdsXaZfnn');
define('NONCE_KEY',        'LLf1WCh689AqzTf4oSgzaEbzZWHtBgpVVTNnZMg0XyGM7aMYzmA4msZL1giSiNC3');
define('AUTH_SALT',        'VUuGGuH4xilpaiCxqGCOj3VT3fAZO66xedWszkFNKPtnR1SO4bOa4M8QoiU784Fv');
define('SECURE_AUTH_SALT', 'EjHYXKcASjg5qdjWIq8wD7qzQrBeVjSn7ncYLraY0aBT7tWQNS0g7Vc9mu9OQjXS');
define('LOGGED_IN_SALT',   'aR6chpV1obiG18I3OlgBvKp8l9XrEwyVN7g9M7SvPXMPeXUSDONIF1nAGm00m2dm');
define('NONCE_SALT',       'S7CFrIaWiRZQyx9QIfm7sGByToUMKwJ9WV8YCKmOYK2Ir82oBqVKZmoNnpcDw1Ym');

/**
 * Other customizations.
 */
define('WP_TEMP_DIR',dirname(__FILE__).'/wp-content/uploads');


define( 'WP_ENVIRONMENT_TYPE', 'production' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
