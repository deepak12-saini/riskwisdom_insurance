<?php
/**
 * Switch WP Mail SMTP to Office 365 and optionally send a test email.
 *
 * Usage:
 *   set RISKWISDOM_SMTP_PASS=YourPassword
 *   php setup-smtp.php
 *   php setup-smtp.php --test
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

if ( ! function_exists( 'wp_mail_smtp' ) ) {
	echo "WP Mail SMTP is not active.\n";
	exit( 1 );
}

$pass = getenv( 'RISKWISDOM_SMTP_PASS' ) ?: '';
$test = in_array( '--test', $argv ?? array(), true );

$payload = array(
	'mail' => array(
		'mailer'           => 'smtp',
		'from_email'       => 'info@riskwisdom.com.au',
		'from_name'        => 'Risk Wisdom',
		'from_email_force' => true,
		'from_name_force'  => true,
	),
	'smtp' => array(
		'host'       => 'smtp.office365.com',
		'port'       => 587,
		'encryption' => 'tls',
		'auth'       => true,
		'autotls'    => true,
		'user'       => 'info@riskwisdom.com.au',
	),
);

if ( $pass !== '' ) {
	$payload['smtp']['pass'] = $pass;
}

( new WPMailSMTP\Options() )->set( $payload );

$opts = new WPMailSMTP\Options();
echo "Mailer: " . $opts->get( 'mail', 'mailer' ) . "\n";
echo "From: " . $opts->get( 'mail', 'from_email' ) . "\n";
echo "SMTP: " . $opts->get( 'smtp', 'host' ) . ':' . $opts->get( 'smtp', 'port' ) . "\n";

if ( ! $test ) {
	echo "Done. Add --test to send a test email, or submit the Life Insurance form.\n";
	exit( 0 );
}

$sent = wp_mail(
	'info@riskwisdom.com.au',
	'Risk Wisdom form mail test ' . gmdate( 'Y-m-d H:i:s' ),
	"SMTP test from setup-smtp.php\n"
);

echo $sent ? "Test email sent.\n" : "Test email failed.\n";
global $phpmailer;
if ( isset( $phpmailer ) && ! empty( $phpmailer->ErrorInfo ) ) {
	echo $phpmailer->ErrorInfo . "\n";
}
