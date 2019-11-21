$(document).ready(function(){
	
$(".owl-carousel").owlCarousel({
    margin: 0,
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


// Select tab by url

  var hash = window.location.hash;
  hash && $('ul.nav a[href="' + hash + '"]').tab('show');

  $('.nav-tabs a').click(function (e) {
    $(this).tab('show');
    //var scrollmem = $('body').scrollTop();
    window.location.hash = this.hash;
    //$('html,body').scrollTop(scrollmem);
  });

// Ajax quick search top
	  $("#quick_find_keyword_header").keyup(function(){
	      var searchString = $("#quick_find_keyword_header").val(); 
	      $.ajax({
	      	url: "index_ajax.php",             
	      	dataType : "html",
	      	type: "POST",
	      	data: "q=includes/modules/ajax/ajaxQuickFind.php&keywords="+searchString,
	      	success: function(msg){$("#ajaxQuickFindHeader").html(msg);}            
	 });     
	   });

// Bootstrap carousel equal heights
function normalizeSlideHeights() {
    $('.carousel').each(function(){
      var items = $('.carousel-item', this);
      // reset the height
      items.css('min-height', 0);
      // set the height
      var maxHeight = Math.max.apply(null, 
          items.map(function(){
              return $(this).outerHeight()}).get() );
      items.css('min-height', maxHeight + 'px');
    })
}

$(window).on(
    'load resize orientationchange', 
    normalizeSlideHeights);
    
// Ajax quick search
  $("#quick_find_keyword").keyup(function(){
      var searchString = $("#quick_find_keyword").val(); 
      $.ajax({
      	url: "index_ajax.php",             
      	dataType : "html",
      	type: "POST",
      	data: "q=includes/modules/ajax/ajaxQuickFind.php&keywords="+searchString,
      	success: function(msg){$("#ajaxQuickFind").html(msg);}            
 });     
                           
                           
   });


});

// Plus minus at product listing
$(document).on('click','.value-control',function(){
    var action = $(this).attr('data-action')
    var target = $(this).attr('data-target')
    var value  = parseFloat($('[id="'+target+'"]').val());
    if ( action == "plus" ) {
      value++;
    }
    if ( action == "minus" ) {
      value--;
    }
    $('[id="'+target+'"]').val(value)
})

// Register service worker to control making site work offline

$(function(){
	
if('serviceWorker' in navigator) {
  navigator.serviceWorker
           .register('/sw.js')
           .then(function() { console.log('Service Worker Registered'); });
}

// Code to handle install prompt on desktop

let deferredPrompt;
const addBtn = document.querySelector('.a2hs-button');
if (addBtn != null) {
addBtn.style.display = 'none';

window.addEventListener('beforeinstallprompt', (e) => {
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  // Update UI to notify the user they can add to home screen
  addBtn.style.display = 'block';

  addBtn.addEventListener('click', (e) => {
    // hide our user interface that shows our A2HS button
    addBtn.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then((choiceResult) => {
        if (choiceResult.outcome === 'accepted') {
          console.log('User accepted the A2HS prompt');
        } else {
          console.log('User dismissed the A2HS prompt');
        }
        deferredPrompt = null;
      });
  });
});
}

});

// Geo Modal
			$(function() {
				$("#vamshop-city").autocomplete({
                  appendTo: "#vamshop-cities",
					source : function(request, response) {
						$.ajax({
							url : "https://api.cdek.ru/city/getListByTerm/jsonp.php?callback=?",
							dataType : "jsonp",
							data : {
								q : function() {
									return $("#vamshop-city").val()
								},
								name_startsWith : function() {
									return $("#vamshop-city").val()
								}
							},
							success : function(data) {
								response($.map(data.geonames, function(item) {
									return {
										label : item.cityName,
										value : item.cityName,
										id : item.id
									}
								}));
							}
						});
					},
					minLength : 1,
					select : function(event, ui) {
						//console.log("Yep!");
						//$('#receiverCityId').val(ui.item.id);
					}
});
});            

  $(function() {
$("#submit-modal1").on("click", function(e) {
    e.preventDefault();
   $.cookie("vamshop-city", $("#vamshop-city").val(), { expires : 10, path: "/" });
    location.reload();
});
});           

//Cookie alert
$('#cookie-alert').on('closed.bs.alert', function (e) {
    e.preventDefault();
   $.cookie("cookie-alert", 1, { expires : 365, path: "/" });
})