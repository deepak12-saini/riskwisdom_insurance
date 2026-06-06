<?php
/**
 * CF7 fixes: prevent double-submit 500 (WooCommerce), local mail/recaptcha, loader UI.
 */

$riskwisdom_is_local = isset( $_SERVER['HTTP_HOST'] )
	&& in_array( $_SERVER['HTTP_HOST'], array( 'localhost', '127.0.0.1' ), true );

if ( $riskwisdom_is_local ) {
	// Local: skip reCAPTCHA spam checks (no Google token on localhost).
	add_filter( 'wpcf7_skip_spam_check', '__return_true' );

	// One-time: point leftover production slider image URLs at localhost.
	add_action(
		'init',
		static function () {
			if ( get_option( 'riskwisdom_revslider_urls_fixed' ) ) {
				return;
			}

			global $wpdb;
			$table = $wpdb->prefix . 'revslider_slides';
			$replacements = array(
				'https:\/\/www.riskwisdomfp.com.au' => 'http:\/\/localhost\/riskwisdom',
				'http:\/\/www.riskwisdomfp.com.au'  => 'http:\/\/localhost\/riskwisdom',
				'https:\/\/riskwisdomfp.com.au'     => 'http:\/\/localhost\/riskwisdom',
				'http:\/\/riskwisdomfp.com.au'      => 'http:\/\/localhost\/riskwisdom',
				'https:\/\/riskwisdom.com.au'       => 'http:\/\/localhost\/riskwisdom',
				'http:\/\/riskwisdom.com.au'        => 'http:\/\/localhost\/riskwisdom',
				'https://www.riskwisdomfp.com.au'   => 'http://localhost/riskwisdom',
				'http://www.riskwisdomfp.com.au'    => 'http://localhost/riskwisdom',
				'https://riskwisdomfp.com.au'       => 'http://localhost/riskwisdom',
				'http://riskwisdomfp.com.au'        => 'http://localhost/riskwisdom',
				'https://riskwisdom.com.au'         => 'http://localhost/riskwisdom',
				'http://riskwisdom.com.au'          => 'http://localhost/riskwisdom',
			);

			foreach ( $replacements as $from => $to ) {
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE {$table} SET params = REPLACE(params, %s, %s) WHERE params LIKE %s",
						$from,
						$to,
						'%' . $wpdb->esc_like( $from ) . '%'
					)
				);
			}

			update_option( 'riskwisdom_revslider_urls_fixed', 1, false );
		},
		1
	);
}

/**
 * WordPress native lazy-load breaks Revolution Slider data-lazyload backgrounds.
 */
add_filter(
	'wp_img_tag_add_loading_attr',
	static function ( $value, $image_html, $context ) {
		unset( $context );

		if (
			is_string( $image_html ) && (
				strpos( $image_html, 'rev-slidebg' ) !== false ||
				strpos( $image_html, 'data-lazyload' ) !== false ||
				strpos( $image_html, 'rev_slider' ) !== false
			)
		) {
			return false;
		}

		return $value;
	},
	10,
	3
);

/**
 * WooCommerce Coming Soon calls WP::parse_request() again during template_include.
 * CF7 non-Ajax POST already ran on the first parse_request; a second wpcf7_control_init()
 * makes WPCF7_Submission::get_instance() return null and causes HTTP 500.
 */
add_action(
	'parse_request',
	static function () {
		if ( ! class_exists( 'WPCF7_Submission' ) ) {
			return;
		}

		if ( WPCF7_Submission::get_instance() ) {
			remove_action( 'parse_request', 'wpcf7_control_init', 20 );
		}
	},
	19
);

/**
 * Reject placeholder / test emails (e.g. test@gmail.com) before submit.
 */
function riskwisdom_cf7_is_placeholder_email( $email ) {
	if ( ! is_string( $email ) ) {
		return true;
	}

	$email = strtolower( trim( $email ) );

	if ( ! is_email( $email ) ) {
		return true;
	}

	$parts = explode( '@', $email, 2 );
	if ( 2 !== count( $parts ) ) {
		return true;
	}

	list( $local, $domain ) = $parts;

	$allowed_short_locals = array(
		'amy',
		'ann',
		'ben',
		'bob',
		'dan',
		'eli',
		'eva',
		'ian',
		'jay',
		'jim',
		'joe',
		'joy',
		'kim',
		'leo',
		'max',
		'mia',
		'ray',
		'roy',
		'sam',
		'tim',
		'tom',
	);

	// Reject very short local parts except common real first names.
	if ( strlen( $local ) < 3 ) {
		return true;
	}

	if ( strlen( $local ) < 4 && ! in_array( $local, $allowed_short_locals, true ) ) {
		return true;
	}

	// Reject obvious junk like aaa@, 111@, abc@.
	if ( preg_match( '/^(.)\1+$/', $local ) ) {
		return true;
	}

	if ( preg_match( '/^[0-9]+$/', $local ) ) {
		return true;
	}

	// Repeated characters: deeeee@, aaa@, xxxx@.
	if ( preg_match( '/(.)\1{3,}/', $local ) ) {
		return true;
	}

	// One letter dominates the local part (padding to pass length checks).
	if ( strlen( $local ) >= 5 ) {
		$counts = count_chars( $local, 1 );
		if ( $counts ) {
			arsort( $counts );
			$max = (int) reset( $counts );
			if ( $max / strlen( $local ) >= 0.6 ) {
				return true;
			}
		}
	}

	// Keyboard mash / random typing (asdf, qwerty, dsfsdfds).
	$keyboard_spam = array(
		'asdf',
		'asdfg',
		'asdfgh',
		'qwer',
		'qwert',
		'qwerty',
		'zxcv',
		'zxcvb',
		'qazwsx',
		'aaaa',
		'bbbb',
		'cccc',
		'dddd',
		'eeee',
		'ffff',
	);

	foreach ( $keyboard_spam as $spam ) {
		if ( str_contains( $local, $spam ) ) {
			return true;
		}
	}

	$blocked_locals = array(
		'test',
		'testing',
		'demo',
		'fake',
		'example',
		'sample',
		'temp',
		'asdf',
		'abc',
		'xxx',
		'none',
		'user',
		'admin',
		'email',
		'name',
	);

	if ( in_array( $local, $blocked_locals, true ) ) {
		return true;
	}

	$blocked_domains = array(
		'example.com',
		'example.org',
		'example.net',
		'test.com',
		'localhost',
		'invalid.com',
	);

	if ( in_array( $domain, $blocked_domains, true ) ) {
		return true;
	}

	$junk_domains = array(
		'mailinator.com',
		'guerrillamail.com',
		'tempmail.com',
		'10minutemail.com',
		'yopmail.com',
		'throwaway.email',
		'fakeinbox.com',
		'trashmail.com',
	);

	foreach ( $junk_domains as $junk_domain ) {
		if ( $domain === $junk_domain ) {
			return true;
		}
	}

	return false;
}

/**
 * @param WPCF7_Validation $result Validation result.
 * @param WPCF7_FormTag    $tag    Form tag.
 */
function riskwisdom_cf7_validate_real_email( $result, $tag ) {
	$value = wpcf7_superglobal_post( $tag->name );

	if ( '' === $value || ! riskwisdom_cf7_is_placeholder_email( $value ) ) {
		return $result;
	}

	$result->invalidate(
		$tag,
		__( 'Please enter a valid email address (at least 4 characters before @, no test or placeholder emails).', 'riskwisdom' )
	);

	return $result;
}

add_filter( 'wpcf7_validate_email', 'riskwisdom_cf7_validate_real_email', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'riskwisdom_cf7_validate_real_email', 20, 2 );

/**
 * CF7 field names used for person name (stricter link blocking).
 *
 * @return string[]
 */
function riskwisdom_cf7_name_field_names() {
	return array( 'your-name', 'text-340' );
}

/**
 * Normalize user text before spam checks.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function riskwisdom_cf7_normalize_field_text( $value ) {
	if ( ! is_string( $value ) ) {
		return '';
	}

	$value = wp_strip_all_tags( $value );
	$value = preg_replace( '/[\x{200B}-\x{200D}\x{FEFF}]/u', '', $value );

	return trim( $value );
}

/**
 * Strict validation for name fields — block links, domains, and www variants.
 *
 * @param mixed $value Field value.
 * @return bool True when invalid.
 */
function riskwisdom_cf7_is_invalid_name( $value ) {
	$value = riskwisdom_cf7_normalize_field_text( $value );

	if ( '' === $value ) {
		return false;
	}

	$patterns = array(
		'/https?:\/\//i',
		'/ftp:\/\//i',
		'/mailto:/i',
		'/\[url(?:=|\])/i',
		'/\[\/url\]/i',
		'/\[link(?:=|\])/i',
		'/<a\s/i',
		'/^www[\W_]/i',
		'/^www\d*\./i',
		'/[\s(]www[\W_]/i',
		'/www[\.\/]/i',
		'/\swww\d*\./i',
		'/\@/',                          // any email address in name field.
		'/\:\/\/',                       // protocol-relative URL.
		'/\b[a-z0-9][a-z0-9-]{0,62}\.(com|net|org|ru|au|co|uk|io|info|biz|xyz|top|shop|online|site|link|click|tk|cn|de|fr|us|in|me|tv|edu|gov|mil|int)\b/i',
		'/[^\s]+\.(php|html|htm|asp|aspx)\b/i',
	);

	foreach ( $patterns as $pattern ) {
		if ( preg_match( $pattern, $value ) ) {
			return true;
		}
	}

	// Domain-like single token: "www.spam" or "site.ru" (allow "Mary-Jane", "O'Brien").
	if ( preg_match( '/^[a-z0-9][a-z0-9._-]*\.[a-z0-9][a-z0-9._-]*$/i', $value ) ) {
		return true;
	}

	return false;
}

/**
 * Block link/BBCode spam in message and other text fields.
 *
 * @param mixed $value Field value.
 * @return bool
 */
function riskwisdom_cf7_is_spam_text( $value ) {
	$value = riskwisdom_cf7_normalize_field_text( $value );

	if ( '' === $value ) {
		return false;
	}

	$patterns = array(
		'/https?:\/\//i',
		'/ftp:\/\//i',
		'/mailto:/i',
		'/\[url(?:=|\])/i',
		'/\[\/url\]/i',
		'/\[link(?:=|\])/i',
		'/<a\s/i',
		'/www[\.\/]/i',
		'/^www[\W_]/i',
		'/\swww[\.\/]/i',
		'/\:\/\/',
		'/\bnarkolog/i',
		'/\b[a-z0-9][a-z0-9-]{0,62}\.(com|net|org|ru|au|co|uk|io|info|biz|xyz|top|shop|online|site|link|click|tk|cn|de|fr|us|in|me|tv|edu|gov)\b/i',
	);

	foreach ( $patterns as $pattern ) {
		if ( preg_match( $pattern, $value ) ) {
			return true;
		}
	}

	return false;
}

/**
 * @param WPCF7_Validation $result Validation result.
 * @param WPCF7_FormTag    $tag    Form tag.
 */
function riskwisdom_cf7_validate_no_spam_text( $result, $tag ) {
	if ( ! in_array( $tag->basetype, array( 'text', 'textarea' ), true ) ) {
		return $result;
	}

	$value = wpcf7_superglobal_post( $tag->name );

	if ( in_array( $tag->name, riskwisdom_cf7_name_field_names(), true ) ) {
		if ( riskwisdom_cf7_is_invalid_name( $value ) ) {
			$result->invalidate(
				$tag,
				__( 'Please enter your real name only — links and website addresses are not allowed.', 'riskwisdom' )
			);
		}

		return $result;
	}

	if ( riskwisdom_cf7_is_spam_text( $value ) ) {
		$result->invalidate(
			$tag,
			__( 'Please enter plain text only — links are not allowed in this field.', 'riskwisdom' )
		);
	}

	return $result;
}

add_filter( 'wpcf7_validate_text', 'riskwisdom_cf7_validate_no_spam_text', 20, 2 );
add_filter( 'wpcf7_validate_text*', 'riskwisdom_cf7_validate_no_spam_text', 20, 2 );
add_filter( 'wpcf7_validate_textarea', 'riskwisdom_cf7_validate_no_spam_text', 20, 2 );
add_filter( 'wpcf7_validate_textarea*', 'riskwisdom_cf7_validate_no_spam_text', 20, 2 );

/**
 * Honeypot: bots fill hidden field; humans leave it empty.
 */
add_filter(
	'wpcf7_spam',
	static function ( $spam, $submission ) {
		if ( $spam ) {
			return $spam;
		}

		$honeypot = wpcf7_superglobal_post( 'riskwisdom-hp' );

		if ( is_string( $honeypot ) && '' !== trim( $honeypot ) ) {
			if ( $submission instanceof WPCF7_Submission ) {
				$submission->add_spam_log(
					array(
						'agent'  => 'honeypot',
						'reason' => 'Hidden honeypot field was filled.',
					)
				);
			}
			return true;
		}

		return $spam;
	},
	5,
	2
);

add_filter(
	'wpcf7_spam',
	static function ( $spam, $submission ) {
		if ( $spam || ! $submission instanceof WPCF7_Submission ) {
			return $spam;
		}

		foreach ( $submission->get_posted_data() as $key => $value ) {
			if ( is_string( $key ) && str_starts_with( $key, '_' ) ) {
				continue;
			}

			if ( is_array( $value ) ) {
				$value = implode( ' ', $value );
			}

			if ( in_array( $key, array( 'your-email', 'quote-email' ), true ) ) {
				if ( riskwisdom_cf7_is_placeholder_email( $value ) ) {
					$submission->add_spam_log(
						array(
							'agent'  => 'riskwisdom',
							'reason' => 'Invalid or placeholder email: ' . $key,
						)
					);
					return true;
				}
				continue;
			}

			if ( in_array( $key, riskwisdom_cf7_name_field_names(), true ) ) {
				$blocked = riskwisdom_cf7_is_invalid_name( $value );
			} else {
				$blocked = riskwisdom_cf7_is_spam_text( $value );
			}

			if ( $blocked ) {
				$submission->add_spam_log(
					array(
						'agent'  => 'riskwisdom',
						'reason' => 'Link or spam pattern in field: ' . $key,
					)
				);
				return true;
			}
		}

		return $spam;
	},
	6,
	2
);

/**
 * reCAPTCHA v3 often fails on KC tabbed quote forms (empty/expired token).
 * Only bypass on localhost — production must enforce reCAPTCHA.
 */
add_filter(
	'wpcf7_spam',
	static function ( $spam, $submission ) use ( $riskwisdom_is_local ) {
		if ( ! $riskwisdom_is_local || ! $spam || ! $submission instanceof WPCF7_Submission ) {
			return $spam;
		}

		$only_recaptcha = true;

		foreach ( $submission->get_spam_log() as $entry ) {
			if ( empty( $entry['agent'] ) || 'recaptcha' !== $entry['agent'] ) {
				$only_recaptcha = false;
				break;
			}
		}

		if ( $only_recaptcha && $submission->get_spam_log() ) {
			error_log(
				'CF7: allowing submission after reCAPTCHA false positive — ' .
				wp_json_encode( $submission->get_spam_log() )
			);
			return false;
		}

		return $spam;
	},
	20,
	2
);

add_action(
	'wpcf7_submit',
	static function ( $contact_form, $result ) {
		if ( isset( $result['status'] ) && 'mail_sent' !== $result['status'] ) {
			error_log(
				sprintf(
					'CF7 form %d status=%s message=%s',
					$contact_form->id(),
					$result['status'],
					$result['message'] ?? ''
				)
			);
		}
	},
	10,
	2
);

add_filter(
	'phpmailer_init',
	static function ( $phpmailer ) {
		$phpmailer->Timeout = 10;
	}
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! function_exists( 'wpcf7_enqueue_scripts' ) ) {
			return;
		}

		wp_enqueue_script( 'swv' );
		wpcf7_enqueue_scripts();
		wpcf7_enqueue_styles();

		if ( wp_script_is( 'wpcf7-recaptcha', 'registered' ) ) {
			wp_enqueue_script( 'wpcf7-recaptcha' );
		}
	},
	100
);

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! wp_script_is( 'contact-form-7', 'registered' ) ) {
			return;
		}

		$inline = <<<'JS'
(function () {
	function clearCf7Ui() {
		document.querySelectorAll('.wpcf7-form.submitting').forEach(function (form) {
			form.classList.remove('submitting');
		});
		document.querySelectorAll('.preloader').forEach(function (el) {
			el.remove();
		});
		if (document.body) {
			document.body.style.display = '';
			document.body.style.opacity = '1';
		}
	}

	/** Keep KingComposer quote tab (Life/Income/Business/etc.) after CF7 submit. */
	function activateKcTabForCf7(node) {
		if (!node || !window.jQuery) {
			return;
		}

		var container = node.classList && node.classList.contains('wpcf7')
			? node
			: (node.closest ? node.closest('.wpcf7') : null);

		if (!container) {
			return;
		}

		var panel = container.closest('.kc_tab');
		if (!panel || !panel.id) {
			return;
		}

		var $li = jQuery('.kc_tabs_nav a[href="#' + panel.id + '"]').closest('li');
		if ($li.length && !$li.hasClass('ui-tabs-active')) {
			$li.trigger('click');
		}
	}

	function scrollToCf7Form(node) {
		var container = null;

		if (node && node.classList && node.classList.contains('wpcf7')) {
			container = node;
		} else if (node && node.closest) {
			container = node.closest('.wpcf7');
		}

		if (!container && location.hash && location.hash.indexOf('wpcf7') !== -1) {
			container = document.getElementById(location.hash.replace('#', ''));
		}

		if (container && container.scrollIntoView) {
			container.scrollIntoView({ behavior: 'smooth', block: 'center' });
		}
	}

	function activateKcTabFromHash() {
		if (!location.hash || location.hash.indexOf('wpcf7') === -1) {
			return;
		}

		var unitId = location.hash.replace('#', '');
		var el = document.getElementById(unitId);
		if (el) {
			activateKcTabForCf7(el);
			scrollToCf7Form(el);
		}
	}

	['wpcf7submit', 'wpcf7invalid', 'wpcf7spam', 'wpcf7mailfailed'].forEach(function (evt) {
		document.addEventListener(evt, function (e) {
			clearCf7Ui();
			activateKcTabForCf7(e.target);
			scrollToCf7Form(e.target);
		}, false);
	});

	document.addEventListener('DOMContentLoaded', function () {
		if (location.hash && location.hash.indexOf('wpcf7') !== -1) {
			clearCf7Ui();
			// KC tabs() activates tab 1 first; override after it runs.
			setTimeout(activateKcTabFromHash, 200);
			setTimeout(activateKcTabFromHash, 600);
		}
	});

	if (window.jQuery) {
		jQuery(document).ajaxComplete(function (_e, xhr, settings) {
			if (settings && settings.url && settings.url.indexOf('contact-form-7') !== -1) {
				clearCf7Ui();
			}
		});
	}
})();
JS;

		wp_add_inline_script( 'contact-form-7', $inline, 'after' );
	},
	110
);

