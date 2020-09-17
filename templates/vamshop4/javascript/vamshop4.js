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


// Lazy Load
var lazyLoadInstance = new LazyLoad({
  elements_selector: ".lazy",
  //use_native: true
});

//OWL Carousel Slider
$(".owl-carousel").owlCarousel({
    margin: 30,
    nav: false,
    center: false,
    dots: true,
    loop: false,
    navText: ['<span class="fas fa-chevron-left fa-1x"></span>','<span class="fas fa-chevron-right fa-1x"></span>'],
    responsive:{
        0:{
            items:1
        },
        360:{
            items:2
        },
        768:{
            items:3
        },
        992:{
            items:4
        },
        1200:{
            items:4
        }
    }
})

// hook into Bootstrap shown event and manually trigger 'resize' event so that Slick recalculates the widths
$('span[data-toggle="tab"]').on('shown.bs.tab', function (e) {
     $('.owl-carousel').trigger('refresh.owl.carousel');
});

$(".owl-carousel-reverse").owlCarousel({
    margin: 30,
    nav: false,
    loop:false,
    dots: false,
    navText: ['<span class="fas fa-chevron-left fa-1x"></span>','<span class="fas fa-chevron-right fa-1x"></span>'],
    responsive:{
        0:{
            items:1,
            nav:true
        },
        360:{
            items:2,
            nav:true
        },
        768:{
            items:3,
            nav:true
        },
        992:{
            items:4,
            nav:true,
            loop:false
        },
        1200:{
            items:1,
            nav:true,
            loop:false
        }
    }
})

//Slick Slider
//$('.slider').slick({
  //dots: false,
  //arrows: true,
  //prevArrow:'<button type="button" class="slick-prev pull-left" role="presentation"><span class="fas fa-chevron-left fa-1x" aria-hidden="true"></span></button>',
  //nextArrow:'<button type="button" class="slick-next pull-right" role="presentation"><span class="fas fa-chevron-right fa-1x" aria-hidden="true"></span></button>',
  //lazyLoad: 'ondemand',
  //infinite: false,
  //speed: 300,
  //slidesToShow: 5,
  //slidesToScroll: 5,
  //responsive: [
    //{
      //breakpoint: 1360,
      //settings: {
        //slidesToShow: 4,
        //slidesToScroll: 4,
      //}
    //},
    //{
      //breakpoint: 992,
      //settings: {
        //slidesToShow: 3,
        //slidesToScroll: 3,
      //}
    //},
    //{
      //breakpoint: 768,
      //settings: {
        //slidesToShow: 3,
        //slidesToScroll: 3,
      //}
    //},
    //{
      //breakpoint: 576,
      //settings: {
        //slidesToShow: 2,
        //slidesToScroll: 2
      //}
    //},
    //{
      //breakpoint: 360,
      //settings: {
        //slidesToShow: 1,
        //slidesToScroll: 1
      //}
    //}
    // You can unslick at a given breakpoint now by adding:
    // settings: "unslick"
    // instead of a settings object
  //]
//});

$('.tags-list').slick({
  dots: false,
  infinite: false,
  speed: 300,
  arrows: false,
  prevArrow:'<button type="button" class="slick-prev pull-left" role="presentation"><span class="fas fa-chevron-left fa-1x" aria-hidden="true"></span></button>',
  nextArrow:'<button type="button" class="slick-next pull-right" role="presentation"><span class="fas fa-chevron-right fa-1x" aria-hidden="true"></span></button>',
  slidesToShow: 1,
  centerMode: false,
  variableWidth: true
});

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

//$(window).on('load resize orientationchange', 
$(window).on('load', 
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
$(function() {
$('#cookie-alert').on('closed.bs.alert', function (e) {
    e.preventDefault();
   $.cookie("cookie-alert", 1, { expires : 365, path: "/" });
})
});           

$(function() {
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
});           

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
	
	  $("select:not(.noselect2)").select2({
	      theme: "bootstrap",
	      sorter: customSorter
	  });        
});    	 

$(function() {
// Fix select2 width
//$(window).on('resize', function() {
$(window).on('load', function() {
    $('.form-group').each(function() {
        var formGroup = $(this),
            formgroupWidth = "auto";

        formGroup.find('.select2-container').css('width', formgroupWidth);

    });
}); 
});           

$(function() {
 // footer widget hide/show on mobile devices
 // -----------------------------------------------------------------------------
 function doFooter (){
     if ($(window).width() > 576) {
         $('#footer .widget-inner').slideDown("slow").removeClass("do");
         $('#footer .widget-title').removeClass("do");
     } else {
         $('#footer .widget-inner').slideUp("fast").addClass("do");
         $('#footer .widget-title').addClass("do");
     }
 }
 //$(window).on('resize', function(){ doFooter(); });
 //$(window).on('load', function(){ 
 doFooter(); 
 //});
 $('#footer .widget-title').click(function(){
     $(this).next('.widget-inner.do').toggle("slow");
 });
});     

// Tooltips

$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})

// Like
function doLike(id) {
		var data = 'q=includes/modules/ajax/ajaxLike.php&products_id='+id;
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#likes").html(msg);
					 $("#like").removeAttr("onclick");
					 $("#dislike").removeAttr("onclick");
					 $("#like").addClass("rounded-circle border border-primary");
               }
		});
	}
	
// Dislike
function doDislike(id) {
		var data = 'q=includes/modules/ajax/ajaxDislike.php&products_id='+id;
		$.ajax({
					url : "index_ajax.php",
					dataType : "html",
					data : data,
					type : "GET",
					success : function(msg) {
					 $("#dislikes").html(msg);
					 $("#dislike").removeAttr("onclick");
					 $("#like").removeAttr("onclick");
					 $("#dislike").addClass("rounded-circle border border-danger text-danger");
               }
		});
	}	
	
//$(function () {
// Responsive equal height
if ($(window).width() > 350) {
$(window).on('load', function () {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .attributes').matchHeight();
    $('.card-body .title').matchHeight();
    $('.card-body .price-wrap').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.product-attribute-item .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
    $('.product-attribute-item .card-title').matchHeight();
});
$(document).ajaxSuccess(function () {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .attributes').matchHeight();
    $('.card-body .title').matchHeight();
    $('.card-body .price-wrap').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.product-attribute-item .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
    $('.product-attribute-item .card-title').matchHeight();
});
}	
//$(window).on('resize', function () {
    //$('.card-body .img-wrap').matchHeight();
    //$('.card-body .attributes').matchHeight();
    //$('.card-body .title').matchHeight();
    //$('.card-body .price-wrap').matchHeight();
    //$('.payment-method .method-title').matchHeight();
    //$('.shipping-method .method-title').matchHeight();
    //$('.product-attribute-item .method-title').matchHeight();
    //$('.payment-method .card-title').matchHeight();
    //$('.shipping-method .card-title').matchHeight();
    //$('.product-attribute-item .card-title').matchHeight();
//});
//});

$(function () {
$('span[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .attributes').matchHeight();
    $('.card-body .title').matchHeight();
    $('.card-body .price-wrap').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.product-attribute-item .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
    $('.product-attribute-item .card-title').matchHeight();
});
});

// Product Images Zoom

$(document).ready(function(){
$(".image-zoom").each(function(arg, el){
    var image = $(el).find("img");
    //$(el).wrap('<span style="display:inline-block"></span>')
    $(el).wrap('<span></span>')
    $(el).css('display', 'block')
    $(el).parent()    
    $(el).zoom({
        on: 'mouseover',
        url: image.attr("src").replace("info_images", "popup_images")
    });
});
});  

//Expandable Text
//$('.read-more').expandable({
  //'height': 450,
  //'more': '▼',
  //'less': '▲'
//});

//Sticky Column Calc Height
if ($(window).width() > 1200) {
$(document).ready(function(){
var sticky_column_height = $(".sticky-wrapper").parent().parent().height();
var sticky = $(".sticky-wrapper");
sticky.css("min-height", sticky_column_height + "px");
});  
$(document).ajaxSuccess(function () {	
var sticky_column_height = $(".sticky-wrapper").parent().parent().height();
var sticky = $(".sticky-wrapper");
sticky.css("min-height", sticky_column_height + "px");
});  
}