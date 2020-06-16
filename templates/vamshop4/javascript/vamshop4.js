$(document).ready(function(){

// Lazy Load
var lazyLoadInstance = new LazyLoad({
  elements_selector: ".lazy",
  //use_native: true
});

//OWL Carousel Slider
$(".owl-carousel").owlCarousel({
    margin: 30,
    nav: true,
    //lazyLoad: true,
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
            items:6,
            nav:true,
            loop:false
        }
    }
})

$(".owl-carousel-reverse").owlCarousel({
    margin: 30,
    nav: true,
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
	
	  $("select:not(.noselect2)").select2({
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
 $(window).on('resize', function(){ doFooter(); });
 $(window).on('load', function(){ doFooter(); });
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
	
/**
* jquery.matchHeight-min.js master
* https://github.com/liabru/jquery-match-height
* License: MIT
*/
(function(c){var n=-1,f=-1,g=function(a){return parseFloat(a)||0},r=function(a){var b=null,d=[];c(a).each(function(){var a=c(this),k=a.offset().top-g(a.css("margin-top")),l=0<d.length?d[d.length-1]:null;null===l?d.push(a):1>=Math.floor(Math.abs(b-k))?d[d.length-1]=l.add(a):d.push(a);b=k});return d},p=function(a){var b={byRow:!0,property:"height",target:null,remove:!1};if("object"===typeof a)return c.extend(b,a);"boolean"===typeof a?b.byRow=a:"remove"===a&&(b.remove=!0);return b},b=c.fn.matchHeight=
function(a){a=p(a);if(a.remove){var e=this;this.css(a.property,"");c.each(b._groups,function(a,b){b.elements=b.elements.not(e)});return this}if(1>=this.length&&!a.target)return this;b._groups.push({elements:this,options:a});b._apply(this,a);return this};b._groups=[];b._throttle=80;b._maintainScroll=!1;b._beforeUpdate=null;b._afterUpdate=null;b._apply=function(a,e){var d=p(e),h=c(a),k=[h],l=c(window).scrollTop(),f=c("html").outerHeight(!0),m=h.parents().filter(":hidden");m.each(function(){var a=c(this);
a.data("style-cache",a.attr("style"))});m.css("display","block");d.byRow&&!d.target&&(h.each(function(){var a=c(this),b=a.css("display");"inline-block"!==b&&"inline-flex"!==b&&(b="block");a.data("style-cache",a.attr("style"));a.css({display:b,"padding-top":"0","padding-bottom":"0","margin-top":"0","margin-bottom":"0","border-top-width":"0","border-bottom-width":"0",height:"100px"})}),k=r(h),h.each(function(){var a=c(this);a.attr("style",a.data("style-cache")||"")}));c.each(k,function(a,b){var e=c(b),
f=0;if(d.target)f=d.target.outerHeight(!1);else{if(d.byRow&&1>=e.length){e.css(d.property,"");return}e.each(function(){var a=c(this),b=a.css("display");"inline-block"!==b&&"inline-flex"!==b&&(b="block");b={display:b};b[d.property]="";a.css(b);a.outerHeight(!1)>f&&(f=a.outerHeight(!1));a.css("display","")})}e.each(function(){var a=c(this),b=0;d.target&&a.is(d.target)||("border-box"!==a.css("box-sizing")&&(b+=g(a.css("border-top-width"))+g(a.css("border-bottom-width")),b+=g(a.css("padding-top"))+g(a.css("padding-bottom"))),
a.css(d.property,f-b+"px"))})});m.each(function(){var a=c(this);a.attr("style",a.data("style-cache")||null)});b._maintainScroll&&c(window).scrollTop(l/f*c("html").outerHeight(!0));return this};b._applyDataApi=function(){var a={};c("[data-match-height], [data-mh]").each(function(){var b=c(this),d=b.attr("data-mh")||b.attr("data-match-height");a[d]=d in a?a[d].add(b):b});c.each(a,function(){this.matchHeight(!0)})};var q=function(a){b._beforeUpdate&&b._beforeUpdate(a,b._groups);c.each(b._groups,function(){b._apply(this.elements,
this.options)});b._afterUpdate&&b._afterUpdate(a,b._groups)};b._update=function(a,e){if(e&&"resize"===e.type){var d=c(window).width();if(d===n)return;n=d}a?-1===f&&(f=setTimeout(function(){q(e);f=-1},b._throttle)):q(e)};c(b._applyDataApi);c(window).bind("load",function(a){b._update(!1,a)});c(window).bind("resize orientationchange",function(a){b._update(!0,a)})})(jQuery);

// Responsive equal height
if ($(window).width() > 767) {
$(window).on('load', function () {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .info-wrap .title').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
});
$(document).ajaxComplete(function () {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .info-wrap .title').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
});
}	
$(window).on('resize', function () {
    $('.card-body .img-wrap').matchHeight();
    $('.card-body .info-wrap .title').matchHeight();
    $('.payment-method .method-title').matchHeight();
    $('.shipping-method .method-title').matchHeight();
    $('.payment-method .card-title').matchHeight();
    $('.shipping-method .card-title').matchHeight();
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
//  'height': 350,
//  'more': '▼',
//  'less': '▲'
//});


// Sticky top
var parentElement = document.querySelector('.sticky-wrapper');
var fixedElement = document.querySelector('.sticky-top');

// get parent-element width when page is fully loaded
// and change fixed-element width accordingly
window.addEventListener('load', changeFixedElementWidth);

// get parent-element width when window is resized
// and change fixed-element width accordingly
window.addEventListener('resize', changeFixedElementWidth);

function changeFixedElementWidth() {
  if (parentElement) var parentElementWidth = parentElement.getBoundingClientRect().width;
  if (fixedElement) fixedElement.style.width = parentElementWidth + 'px';
}