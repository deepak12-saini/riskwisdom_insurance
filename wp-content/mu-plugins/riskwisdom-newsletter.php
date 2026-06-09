<?php
/**
 * Risk Wisdom Newsletter — archive helpers and exclude from main blog listings.
 */

const RISKWISDOM_NEWSLETTER_CATEGORY_SLUG = 'newsletter';

/**
 * @return int Term taxonomy ID for the Newsletter category, or 0.
 */
function riskwisdom_newsletter_term_taxonomy_id() {
	static $tt_id = null;

	if ( null !== $tt_id ) {
		return $tt_id;
	}

	$term  = get_term_by( 'slug', RISKWISDOM_NEWSLETTER_CATEGORY_SLUG, 'category' );
	$tt_id = ( $term instanceof WP_Term ) ? (int) $term->term_taxonomy_id : 0;

	return $tt_id;
}

/**
 * @return int Category term ID for Newsletter, or 0.
 */
function riskwisdom_newsletter_term_id() {
	static $term_id = null;

	if ( null !== $term_id ) {
		return $term_id;
	}

	$term    = get_term_by( 'slug', RISKWISDOM_NEWSLETTER_CATEGORY_SLUG, 'category' );
	$term_id = ( $term instanceof WP_Term ) ? (int) $term->term_id : 0;

	return $term_id;
}

/**
 * Whether this query should only show Newsletter posts (do not exclude).
 *
 * @param WP_Query $query Query object.
 * @return bool
 */
function riskwisdom_newsletter_query_is_newsletter_only( WP_Query $query ) {
	if ( $query->get( 'riskwisdom_include_newsletter' ) ) {
		return true;
	}

	if ( RISKWISDOM_NEWSLETTER_CATEGORY_SLUG === $query->get( 'category_name' ) ) {
		return true;
	}

	$newsletter_id = riskwisdom_newsletter_term_id();
	if ( ! $newsletter_id ) {
		return false;
	}

	$cat = $query->get( 'cat' );
	if ( $cat && (int) $cat === $newsletter_id ) {
		return true;
	}

	$category_in = $query->get( 'category__in' );
	if ( is_array( $category_in ) && 1 === count( $category_in ) && (int) $category_in[0] === $newsletter_id ) {
		return true;
	}

	return false;
}

/**
 * Exclude Newsletter category posts from blog/home listings.
 *
 * @param string[] $clauses Query clauses.
 * @param WP_Query $query   Query object.
 * @return string[]
 */
function riskwisdom_newsletter_exclude_from_blog_clauses( $clauses, $query ) {
	if ( is_admin() && ! wp_doing_ajax() ) {
		return $clauses;
	}

	if ( ! $query instanceof WP_Query ) {
		return $clauses;
	}

	if ( riskwisdom_newsletter_query_is_newsletter_only( $query ) ) {
		return $clauses;
	}

	if ( $query->is_singular() ) {
		return $clauses;
	}

	$post_type = $query->get( 'post_type' );
	if ( $post_type && 'post' !== $post_type && ( ! is_array( $post_type ) || ! in_array( 'post', $post_type, true ) ) ) {
		return $clauses;
	}

	$tt_id = riskwisdom_newsletter_term_taxonomy_id();
	if ( ! $tt_id ) {
		return $clauses;
	}

	global $wpdb;

	$clauses['where'] .= $wpdb->prepare(
		" AND {$wpdb->posts}.ID NOT IN (
			SELECT tr.object_id FROM {$wpdb->term_relationships} tr
			WHERE tr.term_taxonomy_id = %d
		)",
		$tt_id
	);

	return $clauses;
}
add_filter( 'posts_clauses', 'riskwisdom_newsletter_exclude_from_blog_clauses', 10, 2 );

/**
 * Render one newsletter card for the archive page template.
 */
function riskwisdom_newsletter_render_card() {
	$excerpt = get_the_excerpt();
	if ( ! $excerpt ) {
		$excerpt = wp_trim_words( wp_strip_all_tags( get_the_content() ), 32 );
	}

	$has_thumb = has_post_thumbnail();
	?>
	<article <?php post_class( 'rw-newsletter-card' ); ?>>
		<?php if ( $has_thumb ) : ?>
			<a class="rw-newsletter-card__media" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<?php the_post_thumbnail( 'medium_large' ); ?>
			</a>
		<?php else : ?>
			<a class="rw-newsletter-card__media rw-newsletter-card__media--placeholder" href="<?php the_permalink(); ?>" tabindex="-1" aria-hidden="true">
				<span class="rw-newsletter-card__badge"><?php esc_html_e( 'Edition', 'health-insurance' ); ?></span>
			</a>
		<?php endif; ?>

		<div class="rw-newsletter-card__body">
			<div class="rw-newsletter-card__meta">
				<span class="rw-newsletter-card__pill"><?php esc_html_e( 'Newsletter', 'health-insurance' ); ?></span>
				<time datetime="<?php echo esc_attr( get_the_date( DATE_W3C ) ); ?>"><?php echo esc_html( get_the_date() ); ?></time>
			</div>

			<h2 class="rw-newsletter-card__title">
				<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
			</h2>

			<p class="rw-newsletter-card__excerpt"><?php echo esc_html( wp_trim_words( $excerpt, 28 ) ); ?></p>

			<a class="rw-newsletter-card__link" href="<?php the_permalink(); ?>">
				<?php esc_html_e( 'Read edition', 'health-insurance' ); ?>
				<span aria-hidden="true">→</span>
			</a>
		</div>
	</article>
	<?php
}
