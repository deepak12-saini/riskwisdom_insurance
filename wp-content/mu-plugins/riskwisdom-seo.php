<?php
/**
 * Local business JSON-LD for Risk Wisdom (complements AIOSEO).
 */

/**
 * @return bool
 */
function riskwisdom_seo_is_local() {
	return isset( $_SERVER['HTTP_HOST'] )
		&& in_array( $_SERVER['HTTP_HOST'], array( 'localhost', '127.0.0.1' ), true );
}

/**
 * @return string
 */
function riskwisdom_seo_site_url() {
	if ( riskwisdom_seo_is_local() ) {
		return home_url( '/' );
	}

	return 'https://riskwisdom.com.au/';
}

add_action(
	'wp_head',
	static function () {
		if ( is_admin() ) {
			return;
		}

		$same_as = apply_filters( 'riskwisdom_seo_same_as', array() );

		if ( defined( 'RISKWISDOM_GBP_URL' ) && is_string( RISKWISDOM_GBP_URL ) && RISKWISDOM_GBP_URL !== '' ) {
			$same_as[] = RISKWISDOM_GBP_URL;
		}

		$same_as = array_values( array_unique( array_filter( $same_as ) ) );

		$schema = array(
			'@context' => 'https://schema.org',
			'@type'    => array( 'FinancialService', 'InsuranceAgency', 'LocalBusiness' ),
			'name'     => 'Risk Wisdom Financial Partners',
			'url'      => riskwisdom_seo_site_url(),
			'logo'     => riskwisdom_seo_site_url() . 'wp-content/uploads/2026/02/riskwisdom-fp-2.jpg',
			'image'    => riskwisdom_seo_site_url() . 'wp-content/uploads/2026/02/riskwisdom-fp-2.jpg',
			'telephone' => '+61-2-9071-4735',
			'email'    => 'info@riskwisdom.com.au',
			'address'  => array(
				'@type'           => 'PostalAddress',
				'streetAddress'   => 'Level 29 Chifley Tower, 2 Chifley Square',
				'addressLocality' => 'Sydney',
				'addressRegion'   => 'NSW',
				'addressCountry'  => 'AU',
			),
			'areaServed' => array(
				'@type' => 'Country',
				'name'  => 'Australia',
			),
			'description' => 'Independent insurance advisors in Sydney specialising in life insurance, income protection, trauma, TPD and business insurance.',
			'sameAs'      => $same_as,
		);

		echo '<script type="application/ld+json">' . wp_json_encode( $schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) . "</script>\n";
	},
	5
);
