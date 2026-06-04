<?php
/**
 * Sidebar
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}?>

<div class="col-md-3">
  <div class="sidebar widgets-style1">
  <?php if ( is_active_sidebar( 'shop' ) ) : ?>
  <?php dynamic_sidebar( 'shop' ); ?>
  <?php endif; ?>
  </div>
</div>	
<div class="divider-space1">
</div>