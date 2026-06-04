<?php
/**
 * author template
 *
 */
get_header(); ?>
<?php get_template_part( 'nav' ); ?>  

<div id="wrapperpages">
<header class="mainheadlinewrapperpage bubbleswrapper">
  <ul class="bubbles">
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
    <li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
    <li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
	<li></li>
  </ul>
  <div class="container titleinner">
    <div class="row">
      <div class="col-sm-8">
        <h1><?php printf( esc_html__( 'Post By: %s', 'health-insurance' ), get_the_author_meta('display_name')); ?>	</h1>       
      </div> 
	  <div class="col-sm-4">
		<div class="breadcrumb">
          <?php 
          if(function_exists('bcn_display')){ bcn_display();} ?>
        </div>
	  </div>
    </div>
  </div>
</header>
  <div class="wrapper100percent"> 
  <div class="container">
    <div class="divider-space4">
    </div>
      <div class="row">
        <div class="<?php echo rt_healthinsurance_archivesidebar1() ?> blogpages">
          <?php if(have_posts()): while(have_posts()): the_post();?>
          <article class="blogpost">
            <div <?php post_class(); ?>>
            <?php include(trailingslashit( get_template_directory() ) . 'post-image.php'); ?>
            <div class="wrapper100percent">
              <?php include(trailingslashit( get_template_directory() ) . 'blog_meta_and_title.php'); ?>     
                <div class="wrapper100percent">
                <p>
				<?php 
                $content = get_the_excerpt();
                $trimmed_content = wp_trim_words( $content, 35 );
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
          <?php endwhile; else : 
            get_template_part( 'content', 'none' );
          endif; 
		    include (trailingslashit( get_template_directory() ) . 'pagination.php');?>
        </div>
          <?php rt_healthinsurance_archivesidebar2() ?>
      </div>
	  <div class="divider-space4">
      </div>
    </div>
  </div>
</div>	
<?php get_footer(); ?>