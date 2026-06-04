<?php
/*
Plugin Name: Rt Health Insurance Theme Functions
Plugin URI: http://themeforest.net/user/rayoflightt
Description: Shortcodes and custom post types for Health Insurance - WordPress Theme
Version: 1.0
Author: rayoflightthemes.com
Author http://themeforest.net/user/rayoflightt
License: http://themeforest.net/licenses
*/
/*** this plugin should be used together with meta box plugin https://wordpress.org/plugins/meta-box/
always be sure meta box plugin is activated when this plugin is activated ****/


/***********************************
something from theme
******************************/
/************************************************************************
* enable shortcodes in widgets
*************************************************************************/
add_filter('widget_text', 'do_shortcode');

/**********************************************************
* support for shortcodes in excerpt 
***********************************************************/
add_filter('the_excerpt', 'do_shortcode');


/********************************************************
* add king composer plugin custom shortcodes
*********************************************************/
if (class_exists('KingComposer')){
include('kingcomposer-custom-shortcodes.php');
}
else '';

/********************************************************
* add shortcode's meta boxes
*********************************************************/
if (class_exists('RW_Meta_Box')){
include('registered-meta-boxes-plugin.php');
}
else '';

/********************************************************
* add scripts
*********************************************************/
function rt_healthinsurance_plugin_scripts() {
/** enqueue plugin scripts **/
wp_enqueue_script( 'rt_healthinsurance_plugin_scripts', plugins_url(). '/rt-healthinsurance-theme-functions/js/scripts.js', array('jquery', 'masonry'), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'rt_healthinsurance_plugin_scripts' );



/********************************************************
* CUSTOM POST TYPES
*********************************************************/

/* Team carousel custom post type */
add_action('init', 'rt_healthinsurancetheme_team_cpt'); 

function rt_healthinsurancetheme_team_cpt() {  
  $labels = array(  
    'name' => esc_html__('Team', 'health-insurance'),  
    'singular_name' => esc_html__('Team', 'health-insurance'),  
    'add_new' => esc_html__('Add New item', 'health-insurance'),  
    'add_new_item' => esc_html__('Add New item', 'health-insurance'),  
    'edit_item' => esc_html__('Edit item', 'health-insurance'),  
    'new_item' => esc_html__('New item', 'health-insurance'),  
    'view_item' => esc_html__('View item', 'health-insurance'),  
    'search_items' => esc_html__('Search items', 'health-insurance'),  
    'not_found' =>  esc_html__('Not found', 'health-insurance'),  
    'not_found_in_trash' => esc_html__('Not found in Trash', 'health-insurance'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' => $labels,
    'hierarchical' => false,
    'supports' => array( 'editor', 'thumbnail', 'title' ),
    'public' => true,
    'show_ui' => true,
    'show_in_menu' => true,
    'show_in_nav_menus' => false,
    'publicly_queryable' => true,
    'exclude_from_search' => false,
    'has_archive' => true,
    'query_var' => true,
    'can_export' => true,
    'rewrite' => array('slug' => 'team','with_front' => false), 
	'menu_position' => 4, 
    'capability_type' => 'post'
  );  
  register_post_type('rt-team',$args);  
} 
/* Team custom post type end */


/* Testimonials custom post type */
add_action('init', 'rt_healthinsurancetheme_testimonials_carousel'); 

function rt_healthinsurancetheme_testimonials_carousel()  {  
  $labels = array(  
    'name' => esc_html__('Testimonials', 'health-insurance'),  
    'singular_name' => esc_html__('Testimonials', 'health-insurance'),  
    'add_new' => esc_html__('Add testimonial', 'health-insurance'),  
    'add_new_item' => esc_html__('Add new testimonial', 'health-insurance'),  
    'edit_item' => esc_html__('Edit testimonial', 'health-insurance'),  
    'new_item' => esc_html__('New testimonial', 'health-insurance'),  
    'view_item' => esc_html__('View testimonial', 'health-insurance'),  
    'search_items' => esc_html__('Search testimonials', 'health-insurance'),  
    'not_found' =>  esc_html__('No testimonials found', 'health-insurance'),  
    'not_found_in_trash' => esc_html__('No testimonials found in Trash', 'health-insurance'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => false,  
    'publicly_queryable' => false,  
    'show_ui' => true,  
    'query_var' => true,
    'rewrite' => true,  
    'capability_type' => 'post',
    'show_in_nav_menus' => true,  	 
    'hierarchical' => false, 
    'exclude_from_search' => true,	 
    'menu_position' => 9, 
    'supports' => array( 'title', 'thumbnail', 'editor')  
  );  
  register_post_type('rt-testi',$args);  
} 
/* Testimonials carousel custom post type end */


/* Gallery filter custom post type */
add_action('init', 'rt_healthinsurancetheme_galleryfilter_cpt'); 

function rt_healthinsurancetheme_galleryfilter_cpt() {  
{
  $labels = array(  
    'name' => esc_html__('Gallery filter', 'health-insurance'),  
    'singular_name' => esc_html__('gallery filter', 'health-insurance'),  
    'add_new' => esc_html__('Add New', 'health-insurance'),  
    'add_new_item' => esc_html__('Add New', 'health-insurance'),  
    'edit_item' => esc_html__('Edit item', 'health-insurance'),  
    'new_item' => esc_html__('New item', 'health-insurance'),  
    'view_item' => esc_html__('View item', 'health-insurance'),  
    'search_items' => esc_html__('Search item', 'health-insurance'),  
    'not_found' =>  esc_html__('No item found', 'health-insurance'),  
    'not_found_in_trash' => esc_html__('No item found in Trash', 'health-insurance'),  
    'parent_item_colon' => '' 
  );  
  
  $args = array(  
    'labels' => $labels,  
    'public' => true,  
    'publicly_queryable' => true,  
    'show_ui' => true,  
    'query_var' => true,
    'rewrite' => array('slug' => 'gallery','with_front' => false), 
    'capability_type' => 'post',
    'show_in_nav_menus' => true,  	 
    'hierarchical' => false, 
    'exclude_from_search' => false,	 
    'menu_position' => 10, 
    'supports' => array( 'title', 'editor', 'thumbnail', 'excerpt')  
  );  
  register_post_type('rt-gaf',$args);  
} 

register_taxonomy( 'rt-ga-cat', 
	array( 	'rt-gaf' ), 
	array( 	'hierarchical' => true,
		'labels' => array('name'=>"Category",'add_new_item'=>"Add New Category"), 
		'singular_label' => __( "Cagetory", 'health-insurance' ), 
		'rewrite' => array( 'slug' => 'category',  
		'with_front' => false)
	) 
);

}
/* gallery filter custom post type end */



register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );
register_activation_hook( __FILE__, 'rt_healthinsurancetheme_functions_flush_rewrites' );
function rt_healthinsurancetheme_functions_flush_rewrites() {
  register_post_type('rt-team',$args);
  register_post_type('rt-testi',$args);
  register_post_type('rt-gaf',$args);
  register_taxonomy( 'rt-ga-cat', 
	array( 	'rt-gaf' ), 
	array( 	'hierarchical' => true,
		'labels' => array('name'=>"Category",'add_new_item'=>"Add New Category"), 
		'singular_label' => __( "Cagetory", 'health-insurance' ), 
		'rewrite' => array( 'slug' => 'category',  
		'with_front' => false)
	) 
);
flush_rewrite_rules();
}

/**********************************************************
 * SHORTCODES  
 *
 ***********************************************************/ 

/******************
 * Team carousel query [rt_team columns="3" limit="-1" order="ASC"]  
 *
 ******************/ 
function rt_healthinsurancetheme_team( $atts, $content = null ) {	
	$atts = extract(shortcode_atts(array(
	'limit' => -1, 
    'columns' => 3,
	'order' => 'ASC',
  ),$atts));
   
	ob_start();	
	include('php/team.php');
	$content = ob_get_clean();
    return $content;
}
add_shortcode('rt_team','rt_healthinsurancetheme_team');



/******************
 * Blog news query [rt_blog_news columns="3" limit="-1" order="DESC"]  
 *
 ******************/ 
function rt_healthinsurancetheme_blognews( $atts, $content = null ) {	
	$atts = extract(shortcode_atts(array(
	'limit' => -1, 
  'columns' => 3,
	'order' => 'DESC',
  ),$atts));
   
	ob_start();	
	include('php/blog-news.php');
	$content = ob_get_clean();
    return $content;
}
add_shortcode('rt_blog_news','rt_healthinsurancetheme_blognews');


/******************
 * Testimonials query [rt_testimonials_carousel limit="-1" order="ASC"]  
 *
 ******************/ 
function rt_healthinsurancetheme_testimonials( $atts, $content = null ) {	
	$atts = extract(shortcode_atts(array(
	'limit' => -1, 
	'order' => 'ASC'
   ),$atts));
   
	ob_start();	
	include('php/testimonials-carousel.php');
	$content = ob_get_clean();
    return $content;
}
add_shortcode('rt_testimonials_carousel','rt_healthinsurancetheme_testimonials');


/******************
 * Gallery filter query [rt_gallery_filter  limit="-1" order="ASC" columns="3"]  
 *
 ******************/ 
function rt_healthinsurancetheme_galleryfilter( $atts, $content = null ) {	

	$atts = extract(shortcode_atts(array(
	'limit' => -1,
	'order' => 'ASC',
 	'columns' => '3' 
   ),$atts));
   
	ob_start();	
	include('php/gallery-filter.php');
	$content = ob_get_clean();
    return $content;
}
add_shortcode('rt_gallery_filter','rt_healthinsurancetheme_galleryfilter');


/******************
 * SHORTCODES WITHOUT CUSTOM POST TYPE
 *
 ******************/

/******************
 * Main headline shortcode  [mainheadline title="" subtitle="" align=""]
 *
 ******************/
function rt_healthinsurancetheme_title( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title' => '',
	'subtitle' => '',
	'align' => ''
	),$atts));

	return "
  <div class=\"mainheadlinewrapper\">
    <div class=\"mainheadline $align\">
      <h2 class=\"headline\">$title</h2>     
      <h3 class=\"subheadline\">$subtitle</h3>  
	</div>
  </div> 
";
}
add_shortcode('mainheadline','rt_healthinsurancetheme_title');



/******************
 * divider line  [divider_line]
 *
 ******************/
function rt_healthinsurancetheme_divid( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	),$atts));

	return "
  <div class=\"divider-line\">
  </div> 
";
}
add_shortcode('divider_line','rt_healthinsurancetheme_divid');


/******************
 * divider line2  [divider_line2]
 *
 ******************/
function rt_healthinsurancetheme_divid2( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	),$atts));

	return "  
  <div class=\"divider-line\"><div class=\"divider-line2\"></div></div>  
";
}
add_shortcode('divider_line2','rt_healthinsurancetheme_divid2');



/******************
 * divider space  [divider_space]
 *
 ******************/
function rt_healthinsurancetheme_divids( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	),$atts));

	return "  
  <div class=\"divider-space1\"></div>  
";
}
add_shortcode('divider_space','rt_healthinsurancetheme_divids');



/******************
 * Button shortcode  [button text="" url="" color="" size="" position="" target="" arrow=""]
 *
 ******************/
function rt_healthinsurancetheme_button( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'text' => 'button',
	'url' => '#',
  'color' => 'firstcolor',
  'size' => '',
  'position' => 'text-left',
  'target' => '_blank',
  'arrow' => 'hide',
	),$atts));

	return "
  <div class=\"$position\">
  <div class=\"button1 $color $size\">
    <a href=\"$url\" target=\"$target\">
	$text <i class=\"$arrow fa fa-long-arrow-right\"> </i>
	</a>
  </div> 
  </div> 
";
}
add_shortcode('button','rt_healthinsurancetheme_button');


/******************
 * Call to action box [cta_box text1="" text2="" url="" icon=""]
 *
 ******************/
function rt_healthinsurancetheme_cta_box( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'text1' => '',
  'text2' => '',
  'url' => 'yourskypeid',
  'icon' => 'fa fa-phone'
	),$atts));

	return "
  <a href=\"$url\" class=\"phonecallicon marginbottom\"> 
    <div class=\"phonecallicon-inner\">
      <div class=\"center\">
        <div class=\"left\">
		  <i class=\"$icon\"></i> 
		</div>
        <div class=\"right\">
          <h4>$text1</h4>
          <h3>$text2</h3>
        </div>
      </div>
	</div>
  </a>
";
}
add_shortcode('cta_box','rt_healthinsurancetheme_cta_box');



/******************
 * Call to action popup box [cta__popup_box text1="" text2="" class="" icon=""]
 *
 ******************/
function rt_healthinsurancetheme_cta_box2( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'text1' => '',
  'text2' => '',
  'class' => '',
  'icon' => 'fa fa-envelope'
	),$atts));

	return "
  <div class=\"$class phonecallicon marginbottom\"> 
    <div class=\"phonecallicon-inner\">
      <div class=\"center\">
        <div class=\"left\">
		  <i class=\"$icon\"></i> 
		</div>
        <div class=\"right\">
          <h4>$text1</h4>
          <h3>$text2</h3>
        </div>
      </div>
	</div>
  </div>
";
}
add_shortcode('cta_popup_box','rt_healthinsurancetheme_cta_box2');


/******************
 * Video box [video_box text="" videourl=""]
 *
 ******************/
function rt_healthinsurancetheme_video_box( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'text' => '',
    'videourl' => ''
	),$atts));

	return "	
    <div class=\"video-box\">
      <div class=\"video-box-button\">
        <a class='youtube' href=\"$videourl\">
          <i class=\"fa fa-play-circle\"></i>
        </a> 
      </div>
	  <div class=\"video-text\">
	    <p> $text </p>
	  </div>
    </div>
";
}
add_shortcode('video_box','rt_healthinsurancetheme_video_box');



/******************
 * Icon1 [rt_icon1 title="" text="" icon="" aligh="" width=""]
 *
 ******************/
function rt_healthinsurancetheme_icon( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title' => '',
    'text' => '',
	'icon' => 'icon-call-in',
	'align' => 'text-left',
	'width' => 'one-in-row',
	),$atts));

	return "
	<div class=\"contacticon\">
	<div class=\"icon $align $width\">
      <i class=\"$icon\"></i> 
      <h5>$title</h5>
      $text
    </div> 
	</div>
";
}
add_shortcode('rt_icon1','rt_healthinsurancetheme_icon');




/******************
 * Icon1 [rt_serviceicon title="" text="" icon="" aligh="" width="" whitetext=""]
 *
 ******************/
function rt_healthinsurancetheme_icon2( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title' => '',
  'text' => '',
	'icon' => 'icon-call-in',
	'align' => 'text-left',
	'width' => 'one-in-row',
	'whitetext' => '',	
	),$atts));

	return "
	<div class=\"serviceone $align $width $whitetext\">
      <i class=\"$icon\"></i> 
      <h2>$title</h2>
      <p>$text</p>
    </div> 
";
}
add_shortcode('rt_serviceicon','rt_healthinsurancetheme_icon2');


/******************
 * Tabs special2 shortcode  [tabs_special2 id="" iconurl1="" title1=""
  iconurl2="" title2="" 
  image1="" content1="" 
  image2="" content2=""]
 *
 ******************/

function rt_healthinsurancetheme_tabs_special2( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'id' => '',
	'iconurl1' => '',
	'title1' => '',
	'image1' => '',
    'content1' => '',
    'iconurl2' => '',
	'title2' => '',
	'image2' => '',
    'content2' => '',
	),$atts));
	return "
	<div class=\"wrapper100percent\">
	<div class=\"row\">
	<ul class=\"col-md-6 col-md-push-6 tabs-special\" role=\"tablist\">
        <li role=\"presentation\" class=\"active col-xs-6\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#one$id\" aria-controls=\"one$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl1\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title1</h2>
            </div>  
            </a>
          </div>
        </li>             
        <li role=\"presentation\" class=\"col-xs-6\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#two$id\" aria-controls=\"two$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl2\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title2</h2>
            </div>  
            </a>
          </div>
        </li>  
      </ul> 
	</div>
	  <!-- Tab panes -->
      <div class=\"tab-content tabs-special-panes\">
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in active\" id=\"one$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image1\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content1
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"two$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image2\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content2
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
      </div> 
	  </div> 
      <!-- Tab panes end -->
";
}
add_shortcode('tabs_special2','rt_healthinsurancetheme_tabs_special2');



/******************
 * Tabs special3 shortcode  [tabs_special3 id="" iconurl1="" title1=""
  iconurl2="" title2="" 
  iconurl3="" title3=""
  image1="" content1="" 
  image2="" content2="" 
  image3="" content3=""]
 *
 ******************/

function rt_healthinsurancetheme_tabs_special3( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'id' => '',
	'iconurl1' => '',
	'title1' => '',
	'image1' => '',
    'content1' => '',
    'iconurl2' => '',
	'title2' => '',
	'image2' => '',
    'content2' => '',
    'iconurl3' => '',
	'title3' => '',
	'image3' => '',
    'content3' => ''
	),$atts));
	return "
	<div class=\"wrapper100percent\">
	<div class=\"row\">
	<ul class=\"col-md-6 col-md-push-6 tabs-special\" role=\"tablist\">
        <li role=\"presentation\" class=\"active col-sm-4 col-xs-4\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#one$id\" aria-controls=\"one$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl1\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title1</h2>
            </div>  
            </a>
          </div>
        </li>             
        <li role=\"presentation\" class=\"col-sm-4 col-xs-4\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#two$id\" aria-controls=\"two$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl2\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title2</h2>
            </div>  
            </a>
          </div>
        </li>  
        <li role=\"presentation\" class=\"col-sm-4 col-xs-4\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#three$id\" aria-controls=\"three$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl3\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title3</h2>
            </div>  
            </a>
          </div>
        </li>  
      </ul> 
	</div>
	
	  <!-- Tab panes -->
      <div class=\"tab-content tabs-special-panes\">
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in active\" id=\"one$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image1\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content1
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"two$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image2\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content2
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"three$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image3\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content3
			</div>
          </div>
		</div>

        <!-- ONE PANE END -->
		</div>
		</div>
      <!-- Tab panes end -->
";
}
add_shortcode('tabs_special3','rt_healthinsurancetheme_tabs_special3');


/******************
 * Tabs special4 shortcode  [tabs_special4 id="" iconurl1="" title1=""
  iconurl2="" title2="" 
  iconurl3="" title3=""
  iconurl4="" title4=""
  image1="" content1="" 
  image2="" content2="" 
  image3="" content3=""
  image4="" content4=""
  ]
 *
 ******************/

function rt_healthinsurancetheme_tabs_special4( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'id' => '',
	'iconurl1' => '',
	'title1' => '',
	'image1' => '',
    'content1' => '',
    'iconurl2' => '',
	'title2' => '',
	'image2' => '',
    'content2' => '',
    'iconurl3' => '',
	'title3' => '',
	'image3' => '',
    'content3' => '',
	'iconurl4' => '',
	'title4' => '',
	'image4' => '',
    'content4' => ''
	),$atts));
	return "	
	<div class=\"row\">
	<ul class=\"col-md-6 col-md-push-6 tabs-special\" role=\"tablist\">
        <li role=\"presentation\" class=\"active col-sm-3 col-xs-3\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#one$id\" aria-controls=\"one$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl1\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title1</h2>
            </div>  
            </a>
          </div>
        </li>             
        <li role=\"presentation\" class=\"col-sm-3 col-xs-3\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#two$id\" aria-controls=\"two$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl2\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title2</h2>
            </div>  
            </a>
          </div>
        </li> 
		<li role=\"presentation\" class=\"col-sm-3 col-xs-3\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#three$id\" aria-controls=\"three$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl3\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title3</h2>
            </div>  
            </a>
          </div>
        </li>
		<li role=\"presentation\" class=\"col-sm-3 col-xs-3\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#four$id\" aria-controls=\"four$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl4\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title4</h2>
            </div>  
            </a>
          </div>
        </li>  
      </ul> 
	</div>
	  <!-- Tab panes -->
      <div class=\"tab-content tabs-special-panes\">
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in active\" id=\"one$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image1\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content1
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"two$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image2\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content2
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"three$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image3\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content3
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"four$id\">
          <div class=\"row\">
			<div class=\"col-sm-6\">
			  <img src=\"$image4\"  alt=\"\">
			</div>
			<div class=\"col-sm-6 tab-content-wrapper\">
              $content4
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
      </div> 
      <!-- Tab panes end -->
";
}
add_shortcode('tabs_special4','rt_healthinsurancetheme_tabs_special4');


/******************
 * Tabs special5 shortcode  [tabs_special5 id="" iconurl1="" title1=""
  iconurl2="" title2=""
  iconurl3="" title3=""
  iconurl4="" title4=""
  iconurl5="" title5=""
  image1="" content1="" 
  image2="" content2="" 
  image3="" content3=""
  image4="" content4=""
  image5="" content5=""  
  ]
 *
 ******************/

function rt_healthinsurancetheme_tabs_special5( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'id' => '',
	'iconurl1' => '',
	'title1' => '',
	'image1' => '',
    'content1' => '',
    'iconurl2' => '',
	'title2' => '',
	'image2' => '',
    'content2' => '',
    'iconurl3' => '',
	'title3' => '',
	'image3' => '',
    'content3' => '',
	'iconurl4' => '',
	'title4' => '',
	'image4' => '',
    'content4' => '',
	'iconurl5' => '',
	'title5' => '',
	'image5' => '',
    'content5' => ''
	),$atts));
	return "	
	<div class=\"row\">
	<ul class=\"col-md-8 col-md-push-4 tabs-special\" role=\"tablist\">
        <li role=\"presentation\" class=\"active col-five-columns\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#one$id\" aria-controls=\"one$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl1\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title1</h2>
            </div>  
            </a>
          </div>
        </li>             
        <li role=\"presentation\" class=\"col-five-columns\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#two$id\" aria-controls=\"two$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl2\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title2</h2>
            </div>  
            </a>
          </div>
        </li> 
		<li role=\"presentation\" class=\"col-five-columns\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#three$id\" aria-controls=\"three$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl3\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title3</h2>
            </div>  
            </a>
          </div>
        </li>
		<li role=\"presentation\" class=\"col-five-columns\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#four$id\" aria-controls=\"four$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl4\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title4</h2>
            </div>  
            </a>
          </div>
        </li> 
		<li role=\"presentation\" class=\"col-five-columns\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#five$id\" aria-controls=\"five$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl5\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title5</h2>
            </div>  
            </a>
          </div>
        </li> 
      </ul> 
	</div>
	  <!-- Tab panes -->
      <div class=\"tab-content tabs-special-panes\">
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in active\" id=\"one$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image1\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content1
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"two$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image2\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content2
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"three$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image3\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content3
			</div>
          </div>
		</div>
 
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"four$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image4\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content4
			</div>
          </div>
		</div>
    
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"five$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image5\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content5
			</div>
          </div>
		</div>

        <!-- ONE PANE END -->
      </div> 
      <!-- Tab panes end -->
";
}
add_shortcode('tabs_special5','rt_healthinsurancetheme_tabs_special5');



/******************
 * Tabs special6 shortcode  [tabs_special6 id="" iconurl1="" title1=""
  iconurl2="" title2=""
  iconurl3="" title3=""
  iconurl4="" title4=""
  iconurl5="" title5=""
  iconurl6="" title6=""
  image1="" content1="" 
  image2="" content2="" 
  image3="" content3=""
  image4="" content4=""
  image5="" content5="" 
  image6="" content6=""  
  ]
 *
 ******************/

function rt_healthinsurancetheme_tabs_special6( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'id' => '',
	'iconurl1' => '',
	'title1' => '',
	'image1' => '',
    'content1' => '',
    'iconurl2' => '',
	'title2' => '',
	'image2' => '',
    'content2' => '',
    'iconurl3' => '',
	'title3' => '',
	'image3' => '',
    'content3' => '',
	'iconurl4' => '',
	'title4' => '',
	'image4' => '',
    'content4' => '',
	'iconurl5' => '',
	'title5' => '',
	'image5' => '',
    'content5' => '',
	'iconurl6' => '',
	'title6' => '',
	'image6' => '',
    'content6' => ''
	),$atts));
	return "	
	<div class=\"row\">
	<ul class=\"col-md-8 col-md-push-4 tabs-special\" role=\"tablist\">
        <li role=\"presentation\" class=\"active col-sm-2\">
          <div class=\"tabs-special-inner\"> 
            <a href=\"#one$id\" aria-controls=\"one$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl1\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title1</h2>
            </div>  
            </a>
          </div>
        </li>             
        <li role=\"presentation\" class=\"col-sm-2\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#two$id\" aria-controls=\"two$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl2\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title2</h2>
            </div>  
            </a>
          </div>
        </li> 
		<li role=\"presentation\" class=\"col-sm-2\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#three$id\" aria-controls=\"three$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl3\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title3</h2>
            </div>  
            </a>
          </div>
        </li>
		<li role=\"presentation\" class=\"col-sm-2\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#four$id\" aria-controls=\"four$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl4\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title4</h2>
            </div>  
            </a>
          </div>
        </li> 
		<li role=\"presentation\" class=\"col-sm-2\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#five$id\" aria-controls=\"five$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl5\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title5</h2>
            </div>  
            </a>
          </div>
        </li>
		<li role=\"presentation\" class=\"col-sm-2\" >
          <div class=\"tabs-special-inner\"> 
            <a href=\"#six$id\" aria-controls=\"six$id\" role=\"tab\" data-toggle=\"tab\">
            <div class=\"tabs-special-img-wrapper\">
              <i class=\"$iconurl6\"></i>
              <div class=\"tabs-special-line\"></div>
            </div> 
            <div>
              <h2>$title6</h2>
            </div>  
            </a>
          </div>
        </li> 	
      </ul> 
	</div>
	  <!-- Tab panes -->
      <div class=\"tab-content tabs-special-panes\">
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in active\" id=\"one$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image1\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content1
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"two$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image2\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content2
			</div>
          </div>
        </div>
        <!-- ONE PANE END -->
        <!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"three$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image3\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content3
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"four$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image4\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content4
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"five$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image5\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content5
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
		<!-- ONE PANE -->
        <div role=\"tabpanel\" class=\"tab-pane tab-special-pane fade in\" id=\"six$id\">
          <div class=\"row\">
			<div class=\"col-sm-4\">
			  <img src=\"$image6\"  alt=\"\">
			</div>
			<div class=\"col-sm-8 tab-content-wrapper\">
              $content6
			</div>
          </div>
		</div>
        <!-- ONE PANE END -->
      </div> 
      <!-- Tab panes end -->
";
}
add_shortcode('tabs_special6','rt_healthinsurancetheme_tabs_special6');



/******************
 * Services links2 shortcode  [services_links2 title1="" imgurl1="" url1="" active1=""
   title2="" imgurl2="" url2="" active2=""]
 *
 ******************/

function rt_healthinsurancetheme_services_links2( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title1' => '',
    'imgurl1' => '',
	'url1' => '',
    'active1' => '',
	'title2' => '',
    'imgurl2' => '',
	'url2' => '',
    'active2' => ''
	),$atts));
	return "	
	<div class=\"insurance-headline\"> 
      <ul class=\"single-icons-wrapper row\"> 
        <li class=\"col-sm-6 col-xs-6\">        
          <a href=\"$url1\" class=\"$active1\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl1\" alt=\"\"> 
            </div>
            <h4>
              $title1
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
        <li class=\"col-sm-6 col-xs-6\">        
          <a href=\"$url2\" class=\"$active2\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl2\" alt=\"\"> 
            </div>
            <h4>
              $title2
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
      </ul>
    </div>
";
}
add_shortcode('services_links2','rt_healthinsurancetheme_services_links2');


/******************
 * Services links3 shortcode  [services_links3 title1="" imgurl1="" url1="" active1=""
   title2="" imgurl2="" url2="" active2=""
   title3="" imgurl3="" url3="" active3=""]
 *
 ******************/

function rt_healthinsurancetheme_services_links3( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title1' => '',
    'imgurl1' => '',
	'url1' => '',
    'active1' => '',
	'title2' => '',
    'imgurl2' => '',
	'url2' => '',
    'active2' => '',
	'title3' => '',
    'imgurl3' => '',
	'url3' => '',
    'active3' => ''
	),$atts));
	return "	
	<div class=\"insurance-headline\"> 
      <ul class=\"single-icons-wrapper row\"> 
        <li class=\"col-sm-4 col-xs-12\">        
          <a href=\"$url1\" class=\"$active1\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl1\" alt=\"\"> 
            </div>
            <h4>
              $title1
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
        <li class=\"col-sm-4 col-xs-12\">        
          <a href=\"$url2\" class=\"$active2\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl2\" alt=\"\"> 
            </div>
            <h4>
              $title2
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-sm-4 col-xs-12\">        
          <a href=\"$url3\" class=\"$active3\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl3\" alt=\"\"> 
            </div>
            <h4>
              $title3
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
      </ul>
    </div>
";
}
add_shortcode('services_links3','rt_healthinsurancetheme_services_links3');


/******************
 * Services links4 shortcode  [services_links4 title1="" imgurl1="" url1="" active1=""
   title2="" imgurl2="" url2="" active2=""
   title3="" imgurl3="" url3="" active3=""
   title4="" imgurl4="" url4="" active4=""]
 *
 ******************/

function rt_healthinsurancetheme_services_links4( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title1' => '',
    'imgurl1' => '',
	'url1' => '',
    'active1' => '',
	'title2' => '',
    'imgurl2' => '',
	'url2' => '',
    'active2' => '',
	'title3' => '',
    'imgurl3' => '',
	'url3' => '',
    'active3' => '',
	'title4' => '',
    'imgurl4' => '',
	'url4' => '',
    'active4' => ''
	),$atts));
	return "	
	<div class=\"insurance-headline\"> 
      <ul class=\"single-icons-wrapper row\"> 
        <li class=\"col-sm-3 col-xs-12\">        
          <a href=\"$url1\" class=\"$active1\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl1\" alt=\"\"> 
            </div>
            <h4>
              $title1
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
        <li class=\"col-sm-3 col-xs-12\">        
          <a href=\"$url2\" class=\"$active2\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl2\" alt=\"\"> 
            </div>
            <h4>
              $title2
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-sm-3 col-xs-12\">        
          <a href=\"$url3\" class=\"$active3\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl3\" alt=\"\"> 
            </div>
            <h4>
              $title3
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-sm-3 col-xs-12\">        
          <a href=\"$url4\" class=\"$active4\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl4\" alt=\"\"> 
            </div>
            <h4>
              $title4
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
      </ul>
    </div>
";
}
add_shortcode('services_links4','rt_healthinsurancetheme_services_links4');


/******************
 * Services links5 shortcode  [services_links5 title1="" imgurl1="" url1="" active1=""
   title2="" imgurl2="" url2="" active2=""
   title3="" imgurl3="" url3="" active3=""
   title4="" imgurl4="" url4="" active4=""
   title5="" imgurl5="" url5="" active5=""]
 *
 ******************/

function rt_healthinsurancetheme_services_links5( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title1' => '',
    'imgurl1' => '',
	'url1' => '',
    'active1' => '',
	'title2' => '',
    'imgurl2' => '',
	'url2' => '',
    'active2' => '',
	'title3' => '',
    'imgurl3' => '',
	'url3' => '',
    'active3' => '',
	'title4' => '',
    'imgurl4' => '',
	'url4' => '',
    'active4' => '',
	'title5' => '',
    'imgurl5' => '',
	'url5' => '',
    'active5' => ''
	),$atts));
	return "	
	<div class=\"insurance-headline\"> 
      <ul class=\"single-icons-wrapper row\"> 
        <li class=\"col-five-columns col-xs-12\">        
          <a href=\"$url1\" class=\"$active1\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl1\" alt=\"\"> 
            </div>
            <h4>
              $title1
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
        <li class=\"col-five-columns col-xs-12\">        
          <a href=\"$url2\" class=\"$active2\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl2\" alt=\"\"> 
            </div>
            <h4>
              $title2
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-five-columns col-xs-12\">        
          <a href=\"$url3\" class=\"$active3\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl3\" alt=\"\"> 
            </div>
            <h4>
              $title3
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-five-columns col-xs-12\">        
          <a href=\"$url4\" class=\"$active4\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl4\" alt=\"\"> 
            </div>
            <h4>
              $title4
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-five-columns col-xs-12\">        
          <a href=\"$url5\" class=\"$active5\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl5\" alt=\"\"> 
            </div>
            <h4>
              $title5
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
      </ul>
    </div>
";
}
add_shortcode('services_links5','rt_healthinsurancetheme_services_links5');



/******************
 * Services links6 shortcode  [services_links6 title1="" imgurl1="" url1="" active1=""
   title2="" imgurl2="" url2="" active2=""
   title3="" imgurl3="" url3="" active3=""
   title4="" imgurl4="" url4="" active4=""
   title5="" imgurl5="" url5="" active5=""
   title6="" imgurl6="" url6="" active6=""]
 *
 ******************/

function rt_healthinsurancetheme_services_links6( $atts, $content = null ) {
	$atts = extract(shortcode_atts(array(
	'title1' => '',
    'imgurl1' => '',
	'url1' => '',
    'active1' => '',
	'title2' => '',
    'imgurl2' => '',
	'url2' => '',
    'active2' => '',
	'title3' => '',
    'imgurl3' => '',
	'url3' => '',
    'active3' => '',
	'title4' => '',
    'imgurl4' => '',
	'url4' => '',
    'active4' => '',
	'title5' => '',
    'imgurl5' => '',
	'url5' => '',
    'active5' => '',
	'title6' => '',
    'imgurl6' => '',
	'url6' => '',
    'active6' => ''
	),$atts));
	return "	
	<div class=\"insurance-headline\"> 
      <ul class=\"single-icons-wrapper row\"> 
        <li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url1\" class=\"$active1\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl1\" alt=\"\"> 
            </div>
            <h4>
              $title1
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
        <li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url2\" class=\"$active2\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl2\" alt=\"\"> 
            </div>
            <h4>
              $title2
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url3\" class=\"$active3\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl3\" alt=\"\"> 
            </div>
            <h4>
              $title3
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url4\" class=\"$active4\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl4\" alt=\"\"> 
            </div>
            <h4>
              $title4
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url5\" class=\"$active5\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl5\" alt=\"\"> 
            </div>
            <h4>
              $title5
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
		<li class=\"col-md-2 col-xs-12\">        
          <a href=\"$url6\" class=\"$active6\"> 
            <div class=\"single-icon\"> 
              <img src=\"$imgurl6\" alt=\"\"> 
            </div>
            <h4>
              $title6
            </h4>
			<i class=\"fa fa-angle-right\"></i>
          </a>
        </li>
      </ul>
    </div>
";
}
add_shortcode('services_links6','rt_healthinsurancetheme_services_links6');
