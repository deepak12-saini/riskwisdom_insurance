<?php
/**
 *  query for testimonials carousel custom post type
 *
 */
 ?>
<div class="wrapper100percent">
  <div class="testimonials">
  <div class="js-flickity" data-flickity-options='{ 
    "contain": true, 
    "imagesLoaded": true, 
    "autoPlay": 3000,
    "pageDots": false,
    "prevNextButtons": true,
    "wrapAround": false
  }'>
  <?php
    $args = array( 'post_type' => 'rt-testi', 'posts_per_page' => $limit, 'order' => $order );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
  ?>
    <div class="testimonialsinner">
      <div class="testimonial">
        <?php the_post_thumbnail('thumbnail'); ?>
        <i class="fa fa-quote-left"></i> 
        <h4><?php the_content(); ?> </h4>   
        <h6><?php the_title(); ?></h6> 
      </div>
    </div>  
  <?php endwhile; wp_reset_postdata(); ?>
  </div>
  </div>
</div>