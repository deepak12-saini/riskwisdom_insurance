<?php

/*Template Name: Newsletter archive - 1 column and sidebar
*/
get_header(); ?>

<?php
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
  <?php
	include trailingslashit( get_template_directory() ) . 'title-background-images/title-function.php';
  ?>
  <div class="wrapper100percent">
  <div class="divider-space4">
  </div>
    <div class="container">
      <div class="row">
        <div class="col-md-8 blogpages">
          <div class="rw-newsletter-hero">
            <h2 class="rw-newsletter-hero__title"><?php esc_html_e( 'Risk Wisdom Newsletter', 'health-insurance' ); ?></h2>
            <p class="rw-newsletter-hero__text"><?php esc_html_e( 'Insurance insights, market updates, and practical advice for Sydney and Australia.', 'health-insurance' ); ?></p>
          </div>
          <div class="rw-newsletter-grid">
          <?php
			global $wp_query;

			if ( get_query_var( 'paged' ) ) {
				$paged = (int) get_query_var( 'paged' );
			} elseif ( get_query_var( 'page' ) ) {
				$paged = (int) get_query_var( 'page' );
			} else {
				$paged = 1;
			}

			$newsletter_query = new WP_Query(
				array(
					'post_type'      => 'post',
					'category_name'  => 'newsletter',
					'paged'          => $paged,
					'posts_per_page' => (int) get_option( 'posts_per_page' ),
				)
			);

			$wp_query = $newsletter_query;

			if ( $newsletter_query->have_posts() ) :
				while ( $newsletter_query->have_posts() ) :
					$newsletter_query->the_post();
					if ( function_exists( 'riskwisdom_newsletter_render_card' ) ) {
						riskwisdom_newsletter_render_card();
					}
				endwhile;
			else :
				?>
          <p><?php esc_html_e( 'Newsletter editions will appear here soon.', 'health-insurance' ); ?></p>
				<?php
			endif;

			wp_reset_postdata();
			?>
          </div>
        </div>
        <!--sidebar-->
        <div class="col-md-4">
          <div class="sidebar widgets-style1">
          <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
          <?php dynamic_sidebar( 'sidebar-1' ); ?>
          <?php endif; ?>
          </div>
        </div>
        <!--sidebar end-->
      </div>
    </div>
	<div class="divider-space4">
    </div>
    <div class="wrapper100percent">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <?php include trailingslashit( get_template_directory() ) . 'pagination.php'; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>
