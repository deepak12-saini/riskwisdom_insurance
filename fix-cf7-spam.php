<?php
/**
 * Honeypot + Reply-To + validation messages for CF7 forms.
 * Run: php fix-cf7-spam.php
 */

define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

if ( ! class_exists( 'WPCF7_ContactForm' ) ) {
	echo "Contact Form 7 is not active.\n";
	exit( 1 );
}

$honeypot_markup = <<<'HTML'

<div class="riskwisdom-hp" aria-hidden="true" style="position:absolute;left:-9999px;top:-9999px;height:0;width:0;overflow:hidden;opacity:0;pointer-events:none;">
<label>Leave this field empty<input type="text" name="riskwisdom-hp" value="" tabindex="-1" autocomplete="off"></label>
</div>
HTML;

$akismet = function_exists( 'wpcf7_akismet_is_available' ) && wpcf7_akismet_is_available();

$forms = array(
	2515 => array(
		'form' => '<div style="padding: 50px;">
[text* your-name' . ( $akismet ? ' akismet:author' : '' ) . ' placeholder "Your Name"]
[email* your-email' . ( $akismet ? ' akismet:author_email' : '' ) . ' placeholder "Your Email Address"]
[text* phone placeholder "Phone"]
[text* your-subject placeholder "Subject"]
[textarea your-message' . ( $akismet ? ' akismet:author_content' : '' ) . ' placeholder "Please leave us a message."]
' . $honeypot_markup . '
[submit "Send"]
</div>',
		'mail_headers' => "Reply-To: [your-email]\n",
		'messages'     => array(
			'invalid_email' => 'Please enter your real email address (test or placeholder emails are not accepted).',
			'spam'          => 'Your message was blocked by our spam filter. Please call us or try again.',
		),
	),
	2234 => null,
	2478 => null,
	2862 => null,
	2863 => null,
	2866 => null,
);

foreach ( array( 2234, 2478, 2862, 2863, 2866 ) as $form_id ) {
	$contact_form = wpcf7_contact_form( $form_id );
	if ( ! $contact_form ) {
		continue;
	}

	$form = $contact_form->prop( 'form' );
	if ( str_contains( $form, 'riskwisdom-hp' ) ) {
		$forms[ $form_id ] = array( 'skip' => true );
		continue;
	}

	$akismet_name = $akismet ? ' akismet:author' : '';
	$akismet_msg  = $akismet ? ' akismet:author_content' : '';

	$form = preg_replace(
		'/\[text\* text-340\]/',
		'[text* text-340' . $akismet_name . ']',
		$form,
		1
	);
	$form = preg_replace(
		'/\[textarea textarea-570/',
		'[textarea textarea-570' . $akismet_msg,
		$form,
		1
	);
	$form = preg_replace(
		'/\[submit/',
		$honeypot_markup . "\n[submit",
		$form,
		1
	);

	$forms[ $form_id ] = array(
		'form'     => $form,
		'messages' => array(
			'spam' => 'Your message was blocked by our spam filter. Please call us or try again.',
		),
	);
}

foreach ( $forms as $form_id => $config ) {
	if ( ! $config ) {
		echo "Form {$form_id}: skipped (not found during build)\n";
		continue;
	}

	if ( ! empty( $config['skip'] ) ) {
		echo "Form {$form_id}: already has honeypot\n";
		continue;
	}

	$contact_form = wpcf7_contact_form( $form_id );
	if ( ! $contact_form ) {
		echo "Form {$form_id}: not found\n";
		continue;
	}

	$properties = $contact_form->get_properties();

	if ( ! empty( $config['form'] ) ) {
		$properties['form'] = $config['form'];
	}

	if ( ! empty( $config['mail_headers'] ) ) {
		$properties['mail']['additional_headers'] = $config['mail_headers'];
	}

	if ( ! empty( $config['messages'] ) ) {
		foreach ( $config['messages'] as $key => $message ) {
			$properties['messages'][ $key ] = $message;
		}
	}

	$contact_form->set_properties( $properties );
	$contact_form->save();
	delete_post_meta( $form_id, '_config_validation' );

	echo "Form {$form_id} ({$contact_form->title()}): spam protection updated\n";
}

echo 'Akismet: ' . ( $akismet ? 'enabled on fields' : 'not active (honeypot only)' ) . "\n";
echo "Done.\n";
