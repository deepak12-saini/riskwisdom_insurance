<?php
/**
 *  query for team custom post type
 *
 */
 ?> 
<div class="wrapper100percent">
<div class="js-flickity" data-flickity-options='{ 
  "contain": true, 
  "imagesLoaded": true, 
  "autoPlay": 3000,
  "pageDots": false,
  "prevNextButtons": true,
  "wrapAround": false
}'>
  <?php
    $args = array( 'post_type' => 'rt-team', 'columns' => $columns, 'posts_per_page' => $limit, 'order' => $order );
    $loop = new WP_Query( $args );
    while ( $loop->have_posts() ) : $loop->the_post();
  ?>
  <div class="<?php 
    if ($columns == "1"){ 
	    echo "col-md-12 col-sm-3 col-xs-4"; 
    }
    elseif ($columns == "2"){ 
	    echo "col-md-6 col-sm-3 col-xs-4"; 
	  }  
    elseif ($columns == "3"){ 
	    echo "col-md-4 col-sm-3 col-xs-4"; 
	}
    elseif ($columns == "4"){ 
	  	echo "col-md-3 col-sm-3 col-xs-4"; 
	  }
    elseif ($columns == "5"){ 
	    echo "col-five-columns-team col-sm-3 col-xs-4"; 
    }
    elseif ($columns == "6"){ 
	    echo "col-md-2 col-sm-3 col-xs-4"; 
    }
    else { 
	    echo "col-md-4 col-sm-3 col-xs-4"; 
	  } ?> team">
    <figure class="view view-first">
        <?php if ($columns == "1"){ 
	        echo the_post_thumbnail('rt_healthinsurance_one_row_img'); 
		    }
        elseif ($columns == "2"){ 
		      echo the_post_thumbnail('rt_healthinsurance_two_rows_img'); 
		    }
        elseif ($columns == "3"){
		      echo the_post_thumbnail('rt_healthinsurance_three_rows_img'); 
		    }
        elseif ($columns == "4"){
		      echo the_post_thumbnail('rt_healthinsurance_four_rows_img'); 
		    }
        elseif ($columns == "5"){
		      echo the_post_thumbnail('rt_healthinsurance_five_rows_img'); 
		    }
        elseif ($columns == "6"){
		      echo the_post_thumbnail('rt_healthinsurance_six_rows_img'); 
		    }
        else {
		      echo the_post_thumbnail('rt_healthinsurance_three_rows_img'); 
		    } ?>
		<figcaption class="mask">
	      <div class="maskinner">
            <?php 
            if (class_exists('RW_Meta_Box')){
            $teamtext2 = rwmb_meta('healthinsurance_teamtext2'); 
            }
            else $teamtext2 = NULL;
            ?>
            <?php 
            if($teamtext2) 
              echo '<div class="icons">' . $teamtext2 . '</div>';
            else ''; 
            ?>
            <h2><?php the_title();?></h2>
			<?php 
            if (class_exists('RW_Meta_Box')){
            $teamtext1 = rwmb_meta('healthinsurance_teamtext1');
            }
            else $teamtext1 = NULL;
            ?>
            <?php 
            if($teamtext1) 
              echo '<p class="title">' . $teamtext1 . '</p>';
            else $teamtext1 = NULL;
            ?>
			<?php 
            if (class_exists('RW_Meta_Box')){
            $teamtext3 = rwmb_meta('healthinsurance_teamtext3');
            }
            else $teamtext3 = NULL;
            ?>
			<?php 
            if($teamtext3) 
              echo '<div class="link1"><a class="link1" href="' . get_permalink() . '">' . $teamtext3 . '</a></div>';
            else $teamtext3 = NULL;
			?>
          </div>
		</figcaption> 
	  </figure>
    </div> 
  <?php endwhile; wp_reset_postdata(); ?>
</div>
</div>