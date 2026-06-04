<?php
/**
 * default search form
 */
?>
<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="submit" class="search-submit" value="" />
	<label>
		<span class="screen-reader-text"> <?php esc_html__('Search for: ', 'health-insurance') ?> </span>
		<input type="search" class="search-field" placeholder="Search …" value="" name="s" title="Search for:" />
	</label>
	
</form>