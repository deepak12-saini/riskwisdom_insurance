<?php
/**
 * Template for single team post
 *
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
<?php if(have_posts()): while(have_posts()): the_post(); ?>
  <?php 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/title-function.php');
  ?> 
  <div class="wrapper100percent">
    <div class="container">
      <div class="row blogpages">
        <div class="divider-space4">
        </div>
        <?php //sidebar metabox 
        if (class_exists( 'RW_Meta_Box' )){
          $sideb = rwmb_meta('healthinsurance_sideb'); 
        }
        else{
          $sideb = NULL;  
        }  
         ?>
        <div class="<?php if (isset($sideb)&& strlen($sideb)) echo $sideb; else echo "col-md-9"; ?>"> 
        <?php //sidebar metabox ?>
        <!-- post -->
        <article class="row">
		  <div class="col-md-4"> 
		    <?php the_post_thumbnail('rt_healthinsurance_one_row_img'); ?>
          </div>
		  <div class="col-md-8"> 
            <?php  the_content(); ?>
            <?php 
            if (class_exists('RW_Meta_Box')){
            $teamtext2 = rwmb_meta('healthinsurance_teamtext2'); 
            }
            else $teamtext2 = NULL;
            ?>
            <?php 
            if($teamtext2) 
              echo '<div class="socialicons">' . $teamtext2 . '</div>';
            else ''; 
            ?>
		  </div>
        </article>
        <!-- post end -->
        <?php endwhile; else : 
          get_template_part( 'content', 'none' );
        endif; ?>		
        </div>
		  <?php 
        //sidebar metabox
        if (class_exists( 'RW_Meta_Box' )){
          $sideb = rwmb_meta('healthinsurance_sideb'); 
        }
        else{
          $sideb = NULL;  
        }  
        if($sideb == "col-md-12") 
          unregister_sidebar( 'sidebar-1' ); 
        else 
          get_sidebar(); 
        ?> 
		<div class="divider-space4">
        </div>
      </div>	
    </div>
  </div> 
</div> 
<?php posts_nav_link(); ?> 
<?php get_footer(); ?>