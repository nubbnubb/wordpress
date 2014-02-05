//==============================================================
// CUSTOM SCRIPTS
// Author: Sampression Themes  (http://sampression.com)
// 2013
// =============================================================
(function($) {

// this fixes post spacing issue  when image is set to 100%
setTimeout(function(){$(window).resize()},2000); // This triggers window resize 1 second after dom is ready

// For Primary Navigation	
var minHt = 28; // Minimum height for Navigation
var ulHt = getTotalHt($('#primary-nav').find('ul')) || 28; // Getting the height of Navigation

//show the sneak peek of all categories
if( minHt < ulHt ) {
	$('#btn-nav-opt').show();
	$('#primary-nav .sixteen')
	.animate({ 'height' : ulHt },300,function(){
		$('#btn-nav-opt').addClass('up');
	})
	.delay( 300)
	.animate({ 'height' : minHt },1000,function(){
		$('#btn-nav-opt').removeClass('up');
	});
}

//==============================================================
// Toggle Height of the Primary Navigation
// =============================================================
$('#btn-nav-opt').click(function(){
	if($(this).hasClass('up')){
		$('#primary-nav .sixteen').animate({ 'height' : minHt } );
		$(this).removeClass('up');
	}else{
		$('#primary-nav .sixteen').animate({ 'height' : ulHt });
		$(this).addClass('up');
	}
	return false;
});
//==============================================================
// WordPress specialist:
// get Widget title as a widget class
// ==============================================================

$('.widget').each( function(){
	var widgetTitle = $(this).find('.widget-title').text();
	var widgetTitleSlug = widgetTitle.replace(/ /gi, "-");
	widgetTitleSlug = widgetTitleSlug.toLowerCase();
	widgetTitleSlug = "widget-" + widgetTitleSlug;
	$(this).addClass(widgetTitleSlug);
});


//==============================================================
// get Sticky menu
// ==============================================================
if($('body').hasClass('home')){ 	// enable sticky menu only on homepage
	$(window).scroll( function() {
		if ($(window).scrollTop() > getTotalHt('#header')){
			$('#primary-nav').addClass('fixed');
			$('.btn-top').addClass('fixed');
			$('#content-wrapper').css('padding-top',minHt+30);
			
		} else {
			$('#primary-nav').removeClass('fixed');
			$('.btn-top').removeClass('fixed');
			$('#content-wrapper').css('padding-top','20px');
		}
	} );
}

$('.menu-primary-menu-container select').change(function(){
	var currentpage = $(this).val();
	$(location).attr('href','?page_id='+currentpage);
}); 

$('.menu-item').hover(
	function(e){
	e.stopPropagation();
	$(this).children('ul').fadeIn();
	},
	function(e){
	e.stopPropagation();
	$(this).children('ul').delay(100).fadeOut();
	}
); 

	// Create the label 'Menu:'
	$("#top-nav-mobile").append($("<div />",{"class":"nav-label"}).html("Menu:"));
	
	// Create the dropdown select element
	$("<select />",{"class":"top-menu-nav"}).insertAfter("#top-nav-mobile .nav-label");
	
    // Create default option "Go to"
	$("<option />", {
			 "selected": "selected",
			 "value"   : "",
			 "text"    : "Go To"
	}).appendTo(" #top-nav-mobile select");
	  
    // Populate dropdown with menu items
	recursiveDropdown($("nav#top-nav > ul ").children('li'),'');
	
	// Recursive function for multilevel menu
	function recursiveDropdown(elem, dash){
		elem.each(function(){
			var el = $(this), anchor = $('> a', this);
			var sl = $("<option />", {
						"value"   : anchor.attr("href"),
						"text"    : dash+anchor.text()
					});
			if(el.children('ul').length>0){  //contains next level 
				$("#top-nav-mobile select").append(sl);
				recursiveDropdown(el.children('ul').children('li'), dash+'-'); //grab them
			}else{
				$("#top-nav-mobile select").append(sl);
			}	
		});	
	}
	  
	// To make dropdown actually work
    $("select.top-menu-nav").change(function() {
        window.location = $(this).find("option:selected").val();
    }); 
	 
	$('#page_id').change(function(){
		var currentpage = $(this).val();
		$(location).attr('href','?page_id='+currentpage);
	});
})(jQuery);
// end ready function here.

//==============================================================
// scroll Particular Point
// ==============================================================
function pageScroll(scrollPoint,time){ // obj: click object, scrollPoint:Location to reach on page scroll
    var divOffset = jQuery(scrollPoint).offset().top;      
    jQuery('html,body').delay(time||0).animate({scrollTop: divOffset}, 500); 
}
//==============================================================
// jQuery isotope
// ==============================================================

  jQuery.Isotope.prototype._masonryResizeChanged = function() {
    return true;
  };

  jQuery.Isotope.prototype._masonryReset = function() {
    // layout-specific props
    this.masonry = {};
    this._getSegments();
    var i = this.masonry.cols;
    this.masonry.colYs = [];
    while (i--) {
      this.masonry.colYs.push( 0 );
    }
  
    if ( this.options.masonry.cornerStampSelector ) {
      var $cornerStamp = this.element.find( this.options.masonry.cornerStampSelector ),
          stampWidth = $cornerStamp.outerWidth(true) - ( this.element.width() % this.masonry.columnWidth ),
          cornerCols = Math.ceil( stampWidth / this.masonry.columnWidth ),
          cornerStampHeight = $cornerStamp.outerHeight(true);
    //  for ( i = Math.max( this.masonry.cols - cornerCols, cornerCols ); i < this.masonry.cols; i++ ) {
		for ( i = ( this.masonry.cols - cornerCols ); i < this.masonry.cols; i++ ) {
        this.masonry.colYs[i] = cornerStampHeight;
      }
    }
  };

jQuery(function(){
var $container = jQuery('#post-listing');
$container.isotope({
	 itemSelector: '.item',
	 masonry : {
        cornerStampSelector: '.corner-stamp',
		columnWidth: $container.width() / 4
		
      }
});

var selector = '';
jQuery('.nav-listing li a').click(function(){

  selector = jQuery(this).attr('data-filter');  
	$all = jQuery('.nav-listing li a[data-filter="*"]');
	
	var num_selected = jQuery('.nav-listing li a.selected').length;  //get total count of selected options before clicking
	
	/* if show all option clicked */
  if( selector == "*" ){
		jQuery('.nav-listing li a').removeClass('selected');		
		jQuery(this).addClass('selected');						
	/* - if any category option clicked and its already selected, it should unfiltered 
		- show all option is not selected
		- num of other options selected is more than 1 */	
	}else if( jQuery(this).hasClass('selected') && !$all.hasClass('selected')){
		jQuery(this).removeClass('selected');				
	/* - if any category option clicked, it should added
		 - show all option is not selected
		 - num of other options selected is more than 1 */	
	}else if( !jQuery(this).hasClass('selected') && !$all.hasClass('selected') ){		
		jQuery(this).addClass('selected');
	}else{
		jQuery('.nav-listing li a').removeClass('selected');
		jQuery(this).addClass('selected');	
	}
	
	
  num_selected = jQuery('.nav-listing li a.selected').length;  //get total count of selected options after clicking
	
	/*If non of the option selected then show all*/
	if( num_selected == 0 ){		
		$all.addClass('selected');
		selector = $all.attr('data-filter');  
	}
	
	var isoFilters = [];
	if( num_selected>0 && !$all.hasClass('selected') ){
		optionsList = jQuery('.nav-listing li a.selected');		
		
		for( i=0; i<num_selected; i++){			
			isoFilters.push( optionsList.eq(i).attr('data-filter') );
		}		
		selector = isoFilters.join();
	}
	//alert(selector);
	
	$container.isotope({ filter: selector });
	
	//calling append function
	appenditem(this.id);
	jQuery('#primary-nav .sixteen').animate({ 'height' : 28 },function(){
		jQuery('#btn-nav-opt').removeClass('up');
		pageScroll('#primary-nav-scroll',700); //scrolling page to the top when user clicks  on categories
		setTimeout(function(){jQuery(window).resize()},20); 
	});
	
  return false;
});


jQuery('#get-cats').change(function(){

  var selector = jQuery(this).val();
  $container.isotope({ filter: selector });
  selector = selector.replace(".","");
	appenditem(selector);
	pageScroll('#primary-nav-scroll',700); //scrolling page to the top when user changes categories
  return false;
}); 
 
});

// update columnWidth on window resize
    jQuery(window).smartresize(function(){
		var $container = jQuery('#post-listing');
      $container.isotope({
        // set columnWidth to a percentage of container width
        masonry: {
          columnWidth: $container.width() / 4
        }
      });
	  
    });


//==============================================================
// Get Total Height
// ==============================================================

function getTotalHt(obj, addPadding, addMargin, addBorder){
	if(jQuery(obj).is(':hidden')) return false;
	
    addPadding = typeof addPadding == 'undefined' ? 1 : addPadding;
    addMargin = typeof addMargin == 'undefined' ? 1 : addMargin;
    addBorder = typeof addBorder == 'undefined' ? 1 : addBorder;
    
    var totalHt = jQuery(obj).height();
    if( addPadding == 1){
    totalHt += parseInt(jQuery(obj).css('padding-top'));
    totalHt += parseInt(jQuery(obj).css('padding-bottom'));
    }
    if( addMargin == 1){
    totalHt += parseInt(jQuery(obj).css('margin-top'));
    totalHt += parseInt(jQuery(obj).css('margin-bottom'));
    }
    if( addBorder == 1){
    totalHt += parseInt(jQuery(obj).css('borderTopWidth'));
    totalHt += parseInt(jQuery(obj).css('borderBottomWidth'));
    }
    
    return totalHt;
}

//==============================================================
// Hide the Address Bar in MobileSafari
// =============================================================

addEventListener("load", function() { setTimeout(
hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); }