<?php
/**
 * Run on production immediately after every Git deploy (Plesk SSH).
 *
 *   cd /var/www/vhosts/riskwisdom.com.au/httpdocs
 *   php post-deploy-production.php --apply
 *
 * Fixes the common post-deploy 500 on /about/ etc. when localhost .htaccess
 * was pushed (RewriteBase /riskwisdom/). Also runs SEO + form scripts.
 */
$apply = in_array( '--apply', $argv ?? array(), true );
$root  = __DIR__;
$flag  = $apply ? '--apply' : '';

echo "=== Risk Wisdom: post-deploy production ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$scripts = array(
	'fix-production-500.php'    => 'Fix .htaccess redirect loop (500 on inner pages)',
	'fix-seo-urls.php'          => 'Replace localhost / old domain URLs in DB',
	'fix-seo-meta.php'          => 'Set page titles and meta descriptions',
	'fix-seo-content.php'       => 'On-page SEO copy tweaks',
	'deploy-production-forms.php' => 'Contact Form 7 production forms',
);

foreach ( $scripts as $script => $label ) {
	$path = $root . '/' . $script;
	if ( ! is_file( $path ) ) {
		echo "SKIP: {$script} not found\n\n";
		continue;
	}

	echo "========== {$script} — {$label} ==========\n";
	passthru( 'php ' . escapeshellarg( $path ) . ( $flag ? ' ' . $flag : '' ), $code );
	echo "\n";
	if ( 0 !== $code ) {
		echo "WARNING: {$script} exited with code {$code}\n\n";
	}
}

echo "========== Manual steps ==========\n";
echo "1. wp-admin → WP Fastest Cache → Delete Cache\n";
echo "2. Test: https://riskwisdom.com.au/about/\n";
echo "3. Test: https://riskwisdom.com.au/life-insurance/\n";
echo "4. If still 500: Plesk → Files → paste .htaccess.production into httpdocs/.htaccess\n";

if ( ! $apply ) {
	echo "\nDry run only. On server run: php post-deploy-production.php --apply\n";
}

echo "\nDone.\n";
