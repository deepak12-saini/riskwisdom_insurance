<?php
/**
 * Copy to wp-config-smtp.php on each server (do NOT commit wp-config-smtp.php).
 * @link https://wpmailsmtp.com/docs/how-to-set-up-the-other-smtp-mailer-in-wp-mail-smtp/#constants
 */
define( 'WPMS_ON', true );
define( 'WPMS_MAILER', 'smtp' );
define( 'WPMS_MAIL_FROM', 'info@riskwisdom.com.au' );
define( 'WPMS_MAIL_FROM_NAME', 'Risk Wisdom' );
define( 'WPMS_MAIL_FROM_FORCE', true );
define( 'WPMS_MAIL_FROM_NAME_FORCE', true );
define( 'WPMS_SMTP_HOST', 'smtp.office365.com' );
define( 'WPMS_SMTP_PORT', 587 );
define( 'WPMS_SMTP_AUTH', true );
define( 'WPMS_SMTP_USER', 'info@riskwisdom.com.au' );
define( 'WPMS_SMTP_PASS', 'Info@123#' );
define( 'WPMS_SMTP_AUTOTLS', true );
define( 'WPMS_SSL', 'tls' );
