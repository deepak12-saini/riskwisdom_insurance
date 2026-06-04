<?php
add_action('init', 'rt_healthinsurance_wp_init', 99 );
function rt_healthinsurance_wp_init(){
  
  global $kc;
  $kc->add_map(

  array(

/******************
 * Team shortcode  
 *
******************/ 
    // 1s shortcode element
    'rt_team' => array(
    'name' => 'Team shortcode RT',
    'description' => 'This is shortcode for display team posts carousel',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'columns',
        'label' => 'Number of columns?',
        'type' => 'radio',
        'options' => array(
          '1' => '1 column',
          '2' => '2 columns',
          '3' => '3 columns',
          '4' => '4 columns',
          '5' => '5 columns',
          '6' => '6 columns',
        )
      ),
      //2nd field
      array(
        'name' => 'order',
        'label' => 'Order of posts?',
        'type' => 'radio',
        'options' => array(
          'ASC' => 'from oldest to newest',
          'DESC' => 'from newest to oldest',
        )
      ),
      //3rd field
      array(
        'name' => 'limit',
        'label' => 'Number of posts? (for unlimited number write -1',
        'type' => 'text',
      ),
    )
  ),// end team shortcode   
    
/******************
 * Blog news shortcode  
 *
******************/ 

    // 1st shortcode element
    'rt_blog_news' => array(
    'name' => 'Blog News shortcode RT',
    'description' => 'This is shortcode for display blog posts',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'columns',
        'label' => 'Number of columns?',
        'type' => 'radio',
        'options' => array(
          '2' => '2 columns',
          '3' => '3 columns',
          '4' => '4 columns',
        )
      ),
      //2nd field
      array(
        'name' => 'order',
        'label' => 'Order of posts?',
        'type' => 'radio',
        'options' => array(
          'ASC' => 'from oldest to newest',
          'DESC' => 'from newest to oldest',
        )
      ),
      //3rd field
      array(
        'name' => 'limit',
        'label' => 'Number of posts? (for unlimited number write -1',
        'type' => 'text',
      ),
    ) 
  ),//end blog news shortcode 
  
  
/******************
 * Testimonials carousel shortcode  
 *
******************/ 

    // 1st shortcode element
    'rt_testimonials_carousel' => array(
    'name' => 'Testimonials shortcode RT',
    'description' => 'This is shortcode for display testimonails',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'order',
        'label' => 'Order of posts?',
        'type' => 'radio',
        'options' => array(
          'ASC' => 'from oldest to newest',
          'DESC' => 'from newest to oldest',
        )
      ),
      //2nd field
      array(
        'name' => 'limit',
        'label' => 'Number of posts? (for unlimited number write -1',
        'type' => 'text',
      ),
    ) 
  ),//end testimonials shortcode 
  
  
  
  /******************
 * Gallery filter shortcode  
 *
******************/ 

    // 1st shortcode element
    'rt_gallery_filter' => array(
    'name' => 'Gallery filter shortcode RT',
    'description' => 'This is shortcode for display gallery filter posts',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'columns',
        'label' => 'Number of columns?',
        'type' => 'radio',
        'options' => array(
          '3' => '3 columns',
          '4' => '4 columns',
          '2' => '2 columns',
        )
      ),
      //2nd field
      array(
        'name' => 'order',
        'label' => 'Order of posts?',
        'type' => 'radio',
        'options' => array(
          'ASC' => 'from oldest to newest',
          'DESC' => 'from newest to oldest',
        )
      ),
      //3rd field
      array(
        'name' => 'limit',
        'label' => 'Number of posts? (for unlimited number write -1',
        'type' => 'text',
      ),
    ) 
  ),//end gallery filter shortcode 

  
/******************
 * Main headline shortcode  
 *
******************/ 
    // 1st shortcode element
    'mainheadline' => array(
    'name' => 'Main headline shortcode RT',
    'description' => 'Shortcode for display main headline text',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'title',
        'label' => 'Title',
        'type' => 'text',
      ),
      //2nd field
      array(
        'name' => 'subtitle',
        'label' => 'Subtitle',
        'type' => 'text',
      ),
	  //3 field
      array(
        'name' => 'align',
        'label' => 'Align left, center, right.',
        'type' => 'radio',
		'options' => array(
          'text-left' => 'Left',
          'text-center' => 'Center',
          'text-right' => 'Right'
        )
      ),
    ) 
  ),//end main headline shortcode 
  
  
  /******************
 * Divider line shortcode  
 *
******************/ 
    // 1st shortcode element
    'divider_line' => array(
    'name' => 'Divider line shortcode RT',
    'description' => 'Shortcode for space with line',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      array(
        'name' => 'text',
        'label' => '',
        'type' => 'text',
      ),
    )
  ),//end divider line shortcode 
  
  
/******************
 * Divider line2 shortcode  
 *
******************/ 
    // 1st shortcode element
    'divider_line2' => array(
    'name' => 'Divider line2 shortcode RT',
    'description' => 'Shortcode for space with line2',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      array(
        'name' => 'text',
        'label' => '',
        'type' => 'text',
      ),
    )
  ),//end divider line2 shortcode 
  
  
/******************
 * Video box shortcode  
 *
******************/ 
    // 1st shortcode element
    'video_box' => array(
    'name' => 'Video box shortcode RT',
    'description' => 'Shortcode for video box',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      array(
        'name' => 'text',
        'label' => 'text',
        'type' => 'text',
      ),
	  array(
        'name' => 'videourl',
        'label' => 'video url',
        'type' => 'text',
      )
    )
  ),//end video box shortcode   
  
  
  
 /******************
 * Icon shortcode  
 *
******************/ 
    // 1st shortcode element
    'rt_icon1' => array(
    'name' => 'Icon1 shortcode RT',
    'description' => 'Shortcode for icon1',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'title',
        'label' => 'Title',
        'type' => 'text',
      ),
      array(
        'name' => 'text',
        'label' => 'Text',
        'type' => 'text',
      ),
	  array(
        'name' => 'icon',
        'label' => 'Icon e.g icon-call-in. Add any icon from this lists: http://fontawesome.io/icons/ or http://simplelineicons.com/',
        'type' => 'text',
      ),
	  array(
        'name' => 'align',
        'label' => 'align left center or right',
        'type' => 'radio',
        'options' => array(
          'text-left' => 'Left',
          'text-center' => 'Center',
          'text-right' => 'Right'
        )
      ),
	  array(
        'name' => 'width',
        'label' => 'Have one icon in row or more icons in row.',
        'type' => 'radio',
        'options' => array(
          'one-in-row' => 'One in row',
          '' => 'Two and more in row'
        )
      ),
    )
  ),//end icon shortcode  
  
  
  
 /******************
 * Service icon shortcode  
 *
******************/ 
    // 1st shortcode element
    'rt_serviceicon' => array(
    'name' => 'Service icon shortcode RT',
    'description' => 'Shortcode for service icon',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'title',
        'label' => 'Title',
        'type' => 'text',
      ),
      array(
        'name' => 'text',
        'label' => 'Text',
        'type' => 'text',
      ),
	  array(
        'name' => 'icon',
        'label' => 'Icon e.g icon-call-in. Add any icon from this lists: http://fontawesome.io/icons/ or http://simplelineicons.com/',
        'type' => 'text',
      ),
	  array(
        'name' => 'align',
        'label' => 'align left center or right',
        'type' => 'radio',
        'options' => array(
          'text-left' => 'Left',
          'text-center' => 'Center',
          'text-right' => 'Right'
        )
      ),
	  array(
        'name' => 'width',
        'label' => 'Have one icon in row or more icons in row.',
        'type' => 'radio',
        'options' => array(
          'one-in-row' => 'One in row',
          '' => 'Two and more in row'
        )
      ),
	  array(
        'name' => 'whitetext',
        'label' => 'White text color options.',
        'type' => 'radio',
        'options' => array(
          '' => 'default text',
          'whitetext' => 'whitetext'
        )
      ),
    )
  ),//end service icon shortcode  
   
  
  
  
/******************
 * Call to action box shortcode  
 *
******************/ 
    // 1st shortcode element
    'cta_box' => array(
    'name' => 'Call to action box shortcode RT',
    'description' => 'Shortcode for phone (icon) box or any other icons and text',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      array(
        'name' => 'text1',
        'label' => 'Text 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'text2',
        'label' => 'Text 2',
        'type' => 'text',
      ),	  
	  array(
        'name' => 'icon',
        'label' => 'any icon from list can be added here. icon list: http://fontawesome.io/icons/ icon for phone: fa fa-phone',
        'type' => 'text',
      ),
	  array(
        'name' => 'url',
		'label' => 'add here url or skype id',
        'type' => 'text',
      ),
    )
  ),//end cta box shortcode  
  
  
  
  /******************
 * Call to action popup box shortcode  
 *
******************/ 
    // 1st shortcode element
    'cta_popup_box' => array(
    'name' => 'Call to action popup box shortcode RT',
    'description' => 'Shortcode for popup box',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      array(
        'name' => 'text1',
        'label' => 'Text 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'text2',
        'label' => 'Text 2',
        'type' => 'text',
      ),	  
	  array(
        'name' => 'icon',
        'label' => 'any icon from list can be added here. icon list: http://fontawesome.io/icons/ icon for phone: fa fa-phone',
        'type' => 'text',
      ),
	  array(
        'name' => 'class',
		'label' => 'add here popup class',
        'type' => 'text',
      ),
    )
  ),//end cta box shortcode  
  
  
 /******************
 * Button shortcode  
 *
******************/ 
    // 1st shortcode element
    'button' => array(
    'name' => 'Button shortcode RT',
    'description' => 'Shortcode for button',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1st field
      array(
        'name' => 'text',
        'label' => 'Text',
        'type' => 'text',
      ),
      //2nd field
      array(
        'name' => 'url',
        'label' => 'url',
        'type' => 'text',
      ),
      //3rd field
      array(
        'name' => 'color',
        'label' => 'color',
        'type' => 'radio',
        'options' => array(
          'color1' => 'first color (blue)',
          'color2' => 'second color (grey)',
          'color3' => 'third color (dark)',
		  'white' => 'white',
        )
      ),
      //4th field
      array(
        'name' => 'size',
        'label' => 'size',
        'type' => 'radio',
        'options' => array(
          'normal' => 'normal',
		  'large' => 'large',
          'small' => 'small',
        )
      ),
      //5th field
      array(
        'name' => 'position',
        'label' => 'position',
        'type' => 'radio',
        'options' => array(
          'text-left' => 'left',
          'text-center' => 'center',
          'text-right' => 'right',
        )
      ),
      //6th field
      array(
        'name' => 'target',
        'label' => 'open in same or new window',
        'type' => 'radio',
        'options' => array(
          '_self' => 'same window',
          '_blank' => 'new window',
        )
      ),
	  //7 field
      array(
        'name' => 'arrow',
        'label' => 'arrow',
        'type' => 'radio',
        'options' => array(
          'hide' => 'hide',
          'show' => 'show'
        )
      ),
      
    ) 
  ),//end button shortcode 
  
   
/******************
 * Tabs special2 shortcode  
 *
******************/ 
    'tabs_special2' => array(
    'name' => 'RT Tabs special2',
    'description' => 'This is shortcode for display tabs special with 2 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'ID',
        'label' => 'Add unique ID here if you want to add more then one tab per page',
        'type' => 'text',
      ),
      //1 tab
      array(
        'name' => 'iconurl1',
        'label' => 'Add font icon for tab 1 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title1',
        'label' => 'Title 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'image1',
        'label' => 'Upload image for tab 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content1',
        'label' => 'Content for tab 1. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //2 tab
      array(
        'name' => 'iconurl2',
        'label' => 'Add font icon for tab 2 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title2',
        'label' => 'Title 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'image2',
        'label' => 'Upload image for tab 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content2',
        'label' => 'Content for tab 2. Text or html code can be added in text editor here.',
        'type' => 'editor',
      )	  
    ) 
  ),//end main box shortcode  
  
  
/******************
 * Tabs special3 shortcode  
 *
******************/ 
    'tabs_special3' => array(
    'name' => 'RT Tabs special3',
    'description' => 'This is shortcode for display tabs special with 3 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'ID',
        'label' => 'Add unique ID here if you want to add more then one tab per page',
        'type' => 'text',
      ),
      //1 tab
      array(
        'name' => 'iconurl1',
        'label' => 'Add font icon for tab 1 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title1',
        'label' => 'Title 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'image1',
        'label' => 'Upload image for tab 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content1',
        'label' => 'Content for tab 1. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //2 tab
      array(
        'name' => 'iconurl2',
        'label' => 'Add font icon for tab 2 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title2',
        'label' => 'Title 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'image2',
        'label' => 'Upload image for tab 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content2',
        'label' => 'Content for tab 2. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //3 tab
      array(
        'name' => 'iconurl3',
        'label' => 'Add font icon for tab 3 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title3',
        'label' => 'Title 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'image3',
        'label' => 'Upload image for tab 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content3',
        'label' => 'Content for tab 3. Text or html code can be added in text editor here.',
        'type' => 'editor',
      )
    ) 
  ),//end main box shortcode 
  
  
/******************
 * Tabs special4 shortcode  
 *
******************/ 
    'tabs_special4' => array(
    'name' => 'RT Tabs special4',
    'description' => 'This is shortcode for display tabs special with 4 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'ID',
        'label' => 'Add unique ID here if you want to add more then one tab per page',
        'type' => 'text',
      ),
      //1 tab
      array(
        'name' => 'iconurl1',
        'label' => 'Add font icon for tab 1 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title1',
        'label' => 'Title 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'image1',
        'label' => 'Upload image for tab 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content1',
        'label' => 'Content for tab 1. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //2 tab
      array(
        'name' => 'iconurl2',
        'label' => 'Add font icon for tab 2 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title2',
        'label' => 'Title 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'image2',
        'label' => 'Upload image for tab 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content2',
        'label' => 'Content for tab 2. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //3 tab
      array(
        'name' => 'iconurl3',
        'label' => 'Add font icon for tab 3 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title3',
        'label' => 'Title 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'image3',
        'label' => 'Upload image for tab 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content3',
        'label' => 'Content for tab 3. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //4 tab
      array(
        'name' => 'iconurl4',
        'label' => 'Add font icon for tab 4 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title4',
        'label' => 'Title 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'image4',
        'label' => 'Upload image for tab 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content4',
        'label' => 'Content for tab 4. Text or html code can be added in text editor here.',
        'type' => 'editor',
      )
    ) 
  ),//end main box shortcode 
  

/******************
 * Tabs special5 shortcode  
 *
******************/ 
    'tabs_special5' => array(
    'name' => 'RT Tabs special5',
    'description' => 'This is shortcode for display tabs special with 5 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'ID',
        'label' => 'Add unique ID here if you want to add more then one tab per page',
        'type' => 'text',
      ),
      //1 tab
      array(
        'name' => 'iconurl1',
        'label' => 'Add font icon for tab 1 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title1',
        'label' => 'Title 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'image1',
        'label' => 'Upload image for tab 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content1',
        'label' => 'Content for tab 1. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //2 tab
      array(
        'name' => 'iconurl2',
        'label' => 'Add font icon for tab 2 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title2',
        'label' => 'Title 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'image2',
        'label' => 'Upload image for tab 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content2',
        'label' => 'Content for tab 2. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //3 tab
      array(
        'name' => 'iconurl3',
        'label' => 'Add font icon for tab 3 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title3',
        'label' => 'Title 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'image3',
        'label' => 'Upload image for tab 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content3',
        'label' => 'Content for tab 3. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //4 tab
      array(
        'name' => 'iconurl4',
        'label' => 'Add font icon for tab 4 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title4',
        'label' => 'Title 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'image4',
        'label' => 'Upload image for tab 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content4',
        'label' => 'Content for tab 4. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //5 tab
      array(
        'name' => 'iconurl5',
        'label' => 'Add font icon for tab 5 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title5',
        'label' => 'Title 5',
        'type' => 'text',
      ),
	  array(
        'name' => 'image5',
        'label' => 'Upload image for tab 5',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content5',
        'label' => 'Content for tab 5. Text or html code can be added in text editor here.',
        'type' => 'editor',
      )
    ),
  ),//end main box shortcode 
  
  
/******************
 * Tabs special6 shortcode  
 *
******************/ 
    'tabs_special6' => array(
    'name' => 'RT Tabs special6',
    'description' => 'This is shortcode for display tabs special with 6 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
	  array(
        'name' => 'ID',
        'label' => 'Add unique ID here if you want to add more then one tab per page',
        'type' => 'text',
      ),
      //1 tab
      array(
        'name' => 'iconurl1',
        'label' => 'Add font icon for tab 1 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title1',
        'label' => 'Title 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'image1',
        'label' => 'Upload image for tab 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content1',
        'label' => 'Content for tab 1. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //2 tab
      array(
        'name' => 'iconurl2',
        'label' => 'Add font icon for tab 2 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title2',
        'label' => 'Title 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'image2',
        'label' => 'Upload image for tab 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content2',
        'label' => 'Content for tab 2. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),	  
	  //3 tab
      array(
        'name' => 'iconurl3',
        'label' => 'Add font icon for tab 3 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title3',
        'label' => 'Title 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'image3',
        'label' => 'Upload image for tab 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content3',
        'label' => 'Content for tab 3. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //4 tab
      array(
        'name' => 'iconurl4',
        'label' => 'Add font icon for tab 4 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title4',
        'label' => 'Title 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'image4',
        'label' => 'Upload image for tab 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content4',
        'label' => 'Content for tab 4. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //5 tab
      array(
        'name' => 'iconurl5',
        'label' => 'Add font icon for tab 5 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title5',
        'label' => 'Title 5',
        'type' => 'text',
      ),
	  array(
        'name' => 'image5',
        'label' => 'Upload image for tab 5',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content5',
        'label' => 'Content for tab 5. Text or html code can be added in text editor here.',
        'type' => 'editor',
      ),
	  //6 tab
      array(
        'name' => 'iconurl6',
        'label' => 'Add font icon for tab 6 e.g icon-user these are lists of supported icons http://fontawesome.io/icons/ http://simplelineicons.com/',
        'type' => 'text',
      ),
      array(
        'name' => 'title6',
        'label' => 'Title 6',
        'type' => 'text',
      ),
	  array(
        'name' => 'image6',
        'label' => 'Upload image for tab 6',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'content6',
        'label' => 'Content for tab 6. Text or html code can be added in text editor here.',
        'type' => 'editor',
      )
    ) 
  ),//end main box shortcode 
  
  
/******************
 * Services links2 shortcode  
 *
******************/ 
    'services_links2' => array(
    'name' => 'RT Services links2',
    'description' => 'This is shortcode for display service links to inner pages with 2 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1 tab
      array(
        'name' => 'title1',
        'label' => 'Title for service box 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl1',
        'label' => 'Upload image for service box 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url1',
        'label' => 'URL for page 1',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active1',
        'label' => 'Upload icon image for tab 1',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
      //2 tab
      array(
        'name' => 'title2',
        'label' => 'Title for service box 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl2',
        'label' => 'Upload image for service box 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url2',
        'label' => 'URL for page 2',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active2',
        'label' => 'Upload icon image for tab 2',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      )
    ) 
  ),//end main box shortcode  
    

/******************
 * Services links3 shortcode  
 *
******************/ 
    'services_links3' => array(
    'name' => 'RT Services links3',
    'description' => 'This is shortcode for display service links to inner pages with 3 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1 tab
      array(
        'name' => 'title1',
        'label' => 'Title for service box 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl1',
        'label' => 'Upload image for service box 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url1',
        'label' => 'URL for page 1',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active1',
        'label' => 'Upload icon image for tab 1',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
      //2 tab
      array(
        'name' => 'title2',
        'label' => 'Title for service box 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl2',
        'label' => 'Upload image for service box 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url2',
        'label' => 'URL for page 2',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active2',
        'label' => 'Upload icon image for tab 2',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //3 tab
      array(
        'name' => 'title3',
        'label' => 'Title for service box 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl3',
        'label' => 'Upload image for service box 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url3',
        'label' => 'URL for page 3',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active3',
        'label' => 'Upload icon image for tab 3',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      )
    ) 
  ),//end main box shortcode  
	

/******************
 * Services links4 shortcode  
 *
******************/ 
    'services_links4' => array(
    'name' => 'RT Services links4',
    'description' => 'This is shortcode for display service links to inner pages with 4 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1 tab
      array(
        'name' => 'title1',
        'label' => 'Title for service box 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl1',
        'label' => 'Upload image for service box 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url1',
        'label' => 'URL for page 1',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active1',
        'label' => 'Upload icon image for tab 1',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
      //2 tab
      array(
        'name' => 'title2',
        'label' => 'Title for service box 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl2',
        'label' => 'Upload image for service box 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url2',
        'label' => 'URL for page 2',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active2',
        'label' => 'Upload icon image for tab 2',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //3 tab
      array(
        'name' => 'title3',
        'label' => 'Title for service box 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl3',
        'label' => 'Upload image for service box 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url3',
        'label' => 'URL for page 3',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active3',
        'label' => 'Upload icon image for tab 3',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //4 tab
      array(
        'name' => 'title4',
        'label' => 'Title for service box 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl4',
        'label' => 'Upload image for service box 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url4',
        'label' => 'URL for page 4',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active4',
        'label' => 'Upload icon image for tab 4',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      )
    ) 
  ),//end main box shortcode  	
	
	
/******************
 * Services links5 shortcode  
 *
******************/ 
    'services_links5' => array(
    'name' => 'RT Services links5',
    'description' => 'This is shortcode for display service links to inner pages with 5 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1 tab
      array(
        'name' => 'title1',
        'label' => 'Title for service box 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl1',
        'label' => 'Upload image for service box 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url1',
        'label' => 'URL for page 1',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active1',
        'label' => 'Upload icon image for tab 1',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
      //2 tab
      array(
        'name' => 'title2',
        'label' => 'Title for service box 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl2',
        'label' => 'Upload image for service box 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url2',
        'label' => 'URL for page 2',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active2',
        'label' => 'Upload icon image for tab 2',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //3 tab
      array(
        'name' => 'title3',
        'label' => 'Title for service box 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl3',
        'label' => 'Upload image for service box 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url3',
        'label' => 'URL for page 3',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active3',
        'label' => 'Upload icon image for tab 3',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //4 tab
      array(
        'name' => 'title4',
        'label' => 'Title for service box 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl4',
        'label' => 'Upload image for service box 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url4',
        'label' => 'URL for page 4',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active4',
        'label' => 'Upload icon image for tab 4',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //5 tab
      array(
        'name' => 'title5',
        'label' => 'Title for service box 5',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl5',
        'label' => 'Upload image for service box 5',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url5',
        'label' => 'URL for page 5',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active5',
        'label' => 'Upload icon image for tab 5',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      )
    ) 
  ),//end main box shortcode  		
	
	
		
/******************
 * Services links6 shortcode  
 *
******************/ 
    'services_links6' => array(
    'name' => 'RT Services links6',
    'description' => 'This is shortcode for display service links to inner pages with 6 columns.',
    'icon' => 'my-class-icon',
    'category' => 'Content',
    'params' => array(
      //1 tab
      array(
        'name' => 'title1',
        'label' => 'Title for service box 1',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl1',
        'label' => 'Upload image for service box 1',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url1',
        'label' => 'URL for page 1',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active1',
        'label' => 'Upload icon image for tab 1',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
      //2 tab
      array(
        'name' => 'title2',
        'label' => 'Title for service box 2',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl2',
        'label' => 'Upload image for service box 2',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url2',
        'label' => 'URL for page 2',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active2',
        'label' => 'Upload icon image for tab 2',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //3 tab
      array(
        'name' => 'title3',
        'label' => 'Title for service box 3',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl3',
        'label' => 'Upload image for service box 3',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url3',
        'label' => 'URL for page 3',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active3',
        'label' => 'Upload icon image for tab 3',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //4 tab
      array(
        'name' => 'title4',
        'label' => 'Title for service box 4',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl4',
        'label' => 'Upload image for service box 4',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url4',
        'label' => 'URL for page 4',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active4',
        'label' => 'Upload icon image for tab 4',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //5 tab
      array(
        'name' => 'title5',
        'label' => 'Title for service box 5',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl5',
        'label' => 'Upload image for service box 5',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url5',
        'label' => 'URL for page 5',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active5',
        'label' => 'Upload icon image for tab 5',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      ),
	  //6 tab
      array(
        'name' => 'title6',
        'label' => 'Title for service box 6',
        'type' => 'text',
      ),
	  array(
        'name' => 'imgurl6',
        'label' => 'Upload image for service box 6',
        'type' => 'attach_image_url',
      ),
      array(
        'name' => 'url6',
        'label' => 'URL for page 6',
        'type' => 'text',
      ),	  
      array (
        'name' => 'active6',
        'label' => 'Upload icon image for tab 6',
        'type' => 'radio',
        'options' => array(
          'active' => 'current page',
          '' => 'not current page'
        )	 
      )
    ) 
  ),//end main box shortcode  		
	
	
)
);// end map
 
}// end rt_healthinsurance_wp_init