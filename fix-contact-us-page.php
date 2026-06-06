<?php
/**
 * Replace frozen Contact Us page HTML with live CF7 shortcode (spam + reCAPTCHA v3).
 * Run: php fix-contact-us-page.php
 * Apply: php fix-contact-us-page.php --apply
 */

define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply   = in_array( '--apply', $argv ?? array(), true );
$page    = get_page_by_path( 'contact-us' );
$shortcode = '[contact-form-7 id="2515" title="contact form"]';

if ( ! $page ) {
	echo "Contact Us page not found.\n";
	exit( 1 );
}

$content = $page->post_content;

if ( str_contains( $content, '[contact-form-7' ) && str_contains( $content, '2515' ) ) {
	echo "Contact Us page ({$page->ID}): already uses CF7 shortcode\n";
	exit( 0 );
}

$updated = preg_replace(
	'/<div role="form" class="wpcf7"[^>]*>[\s\S]*?<\/form>\s*<\/div>/',
	$shortcode,
	$content,
	1,
	$count
);

if ( 0 === $count || null === $updated ) {
	echo "Contact Us page ({$page->ID}): static form block not found — check page content manually.\n";
	exit( 1 );
}

if ( $updated === $content ) {
	echo "Contact Us page ({$page->ID}): no changes needed\n";
	exit( 0 );
}

if ( ! $apply ) {
	echo "Contact Us page ({$page->ID}): would replace static form with CF7 shortcode\n";
	echo "Run: php fix-contact-us-page.php --apply\n";
	exit( 0 );
}

wp_update_post(
	array(
		'ID'           => $page->ID,
		'post_content' => $updated,
	)
);

if ( function_exists( 'wpfc_clear_all_cache' ) ) {
	wpfc_clear_all_cache( true );
}

echo "Contact Us page ({$page->ID}): static form replaced with live CF7 shortcode\n";
echo "Next: php fix-cf7-spam.php\n";
echo "Done.\n";
