<?php
/**
 * Run after Git deploy on production — updates CF7 forms in the DATABASE.
 * Git only uploads PHP files; form fields (email, honeypot, labels) live in MySQL.
 *
 * SSH:
 *   cd /var/www/vhosts/riskwisdom.com.au/httpdocs
 *   php deploy-production-forms.php
 */
define( 'WP_USE_THEMES', false );

$root = __DIR__;
$steps = array(
	'fix-cf7-spam.php'        => 'Add email field, honeypot, labels to all forms',
	'fix-cf7-mail.php'        => 'Update notification email templates',
	'fix-contact-us-page.php' => 'Contact page live CF7 shortcode (needs --apply)',
);

echo "=== Risk Wisdom: deploy form updates to database ===\n\n";

foreach ( $steps as $script => $label ) {
	$path = $root . '/' . $script;
	if ( ! is_file( $path ) ) {
		echo "SKIP: {$script} not found\n";
		continue;
	}

	echo "--- {$script} — {$label} ---\n";
	$args = ( 'fix-contact-us-page.php' === $script ) ? array( '--apply' ) : array();
	passthru( 'php ' . escapeshellarg( $path ) . ( $args ? ' --apply' : '' ), $code );
	echo "\n";
	if ( 0 !== $code ) {
		echo "WARNING: {$script} exited with code {$code}\n\n";
	}
}

require $root . '/wp-load.php';

$quote_ids = array( 2234, 2478, 2862, 2863, 2866 );
echo "=== Verification ===\n";
foreach ( $quote_ids as $id ) {
	$form = wpcf7_contact_form( $id );
	if ( ! $form ) {
		echo "Form {$id}: NOT FOUND\n";
		continue;
	}
	$markup = $form->prop( 'form' );
	$has_email = str_contains( $markup, 'quote-email' );
	$has_hp    = str_contains( $markup, 'riskwisdom-hp' );
	echo sprintf(
		"Form %d (%s): email=%s honeypot=%s\n",
		$id,
		$form->title(),
		$has_email ? 'YES' : 'MISSING',
		$has_hp ? 'YES' : 'MISSING'
	);
}

$contact = wpcf7_contact_form( 2515 );
if ( $contact ) {
	$markup = $contact->prop( 'form' );
	echo sprintf(
		"Form 2515 (Contact): email=%s honeypot=%s\n",
		str_contains( $markup, 'your-email' ) ? 'YES' : 'MISSING',
		str_contains( $markup, 'riskwisdom-hp' ) ? 'YES' : 'MISSING'
	);
}

echo "\nNext: wp-admin → WP Fastest Cache → Delete Cache\n";
echo "Then test homepage Life Insurance tab — Email field should appear.\n";
echo "Done.\n";
