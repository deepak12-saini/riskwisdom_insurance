<?php
/**
 * Risk Wisdom — site-wide UI polish (inner pages, blog, newsletter, mobile nav).
 * Theme colors unchanged; complements riskwisdom-home-ui.php on the homepage.
 */

define( 'RISKWISDOM_UI_VERSION', '1.1.0' );

/** @var string[] */
const RISKWISDOM_UI_SERVICE_SLUGS = array(
	'life-insurance',
	'income-insurance',
	'trauma-insurance',
	'tpd-insurance',
	'business-insurance',
	'key-man-insurance',
	'financial-planning-process',
	'about',
);

/** @var string[] Spam patterns for homepage embedded blog HTML. */
const RISKWISDOM_UI_SPAM_BLOG_PATTERNS = array(
	'/\bcrack\b/i',
	'/\bpatch\b/i',
	'/keygen/i',
	'/activat(ed)?/i',
	'/torrent/i',
	'/warez/i',
	'/HASH/i',
	'/hash[- ]?sum/i',
	'/x86x64/i',
	'/MediaFire/i',
	'/license\s*\[/i',
);

/**
 * @return bool
 */
function riskwisdom_ui_is_active() {
	return ! is_admin();
}

/**
 * @return bool
 */
function riskwisdom_ui_is_home() {
	if ( function_exists( 'riskwisdom_home_ui_is_home' ) ) {
		return riskwisdom_home_ui_is_home();
	}

	return is_front_page();
}

/**
 * @param string[] $classes Body classes.
 * @return string[]
 */
function riskwisdom_ui_body_class( $classes ) {
	if ( ! riskwisdom_ui_is_active() ) {
		return $classes;
	}

	$classes[] = 'riskwisdom-ui';

	if ( is_page( 'newsletter' ) || is_page_template( 'page-templates/blog-archive-newsletter.php' ) ) {
		$classes[] = 'riskwisdom-newsletter-archive';
	}

	if ( is_singular( 'post' ) && in_category( 'newsletter' ) ) {
		$classes[] = 'riskwisdom-newsletter-single';
	}

	if ( is_page( RISKWISDOM_UI_SERVICE_SLUGS ) ) {
		$classes[] = 'riskwisdom-service-page';
	}

	if ( is_page( 'contact-us' ) ) {
		$classes[] = 'riskwisdom-contact-page';
	}

	if ( is_page( 'faq' ) ) {
		$classes[] = 'riskwisdom-faq-page';
	}

	return $classes;
}
add_filter( 'body_class', 'riskwisdom_ui_body_class' );

/**
 * Enqueue site-wide UI assets.
 */
function riskwisdom_ui_enqueue_assets() {
	if ( ! riskwisdom_ui_is_active() ) {
		return;
	}

	wp_enqueue_style(
		'riskwisdom-ui',
		plugins_url( 'assets/riskwisdom-ui.css', __FILE__ ),
		array( 'rt_healthinsurance_green' ),
		RISKWISDOM_UI_VERSION
	);

	wp_enqueue_script(
		'riskwisdom-ui',
		plugins_url( 'assets/riskwisdom-ui.js', __FILE__ ),
		array( 'jquery' ),
		RISKWISDOM_UI_VERSION,
		true
	);
}
add_action( 'wp_enqueue_scripts', 'riskwisdom_ui_enqueue_assets', 130 );

/**
 * @param string $html Blog article HTML.
 * @return bool
 */
function riskwisdom_ui_is_spam_blog_html( $html ) {
	foreach ( RISKWISDOM_UI_SPAM_BLOG_PATTERNS as $pattern ) {
		if ( preg_match( $pattern, $html ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Remove hacked/spam blog cards from homepage KingComposer HTML.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_ui_filter_homepage_blog_spam( $content ) {
	if ( ! riskwisdom_ui_is_home() || ! is_string( $content ) || $content === '' ) {
		return $content;
	}

	$filtered = preg_replace_callback(
		'/<article class="blogpost">[\s\S]*?<\/article>\s*/i',
		static function ( $matches ) {
			return riskwisdom_ui_is_spam_blog_html( $matches[0] ) ? '' : $matches[0];
		},
		$content
	);

	return is_string( $filtered ) ? $filtered : $content;
}
add_filter( 'the_content', 'riskwisdom_ui_filter_homepage_blog_spam', 98 );

/**
 * Add "View all articles" under homepage blog strip.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_ui_inject_blog_view_all( $content ) {
	if ( ! riskwisdom_ui_is_home() || ! is_string( $content ) || $content === '' ) {
		return $content;
	}

	if ( strpos( $content, 'rw-blog-view-all' ) !== false || strpos( $content, 'Blog news' ) === false ) {
		return $content;
	}

	$block = sprintf(
		'<div class="rw-blog-view-all text-center"><a class="rw-btn rw-btn--primary" href="%s">%s <span aria-hidden="true">→</span></a></div>',
		esc_url( home_url( '/blog/' ) ),
		esc_html__( 'View all articles', 'health-insurance' )
	);

	$updated = preg_replace(
		'/(<h2 class="headline">Blog news<\/h2>[\s\S]*?<div class="row">[\s\S]*?<\/div>)(\s*<div class="kc-elm)/',
		'$1' . $block . '$2',
		$content,
		1
	);

	return is_string( $updated ) ? $updated : $content;
}
add_filter( 'the_content', 'riskwisdom_ui_inject_blog_view_all', 99 );

/**
 * @return string
 */
function riskwisdom_ui_service_cta_html() {
	ob_start();
	?>
<section class="rw-service-cta">
	<div class="rw-service-cta__inner">
		<h2 class="rw-service-cta__title"><?php esc_html_e( 'Ready to talk to an advisor?', 'health-insurance' ); ?></h2>
		<p class="rw-service-cta__text"><?php esc_html_e( 'Independent insurance advice for Sydney and Australia. We respond within one business day.', 'health-insurance' ); ?></p>
		<div class="rw-service-cta__actions">
			<a class="rw-btn rw-btn--primary" href="tel:0290714735"><?php esc_html_e( 'Call 02 9071 4735', 'health-insurance' ); ?></a>
			<a class="rw-btn rw-btn--ghost" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Request a quote', 'health-insurance' ); ?></a>
		</div>
	</div>
</section>
	<?php
	return (string) ob_get_clean();
}

/**
 * Append CTA strip on service and about pages.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_ui_append_service_cta( $content ) {
	if ( ! is_page( RISKWISDOM_UI_SERVICE_SLUGS ) || ! is_string( $content ) || $content === '' ) {
		return $content;
	}

	if ( strpos( $content, 'rw-service-cta' ) !== false ) {
		return $content;
	}

	return $content . riskwisdom_ui_service_cta_html();
}
add_filter( 'the_content', 'riskwisdom_ui_append_service_cta', 100 );

/**
 * Contact page trust strip above content.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_ui_contact_trust_strip( $content ) {
	if ( ! is_page( 'contact-us' ) || ! is_string( $content ) || $content === '' ) {
		return $content;
	}

	if ( strpos( $content, 'rw-contact-trust' ) !== false ) {
		return $content;
	}

	$strip = sprintf(
		'<div class="rw-contact-trust"><div class="rw-contact-trust__item"><strong>%s</strong><span>%s</span></div><div class="rw-contact-trust__item"><strong>%s</strong><a href="tel:0290714735">02 9071 4735</a></div><div class="rw-contact-trust__item"><strong>%s</strong><a href="mailto:info@riskwisdom.com.au">info@riskwisdom.com.au</a></div><div class="rw-contact-trust__item"><strong>%s</strong><span>%s</span></div></div>',
		esc_html__( 'Office', 'health-insurance' ),
		esc_html__( 'Level 29 Chifley Tower, 2 Chifley Square, Sydney NSW', 'health-insurance' ),
		esc_html__( 'Phone', 'health-insurance' ),
		esc_html__( 'Email', 'health-insurance' ),
		esc_html__( 'Response time', 'health-insurance' ),
		esc_html__( 'Within 1 business day', 'health-insurance' )
	);

	return $strip . $content;
}
add_filter( 'the_content', 'riskwisdom_ui_contact_trust_strip', 5 );

/**
 * Newsletter single: back link + readable prose wrapper.
 *
 * @param string $content Post content.
 * @return string
 */
function riskwisdom_ui_newsletter_single_content( $content ) {
	if ( ! is_singular( 'post' ) || ! in_category( 'newsletter' ) ) {
		return $content;
	}

	static $wrapped = false;
	if ( $wrapped ) {
		return $content;
	}
	$wrapped = true;

	$back = sprintf(
		'<a class="rw-newsletter-back" href="%s"><span aria-hidden="true">←</span> %s</a>',
		esc_url( home_url( '/newsletter/' ) ),
		esc_html__( 'All newsletter editions', 'health-insurance' )
	);

	return $back . '<div class="rw-newsletter-prose">' . $content . '</div>';
}
add_filter( 'the_content', 'riskwisdom_ui_newsletter_single_content', 8 );

/**
 * Mobile logo bar (small screens).
 */
function riskwisdom_ui_mobile_topbar() {
	if ( ! riskwisdom_ui_is_active() ) {
		return;
	}
	?>
	<div class="rw-mobile-topbar">
		<a class="rw-mobile-topbar__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php if ( get_theme_mod( 'logo' ) ) : ?>
				<img src="<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php else : ?>
				<span><?php bloginfo( 'name' ); ?></span>
			<?php endif; ?>
		</a>
	</div>
	<?php
}

/**
 * Sticky mobile call / quote bar.
 */
function riskwisdom_ui_mobile_cta_bar() {
	if ( ! riskwisdom_ui_is_active() ) {
		return;
	}
	?>
	<div class="rw-mobile-cta" role="navigation" aria-label="<?php esc_attr_e( 'Quick contact', 'health-insurance' ); ?>">
		<a class="rw-mobile-cta__btn rw-mobile-cta__btn--call" href="tel:0290714735">
			<span aria-hidden="true">📞</span> <?php esc_html_e( 'Call', 'health-insurance' ); ?>
		</a>
		<a class="rw-mobile-cta__btn rw-mobile-cta__btn--quote" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>">
			<?php esc_html_e( 'Get a quote', 'health-insurance' ); ?>
		</a>
	</div>
	<?php
}
add_action( 'wp_footer', 'riskwisdom_ui_mobile_cta_bar', 5 );

/**
 * FAQ page: simple client-side filter for accordion headings.
 */
function riskwisdom_ui_faq_search() {
	if ( ! is_page( 'faq' ) ) {
		return;
	}
	?>
	<div class="rw-faq-search-wrap">
		<label class="screen-reader-text" for="rw-faq-search"><?php esc_html_e( 'Search FAQs', 'health-insurance' ); ?></label>
		<input type="search" id="rw-faq-search" class="rw-faq-search" placeholder="<?php esc_attr_e( 'Search FAQs…', 'health-insurance' ); ?>" autocomplete="off">
	</div>
	<?php
}
add_action( 'wp_footer', 'riskwisdom_ui_faq_search', 6 );
