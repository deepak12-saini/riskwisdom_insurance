<?php

/*Template Name: Page Right Sidebar
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
<?php while ( have_posts() ) : the_post();?>
  <?php 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/title-function.php');
  ?> 
  <div class="wrapper100percent">
    <div class="container">
      <div class="row">
	  <div class="divider-space4">
	  </div>
        <div class="col-md-9">	
          <?php the_post_thumbnail('post-large'); ?>
          <div class="wrapper100percent">
            <?php  the_content(); ?>
          </div> 
          <?php
          if ( comments_open() || get_comments_number() ) {
          comments_template();
          } endwhile; ?>
        </div> 
        <!-- col-md-9 end--> 
          <br> 
          <?php get_sidebar(); ?>
      <div class="divider-space4">
	  </div>
	  </div>
    </div> 
  </div> 
</div> 
<?php get_footer(); ?>