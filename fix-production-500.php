<?php
/**
 * One-shot fix for production 500 on inner pages (/about/, /life-insurance/, etc.).
 *
 * Run on server:
 *   cd /var/www/vhosts/riskwisdom.com.au/httpdocs
 *   php fix-production-500.php
 *   php fix-production-500.php --apply
 */
$apply = in_array( '--apply', $argv ?? array(), true );
$root  = __DIR__;
$flag  = $apply ? '--apply' : '';

echo "=== Risk Wisdom: fix production 500 errors ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

$steps = array(
	'cleanup-malware.php'       => 'Remove hacked .htaccess and backdoor PHP',
	'fix-production-pages.php'  => 'Fix root .htaccess RewriteBase + ErrorDocument',
);

foreach ( $steps as $script => $label ) {
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

echo "========== Next steps ==========\n";
echo "1. wp-admin → WP Fastest Cache → Delete Cache\n";
echo "2. Test: https://riskwisdom.com.au/about/\n";
echo "3. Test: https://riskwisdom.com.au/life-insurance/\n";
echo "4. If still 500, open Plesk → Files → httpdocs/.htaccess and paste .htaccess.production\n";
echo "5. Check log: tail -30 /var/www/vhosts/riskwisdom.com.au/logs/error_log\n";

if ( ! $apply ) {
	echo "\nDry run only. Re-run: php fix-production-500.php --apply\n";
}

echo "\nDone.\n";
