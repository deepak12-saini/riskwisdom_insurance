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
					?>
          <article class="blogpost">
            <div <?php post_class(); ?>>
            <?php include trailingslashit( get_template_directory() ) . 'post-image.php'; ?>
            <div class="wrapper100percent">
              <?php include trailingslashit( get_template_directory() ) . 'blog_meta_and_title.php'; ?>
                <div class="wrapper100percent">
                <p>
				<?php
				$content         = get_the_excerpt();
				$trimmed_content = wp_trim_words( $content, 35 );
				echo esc_html( $trimmed_content );
				?>
				</p>
                <div class="text-left">
                  <?php include trailingslashit( get_template_directory() ) . 'button2.php'; ?>
                </div>
                </div>
            </div>
            </div>
          </article>
					<?php
				endwhile;
			else :
				?>
          <article class="blogpost">
            <p><?php esc_html_e( 'Newsletter editions will appear here soon.', 'health-insurance' ); ?></p>
          </article>
				<?php
			endif;

			wp_reset_postdata();
			?>
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
