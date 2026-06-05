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
		__( 'Please enter your real email address (test or placeholder emails are not accepted).', 'riskwisdom' )
	);

	return $result;
}

add_filter( 'wpcf7_validate_email', 'riskwisdom_cf7_validate_real_email', 20, 2 );
add_filter( 'wpcf7_validate_email*', 'riskwisdom_cf7_validate_real_email', 20, 2 );

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

/**
 * reCAPTCHA v3 often fails on KC tabbed quote forms (empty/expired token).
 * SMTP test works; CF7 was returning status "spam" with the same message as mail_failed.
 */
add_filter(
	'wpcf7_spam',
	static function ( $spam, $submission ) {
		if ( ! $spam || ! $submission instanceof WPCF7_Submission ) {
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

