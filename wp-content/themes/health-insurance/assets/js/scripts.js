"use strict";

(function($) {
  
  //preloader
  var foo3 = $('body');
  foo3.fadeOut(100);  
  $('.preloader').fadeOut(800,function(){$(this).remove();})
  foo3.fadeIn(1000);

  
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

  // Services (and any parent) menu: prevent link navigation and toggle dropdown on click
  $(document).on('click', '.menu__list li.menu-item-has-children > a, .menu-item-has-children > a', function(e) {
    e.preventDefault();
    e.stopPropagation();
    var $li = $(this).closest('li.menu-item-has-children');
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
        
    //dropdown menu link on hover second level
    $('.navbarinner .menu__list li').on("click", function(){ 
      $(this).toggleClass('open');
    });     
    
    //dropdown menu link on hover third level
    $('.navbarinner .menu__list li ul li').on("click", function(){ 
      $('.navbarinner .menu__list li ul li ul').toggleClass('open');
    });    
    
    //dropdown menu link prevent closing on click on phones 
    $('.navbarinner .menu__list li').on("click", function(event){
      event.stopPropagation();        
    });

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
  
    
  
    //menu scroll
  var menu = $('.navbar');
    $(window).scroll(function() {
  });
  $('.navbar a[href^="#"]').on('click', function(e) {
  e.preventDefault();
  var target = this.hash,
  $target = $(target);
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