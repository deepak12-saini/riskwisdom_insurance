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

	['wpcf7submit', 'wpcf7invalid', 'wpcf7spam', 'wpcf7mailfailed'].forEach(function (evt) {
		document.addEventListener(evt, clearCf7Ui, false);
	});

	document.addEventListener('DOMContentLoaded', function () {
		if (location.hash && location.hash.indexOf('wpcf7') !== -1) {
			clearCf7Ui();
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

