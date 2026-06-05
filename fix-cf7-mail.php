<?php
/**
 * Fix CF7 quote form mail settings and clear config validation errors.
 * Run: php fix-cf7-mail.php
 */

define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	echo "Contact Form 7 is not active.\n";
	exit( 1 );
}

$quote_form_ids = array( 2234, 2478, 2862, 2863, 2866 );

foreach ( $quote_form_ids as $form_id ) {
	$contact_form = wpcf7_contact_form( $form_id );

	if ( ! $contact_form ) {
		echo "Form {$form_id}: not found\n";
		continue;
	}

	$properties = $contact_form->get_properties();
	$properties['mail']['sender']    = '[text-340] <info@riskwisdom.com.au>';
	$properties['mail']['recipient'] = 'info@riskwisdom.com.au';

	$contact_form->set_properties( $properties );
	$contact_form->save();

	delete_post_meta( $form_id, '_config_validation' );

	echo "Form {$form_id} ({$contact_form->title()}): mail settings updated\n";
}

echo "Done.\n";
