<?php

/*Template Name: Blog archive posts - 3 columns no sidebar
*/
get_header(); ?>

<?php 
if (class_exists( 'RW_Meta_Box' )){
  $menusswitch = rwmb_meta('healthinsurance_menusswitch');
}
else {
  $menusswitch = NULL;
}
if($menusswitch) {
  get_template_part( 'nav', 'single' );
}
else {
  get_template_part( 'nav' );
}  
?> 

<div id="wrapperpages">
  <?php 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/title-function.php');
  ?> 
  <div class="wrapper100percent"> 
    <div class="container">
    <div class="divider-space4">
    </div>
      <div class="row">
        <div class="col-md-12"> 
		  <div class="row">
		  <div class="masonry1grid">
          <?php   
          $wp_query = null; 
          $wp_query = new WP_Query(); 
          $wp_query->query('post_type=post'.'&paged='.$paged); 
          while ($wp_query->have_posts()) : $wp_query->the_post(); 
          ?>
		  <div class="col-md-4 blogpages masonry-grid-item1"> 
          <article class="blogpost">
            <div <?php post_class(); ?>>
            <?php include(trailingslashit( get_template_directory() ) . 'post-image.php'); ?>
            <div class="wrapper100percent">
              <?php include(trailingslashit( get_template_directory() ) . 'blog_meta_and_title.php'); ?>     
                <div class="wrapper100percent">
                <p>
				<?php 
                $content = get_the_excerpt();
                $trimmed_content = wp_trim_words( $content, 35 );
                echo $trimmed_content;
                ?>
				</p>  
                <div class="text-left"> 
                  <?php include (trailingslashit( get_template_directory() ) . 'button2.php');?>
                </div>
                </div>
            </div>
            </div> 
          </article>
		  </div>
          <?php 
          endwhile; 
          wp_reset_postdata(); 
          ?>	
		  </div>
		  </div>
		</div>
      </div>
	  <div class="divider-space2">
      </div>
    </div>
    <div class="wrapper100percent">
      <div class="container">
        <div class="row">
          <div class="col-lg-12">
            <?php  include (trailingslashit( get_template_directory() ) . 'pagination.php');   ?>	
          </div> 
        </div>
      </div>
    </div>   
  </div> 
</div> 
<?php get_footer(); ?>