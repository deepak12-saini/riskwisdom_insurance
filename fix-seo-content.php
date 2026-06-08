<?php
/**
 * Light on-page SEO copy updates (KingComposer page content).
 *
 * Run: php fix-seo-content.php
 * Apply: php fix-seo-content.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

echo "=== Risk Wisdom: on-page SEO content ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$updates = array(
	2318 => array(
		'label' => 'homepage',
		'from'  => 'Risk Wisdom is an independent insurance advisory firm comprising of resolute financial risk advisors',
		'to'    => 'Risk Wisdom is an independent insurance advisor in Sydney, comprising resolute financial risk advisors',
	),
);

$changed = 0;

foreach ( $updates as $post_id => $config ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		echo "SKIP {$config['label']}: post {$post_id} not found\n";
		continue;
	}

	if ( ! str_contains( $post->post_content, $config['from'] ) ) {
		if ( str_contains( $post->post_content, $config['to'] ) ) {
			echo "{$config['label']}: already updated\n";
			continue;
		}
		echo "SKIP {$config['label']}: source phrase not found\n";
		continue;
	}

	echo "{$config['label']}: would update welcome subheadline\n";

	if ( $apply ) {
		wp_update_post(
			array(
				'ID'           => $post_id,
				'post_content' => str_replace( $config['from'], $config['to'], $post->post_content ),
			)
		);
		echo "  -> saved\n";
	}

	++$changed;
}

echo "\nUpdates: {$changed}\n";
if ( ! $apply ) {
	echo "Dry run only. Re-run with --apply to save.\n";
}
