"use strict";

(function($) {
  
  function clearCf7Loader() {
    $('.preloader').stop(true, true).remove();
    $('body').css({ opacity: 1, display: '' });
    $('.wpcf7-form').removeClass('submitting');
  }

  document.addEventListener('wpcf7submit', clearCf7Loader);
  document.addEventListener('wpcf7invalid', clearCf7Loader);
  document.addEventListener('wpcf7mailfailed', clearCf7Loader);
  document.addEventListener('wpcf7spam', clearCf7Loader);

  var skipPreloader = window.location.hash && window.location.hash.indexOf('wpcf7') !== -1;

  //preloader — only fade the overlay; do not hide body (breaks Revolution Slider lazy-load)
  if (!skipPreloader) {
    $('.preloader').fadeOut(800, function() {
      $(this).remove();
    });
  } else {
    clearCf7Loader();
  }

  
  //animations
  var foo2 = $('.startAnimation');
  foo2.css('opacity', 0);
  foo2.waypoint(function() {
  var animationclass = $(this).attr('data-animate');
  $(this).css('opacity', '1');
  $(this).addClass("animated " + animationclass);
  },{offset: '100%', triggerOnce: true});

    //scrollspy (only if Bootstrap loaded – requires jQuery <3 with unpatched Bootstrap)
  if ($.fn.scrollspy) {
    $('body').scrollspy({ target: '#navbar-scroll' });
  }
  $('.menu__list > li:first-child').addClass('active');
  $('.menu__list > li:nth-child(2)').removeClass('active');
  $('.innerpage.menu__list > li:first-child').removeClass('active');
  $('.innerpage.menu__list > li.current').addClass('active');
  
  
  //double menu
  var options = {
    offset: '.menuswitch',
    offsetSide: 'top',
    classes: {
      clone:   'banner--clone',
      stick:   'banner--stick',
      unstick: 'banner--unstick'
    }
  };
  var banner = new Headhesive('.headhesive', options);  
  
  
  // on mobile button menu click
  var sideslider = $('[data-toggle=collapse-side]');
  var se1 = sideslider.attr('data-target1');
  var se2 = sideslider.attr('data-target2');
  var se3 = sideslider.attr('data-target3');
  var se4 = sideslider.attr('data-target4');
  var se5 = sideslider.attr('data-target5'); 
    sideslider.on("click", function(event){
      $(se1).toggleClass('in');
      $(se2).toggleClass('out');
      $(se3).toggleClass('navbarclick');
      $(se4).toggleClass('bodybackground-activated');
      $(se5).toggleClass('open2');
    });
     

    //scroll to top function
    var ascroll = 300;
    $(window).scroll(function() {
    var foo5 = $(".scrollbutton a");  
	  if ( $(window).scrollTop() > ascroll ) {
		  foo5.fadeIn('slow');
	  } else {
		  foo5.fadeOut('slow');
	  }
    });
    $('.scrollbutton a').on("click", function() {
	  $('html, body').animate({
		  scrollTop: 0
	  }, 700);
	  return false;
    });

  // Parent menu items: toggle submenu on desktop only (mobile panel handled in riskwisdom-ui.js).
  $(document).on('click', '.menu__list li.menu-item-has-children > a', function(e) {
    var $link = $(this);

    if ($link.closest('.side-collapse').length && $(window).width() < 992) {
      return;
    }

    e.preventDefault();
    e.stopPropagation();

    var $li = $link.closest('li.menu-item-has-children');
    var $sub = $li.children('ul.sub-menu');
    $li.toggleClass('open');
    if ($sub.length) {
      $sub.slideToggle(200);
    }
  });

  //function for media queries setup
  smallscreen();
  $(window).on("resize", function () {
    smallscreen();
  }); 

  
  //media queries function for dropdown menu
  function smallscreen(){
   
  if ( $(window).width() >= 992 ) { 
    
    //dropdown menu link on hover second level
    $('.navbarinner .menu__list li').on("mouseenter", function(){ 
      $(this).addClass('open');
    });    
    $('.navbarinner .menu__list li').on("mouseleave", function(){ 
      $(this).removeClass('open');
    });    
    
    //dropdown menu link on hover third level
    $('.navbarinner .menu__list li ul li').on("mouseenter", function(){ 
      $('.navbarinner .menu__list li ul li ul').addClass('open');
    });    
    $('.navbarinner .menu__list li ul li').on("mouseleave", function(){ 
      $('.navbarinner .menu__list li ul li ul').removeClass('open');
    });
      
  }   
  else if ( $(window).width() < 992 ){
    // Mobile submenu toggles are handled in riskwisdom-ui.js (capture phase).
  }
  };


  var $grid = $('.masonry1grid').imagesLoaded( function() {
  // masonry for blogpage templates
    $grid.masonry({
      itemSelector: '.masonry-grid-item1' 
    });
  });
  

   var $grid1 = $('#masonrycontainer2').imagesLoaded( function() {
  // masonry for blog blogindex page
    $grid1.masonry({
      itemSelector: '.masonrys' 
    });
  });
  
    
  
    //menu scroll — only in-page anchors with a real target (skip bare "#")
  $('.navbar a[href^="#"]').on('click', function(e) {
  var target = this.hash;
  if (!target || target === '#') {
    return;
  }
  var $target = $(target);
  if (!$target.length || typeof $target.offset() === 'undefined') {
    return;
  }
  e.preventDefault();
  $('html, body').stop().animate({
    'scrollTop': $target.offset().top
  }, 500, 'swing', function() {
    window.location.hash = target;
  });
  }); 
  
  
 // init Isotope
  var $container = $('#isotopecontainer').isotope({
    itemSelector: '.element-isotope',
    layoutMode: 'masonry',
    getSortData: {
      name: '.name',
      symbol: '.symbol',
      number: '.number parseInt',
      category: '[data-category]',
      weight: function( itemElem ) {
        var weight = $( itemElem ).find('.weight').text();
        return parseFloat( weight.replace( /[\(\)]/g, '') );
      }
    }
  });
  $container.imagesLoaded( function() {
    $container.isotope('layout');
  });
  // filter functions
  var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function() {
      var number = $(this).find('.number').text();
      return parseInt( number, 10 ) > 50;
    },
    // show if name ends with -ium
    ium: function() {
      var name = $(this).find('.name').text();
      return name.match( /ium$/ );
    }
  };
  // bind filter button click
  $('#filters').on( 'click', 'button', function() {
    var filterValue = $( this ).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[ filterValue ] || filterValue;
    $container.isotope({ filter: filterValue });
  }); 
  // change active class on buttons
  $('.button-group').each( function( i, buttonGroup ) {
    var $buttonGroup = $( buttonGroup );
    $buttonGroup.on( 'click', 'button', function() {
      $buttonGroup.find('.active').removeClass('active');
      $( this ).addClass('active');
    });
  }); 
// init Isotope end
  
    //colorbox lightbox image
  $('.imagepopup').colorbox({maxWidth:'70%', maxHeight:'70%', rel:'gal'});
  
   //colorbox video
  $('.youtube').colorbox({iframe:true, innerWidth:640, innerHeight:390});
  
  //colorbox lightbox video
  $(".popup").colorbox({iframe:true, innerWidth:640, innerHeight:390});   

  // range slider
  $(".rangeexample").ionRangeSlider({
    min: 100,
    max: 1000,
    from: 450,
	step: 1,
	hide_min_max: true,
	prefix: "$ ",
	postfix: ",00",
  });

			
})(jQuery);