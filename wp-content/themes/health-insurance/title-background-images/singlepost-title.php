<header class="singletitlebg bubbleswrapper">
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
        <h1 class="entry-title"><?php the_title(); ?></h1>
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