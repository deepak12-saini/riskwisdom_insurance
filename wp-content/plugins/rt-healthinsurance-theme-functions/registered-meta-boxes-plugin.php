<?php
add_filter( 'rwmb_meta_boxes', 'rt_healthinsurance_register_meta_boxes_plugin' );
function rt_healthinsurance_register_meta_boxes_plugin( $meta_boxes )
{
$prefix = 'healthinsurance_';

// 1 meta box
$meta_boxes[] = array(
'id' => "{$prefix}teamtext",
'title' => esc_html__( 'Team', 'health-insurance' ),
'post_types' => array( 'rt-team' ),
'context' => 'normal',
'priority' => 'high',
'autosave' => true,
'fields' => array(

// text
array(
// Field name - Will be used as label
'name' => esc_html__( 'Team member function', 'health-insurance' ),
// Field ID, i.e. the meta key
'id' => "{$prefix}teamtext1",
// Field description (optional)
'desc' => esc_html__( 'Team member function', 'health-insurance' ),
'type' => 'text',
// Default value (optional)
'std' => esc_html__( '', 'health-insurance' ),
// CLONES: Add to make the field cloneable (i.e. have multiple value)
'clone' => false,
),


// custom_html
array(
// Field name - Will be used as label
'name' => esc_html__( 'Team member icons', 'health-insurance' ),
// Field ID, i.e. the meta key
'id' => "{$prefix}teamtext2",
// Field description (optional)
'desc' => esc_html__( 'Team member icons code snippet', 'health-insurance' ),
'type' => 'wysiwyg',
// Default value (optional)
'std' => esc_html__( '', 'health-insurance' ),
// CLONES: Add to make the field cloneable (i.e. have multiple value)
'clone' => false,
),


// text
array(
// Field name - Will be used as label
'name' => esc_html__( 'Text for link', 'health-insurance' ),
// Field ID, i.e. the meta key
'id' => "{$prefix}teamtext3",
// Field description (optional)
'desc' => esc_html__( 'Text for link', 'health-insurance' ),
'type' => 'text',
// Default value (optional)
'std' => esc_html__( 'see more', 'health-insurance' ),
// CLONES: Add to make the field cloneable (i.e. have multiple value)
'clone' => false,
),

)
);
//1 metabox end



// 2 meta box
$meta_boxes[] = array(
'id' => "{$prefix}galleryimageicon",
'title' => esc_html__( 'Gallery', 'health-insurance' ),
'post_types' => array( 'rt-gaf' ),
'context' => 'normal',
'priority' => 'high',
'autosave' => true,
'fields' => array(


// custom_html
array(
// Field name - Will be used as label
'name' => esc_html__( 'Gallery icons', 'health-insurance' ),
// Field ID, i.e. the meta key
'id' => "{$prefix}galleryimageicon1",
// Field description (optional)
'desc' => esc_html__( 'Gallery icons code snippet', 'health-insurance' ),
'type' => 'wysiwyg',
// Default value (optional)
'std' => esc_html__( '', 'health-insurance' ),
// CLONES: Add to make the field cloneable (i.e. have multiple value)
'clone' => false,
)


)
);
//2 metabox end



return $meta_boxes;
}