  <?php 
  
  /*function for general background image from Customizer or individual meta field background images in single posts and pages
*/  
  if ( (class_exists( 'RW_Meta_Box' )) and (0 < count( ( $rt_healthinsurance_title_background_image_url2 = rwmb_meta( 'healthinsurance_singletitlebg', 'type=image' )) )) )
  { 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/singlepost-title.php');
  }  
  else
  { 
    include(trailingslashit( get_template_directory() ) . 'title-background-images/innerpages-title.php');
  }
  ?> 