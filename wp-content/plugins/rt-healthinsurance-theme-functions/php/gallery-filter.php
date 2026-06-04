<?php
/**
 *  query for gallery Isotope filterable custom post type
 *
 */
 ?>	
<div class="isotopewrapper">  
 
<div id="filters" class="row button-group"> 
  <button class="gallery-button hvr-shutter-out-horizontal" data-filter="*"><i class="fa fa-list-ul"></i></button>
  <?php 
	  $terms = get_terms("rt-ga-cat"); 
	  $count = count($terms); 
	  if ( $count > 0 ){ 
	    foreach ( $terms as $term ) { 
	    $termname = strtolower($term->name);
      $termname = str_replace(' ','-', $termname);
	    echo "<button class=\"gallery-button hvr-shutter-out-horizontal\" data-filter='.".$termname."'>" . $term->name . "</button>\n";
	    } 
    }    
  ?>
</div>

<div id="isotopecontainer" class="row" >
 
<?php
$args = array( 'post_type' => 'rt-gaf', 'posts_per_page' => $limit, 'order' => $order, 'columns' => $columns );
$loop = new WP_Query( $args );
while ( $loop->have_posts() ) : $loop->the_post();

$post = NULL;
$terms = get_the_terms( $post, 'rt-ga-cat' );						
  if ( $terms && ! is_wp_error( $terms ) ) : 
    $items = array();
      foreach ( $terms as $term ) {
        $items[] = $term->name;
      }
      $taxonomy_items = join( " ", str_replace(' ', '-', $items));          
      $taxonomy_items = strtolower($taxonomy_items);
      else :	
	    $taxonomy_items = NULL;					
      endif; 
?>

<?php //isotope item in loop ?>
<div class="element-isotope 
<?php 
if ($columns == 2) { 
echo 'col-sm-6 col-xs-4 ';
}
elseif ($columns == 3) { 
echo 'col-sm-4 col-xs-4 ';
}
elseif ($columns == 4) { 
echo 'col-sm-3 col-xs-4 ';
}
else { 
echo 'col-sm-4 col-xs-4 ';
}
echo esc_attr( strtolower($taxonomy_items) );?>">
  
<div class="carouselwrapper view view-first">
<div class="carouselimage">
<?php 
if ($columns == 2) { 
echo the_post_thumbnail('rt_healthinsurance_two_rows_img');
}
elseif ($columns == 3) { 
echo the_post_thumbnail('rt_healthinsurance_three_rows_img');
}
elseif ($columns == 4) { 
echo the_post_thumbnail('rt_healthinsurance_four_rows_img');
}
else { 
echo the_post_thumbnail('rt_healthinsurance_three_rows_img');
}
?> 
</div>             
<div class="">
  <div class="maskhover">
    <ul>
      <li>
      <?php 
      if (class_exists('RW_Meta_Box')){
      $galleryimageicon1 = rwmb_meta('healthinsurance_galleryimageicon1');
      } 
      else $galleryimageicon1 = NULL;
      ?>
      <?php 
      if($galleryimageicon1) 
        echo '        <div class="maskinner">
                        <div class="maskinner2">
						<figcaption class="mask">' . $galleryimageicon1 . '</figcaption></div>  
                      </div> ';
        else ''; 
      ?>
      </li> 
    </ul>
  </div>
</div>
</div> 
</div>
<?php //isotope item in loop end ?>
     
<?php endwhile; wp_reset_postdata(); ?>
</div>
</div>