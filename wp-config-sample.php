<?php
/**
 * Copy this file to wp-config.php and fill in your values.
 * Do not commit wp-config.php — it contains secrets.
 */

define( 'WP_TOOLKIT_API_TOKEN', 'your-token-here' );

define( 'DB_NAME', 'your_database_name' );
define( 'DB_USER', 'your_database_user' );
define( 'DB_PASSWORD', 'your_database_password' );
define( 'DB_HOST', 'localhost' );
define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'AUTH_KEY', 'put-your-unique-phrase-here' );
define( 'SECURE_AUTH_KEY', 'put-your-unique-phrase-here' );
define( 'LOGGED_IN_KEY', 'put-your-unique-phrase-here' );
define( 'NONCE_KEY', 'put-your-unique-phrase-here' );
define( 'AUTH_SALT', 'put-your-unique-phrase-here' );
define( 'SECURE_AUTH_SALT', 'put-your-unique-phrase-here' );
define( 'LOGGED_IN_SALT', 'put-your-unique-phrase-here' );
define( 'NONCE_SALT', 'put-your-unique-phrase-here' );

$table_prefix = 'wp_';

if ( isset( $_SERVER['HTTP_HOST'] ) && in_array( $_SERVER['HTTP_HOST'], array( 'localhost', '127.0.0.1' ), true ) ) {
	define( 'WP_HOME', 'http://localhost/riskwisdom' );
	define( 'WP_SITEURL', 'http://localhost/riskwisdom' );
} else {
	define( 'WP_HOME', 'https://riskwisdom.com.au' );
	define( 'WP_SITEURL', 'https://riskwisdom.com.au' );
}

define( 'WP_ALLOW_MULTISITE', true );

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

require_once ABSPATH . 'wp-settings.php';
