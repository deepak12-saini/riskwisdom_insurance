<?php
/**
 * Replace localhost / old domain URLs in the WordPress database.
 *
 * Run: php fix-seo-urls.php
 * Apply: php fix-seo-urls.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

$production_url = 'https://riskwisdom.com.au';

$replacements = array(
	'http://localhost/riskwisdom'  => $production_url,
	'https://localhost/riskwisdom' => $production_url,
	'http://www.riskwisdomfp.com.au' => $production_url,
	'https://www.riskwisdomfp.com.au' => $production_url,
	'http://riskwisdomfp.com.au'   => $production_url,
	'https://riskwisdomfp.com.au'  => $production_url,
);

// JSON-escaped variants (RevSlider, KC stored JSON).
foreach ( array_keys( $replacements ) as $from ) {
	$replacements[ str_replace( '/', '\\/', $from ) ] = str_replace( '/', '\\/', $replacements[ $from ] );
}

global $wpdb;

echo "=== Risk Wisdom: fix SEO URLs ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$siteurl  = get_option( 'siteurl' );
$home     = get_option( 'home' );
$is_local = is_string( $siteurl ) && str_contains( $siteurl, 'localhost' );

echo "Current siteurl: {$siteurl}\n";
echo "Current home:    {$home}\n";

if ( $is_local ) {
	echo "Note: localhost detected — siteurl/home will NOT be changed (content URL replace still runs with --apply).\n";
}

if ( $apply && ! $is_local && is_string( $siteurl ) && str_contains( $siteurl, 'localhost' ) ) {
	update_option( 'siteurl', $production_url );
	echo "Updated siteurl -> {$production_url}\n";
}

if ( $apply && ! $is_local && is_string( $home ) && str_contains( $home, 'localhost' ) ) {
	update_option( 'home', $production_url );
	echo "Updated home -> {$production_url}\n";
}

$tables = array(
	$wpdb->posts    => array( 'post_content', 'post_excerpt', 'guid' ),
	$wpdb->postmeta => array( 'meta_value' ),
	$wpdb->options  => array( 'option_value' ),
);

$total = 0;

foreach ( $tables as $table => $columns ) {
	foreach ( $columns as $column ) {
		foreach ( $replacements as $from => $to ) {
			if ( $from === $to ) {
				continue;
			}

			$count = (int) $wpdb->get_var(
				$wpdb->prepare(
					"SELECT COUNT(*) FROM {$table} WHERE {$column} LIKE %s",
					'%' . $wpdb->esc_like( $from ) . '%'
				)
			);

			if ( $count < 1 ) {
				continue;
			}

			echo "{$table}.{$column}: {$count} row(s) contain \"{$from}\"\n";
			$total += $count;

			if ( $apply ) {
				$wpdb->query(
					$wpdb->prepare(
						"UPDATE {$table} SET {$column} = REPLACE({$column}, %s, %s) WHERE {$column} LIKE %s",
						$from,
						$to,
						'%' . $wpdb->esc_like( $from ) . '%'
					)
				);
			}
		}
	}
}

// RevSlider slides table if present.
$rev_table = $wpdb->prefix . 'revslider_slides';
if ( $wpdb->get_var( $wpdb->prepare( 'SHOW TABLES LIKE %s', $rev_table ) ) === $rev_table ) {
	foreach ( $replacements as $from => $to ) {
		if ( $from === $to ) {
			continue;
		}

		$count = (int) $wpdb->get_var(
			$wpdb->prepare(
				"SELECT COUNT(*) FROM {$rev_table} WHERE params LIKE %s",
				'%' . $wpdb->esc_like( $from ) . '%'
			)
		);

		if ( $count < 1 ) {
			continue;
		}

		echo "{$rev_table}.params: {$count} row(s) contain \"{$from}\"\n";
		$total += $count;

		if ( $apply ) {
			$wpdb->query(
				$wpdb->prepare(
					"UPDATE {$rev_table} SET params = REPLACE(params, %s, %s) WHERE params LIKE %s",
					$from,
					$to,
					'%' . $wpdb->esc_like( $from ) . '%'
				)
			);
		}
	}
}

echo "\nTotal affected rows (may include duplicates across patterns): {$total}\n";

if ( ! $apply ) {
	echo "\nDry run only. Re-run with --apply to update the database.\n";
} else {
	echo "\nDone. Clear WP Fastest Cache after applying on production.\n";
}
