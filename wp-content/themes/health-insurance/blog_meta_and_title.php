<?php
/**
 * meta tags
 *
 */
 ?>
  	<h2 class="blog-title">
      <a href="<?php the_permalink(); ?>">
      <?php the_title(); ?>
      </a>
    </h2>
<ul class="meta">
  <li class="category">   <?php the_category(', ') ?>  </li>  
  <li>  <i class="fa fa-calendar"></i>  <?php echo get_the_date(get_option('date_format'))?> </li>
  <li> <i class="fa fa-user"></i>   <?php the_author_posts_link(); ?>  </li>  
</ul>

