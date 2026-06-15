<!-- primary navigation for single page -->	
  <div id="home"></div> 
  <header>     
  <div class="top widgets-style1"> 
    <div class="top1"> 
      <div class="container widgets-style2">   
        <div class="row">   
	      <div class="col-sm-6">   
            <?php if ( is_active_sidebar( 'sidebar-3ha' ) ) : ?>
             <?php dynamic_sidebar( 'sidebar-3ha' ); ?>	
            <?php endif; ?>
	      </div>
	      <div class="col-sm-6 text-right">   
            <?php if ( is_active_sidebar( 'sidebar-3hb' ) ) : ?>
            <?php dynamic_sidebar( 'sidebar-3hb' ); ?>	
            <?php endif; ?>
	      </div>
        </div>
	  </div>
	</div>		
    <div class="top2"> 
      <div class="container widgets-style1">   
        <div class="row"> 
		<div class="col-lg-3 col-xs-12"> 
		 <div class="navbar-brand">
          <?php if ( get_theme_mod( 'logo' ) ) : ?>
            <div class='site-logo'>
              <a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'>
                <img src='<?php echo esc_url( get_theme_mod( 'logo' ) ); ?>' alt='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>'>
              </a>
            </div>
          <?php else : ?>
          <hgroup class="sitetitle">
            <h2 class='site-title'><a href='<?php echo esc_url( home_url( '/' ) ); ?>' title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' rel='home'><?php bloginfo( 'name' ); ?></a></h2>
            <h2 class='site-description'><?php bloginfo( 'description' ); ?></h2>
          </hgroup>
          <?php endif; ?>
          </div>
		  </div>
		  <div class="col-lg-9 col-xs-12"> 
            <?php if ( is_active_sidebar( 'sidebar-3h2' ) ) : ?>
            <?php dynamic_sidebar( 'sidebar-3h2' ); ?>	
            <?php endif; ?>
		  </div>
        </div>
	  </div>
    </div>
  </div>
  <?php
  if ( function_exists( 'riskwisdom_ui_mobile_topbar' ) ) {
	  riskwisdom_ui_mobile_topbar();
  }
  ?>
  <!-- menu -->
    <div class="headhesive-wrapper">
    <div class="headhesive" id="navbar-scroll">
      <nav class="navbar menu menu--prospero"> 
        <div class="navbarinner"> 		
		<div class="container">   
        <div class="row">   
          <div class="navbar-header">  
            <button id="toggle-icon2" class="navbar-toggle" type="button" aria-label="<?php esc_attr_e( 'Open menu', 'health-insurance' ); ?>" data-toggle="collapse-side" 
              data-target1=".side-collapse" 
              data-target2=".side-collapse-container"
              data-target3=".navbar" 
              data-target4=".bodybackground" 
              data-target5=".navbar-toggle" >
              <span></span>
            </button>
          </div>
          <div role="navigation" class="side-collapse in navbar-collapse navbar-ex1-collapse"> 
          <?php wp_nav_menu( array( 
            'theme_location' => 'primary-menu',
            'fallback_cb' => 'rt_healthinsurance_default_menu',
            'menu' => 'top_menu',
            'menu_class' => 'innerpage menu__list nav navbar-nav'
            )
          );
          ?>
          </div>
		</div>
		</div>  
		</div> 
      </nav> 
    </div>
    </div>
  </header>   
  <div class="menuswitch"></div> 