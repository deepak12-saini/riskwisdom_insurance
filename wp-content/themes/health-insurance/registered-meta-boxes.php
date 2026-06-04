<?php
/**REGISTERED META BOXES
* 
*
* All the definitions of meta boxes are listed below with comments.
* Please read them CAREFULLY.
*
* You also should read the changelog to know what has been changed before updating.
*
* For more information, please visit:
* @link http://metabox.io/docs/registering-meta-boxes/
*/


add_filter( 'rwmb_meta_boxes', 'rt_healthinsurance_register_meta_boxes' );
function rt_healthinsurance_register_meta_boxes( $meta_boxes )
{
/**
* prefix of meta keys (optional)
* Use underscore (_) at the beginning to make keys hidden
* Alt.: You also can make prefix empty to disable it
*/
// Better has an underscore as last sign
$prefix = 'healthinsurance_';


// 1st meta box

$meta_boxes[] = array(
// Meta box id, UNIQUE per meta box. Optional since 4.1.5
'id' => 'sidebars',
// Meta box title - Will appear at the drag and drop handle bar. Required.
'title' => esc_html__( 'Sidebar', 'health-insurance' ),
// Post types, accept custom post types as well - DEFAULT is 'post'. Can be array (multiple post types) or string (1 post type). Optional.
'post_types' => array( 'post', 'rt-team', 'rt-gaf', 'product' ),
// Where the meta box appear: normal (default), advanced, side. Optional.
'context' => 'normal',
// Order of meta box: high (default), low. Optional.
'priority' => 'high',
// Auto save: true, false (default). Optional.
'autosave' => true,
// List of meta fields
'fields' => array(

// radio button
array(
'name' => esc_html__( 'Sidebar in post', 'health-insurance' ),
'id' => "{$prefix}sideb",
'type' => 'radio',
// Array of 'value' => 'Label' pairs for select box
'options' => array(
'col-md-9' => esc_html__( 'add sidebar in post', 'health-insurance' ),
'col-md-12' => esc_html__( 'remove sidebar from post', 'health-insurance' ),
),
// Select multiple values, optional. Default is false.
'multiple' => false,
'std' => 'col-md-9',
),

)
);
//1st metabox end


// 3 meta box

$meta_boxes[] = array(
'id' => 'menusswitch',
'title' => esc_html__( 'Menus', 'health-insurance' ),
'post_types' => array( 'post', 'page', 'rt-gaf', 'rt-team' ),
'context' => 'normal',
'priority' => 'high',
'autosave' => true,
'fields' => array(

// checkbox
array(
'name' => esc_html__( 'Mark this checkbox if you want -menu for single page- to appear on this page/post instead of default multi page menu', 'health-insurance' ),
'id' => "{$prefix}menusswitch",
'type' => 'checkbox',
'multiple' => false,
'std' => '0',
),

)
);
//3 metabox end

return $meta_boxes;
}