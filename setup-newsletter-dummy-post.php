<?php
/**
 * Create one sample Newsletter post if the category has no posts yet.
 *
 * Run: php setup-newsletter-dummy-post.php
 * Apply: php setup-newsletter-dummy-post.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

echo "=== Risk Wisdom: dummy Newsletter post ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$category = get_term_by( 'slug', 'newsletter', 'category' );

if ( ! $category instanceof WP_Term ) {
	echo "ERROR: Newsletter category not found. Run: php setup-newsletter-page.php --apply\n";
	exit( 1 );
}

$existing = get_posts(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'posts_per_page' => 1,
		'category'       => (int) $category->term_id,
		'fields'         => 'ids',
	)
);

if ( ! empty( $existing ) ) {
	echo 'Newsletter category already has ' . count(
		get_posts(
			array(
				'post_type'      => 'post',
				'post_status'    => 'publish',
				'posts_per_page' => -1,
				'category'       => (int) $category->term_id,
				'fields'         => 'ids',
			)
		)
	) . " published post(s). Skipping dummy create.\n";
	echo 'View: ' . home_url( '/newsletter/' ) . "\n";
	exit( 0 );
}

$title   = 'Welcome to the Risk Wisdom Newsletter';
$content = <<<'HTML'
<p>Welcome to the Risk Wisdom newsletter — your source for practical insurance insights for individuals and businesses across Australia.</p>

<p>In each edition we share timely updates on life insurance, income protection, trauma cover, TPD, and business insurance — written in plain language by our independent advisors in Sydney.</p>

<h3>What you can expect</h3>
<ul>
<li>Clear explanations of insurance topics that matter to Australian families and business owners</li>
<li>Practical tips to help you review and protect your financial future</li>
<li>Updates on market changes and cover options worth discussing with your advisor</li>
</ul>

<p>This is a sample edition to show how newsletter messages will appear on the website. Future editions can be added in <strong>wp-admin → Posts → Add New</strong> under the <strong>Newsletter</strong> category.</p>

<p>If you would like personalised advice, contact our team on <strong>02 9071 4735</strong> or visit our <a href="/contact-us/">contact page</a>.</p>
HTML;

$slug = 'welcome-risk-wisdom-newsletter';

echo "Would create dummy post:\n";
echo "  title: {$title}\n";
echo "  slug:  {$slug}\n";
echo '  url:   ' . home_url( '/newsletter/' ) . "\n";

if ( ! $apply ) {
	echo "\nDry run only. Re-run with --apply to publish the dummy newsletter.\n";
	exit( 0 );
}

$post_id = wp_insert_post(
	array(
		'post_title'   => $title,
		'post_name'    => $slug,
		'post_content' => $content,
		'post_status'  => 'publish',
		'post_type'    => 'post',
		'post_category'=> array( (int) $category->term_id ),
		'post_excerpt' => 'Welcome to the Risk Wisdom newsletter — practical insurance insights for Australian families and businesses.',
	),
	true
);

if ( is_wp_error( $post_id ) ) {
	echo 'ERROR: ' . $post_id->get_error_message() . "\n";
	exit( 1 );
}

echo "\nCreated newsletter post ID {$post_id}\n";
echo 'Single post: ' . get_permalink( $post_id ) . "\n";
echo 'Archive:     ' . home_url( '/newsletter/' ) . "\n";
echo "\nDone. Clear WP Fastest Cache and refresh /newsletter/\n";
