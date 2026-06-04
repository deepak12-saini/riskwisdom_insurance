<?php
/**
 * Template for footer
 *
 */
?>     
<footer class="bottom">
  <div class="container widgets-style2">
	  <div class="row">
      <div class="col-sm-3">   
        <?php if ( is_active_sidebar( 'sidebar-3' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-3' ); ?>	
        <?php endif; ?>
      </div>
		<div class="col-sm-3">   
        <?php if ( is_active_sidebar( 'sidebar-4' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-4' ); ?>	
        <?php endif; ?>
      </div>
		<div class="col-sm-3">   
        <?php if ( is_active_sidebar( 'sidebar-5' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-5' ); ?>	
        <?php endif; ?>
      </div>
	  <div class="col-sm-3">   
        <?php if ( is_active_sidebar( 'sidebar-6' ) ) : ?>
        <?php dynamic_sidebar( 'sidebar-6' ); ?>	
        <?php endif; ?>
      </div>
    </div>
  </div> 
  <div class="container">
  <div class="row">
    <div class="scrollbutton">
      <a href="#"><i class="fa fa-chevron-up"></i></a>
    </div> 
  </div>
  <div class="row">
  
    <div class="col-lg-12 copyright">   
		<p style="text-align:center;">
		Authorised Representative for: Lionsgate Financial Group Pty Ltd ABN 9214 059 1484 Australian Financial Services Licensee Licence Number 342 766
		<br>
		Lionsgate Financial Group Pty Ltd address – Suite 1402, 122 Arthur St, North Sydney NSW 2060
		<br>
		Information provided on this website is general in nature and does not constitute financial advice.
		</p>
      <!--p>
	    <?php echo wp_kses_post( get_theme_mod ('copyright_detailstext')); ?>
	    </p-->
    </div>
  </div>
  </div>

</footer>
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/561cb89e4cce476c061fe61c/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->

<?php wp_footer(); ?>
</body>
</html>