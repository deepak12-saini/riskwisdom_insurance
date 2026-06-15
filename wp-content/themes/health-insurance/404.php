<?php
/**
 * 404 Not Found
 *
 * @package health-insurance
 */

get_header();

if ( class_exists( 'RW_Meta_Box' ) ) {
	$menusswitch = rwmb_meta( 'healthinsurance_menusswitch' );
} else {
	$menusswitch = null;
}

if ( $menusswitch ) {
	get_template_part( 'nav', 'single' );
} else {
	get_template_part( 'nav' );
}
?>

<div id="wrapperpages">
	<div class="rw-404">
		<div class="container">
			<div class="rw-404__card">
				<p class="rw-404__code">404</p>
				<h1 class="rw-404__title"><?php esc_html_e( 'Page not found', 'health-insurance' ); ?></h1>
				<p class="rw-404__text"><?php esc_html_e( 'The page you are looking for may have moved or no longer exists.', 'health-insurance' ); ?></p>
				<div class="rw-404__actions">
					<a class="rw-btn rw-btn--primary" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Back to home', 'health-insurance' ); ?></a>
					<a class="rw-btn rw-btn--ghost" href="<?php echo esc_url( home_url( '/contact-us/' ) ); ?>"><?php esc_html_e( 'Contact us', 'health-insurance' ); ?></a>
				</div>
				<ul class="rw-404__links">
					<li><a href="<?php echo esc_url( home_url( '/life-insurance/' ) ); ?>"><?php esc_html_e( 'Life Insurance', 'health-insurance' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/faq/' ) ); ?>"><?php esc_html_e( 'FAQ', 'health-insurance' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/blog/' ) ); ?>"><?php esc_html_e( 'Blog', 'health-insurance' ); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>

<?php get_footer(); ?>
