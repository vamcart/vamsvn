<?php 
header('Content-Type: application/javascript');

include_once(dirname_r($_SERVER['SCRIPT_FILENAME'],4).'/jscript/jquery/jquery.js');
echo "\n";
//include_once(dirname($_SERVER['SCRIPT_FILENAME']).'/jquery-3.3.1.slim.min.js');
echo "\n";
include_once(dirname_r($_SERVER['SCRIPT_FILENAME']).'/popper.min.js');
echo "\n";
include_once(dirname_r($_SERVER['SCRIPT_FILENAME']).'/bootstrap.min.js');
echo "\n";
include_once(dirname_r($_SERVER['SCRIPT_FILENAME'],4).'/jscript/jquery/plugins/owl/owl.carousel.min.js');
echo "\n";
include_once(dirname_r($_SERVER['SCRIPT_FILENAME'],4).'/jscript/jquery/plugins/scrollup/jquery.scrollup.min.js');
echo "\n";

?>

$(document).ready(function(){
	
$(".owl-carousel").owlCarousel({
    margin: 10,
    nav: true,
    loop:false,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-2x"></span>','<span class="fas fa-chevron-right fa-2x"></span>'],
    responsive:{
        0:{
            items:1,
            nav:true
        },
        576:{
            items:2,
            nav:true
        },
        768:{
            items:3,
            nav:true
        },
        992:{
            items:3,
            nav:true,
            loop:false
        },
        1200:{
            items:4,
            nav:true,
            loop:false
        }
    }
})

// Scroll to top button 
	$(function () {
		$.scrollUp({
	        scrollName: 'scrollup', // Element ID
	        scrollDistance: 200, // Distance from top/bottom before showing element (px)
	        scrollFrom: 'top', // 'top' or 'bottom'
	        scrollSpeed: 500, // Speed back to top (ms)
	        easingType: 'linear', // Scroll to top easing (see http://easings.net/)
	        animation: 'fade', // Fade, slide, none
	        animationSpeed: 500, // Animation in speed (ms)
	        scrollTrigger: false, // Set a custom triggering element. Can be an HTML string or jQuery object
					//scrollTarget: false, // Set a custom target element for scrolling to the top
	        scrollText: '<i class="fa fa-chevron-up"></i>', // Text for element, can contain HTML
	        scrollTitle: false, // Set a custom <a> title if required.
	        scrollImg: false, // Set true to use image
	        activeOverlay: false, // Set CSS color to display scrollUp active point, e.g '#00FFFF'
	        zIndex: 2147483647 // Z-Index for the overlay
		});
	});


});

<?php 

//PHP < 7 compatibility 

function dirname_r($path, $count=1){
    if ($count > 1){
       return dirname(dirname_r($path, --$count));
    }else{
       return dirname($path);
    }
}

?>
