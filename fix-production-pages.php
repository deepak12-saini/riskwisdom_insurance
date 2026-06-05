<?php
/**
 * Diagnose + fix production 500 on inner pages (homepage works, subpages fail).
 *
 * Run on server SSH:
 *   cd /var/www/vhosts/riskwisdom.com.au/httpdocs
 *   php fix-production-pages.php
 *   php fix-production-pages.php --apply
 */
define( 'WP_USE_THEMES', false );

$apply = in_array( '--apply', $argv ?? array(), true );
$root  = __DIR__;

echo "=== Risk Wisdom production page fix ===\n\n";

// 1. Malware .htaccess scan
$bad_htaccess = 0;
$iterator     = new RecursiveIteratorIterator(
	new RecursiveDirectoryIterator( $root, FilesystemIterator::SKIP_DOTS )
);

foreach ( $iterator as $file ) {
	if ( ! $file->isFile() || '.htaccess' !== $file->getFilename() ) {
		continue;
	}

	$path     = $file->getPathname();
	$relative = str_replace( $root . DIRECTORY_SEPARATOR, '', $path );
	$relative = str_replace( '\\', '/', $relative );
	$contents = @file_get_contents( $path );

	if ( ! $contents ) {
		continue;
	}

	$is_root = ( $relative === '.htaccess' );
	$is_core = str_starts_with( $relative, 'wp-admin/' ) || str_starts_with( $relative, 'wp-includes/' );
	$is_mal  = str_contains( $contents, 'Deny from all' ) && str_contains( $contents, 'FilesMatch' );

	if ( $is_core || ( ! $is_root && $is_mal ) ) {
		echo "BAD .htaccess: {$relative}\n";
		++$bad_htaccess;
		if ( $apply ) {
			unlink( $path );
			echo "  -> removed\n";
		}
	}
}

echo "\nMalicious/extra .htaccess files found: {$bad_htaccess}\n";

// 2. Check root .htaccess RewriteBase
$root_htaccess = $root . '/.htaccess';
if ( is_file( $root_htaccess ) ) {
	$ht = file_get_contents( $root_htaccess );
	echo "\nRoot .htaccess RewriteBase: ";
	if ( preg_match( '/RewriteBase\s+(\S+)/', $ht, $m ) ) {
		echo $m[1];
		if ( '/riskwisdom/' === $m[1] ) {
			echo "  *** WRONG for production (should be /)";
		}
	} else {
		echo '(not set)';
	}
	echo "\n";

	if ( str_contains( $ht, 'ErrorDocument' ) ) {
		echo "WARNING: Root .htaccess contains ErrorDocument rules (can cause double 500 errors).\n";
	}
} else {
	echo "\nERROR: Root .htaccess missing!\n";
}

// 3. WP bootstrap test for inner page
require $root . '/wp-load.php';

$test_slugs = array( 'financial-planning-process', 'contact-us' );
echo "\nWordPress page check:\n";
foreach ( $test_slugs as $slug ) {
	$page = get_page_by_path( $slug );
	if ( ! $page ) {
		echo "  {$slug}: NOT IN DATABASE\n";
		continue;
	}
	echo "  {$slug}: ID {$page->ID}, status {$page->post_status}\n";
}

// 4. Clear WP Fastest Cache if present
$cache_dirs = array(
	$root . '/wp-content/cache/all',
	$root . '/wp-content/cache/wpfc-mobile-cache',
);
$cleared = 0;
foreach ( $cache_dirs as $dir ) {
	if ( ! is_dir( $dir ) ) {
		continue;
	}
	$it = new RecursiveIteratorIterator(
		new RecursiveDirectoryIterator( $dir, FilesystemIterator::SKIP_DOTS ),
		RecursiveIteratorIterator::CHILD_FIRST
	);
	foreach ( $it as $item ) {
		if ( $item->isFile() && 'index.html' === $item->getFilename() ) {
			if ( $apply ) {
				unlink( $item->getPathname() );
			}
			++$cleared;
		}
	}
}
echo "\nCached index.html files" . ( $apply ? ' cleared' : ' found' ) . ": {$cleared}\n";

// 5. Apply production WordPress .htaccess (without WPFC block — re-enable cache in wp-admin after)
if ( $apply ) {
	$production = file_get_contents( $root . '/.htaccess.production' );
	if ( $production ) {
		// Preserve WP Fastest Cache block if it exists.
		$current = is_file( $root_htaccess ) ? file_get_contents( $root_htaccess ) : '';
		$wpfc    = '';
		if ( preg_match( '/#\s*BEGIN WpFastestCache.*?#\s*END WpFastestCache/s', $current, $m ) ) {
			$wpfc = "\n" . $m[0] . "\n";
		}
		file_put_contents( $root_htaccess, trim( $production ) . $wpfc );
		echo "\nApplied .htaccess.production" . ( $wpfc ? ' (kept WpFastestCache block)' : '' ) . ".\n";
	}
}

echo "\n--- Recommended steps ---\n";
echo "1. php cleanup-malware.php\n";
echo "2. php fix-production-pages.php --apply\n";
echo "3. In wp-admin: WP Fastest Cache -> Delete Cache\n";
echo "4. Test: https://riskwisdom.com.au/financial-planning-process/\n";
echo "5. If still 500, check Plesk error log: /var/www/vhosts/riskwisdom.com.au/logs/error_log\n";

if ( ! $apply ) {
	echo "\n(Dry run only. Re-run with --apply to fix .htaccess + clear page cache.)\n";
}

echo "\nDone.\n";
