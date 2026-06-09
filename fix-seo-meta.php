<?php
/**
 * Set All in One SEO titles and meta descriptions for key pages.
 *
 * Run: php fix-seo-meta.php
 * Apply: php fix-seo-meta.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

if ( ! class_exists( 'AIOSEO\Plugin\Common\Models\Post' ) ) {
	echo "All in One SEO is not active.\n";
	exit( 1 );
}

use AIOSEO\Plugin\Common\Models\Post as AioseoPost;

/**
 * @return array<string, array{title: string, description: string}>
 */
function riskwisdom_seo_page_meta_map() {
	return array(
		'home' => array(
			'title'       => 'Insurance Advisor Sydney | Risk Wisdom Financial Partners',
			'description' => 'Independent insurance advisory in Sydney — life, income protection, trauma, TPD and business cover. Request a quote from Risk Wisdom.',
		),
		'life-insurance' => array(
			'title'       => 'Life Insurance Advisor Sydney | Risk Wisdom',
			'description' => 'Expert life insurance advice and quotes in Australia. Independent advisors helping you choose the right life cover.',
		),
		'income-insurance' => array(
			'title'       => 'Income Protection Insurance Australia | Risk Wisdom',
			'description' => 'Income protection and sickness cover advice from independent insurance advisors. Request a quote today.',
		),
		'trauma-insurance' => array(
			'title'       => 'Trauma Insurance & Critical Illness Cover | Risk Wisdom',
			'description' => 'Trauma and critical illness insurance advice for individuals and families across Australia.',
		),
		'tpd-insurance' => array(
			'title'       => 'TPD Insurance Advisor Sydney | Risk Wisdom',
			'description' => 'Total and permanent disability insurance — independent advice and quotes from Risk Wisdom Sydney.',
		),
		'business-insurance' => array(
			'title'       => 'Business & Key Person Insurance | Risk Wisdom',
			'description' => 'Key person and business insurance solutions for Australian companies. Speak with our advisors.',
		),
		'financial-planning-process' => array(
			'title'       => 'Financial Planning Process | Risk Wisdom',
			'description' => 'Learn how our financial risk planning process works — transparent, client-focused insurance advice.',
		),
		'contact-us' => array(
			'title'       => 'Contact Risk Wisdom | Insurance Advisors Sydney',
			'description' => 'Contact our Sydney insurance advisory team. Phone 02 9071 4735, email info@riskwisdom.com.au, or send an enquiry.',
		),
		'about' => array(
			'title'       => 'About Risk Wisdom | Independent Insurance Advisors',
			'description' => 'Risk Wisdom is an independent financial risk advisory firm specialising in life, income and business insurance in Australia.',
		),
		'faq' => array(
			'title'       => 'Insurance FAQ | Risk Wisdom Australia',
			'description' => 'Answers to common questions about life insurance, income protection, trauma, TPD and business cover in Australia.',
		),
		'newsletter' => array(
			'title'       => 'Insurance Newsletter | Risk Wisdom Australia',
			'description' => 'Read Risk Wisdom newsletter editions — insurance tips, market updates, and advice for Sydney and Australia.',
		),
	);
}

/**
 * @param string $slug Page slug or "home".
 * @return WP_Post|null
 */
function riskwisdom_seo_get_page( $slug ) {
	if ( 'home' === $slug ) {
		$page_on_front = (int) get_option( 'page_on_front' );
		if ( $page_on_front ) {
			return get_post( $page_on_front );
		}
		return get_post( 2318 );
	}

	return get_page_by_path( $slug );
}

echo "=== Risk Wisdom: SEO meta titles & descriptions ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$updated = 0;
$skipped = 0;

foreach ( riskwisdom_seo_page_meta_map() as $slug => $meta ) {
	$page = riskwisdom_seo_get_page( $slug );

	if ( ! $page ) {
		echo "SKIP: {$slug} — page not found\n";
		++$skipped;
		continue;
	}

	$existing = AioseoPost::getPost( $page->ID );
	$old_title = $existing->title ?? '';
	$old_desc  = $existing->description ?? '';

	echo "Page {$page->ID} ({$slug}):\n";
	echo "  title: {$meta['title']}\n";
	echo "  desc:  {$meta['description']}\n";

	if ( $old_title === $meta['title'] && $old_desc === $meta['description'] ) {
		echo "  -> already set\n\n";
		continue;
	}

	if ( $apply ) {
		$result = AioseoPost::savePost(
			$page->ID,
			array(
				'title'       => $meta['title'],
				'description' => $meta['description'],
				'og_title'       => $meta['title'],
				'og_description' => $meta['description'],
				'twitter_title'       => $meta['title'],
				'twitter_description' => $meta['description'],
				'robots_noindex'  => false,
				'robots_nofollow' => false,
			)
		);

		if ( is_string( $result ) && '' !== $result ) {
			echo "  -> ERROR: {$result}\n\n";
			continue;
		}

		echo "  -> saved\n\n";
		++$updated;
	} else {
		echo "  -> would update\n\n";
		++$updated;
	}
}

if ( $apply && function_exists( 'aioseo' ) ) {
	aioseo()->options->sitemap->general->enable = true;
	aioseo()->options->save();
	echo "XML sitemap enabled in AIOSEO.\n";
}

echo "Pages updated: {$updated}, skipped: {$skipped}\n";

if ( ! $apply ) {
	echo "\nDry run only. Re-run with --apply to save meta.\n";
} else {
	echo "\nDone. Clear cache and verify <title> in browser view-source.\n";
}
