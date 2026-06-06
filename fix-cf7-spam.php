<?php
/**
 * Honeypot + email field + Reply-To + validation messages for CF7 forms.
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

/**
 * @param string $form CF7 form markup.
 * @return string
 */
function riskwisdom_cf7_harden_quote_form( $form, $honeypot_markup, $akismet ) {
	$akismet_name  = $akismet ? ' akismet:author' : '';
	$akismet_email = $akismet ? ' akismet:author_email' : '';

	$form = preg_replace(
		'/\[text\* text-340[^\]]*\]/',
		'[text* text-340' . $akismet_name . ' maxlength:80]',
		$form,
		1
	);

	if ( ! str_contains( $form, 'quote-email' ) ) {
		$form = preg_replace(
			'/(<label>Your name<\/label>\[text\* text-340[^\]]*\])/',
			'$1' . "\n\n<label>Email</label>[email* quote-email" . $akismet_email . ' placeholder "Email address"]',
			$form,
			1
		);
	}

	$form = preg_replace(
		'/\[textarea textarea-570/',
		'[textarea textarea-570' . ( $akismet ? ' akismet:author_content' : '' ),
		$form,
		1
	);

	if ( ! str_contains( $form, 'riskwisdom-hp' ) ) {
		$form = preg_replace(
			'/\[submit/',
			$honeypot_markup . "\n[submit",
			$form,
			1
		);
	}

	return $form;
}

/**
 * Harden Contact Us form markup.
 *
 * @param string $form CF7 form markup.
 * @return string
 */
function riskwisdom_cf7_harden_contact_form( $form, $honeypot_markup, $akismet ) {
	$akismet_name    = $akismet ? ' akismet:author' : '';
	$akismet_email   = $akismet ? ' akismet:author_email' : '';
	$akismet_content = $akismet ? ' akismet:author_content' : '';

	return '<div style="padding: 50px;">
[text* your-name' . $akismet_name . ' maxlength:80 placeholder "Your Name"]
[email* your-email' . $akismet_email . ' placeholder "Your Email Address"]
[tel* phone placeholder "Phone"]
[text* your-subject maxlength:120 placeholder "Subject"]
[textarea your-message' . $akismet_content . ' maxlength:2000 placeholder "Please leave us a message."]
' . $honeypot_markup . '
[submit "Send"]
</div>';
}

/**
 *
 * @param string $form CF7 form markup.
 * @return string
 */
function riskwisdom_cf7_fix_quote_form_labels( $form ) {
	$replacements = array(
		'/<label(\s[^>]*)?>phone<\/label>/i'     => '<label$1>Phone:</label>',
		'/<label(\s[^>]*)?>Email<\/label>/i'      => '<label$1>Email:</label>',
		'/<label(\s[^>]*)?>Your name<\/label>/i'  => '<label$1>Your name:</label>',
	);

	foreach ( $replacements as $pattern => $replacement ) {
		$form = preg_replace( $pattern, $replacement, $form );
	}

	return $form;
}

$forms = array(
	2515 => array(
		'form'         => riskwisdom_cf7_harden_contact_form( '', $honeypot_markup, $akismet ),
		'mail_headers' => "Reply-To: [your-email]\n",
		'messages'     => array(
			'invalid_email' => 'Please enter a valid email address (at least 4 characters before @, no test or placeholder emails).',
			'spam'          => 'Your message was blocked by our spam filter. Please call us or try again.',
		),
	),
);

$quote_form_ids = array( 2234, 2478, 2862, 2863, 2866 );

foreach ( $quote_form_ids as $form_id ) {
	$contact_form = wpcf7_contact_form( $form_id );
	if ( ! $contact_form ) {
		continue;
	}

	$form = $contact_form->prop( 'form' );
	$form = riskwisdom_cf7_fix_quote_form_labels( $form );

	$needs_hardening = ! (
		str_contains( $form, 'quote-email' )
		&& str_contains( $form, 'riskwisdom-hp' )
		&& str_contains( $form, 'maxlength:80' )
	);

	if ( ! $needs_hardening ) {
		$forms[ $form_id ] = array(
			'form' => $form,
		);
		continue;
	}

	$forms[ $form_id ] = array(
		'form'         => riskwisdom_cf7_harden_quote_form( $form, $honeypot_markup, $akismet ),
		'mail_headers' => "Reply-To: [quote-email]\n",
		'messages'     => array(
			'invalid_email' => 'Please enter a valid email address (at least 4 characters before @, no test or placeholder emails).',
			'spam'          => 'Your message was blocked by our spam filter. Please call us or try again.',
		),
	);
}

foreach ( $forms as $form_id => $config ) {
	if ( ! $config ) {
		echo "Form {$form_id}: skipped (not found during build)\n";
		continue;
	}

	$contact_form = wpcf7_contact_form( $form_id );
	if ( ! $contact_form ) {
		echo "Form {$form_id}: not found\n";
		continue;
	}

	$properties = $contact_form->get_properties();
	$before       = $properties['form'] ?? '';

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

	if ( ( $properties['form'] ?? '' ) === $before && empty( $config['mail_headers'] ) && empty( $config['messages'] ) ) {
		echo "Form {$form_id} ({$contact_form->title()}): no changes\n";
		continue;
	}

	$contact_form->set_properties( $properties );
	$contact_form->save();
	delete_post_meta( $form_id, '_config_validation' );

	if ( ! empty( $config['mail_headers'] ) || ! empty( $config['messages'] ) ) {
		echo "Form {$form_id} ({$contact_form->title()}): email + spam protection updated\n";
	} else {
		echo "Form {$form_id} ({$contact_form->title()}): form labels updated\n";
	}
}

echo 'Akismet: ' . ( $akismet ? 'enabled on fields' : 'not active (honeypot + validation only)' ) . "\n";
echo "reCAPTCHA: ensure keys are set in Contact → Integration (v3 runs automatically on submit).\n";
echo "Done.\n";
