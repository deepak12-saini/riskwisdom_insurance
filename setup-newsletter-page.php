<?php
/**
 * Create Newsletter category, archive page, and header menu item.
 *
 * Run: php setup-newsletter-page.php
 * Apply: php setup-newsletter-page.php --apply
 */
define( 'WP_USE_THEMES', false );
require __DIR__ . '/wp-load.php';

$apply = in_array( '--apply', $argv ?? array(), true );

echo "=== Risk Wisdom: setup Newsletter page & menu ===\n";
echo 'Mode: ' . ( $apply ? 'APPLY' : 'dry run' ) . "\n\n";

const RISKWISDOM_NEWSLETTER_MENU_SLUG     = 'multipage-menu-menu1';
const RISKWISDOM_NEWSLETTER_PAGE_SLUG     = 'newsletter';
const RISKWISDOM_NEWSLETTER_CATEGORY_SLUG = 'newsletter';
const RISKWISDOM_NEWSLETTER_TEMPLATE      = 'page-templates/blog-archive-newsletter.php';

/**
 * @return WP_Term|WP_Error|null
 */
function riskwisdom_newsletter_ensure_category( $apply ) {
	$term = get_term_by( 'slug', RISKWISDOM_NEWSLETTER_CATEGORY_SLUG, 'category' );

	if ( $term instanceof WP_Term ) {
		echo "Category: already exists (ID {$term->term_id}, slug " . RISKWISDOM_NEWSLETTER_CATEGORY_SLUG . ")\n";
		return $term;
	}

	echo "Category: would create Newsletter (slug " . RISKWISDOM_NEWSLETTER_CATEGORY_SLUG . ")\n";

	if ( ! $apply ) {
		return null;
	}

	$result = wp_insert_term(
		'Newsletter',
		'category',
		array(
			'slug' => RISKWISDOM_NEWSLETTER_CATEGORY_SLUG,
		)
	);

	if ( is_wp_error( $result ) ) {
		echo "Category: ERROR — " . $result->get_error_message() . "\n";
		return $result;
	}

	$term = get_term( (int) $result['term_id'], 'category' );
	echo "Category: created (ID {$term->term_id})\n";

	return $term;
}

/**
 * @return WP_Post|null
 */
function riskwisdom_newsletter_ensure_page( $apply ) {
	$page = get_page_by_path( RISKWISDOM_NEWSLETTER_PAGE_SLUG );

	if ( $page instanceof WP_Post ) {
		$template = get_page_template_slug( $page->ID );
		echo "Page: already exists (ID {$page->ID}, /" . RISKWISDOM_NEWSLETTER_PAGE_SLUG . "/)\n";

		if ( RISKWISDOM_NEWSLETTER_TEMPLATE !== $template ) {
			echo "Page: template is '{$template}', expected '" . RISKWISDOM_NEWSLETTER_TEMPLATE . "'\n";
			if ( $apply ) {
				update_post_meta( $page->ID, '_wp_page_template', RISKWISDOM_NEWSLETTER_TEMPLATE );
				echo "Page: template updated\n";
			} else {
				echo "Page: would update template\n";
			}
		}

		return $page;
	}

	echo "Page: would create Newsletter page (/" . RISKWISDOM_NEWSLETTER_PAGE_SLUG . "/)\n";

	if ( ! $apply ) {
		return null;
	}

	$page_id = wp_insert_post(
		array(
			'post_title'   => 'Newsletter',
			'post_name'    => RISKWISDOM_NEWSLETTER_PAGE_SLUG,
			'post_status'  => 'publish',
			'post_type'    => 'page',
			'post_content' => '',
		),
		true
	);

	if ( is_wp_error( $page_id ) ) {
		echo "Page: ERROR — " . $page_id->get_error_message() . "\n";
		return null;
	}

	update_post_meta( $page_id, '_wp_page_template', RISKWISDOM_NEWSLETTER_TEMPLATE );

	$page = get_post( $page_id );
	echo "Page: created (ID {$page_id}, " . get_permalink( $page_id ) . ")\n";

	return $page;
}

/**
 * @return WP_Term|null
 */
function riskwisdom_newsletter_get_menu() {
	$menu = wp_get_nav_menu_object( RISKWISDOM_NEWSLETTER_MENU_SLUG );

	if ( $menu instanceof WP_Term ) {
		return $menu;
	}

	$menus = wp_get_nav_menus();
	foreach ( $menus as $candidate ) {
		if ( stripos( $candidate->name, 'multipage' ) !== false ) {
			return $candidate;
		}
	}

	return null;
}

/**
 * @param int $menu_id
 * @param int $page_id
 * @return bool
 */
function riskwisdom_newsletter_menu_has_page( $menu_id, $page_id ) {
	$items = wp_get_nav_menu_items( $menu_id );
	if ( ! is_array( $items ) ) {
		return false;
	}

	foreach ( $items as $item ) {
		if ( 'post_type' === $item->type && (int) $item->object_id === (int) $page_id ) {
			return true;
		}
		if ( stripos( $item->title, 'newsletter' ) !== false ) {
			return true;
		}
	}

	return false;
}

/**
 * @param int $menu_id
 * @param int $page_id
 * @param bool $apply
 */
function riskwisdom_newsletter_ensure_menu_item( $menu_id, $page_id, $apply ) {
	if ( riskwisdom_newsletter_menu_has_page( $menu_id, $page_id ) ) {
		echo "Menu: Newsletter item already in menu (ID {$menu_id})\n";
		return;
	}

	$items = wp_get_nav_menu_items( $menu_id, array( 'orderby' => 'menu_order' ) );
	$insert_order = 0;

	if ( is_array( $items ) ) {
		foreach ( $items as $item ) {
			$is_blog = stripos( $item->title, 'blog' ) !== false || str_contains( (string) $item->url, '/blog' );
			if ( $is_blog ) {
				$insert_order = (int) $item->menu_order + 1;
				break;
			}
		}
	}

	if ( $insert_order < 1 ) {
		$insert_order = is_array( $items ) ? count( $items ) + 1 : 1;
	}

	echo "Menu: would add Newsletter after Blog (menu_order {$insert_order})\n";

	if ( ! $apply ) {
		return;
	}

	if ( is_array( $items ) && $insert_order > 0 ) {
		foreach ( $items as $item ) {
			if ( (int) $item->menu_order >= $insert_order ) {
				wp_update_post(
					array(
						'ID'         => (int) $item->ID,
						'menu_order' => (int) $item->menu_order + 1,
					)
				);
			}
		}
	}

	$item_id = wp_update_nav_menu_item(
		$menu_id,
		0,
		array(
			'menu-item-title'     => 'Newsletter',
			'menu-item-object'    => 'page',
			'menu-item-object-id' => $page_id,
			'menu-item-type'      => 'post_type',
			'menu-item-status'    => 'publish',
			'menu-item-position'  => $insert_order,
		)
	);

	if ( is_wp_error( $item_id ) ) {
		echo "Menu: ERROR — " . $item_id->get_error_message() . "\n";
		return;
	}

	wp_update_post(
		array(
			'ID'         => (int) $item_id,
			'menu_order' => $insert_order,
		)
	);

	echo "Menu: added Newsletter (item ID {$item_id})\n";
}

riskwisdom_newsletter_ensure_category( $apply );
$page = riskwisdom_newsletter_ensure_page( $apply );

if ( $page instanceof WP_Post ) {
	$menu = riskwisdom_newsletter_get_menu();

	if ( ! $menu instanceof WP_Term ) {
		echo "Menu: WARNING — '" . RISKWISDOM_NEWSLETTER_MENU_SLUG . "' not found. Add Newsletter manually in Appearance → Menus.\n";
	} else {
		echo "Menu: using '{$menu->name}' (ID {$menu->term_id})\n";
		riskwisdom_newsletter_ensure_menu_item( (int) $menu->term_id, (int) $page->ID, $apply );
	}
} elseif ( ! $apply ) {
	$menu = riskwisdom_newsletter_get_menu();
	if ( $menu instanceof WP_Term ) {
		echo "Menu: would add Newsletter to '{$menu->name}' (ID {$menu->term_id})\n";
	}
}

echo "\n--- Next steps ---\n";
echo "1. wp-admin → Posts → Add New → assign category Newsletter → Publish\n";
echo "2. php fix-seo-meta.php --apply\n";
echo "3. WP Fastest Cache → Delete Cache\n";
echo "4. Test: " . home_url( '/' . RISKWISDOM_NEWSLETTER_PAGE_SLUG . '/' ) . "\n";

if ( ! $apply ) {
	echo "\nDry run only. Re-run with --apply to create category, page, and menu item.\n";
}

echo "\nDone.\n";
