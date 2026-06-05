<?php
/**
 * Homepage brochure section — interactive PDF viewer above "Welcome to Risk Wisdom!".
 */

define( 'RISKWISDOM_BROCHURE_PDF', 'uploads/2026/06/risk-wisdom-brochure.pdf' );
define( 'RISKWISDOM_BROCHURE_HOME_PAGE_ID', 2318 );

/**
 * @return string
 */
function riskwisdom_brochure_pdf_url() {
	return content_url( '/' . ltrim( RISKWISDOM_BROCHURE_PDF, '/' ) );
}

/**
 * @return bool
 */
function riskwisdom_brochure_is_home() {
	if ( is_front_page() || is_page( RISKWISDOM_BROCHURE_HOME_PAGE_ID ) ) {
		return true;
	}

	global $post;

	return $post instanceof WP_Post && (int) $post->ID === RISKWISDOM_BROCHURE_HOME_PAGE_ID;
}

/**
 * @return string
 */
function riskwisdom_brochure_section_html() {
	$pdf_url  = esc_url( riskwisdom_brochure_pdf_url() );
	$pdf_name = esc_attr( 'Risk-Wisdom-Brochure.pdf' );

	ob_start();
	?>
<div class="rw-brochure-section" id="riskwisdom-brochure">
	<div class="rw-brochure-wrap">
		<div class="rw-brochure-header">
			<h2 class="rw-brochure-title">Our Brochure</h2>
			<p class="rw-brochure-subtitle">Explore the Risk Wisdom brochure — your guide to our insurance advisory services.</p>
		</div>

		<div class="rw-brochure-card">
			<div class="rw-brochure-card__top">
				<div class="rw-brochure-cover">
					<span class="rw-brochure-cover__icon" aria-hidden="true">
						<svg viewBox="0 0 64 64" width="40" height="40" focusable="false">
							<path fill="currentColor" d="M12 8h28l12 12v36a4 4 0 0 1-4 4H12a4 4 0 0 1-4-4V12a4 4 0 0 1 4-4zm26 4v8h8"/>
							<path fill="currentColor" opacity=".65" d="M18 28h28v3H18zm0 10h28v3H18zm0 10h18v3H18z"/>
						</svg>
					</span>
					<div>
						<p class="rw-brochure-cover__title">Risk Wisdom Brochure</p>
						<p class="rw-brochure-cover__meta">Financial services guide</p>
					</div>
				</div>

				<ul class="rw-brochure-features">
					<li>Life, income &amp; business insurance overview</li>
					<li>Expert advisory &amp; claims support</li>
					<li>Preview online or download anytime</li>
				</ul>

				<div class="rw-brochure-actions">
					<button type="button" class="rw-brochure-btn rw-brochure-btn--primary" data-rw-brochure-toggle>
						<span data-rw-brochure-toggle-label>View brochure</span>
					</button>
					<a class="rw-brochure-btn rw-brochure-btn--ghost" href="<?php echo $pdf_url; ?>" target="_blank" rel="noopener noreferrer">Open in new tab</a>
					<a class="rw-brochure-btn rw-brochure-btn--dark" href="<?php echo $pdf_url; ?>" download="<?php echo $pdf_name; ?>">Download PDF</a>
				</div>
			</div>

			<div class="rw-brochure-viewer" data-rw-brochure-viewer>
				<div class="rw-brochure-viewer__bar">
					<span>Brochure preview</span>
					<div class="rw-brochure-viewer__tools">
						<button type="button" class="rw-brochure-tool" data-rw-brochure-zoom="out" aria-label="Zoom out">&minus;</button>
						<span data-rw-brochure-zoom-level>100%</span>
						<button type="button" class="rw-brochure-tool" data-rw-brochure-zoom="in" aria-label="Zoom in">+</button>
						<button type="button" class="rw-brochure-tool" data-rw-brochure-fullscreen aria-label="Fullscreen">&#x26F6;</button>
					</div>
				</div>
				<div class="rw-brochure-viewer__frame" data-rw-brochure-frame-wrap>
					<iframe
						class="rw-brochure-viewer__iframe"
						data-rw-brochure-frame
						src="<?php echo $pdf_url; ?>"
						title="Risk Wisdom Brochure PDF"
					></iframe>
				</div>
			</div>
		</div>
	</div>
</div>
	<?php
	return (string) ob_get_clean();
}

/**
 * Insert brochure section immediately above the Welcome block.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_brochure_insert_before_welcome( $content ) {
	if ( strpos( $content, 'id="riskwisdom-brochure"' ) !== false ) {
		return $content;
	}

	$section     = riskwisdom_brochure_section_html();
	$welcome_pos = strpos( $content, 'Welcome to Risk Wisdom!' );

	if ( $welcome_pos === false ) {
		return $content;
	}

	$before      = substr( $content, 0, $welcome_pos );
	$section_end = strrpos( $before, '</section>' );

	if ( $section_end !== false ) {
		$insert_at = $section_end + strlen( '</section>' );
		return substr( $content, 0, $insert_at ) . $section . substr( $content, $insert_at );
	}

	$marker = strpos( $content, '<h2 class="headline">Welcome to Risk Wisdom!</h2>' ) !== false
		? '<h2 class="headline">Welcome to Risk Wisdom!</h2>'
		: 'Welcome to Risk Wisdom!';

	return str_replace( $marker, $section . $marker, $content );
}

/**
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_brochure_inject_content( $content ) {
	if ( ! riskwisdom_brochure_is_home() || ! is_string( $content ) || $content === '' ) {
		return $content;
	}

	return riskwisdom_brochure_insert_before_welcome( $content );
}

add_filter( 'the_content', 'riskwisdom_brochure_inject_content', 99 );

add_action(
	'wp_enqueue_scripts',
	static function () {
		if ( ! riskwisdom_brochure_is_home() ) {
			return;
		}

		$base = plugin_dir_url( __FILE__ );
		$ver  = '1.0.3';

		wp_enqueue_style( 'riskwisdom-brochure', $base . 'assets/riskwisdom-brochure.css', array(), $ver );
		wp_enqueue_script( 'riskwisdom-brochure', $base . 'assets/riskwisdom-brochure.js', array(), $ver, true );
		wp_localize_script(
			'riskwisdom-brochure',
			'riskwisdomBrochure',
			array(
				'pdfUrl' => riskwisdom_brochure_pdf_url(),
			)
		);
	},
	20
);
