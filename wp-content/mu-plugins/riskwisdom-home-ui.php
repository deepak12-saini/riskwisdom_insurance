<?php
/**
 * Risk Wisdom — homepage UI polish (spacing, cards, forms). Theme colors unchanged.
 */

define( 'RISKWISDOM_HOME_UI_PAGE_ID', 2318 );
define( 'RISKWISDOM_HOME_UI_VERSION', '1.1.0' );

/**
 * @return bool
 */
function riskwisdom_home_ui_is_home() {
	if ( function_exists( 'riskwisdom_brochure_is_home' ) ) {
		return riskwisdom_brochure_is_home();
	}

	if ( is_front_page() ) {
		return true;
	}

	global $post;

	return $post instanceof WP_Post && (int) $post->ID === RISKWISDOM_HOME_UI_PAGE_ID;
}

/**
 * @param string[] $classes Body classes.
 * @return string[]
 */
function riskwisdom_home_ui_body_class( $classes ) {
	if ( riskwisdom_home_ui_is_home() ) {
		$classes[] = 'riskwisdom-home-ui';
	}

	return $classes;
}
add_filter( 'body_class', 'riskwisdom_home_ui_body_class' );

/**
 * Enqueue homepage UI stylesheet.
 */
function riskwisdom_home_ui_enqueue_assets() {
	if ( ! riskwisdom_home_ui_is_home() ) {
		return;
	}

	wp_enqueue_style(
		'riskwisdom-home-ui',
		plugins_url( 'assets/riskwisdom-home-ui.css', __FILE__ ),
		array( 'rt_healthinsurance_green' ),
		'1.1.0'
	);
}
add_action( 'wp_enqueue_scripts', 'riskwisdom_home_ui_enqueue_assets', 140 );
