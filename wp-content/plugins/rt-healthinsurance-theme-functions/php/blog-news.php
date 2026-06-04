<?php
/**
 *  query for blog news custom post type
 *
 */
 ?> 
<div class="row">
  <?php
    $args = array( 'post_type' => 'post', 'columns' => $columns, 'posts_per_page' => $limit, 'order' => $order );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
  ?>
  <div class=" <?php 
    if ($columns == "2"){ 
	    echo "col-sm-6"; 
	  }  
    elseif ($columns == "3"){ 
	    echo "col-sm-4"; 
	  }
    elseif ($columns == "4"){ 
	  	echo "col-sm-3"; 
	  }
    else { 
	    echo "col-sm-4"; 
	  } ?> blogpages">
          <article class="blogpost">
            <div <?php post_class(); ?>>
            <?php include(trailingslashit( get_template_directory() ) . 'post-image.php'); ?>
            <div class="wrapper100percent">
              <?php include(trailingslashit( get_template_directory() ) . 'blog_meta_and_title.php'); ?>     
                <div class="wrapper100percent">
                <p>
				<?php 
                $content = get_the_excerpt();
                $trimmed_content = wp_trim_words( $content, 15 );
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
  <?php endwhile; wp_reset_postdata(); ?>
</div>