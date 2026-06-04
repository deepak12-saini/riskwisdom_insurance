<?php
/*Template Name: Boxed Page with headline(for complex page builder's pages)
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
  <?php 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/title-function.php');
  ?> 
<div id="wrapperpages">
  <?php while ( have_posts() ) : the_post();?>
  <div class="wrapper100percent">
    <div class="container">
      <div class="row">
        <div class="col-md-12">				
          <?php  the_content(); ?>
          <?php endwhile; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php get_footer(); ?>