<?php
/**
 * Template for single blog post
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
        <article>
          <?php the_post_thumbnail('rt_healthinsurance_one_row_img'); ?>
          <!-- meta -->
          <ul class="meta">
            <li class="category">   <?php the_category(', ') ?>  </li>  
            <li>  <i class="fa fa-calendar"></i>  <?php echo get_the_date(get_option('date_format'))?> </li>
            <li> <i class="fa fa-user"></i>   <?php the_author_posts_link(); ?>  </li>  
          </ul>
          <!-- meta end -->
          <div class="wrapper100percent"> 
            <?php  the_content(); ?>
          </div>
          <?php wp_link_pages( array( 'before' => '<div class="pagination">' . esc_html__( 'Pages:', 'health-insurance' ), 'after' => '</div>' ) ); ?>
        </article>
        <!-- post end -->
        <!-- tags -->
        <?php if(has_tag()): ?>
        <div class="tags divider-space">
          <?php the_tags( ' ',' ' ); ?> 
        </div>
        <div class="postnavigation">
          <div class="postnavigation-previous">❮❮ <?php previous_post_link('%link'); ?></div>
          <div class="postnavigation-next"><?php next_post_link('%link'); ?> ❯❯</div>
        </div> 
        <?php endif; ?>
          <!-- comments -->
          <?php if ( comments_open() || '0' != get_comments_number() ){
          comments_template( '', true );
          }
        ?>
        <!-- comments end -->
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
      </div>
	  <div class="divider-space2">
      </div>
    </div>
  </div> 
</div> 
<?php posts_nav_link(); ?> 
<?php get_footer(); ?>