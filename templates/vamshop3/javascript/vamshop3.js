$(document).ready(function(){
	
$(".owl-carousel").owlCarousel({
    margin: 0,
    nav: true,
    loop:false,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-3x"></span>','<span class="fas fa-chevron-right fa-3x"></span>'],
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
        },
        1200:{
            items:4,
            nav:true,
            loop:false
        },
        1440:{
            items:5,
            nav:true,
            loop:false
        },
        1920:{
            items:6,
            nav:true,
            loop:false
        },
        2560:{
            items:8,
            nav:true,
            loop:false
        },
        4096:{
            items:12,
            nav:true,
            loop:false
        },
        7680:{
            items:16,
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
var deferredPrompt = null;
var addBtn = document.querySelector('.a2hs-button');
if (addBtn != null) {
addBtn.style.display = 'none';

window.addEventListener('beforeinstallprompt', function(e) {
	
  // Prevent Chrome 67 and earlier from automatically showing the prompt
  e.preventDefault();
  // Stash the event so it can be triggered later.
  deferredPrompt = e;
  // Update UI to notify the user they can add to home screen
  addBtn.style.display = '';

  addBtn.addEventListener('click', function(e) {

    // hide our user interface that shows our A2HS button
    addBtn.style.display = 'none';
    // Show the prompt
    deferredPrompt.prompt();
    // Wait for the user to respond to the prompt
    deferredPrompt.userChoice.then(function(choiceResult) {
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

//Voice Search
/* setup vars for our trigger, form, text input and result elements */
if ($(window).width() >= 992 ) {
var $voiceTrigger = $("#voice-trigger");
var $searchForm = $("#search");
var $searchInput = $("#quick_find_keyword");
var $result = $("#result");
} else {
var $voiceTrigger = $("#voice-trigger-header");
var $searchForm = $("#searchheader");
var $searchInput = $("#quick_find_keyword_header");
var $result = $("#result-header");
}

/*  set Web Speech API for Chrome or Firefox */
window.SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

/* Check if browser support Web Speech API, remove the voice trigger if not supported */
if (window.SpeechRecognition) {

    /* setup Speech Recognition */
    var recognition = new SpeechRecognition();
    recognition.interimResults = true;
    recognition.lang = 'ru-RU';
    recognition.addEventListener('result', _transcriptHandler);

    recognition.onerror = function(event) {
        console.log(event.error);

        /* Revert input and icon CSS if no speech is detected */
        if(event.error == 'no-speech'){
            $voiceTrigger.removeClass('active');
            //$searchInput.attr("placeholder", "Поиск...");
        }
    }
} else {
    $voiceTrigger.remove();
}

jQuery(document).ready(function(){

    /* Trigger listen event when our trigger is clicked */
    $voiceTrigger.on('click touch', listenStart);
});

/* Our listen event */
function listenStart(e){
    e.preventDefault();
    /* Update input and icon CSS to show that the browser is listening */
    $searchInput.attr("placeholder", "Говорите...");
    $voiceTrigger.addClass('active');
    /* Start voice recognition */
    recognition.start();
}

/* Parse voice input */
function _parseTranscript(e) {
    return Array.from(e.results).map(function (result) { return result[0] }).map(function (result) { return result.transcript }).join('')
}

/* Convert our voice input into text and submit the form */
function _transcriptHandler(e) {
    var speechOutput = _parseTranscript(e)
    $searchInput.val(speechOutput);
    //$result.html(speechOutput);
    if (e.results[0].isFinal) {
        $searchForm.submit();
    }
}

// Select2 added
$(function() {

var customSorter = function(data) {
     return data.sort(function(a,b){
         a = a.text.toLowerCase();
         b = b.text.toLowerCase();
         if(a > b) {
             return 1;
         } else if (a < b) {
             return -1;
         }
         return 0;
     });
};
	
	  $(".select2").select2({
	      theme: "bootstrap",
	      sorter: customSorter
	  });        
});    	 

// Fix select2 width
$(window).on('resize', function() {
    $('.form-group').each(function() {
        var formGroup = $(this),
            formgroupWidth = "auto";

        formGroup.find('.select2-container').css('width', formgroupWidth);

    });
}); 