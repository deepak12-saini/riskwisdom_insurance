<?php
/**
 * This file represents an example of the code that themes would use to register
 * the required plugins.
 *
 * It is expected that theme authors would copy and paste this code into their
 * functions.php file, and amend to suit.
 *
 * @see http://tgmpluginactivation.com/configuration/ for detailed documentation.
 *
 * @package    TGM-Plugin-Activation
 * @subpackage Example
 * @version    2.6.1
 * @author     Thomas Griffin, Gary Jones, Juliette Reinders Folmer
 * @copyright  Copyright (c) 2011, Thomas Griffin
 * @license    http://opensource.org/licenses/gpl-2.0.php GPL v2 or later
 * @link       https://github.com/TGMPA/TGM-Plugin-Activation
 */

/**
 * Include the TGM_Plugin_Activation class.
 */

require_once(trailingslashit( get_template_directory() ) . 'class-tgm-plugin-activation.php');

add_action( 'tgmpa_register', 'rt_healthinsurance_register_required_plugins' );

function rt_healthinsurance_register_required_plugins() {

	$plugins = array(

		// This is an example of how to include a plugin bundled with a theme.
        
    array(
			'name'     				=> esc_html__('Rt Health Insurance Theme Functions', 'health-insurance'), // The plugin name
			'slug'     				=> 'rt-healthinsurance-theme-functions', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/plugins/rt-healthinsurance-theme-functions.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
      'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),
		
    array(
			'name'     				=> esc_html__('Slider Revolution', 'health-insurance'), // The plugin name
			'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
			'source'   				=> get_template_directory() . '/plugins/revslider.zip', // The plugin source
			'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
			'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
			'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
			'force_deactivation' 	=> false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
			'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
      'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
		),   

		// This is an example of how to include a plugin from the WordPress Plugin Repository.
	array(
			'name' 		=> esc_html__('King Composer Page Builder', 'health-insurance'),
			'slug' 		=> 'kingcomposer',
			'required' 	=> true,
		),
    
    array(
			'name' 		=> esc_html__('Meta boxes option fields', 'health-insurance'),
			'slug' 		=> 'meta-box',
			'required' 	=> true,
		),
    
    array(
			'name' 		=> esc_html__('Contact Form', 'health-insurance'),
			'slug' 		=> 'contact-form-7',
			'required' 	=> true,
		),
    
		 array(
			'name' 		=> esc_html__('Breadcrumbs', 'health-insurance'),
			'slug' 		=> 'breadcrumb-navxt',
			'required' 	=> false,
		),

    array(
			'name' 		=> esc_html__('Easy Social Icons', 'health-insurance'),
			'slug' 		=> 'easy-social-icons',
			'required' 	=> false,
		),
		
	    array(
			'name' 		=> esc_html__('Popup maker', 'health-insurance'),
			'slug' 		=> 'popup-maker',
			'required' 	=> false,
		),
		array(
			'name' 		=> esc_html__('WooCommerce', 'health-insurance'),
			'slug' 		=> 'woocommerce',
			'required' 	=> false,
		),
		

	);

	$config = array(
		'id'           => 'tgmpa',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'themes.php',            // Parent menu slug.
		'capability'   => 'edit_theme_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.

	);

	tgmpa( $plugins, $config );
}


/**********************************************************
* include meta boxes 
***********************************************************/
include (trailingslashit( get_template_directory() ) . 'registered-meta-boxes.php');


/**********************************************************
* language support
***********************************************************/
function rt_healthinsurance_load_theme_textdomain() {
  load_theme_textdomain( 'health-insurance', get_template_directory().'/languages' );
}
add_action( 'after_setup_theme', 'rt_healthinsurance_load_theme_textdomain' );


/**********************************************************
* google fonts support
***********************************************************/
function rt_healthinsurance_fonts_url() {
  $font_url = '';

  if ( 'off' !== _x( 'on', 'Google font: on or off', 'health-insurance' ) ) {
    $font_url = add_query_arg( 'family', urlencode( 'Montserrat:300,400,500,600|Roboto:300,400,700&subset=latin,latin-ext' ), "//fonts.googleapis.com/css" );
  }  
  
  return esc_url_raw( $font_url );
}

/************************************************************************
* excerpt in pages
*************************************************************************/
add_action( 'init', 'rt_healthinsurance_add_excerpts_to_pages' );
  function rt_healthinsurance_add_excerpts_to_pages() {
    add_post_type_support( 'page', 'excerpt' );
  }

/**********************************************************
* woocommerce support
***********************************************************/
add_action( 'after_setup_theme', 'rt_healthinsurance_woocommerce_support' );
function rt_healthinsurance_woocommerce_support() {
    add_theme_support( 'woocommerce' );
}


/**********************************************************
* title tag support
***********************************************************/
add_theme_support( 'title-tag' );


/**********************************************************
* menu
***********************************************************/
add_action( 'after_setup_theme', 'rt_healthinsurance_register_my_menus' );
function rt_healthinsurance_register_my_menus() {
  register_nav_menus( array(
  //for inner pages
  'header-menu' => esc_html__( 'Default multipage menu (multipage website)', 'health-insurance' ),
	//for front single page
  'primary-menu' => esc_html__( 'Menu for single page (single page website)', 'health-insurance' )  
  )
  );
}
function rt_healthinsurance_default_menu() {
    include (trailingslashit( get_template_directory() ) . 'nav-fallback.php' );
}

/**********************************************************
* post width
***********************************************************/
if ( ! isset( $content_width ) ) $content_width = 900;


/******************************************************
* rss
*******************************************************/
add_theme_support( 'automatic-feed-links' );


/******************************************************
* enable image support
*******************************************************/
function rt_healthinsurance_image_support() {
  add_theme_support( 'post-thumbnails' );
}
add_action( 'after_setup_theme', 'rt_healthinsurance_image_support' );

if (add_theme_support( 'post-thumbnails' )) {
  add_theme_support( 'post-thumbnails', array( 'post', 'page', 'rt-healthinsurance-icons1', 'rt-healthinsurance-icons2', 'rt-healthinsurance-team', 'rt-healthinsurance-gal1', 'rt-healthinsurance-testi', 'rt-healthinsurance-gaf', 'tribe_events') );  
}


//cropped image sizes for columns
if ( function_exists( 'add_image_size' ) ) {
add_image_size( 'rt_healthinsurance_1200x650', 1200, 650 );
add_image_size( 'rt_healthinsurance_600x550', 600, 550 );
add_image_size( 'rt_healthinsurance_400x400', 400, 400 ); 
add_image_size( 'rt_healthinsurance_300x300', 300, 300 ); 
add_image_size( 'rt_healthinsurance_240x240', 240, 240 );
add_image_size( 'rt_healthinsurance_200x200', 200, 200 ); 
}

/************************************************************************
* backend admin scripts and styles 
*************************************************************************/
function rt_healthinsurance_scripts_admin() {
  wp_enqueue_style( 'rt_healthinsurance_admin_style', get_stylesheet_directory_uri() . '/admin/css/rt-healthinsurance-admin-style.css' );
}
add_action( 'in_admin_footer', 'rt_healthinsurance_scripts_admin' );


/************************************************************************
* frontend scripts and styles 
*************************************************************************/
function rt_healthinsurance_scripts() {

/** enqueue theme style **/
wp_enqueue_style( 'rt_healthinsurance_style', get_stylesheet_uri() );


/** customizer inline css **/

wp_enqueue_style( 'custom-style1', get_stylesheet_directory_uri() . '/assets/css/custom_style1.css' );
 
 /* archive blog and inner pages title background image in Customizer */
 $handle = 'custom-style1';  
 $css = '';
 $rt_healthinsurance_title_background_image_url1 = get_theme_mod( 'titlebg' ); 
 $css .= ( !empty($rt_healthinsurance_title_background_image_url1) ) ? sprintf('
 .mainheadlinewrapperpage {
   background-image: url( %s )!important;
 }
 .mainheadlinewrapperpage .bubbles li {
   visibility: hidden;		
 } 
 ', $rt_healthinsurance_title_background_image_url1 ) : '';
 if ( $css ) {
   wp_add_inline_style( $handle , $css );
 } 
/* archive blog and inner pages title background image in Customizer end */

 /* video box page builder element background image in customizer */
 $handle2 = 'custom-style1';  
 $css2 = '';
 $rt_healthinsurance_videobox_background_image_url1 = get_theme_mod( 'videobox' ); 
 $css2 .= ( !empty($rt_healthinsurance_videobox_background_image_url1) ) ? sprintf('
 .video-box {
   background-image: url( %s )!important;
 }
 ', $rt_healthinsurance_videobox_background_image_url1 ) : '';
 if ( $css2 ) {
   wp_add_inline_style( $handle2 , $css2 );
 } 
/* video box page builder element background image in customizer */
 
/** customizer inline css end **/ 


/** add/remove style.less file **/
if ( 'on' == get_theme_mod( 'stylelessfile' ))
  wp_enqueue_style( 'rt_healthinsurance_styleless', get_stylesheet_directory_uri() . '/style.less'  );
else;

/*** fonts function from above ***/
wp_enqueue_style( 'rt_healthinsurance_fonts', rt_healthinsurance_fonts_url(), array(), '1.0.0' );

/** enqueue comment script in single posts **/
if ( is_singular('post', 'page') ) 
  wp_enqueue_script( 'comment-reply' );
else;	

/** enqueue masonry script in blog page templates with 2 and 3 columns **/
if (is_page_template( 'page-templates/blog-archive-columns2.php' or 'page-templates/blog-archive-columns2a.php' 
or 'page-templates/blog-archive-columns3.php' or 'page-templates/blog-archive-columns3a.php' ))
  wp_enqueue_script( 'masonry' );
else;

/** change default colors in customizer **/
if ( 'green' == get_theme_mod( 'defaultcolors' ))
  wp_enqueue_style( 'rt_healthinsurance_green', get_stylesheet_directory_uri() . '/main-green.css' );
elseif ( 'blue' == get_theme_mod( 'defaultcolors' ))
  wp_enqueue_style( 'rt_healthinsurance_blue', get_stylesheet_directory_uri() . '/main-blue.css' );
elseif ( 'orange' == get_theme_mod( 'defaultcolors' ))
  wp_enqueue_style( 'rt_healthinsurance_orange', get_stylesheet_directory_uri() . '/main-orange.css' );
elseif ( 'less' == get_theme_mod( 'defaultcolors' ))
  wp_enqueue_style( 'rt_healthinsurance_less', get_stylesheet_directory_uri() . '/style.less' );
else 
  wp_enqueue_style( 'rt_healthinsurance_green', get_stylesheet_directory_uri() . '/main-green.css' );
   


/** enqueue theme scripts **/
wp_enqueue_script( 'bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'flickity', get_template_directory_uri() . '/assets/js/flickity.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'isotope', get_template_directory_uri() . '/assets/js/isotope.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'headhesive', get_template_directory_uri() . '/assets/js/headhesive.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'colorbox', get_template_directory_uri() . '/assets/js/colorbox.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'waypoints', get_template_directory_uri() . '/assets/js/waypoints.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'ionrangeslider', get_template_directory_uri() . '/assets/js/ionrangeslider.js', array('jquery'), '1.0.0', true );
wp_enqueue_script( 'rt_healthinsurance_scripts', get_template_directory_uri() . '/assets/js/scripts.js', array('jquery'), '1.0.2', true );

}
add_action( 'wp_enqueue_scripts', 'rt_healthinsurance_scripts' );

// Ensure Services (parent) dropdown opens on click – CSS fallback
function rt_healthinsurance_menu_dropdown_css() {
  echo '<style type="text/css">
    .menu-item-has-children.open > .sub-menu { display: block !important; max-height: 3000px !important; opacity: 1 !important; overflow: visible !important; }
  </style>';
}
add_action( 'wp_head', 'rt_healthinsurance_menu_dropdown_css', 99 );


/************************************************************************
* customize theme in customizer
*************************************************************************/
function rt_healthinsurance_customize_register( $wp_customize ) {

//COPYRIGHT DETAILS
 $wp_customize->add_setting( 'copyright_detailstext' , array(
  'default'     => 'Copyright text',
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_text',
) );

$wp_customize->add_control( 'copyright_detailstext', array(
  'type' => 'textarea',
	'label'        => esc_html__( 'Copyright text', 'health-insurance' ),
	'section'    => 'rt_healthinsurance_copyrighturl',
	'settings'   => 'copyright_detailstext',
 ));

$wp_customize->add_section( 'rt_healthinsurance_copyrighturl' , array(
  'title'      => esc_html__( 'Copyright Details', 'health-insurance' ),  
) );


//CUSTOMIZE LOGO
$wp_customize->add_setting( 'logo', array(
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_image',
) );
$wp_customize->add_section( 'rt_healthinsurance_logo_section' , array(
  'title'       => esc_html__( 'Logo', 'health-insurance' ),
  'priority'    => 30,
  'description' => esc_html__('Upload a logo image to replace the default site name and description in the header, in jpg or png format only. Recommended width for image is under 400px and height at least 100px.', 'health-insurance' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
  'label'    => esc_html__( 'Logo', 'health-insurance' ),
  'section'  => 'rt_healthinsurance_logo_section',
  'settings' => 'logo',
) ) );


//SIDEBAR IN WOOCOMMERCE ARCHIVE PAGES
 $wp_customize->add_setting( 'woocommercesidebar' , array(
  'default'     => 'on',
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_radio',
) );
$wp_customize->add_control( 'woocommercesidebar', array(
	'label'        => esc_html__( 'WooCommerce sidebar', 'health-insurance' ),
	'section'    => 'rt_healthinsurance_woocommercesidebar_section',
	'settings'   => 'woocommercesidebar',
    'type'   => 'radio',
    'choices'    => array(
    'on' => __('Add sidebar in WooCommerce archive pages (category, tag, etc) - default', 'health-insurance' ),
    'off' => __('Remove sidebar in WooCommerce archive pages (category, tag, etc)', 'health-insurance' )  
 ),
 ));
$wp_customize->add_section( 'rt_healthinsurance_woocommercesidebar_section' , array(
  'title'      => esc_html__( 'WooCommerce archive pages sidebar', 'health-insurance' ),  
) );


//SIDEBAR IN ARCHIVE PAGES
 $wp_customize->add_setting( 'archivesidebar' , array(
  'default'     => 'on',
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_radio',
) );
$wp_customize->add_control( 'archivesidebar', array(
  'label'        => esc_html__( 'Blog archive pages sidebar', 'health-insurance' ),
  'section'    => 'rt_healthinsurance_archivesidebar_section',
  'settings'   => 'archivesidebar',
  'type'   => 'radio',
  'choices'    => array(
    'on' => esc_html__('Add sidebar in blog archive pages (category, tag, etc) - default', 'health-insurance' ),
    'off' => esc_html__('Remove sidebar from blog archive pages (category, tag, etc)', 'health-insurance' )  
 ),
 ));
$wp_customize->add_section( 'rt_healthinsurance_archivesidebar_section' , array(
  'title'      => esc_html__( 'Blog archive pages sidebar', 'health-insurance' ),  
) );

//DEFAULT COLOR OPTIONS
 $wp_customize->add_setting( 'defaultcolors' , array(
  'default'     => 'off',
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_radio',
) );
$wp_customize->add_control( 'defaultcolors', array(
  'label'        => esc_html__( 'Default color options', 'health-insurance' ),
  'section'    => 'rt_defaultcolors_section',
  'settings'   => 'defaultcolors',
  'type'   => 'radio',
  'choices'    => array(
    'blue' => esc_html__('blue', 'health-insurance' ),
    'green' => esc_html__('green', 'health-insurance' ),  
    'orange' => esc_html__('orange', 'health-insurance' ),
	'less' => esc_html__('less - use this only if you want to customize style.less file and make sure wp-less plugin is activated', 'health-insurance' )  
 ),
 ));
$wp_customize->add_section( 'rt_defaultcolors_section' , array(
  'title'      => esc_html__( 'Default color options', 'health-insurance' ),  
) );


//CUSTOMIZE INNER PAGES TITLE BACKGROUND IMAGE
$wp_customize->add_setting( 'titlebg', array(
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_image',
) );
$wp_customize->add_section( 'titlebg_section' , array(
  'title'       => esc_html__( 'Inner pages title background', 'health-insurance' ),
  'priority'    => 30,
  'description' => esc_html__('Upload image for inner pages title background in jpg or png format only. Recommended size at least 2000px wide.', 'health-insurance' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'titlebg', array(
  'label'    => esc_html__( 'Title background', 'health-insurance' ),
  'section'  => 'titlebg_section',
  'settings' => 'titlebg',
) ) );


//CUSTOMIZE VIDEO BOX BACKGROUND IMAGE
$wp_customize->add_setting( 'videobox', array(
  'transport'   => 'refresh',
  'sanitize_callback' => 'rt_healthinsurance_sanitize_image',
) );
$wp_customize->add_section( 'videobox_section' , array(
  'title'       => esc_html__( 'Video box background', 'health-insurance' ),
  'priority'    => 30,
  'description' => esc_html__('Upload image for video box background in jpg or png format only. Recommended size at least 1000px wide.', 'health-insurance' ),
) );
$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'videobox', array(
  'label'    => esc_html__( 'Video box background', 'health-insurance' ),
  'section'  => 'videobox_section',
  'settings' => 'videobox',
) ) );

}
add_action( 'customize_register', 'rt_healthinsurance_customize_register' );


/*** sanitize text and image and radio button inputs/choices ****/
function rt_healthinsurance_sanitize_text( $input ) {
    return wp_kses_post( force_balance_tags( $input ) );
}
function rt_healthinsurance_sanitize_image( $image, $setting ) {
	$mimes = array(
		'jpg|jpeg|jpe' => 'image/jpeg',
		'png'          => 'image/png',
	);
	$file = wp_check_filetype( $image, $mimes );
	return ( $file['ext'] ? $image : $setting->default );
}
function rt_healthinsurance_sanitize_radio( $input ) {
  $valid = array(
    'on' => esc_html__('Add sidebar in blog archive pages (category, tag, etc) - default', 'health-insurance' ),
    'off' => esc_html__('Remove sidebar from blog archive pages (category, tag, etc)', 'health-insurance' ),  
    'off' => esc_html__('style.less file removed from theme - default', 'health-insurance' ),
    'on' => esc_html__('add style.less file in theme if wp-less plugin is activated and you want to make custom changes in style.less file', 'health-insurance' ),
    'blue' => esc_html__('blue default', 'health-insurance' ),
    'green' => esc_html__('green', 'health-insurance' ),  
    'orange' => esc_html__('orange', 'health-insurance' ),
	'less' => esc_html__('less - use this only if you want to customize style.less file and make sure wp-less plugin is activated', 'health-insurance' ),  
    'on' => __('Add sidebar in WooCommerce archive pages (category, tag, etc) - default', 'health-insurance' ),
    'off' => __('Remove sidebar in WooCommerce archive pages (category, tag, etc)', 'health-insurance' )  
 
  );
  if ( array_key_exists( $input, $valid ) ) {
    return $input;
  } else {
    return '';
  }
}
/*** sanitize end ***/


/** set archive pages sidebar functions **/
function rt_healthinsurance_archivesidebar1(){
if ( 'on' == get_theme_mod( 'archivesidebar' ))
  return 'col-md-9';
elseif ( 'off' == get_theme_mod( 'archivesidebar' ))
  return 'col-md-12';
else
  return 'col-md-9';
}

function rt_healthinsurance_archivesidebar2(){
if ( 'on' == get_theme_mod( 'archivesidebar' ))
  get_sidebar();
elseif ( 'off' == get_theme_mod( 'archivesidebar' ))
  unregister_sidebar('sidebar-1'); 
else
  get_sidebar();
}
/** set archive pages sidebar functions end **/

/** set woocommerce sidebar functions **/
function rt_healthinsurance_woocommercesidebar1(){
if ( 'on' == get_theme_mod( 'woocommercesidebar' ))
  return 'col-md-9';
elseif ( 'off' == get_theme_mod( 'woocommercesidebar' ))
  return 'col-md-12';
else 
  return 'col-md-9';
}

function rt_healthinsurance_woocommercesidebar2(){
if ( 'on' == get_theme_mod( 'woocommercesidebar' ))
  return;
elseif ( 'off' == get_theme_mod( 'woocommercesidebar' ))
  remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);  
else
  return;
}

function rt_healthinsurance_sideb($sideb1){
  if($sideb1 == "col-md-12") 
    remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10);
}
/** set woocommerce sidebar functions end **/


/****************************************************************
* Sidebars and widget areas
*****************************************************************/

function rt_healthinsurance_widgets_init() {
	register_sidebar( array(
		'name' => esc_html__( 'Main Blog Sidebar', 'health-insurance' ),
		'id' => 'sidebar-1',
		'description' => esc_html__( 'Appears in posts and pages sidebar', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3><span>',
		'after_title' => '</span></h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Header  1', 'health-insurance' ),
		'id' => 'sidebar-3ha',
		'description' => esc_html__( 'Appears in header', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Header  2', 'health-insurance' ),
		'id' => 'sidebar-3hb',
		'description' => esc_html__( 'Appears in header', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Header  3', 'health-insurance' ),
		'id' => 'sidebar-3h2',
		'description' => esc_html__( 'Appears in header', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	
	register_sidebar( array(
		'name' => esc_html__( 'Footer  1', 'health-insurance' ),
		'id' => 'sidebar-3',
		'description' => esc_html__( 'Appears in footer', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );

	register_sidebar( array(
		'name' => esc_html__( 'Footer 2', 'health-insurance' ),
		'id' => 'sidebar-4',
		'description' => esc_html__( 'Appears in footer', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name' => esc_html__( 'Footer 3', 'health-insurance' ),
		'id' => 'sidebar-5',
		'description' => esc_html__( 'Appears in footer', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
		register_sidebar( array(
		'name' => esc_html__( 'Footer 4', 'health-insurance' ),
		'id' => 'sidebar-6',
		'description' => esc_html__( 'Appears in footer', 'health-insurance' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget' => '</aside>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	) );
	register_sidebar( array(
		'name'            => __( 'Shop', 'health-insurance' ),
		'id'              => 'shop',
		'description'     => __( 'Appears in WooCommerce pages', 'health-insurance' ),
		'before_widget'   => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'    => '</aside>',
		'before_title'    => '<h4 class="widget-title">',
		'after_title'     => '</h4>',
	) );
	
}
add_action( 'widgets_init', 'rt_healthinsurance_widgets_init' );


/************************************************************************
* page/post navigation
*************************************************************************/

add_filter( 'wp_nav_menu_objects', 'rt_healthinsurance_nav_links' );
function rt_healthinsurance_nav_links( $abcs ) {
foreach  ($abcs as $abc ) {
if('custom' == $abc->type and !is_page()){
if( 1 == preg_match('/^#([^\/]+)$/', $abc->url )){
$abc->url = home_url( '/' ).$abc->url;
}}}
return $abcs;   
}