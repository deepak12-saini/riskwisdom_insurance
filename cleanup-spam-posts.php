<?php
/**
 * Remove hacker SEO spam posts from WordPress (crack/patch/license posts).
 *
 * Run: php cleanup-spam-posts.php
 * Apply: php cleanup-spam-posts.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

/**
 * @param string $title Post title.
 * @return bool
 */
function riskwisdom_is_spam_post_title( $title ) {
	$title = trim( (string) $title );

	if ( '' === $title ) {
		return true;
	}

	if ( preg_match( '/^0x[0-9a-f]{6,}$/i', $title ) ) {
		return true;
	}

	$spam_pattern = '/\b('
		. 'crack|cracked|keygen|activator|kmspico|patch|license\s*key|product\s*key|'
		. 'serial\s*key|pre-activated|free\[activated\]|portable\s*exe|'
		. 'no\s*virus|x86x64|x32x64|mediafire|mega|gdrive|filecr|reddit'
		. ')\b/i';

	return (bool) preg_match( $spam_pattern, $title );
}

$spam_ids = array();
$query    = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => array( 'publish', 'draft', 'pending', 'future', 'private' ),
		'posts_per_page' => -1,
		'orderby'        => 'date',
		'order'          => 'DESC',
		'fields'         => 'ids',
	)
);

foreach ( $query->posts as $post_id ) {
	$post = get_post( $post_id );
	if ( ! $post ) {
		continue;
	}

	$is_recent_spam = strtotime( $post->post_date ) >= strtotime( '2026-02-23 00:00:00' );
	$is_title_spam  = riskwisdom_is_spam_post_title( $post->post_title );

	if ( $is_recent_spam || $is_title_spam ) {
		$spam_ids[] = $post_id;
		echo sprintf(
			"SPAM #%d | %s | %s\n",
			$post_id,
			$post->post_date,
			$post->post_title
		);
	}
}

echo "\nSpam posts found: " . count( $spam_ids ) . "\n";

if ( ! $apply ) {
	echo "(Dry run. Re-run with --apply to permanently delete.)\n";
	exit( 0 );
}

$deleted = 0;
foreach ( $spam_ids as $post_id ) {
	if ( wp_delete_post( $post_id, true ) ) {
		++$deleted;
	}
}

echo "Deleted: {$deleted}\n";
echo "Done. Clear WP Fastest Cache after running on production.\n";
