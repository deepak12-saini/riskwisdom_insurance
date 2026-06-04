<?php
/**
 * The Template for displaying all single products.
 *
 * Override this template by copying it to yourtheme/woocommerce/single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' ); ?>
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
<div class="divider-space4">
</div>
<div id="wrapperpages">

  <div class="container">
    <div class="row">
	      <?php
      //sidebar metabox
      if (class_exists('RW_Meta_Box')){
         $sideb = rwmb_meta('healthinsurance_sideb'); 
      }
      else {
        $sideb = NULL; 
      } 
      ?>
      <div class="<?php if (isset($sideb)&& strlen($sideb)) echo esc_attr( $sideb ); else echo "col-md-12"; 
      //sidebar metabox end
      ?>"> 

	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>

		<?php while ( have_posts() ) : the_post(); ?>
		
			<?php wc_get_template_part( 'content', 'single-product' ); ?>

		<?php endwhile; // end of the loop. ?>

      </div>
       
	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
		<?php 
rt_healthinsurance_sideb($sideb);
	do_action( 'woocommerce_sidebar' );
        ?> 
  
    </div>
  </div>
</div>
<?php get_footer( 'shop' ); ?>
