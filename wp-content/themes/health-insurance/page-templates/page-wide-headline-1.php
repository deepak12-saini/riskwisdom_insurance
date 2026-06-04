<?php

/*Template Name: Wide Page with headline(default)
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
  <?php the_post_thumbnail('post-large'); ?>
  <?php  the_content(); ?>
  <?php if ( comments_open() || get_comments_number() ) {
  comments_template();
  }
  endwhile; ?>
</div>
<?php get_footer(); ?>