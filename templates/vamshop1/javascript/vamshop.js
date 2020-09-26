// Slide menu

$(document).ready(function(){
  $(".navbar .navbar-toggle").click();
  $('.toggle-menu').jPushMenu({closeOnClickLink: false});
  $('.dropdown-toggle').dropdown();
});

//OWL Carousel Slider
$(".owl-carousel").owlCarousel({
    margin: 30,
    nav: true,
    center: false,
    dots: false,
    loop: false,
    navText: ['<span class="fa fa-chevron-left fa-1x"></span>','<span class="fa fa-chevron-right fa-1x"></span>'],
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

//OWL Carousel Slider
$(".owl-carousel-tags").owlCarousel({
    margin: 12,
    nav: false,
    center: false,
    autoWidth: true,
    stagePadding: 30,
    dots: false,
    loop: false,
    navText: false
})

// hook into Bootstrap shown event and manually trigger 'resize' event so that Slick recalculates the widths
$('span[data-toggle="tab"]').on('shown.bs.tab', function (e) {
     $('.owl-carousel').trigger('refresh.owl.carousel');
});

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

if ($(window).width() > 360) {
$(window).load(function() {
    //$('.owl-carousel .item').matchHeight();
    $('.thumbnails .item .thumbnail').matchHeight();
    $('.item .thumbnail .notop').matchHeight();
    $('.item .thumbnail .notop .title').matchHeight();
    $('.thumbnails .item .thumbnail .title').matchHeight();
    $('.thumbnails .item a.image').matchHeight();
});
$(document).ajaxSuccess(function () {
    //$('.owl-carousel .item').matchHeight();
    $('.thumbnails .item .thumbnail').matchHeight();
    $('.item .thumbnail .notop').matchHeight();
    $('.item .thumbnail .notop .title').matchHeight();
    $('.thumbnails .item .thumbnail .title').matchHeight();
    $('.thumbnails .item a.image').matchHeight();
});
$(window).on('resize', function () {
    //$('.owl-carousel .item').matchHeight();
    $('.thumbnails .item .thumbnail').matchHeight();
    $('.item .thumbnail .notop').matchHeight();
    $('.item .thumbnail .notop .title').matchHeight();
    $('.thumbnails .item .thumbnail .title').matchHeight();
    $('.thumbnails .item a.image').matchHeight();
});
}

$(document).ready(function(){
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

// Only apply the fixed stuff to desktop devices
// -----------------------------------------------------------------------------

$(function(){

	$('#navigation').affix({
	      offset: {
	        top: $('#header').height()-$('#navigation').height()
	      }
	});	

});

// ON DOCUMENT READY
// -----------------------------------------------------------------------------
$(document).ready(function(){

    // footer widget hide/show on mobile devices
    // -----------------------------------------------------------------------------
    function doFooter (){
        if ($(window).width() > 767) {
            $('#footer .widget-inner').slideDown("slow").removeClass("do");
            $('#footer .widget-title').removeClass("do");
        } else {
            $('#footer .widget-inner').slideUp("fast").addClass("do");
            $('#footer .widget-title').addClass("do");
        }
    }
    $(window).resize(function(){ doFooter(); });
    $(window).load(function(){ doFooter(); });
    $('#footer .widget-title').click(function(){
        $(this).next('.widget-inner.do').toggle("slow");
    });

    // Shoping cart SHOW/HIDE
    // -----------------------------------------------------------------------------
    //$('.shopping-cart .cart').hover(
        //function(){
            //$('.shopping-cart .cart-dropdown').show();
        //},
        //function (){
            //$('.shopping-cart .cart-dropdown').hide();
        //}
    //);
    //$('.shopping-cart .cart-dropdown').bind({
        //mouseenter: function(){
            //$(this).show();
        //},
        //mouseleave: function(){
            //$(this).hide();
        //}
    //});

    //$('ul.icons.check a').click(function(){

        //if ($(this).closest('li').hasClass('on')) {
            //$(this).closest('li').removeClass('on');
            //return false;
        //}

        //else {
            //$(this).closest('li').addClass('on');
            //return false;
        //}

    //});

    // tooltip
    // -----------------------------------------------------------------------------
    $("a[data-toggle=tooltip]").tooltip();

    // Placeholder
    // -----------------------------------------------------------------------------
    $('[placeholder]').focus(function() {
        var input = $(this);
        if (input.val() == input.attr('placeholder')) {
            input.val('');
            input.removeClass('placeholder');
        }
    }).blur(function() {
        var input = $(this);
        if (input.val() == '' || input.val() == input.attr('placeholder')) {
            input.addClass('placeholder');
            input.val(input.attr('placeholder'));
        }
        }).blur().parents('form').submit(function() {
            $(this).find('[placeholder]').each(function() {
                var input = $(this);
                if (input.val() == input.attr('placeholder')) {
                    input.val('');
                }
            })
        });

// Bootstrap carousel equal heights
function normalizeSlideHeights() {
    $('.carousel').each(function(){
      var items = $('.item', this);
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

// Select tab by url

$(document).ready(function(event) {
    $('ul.nav.nav-tabs a:first').tab('show'); // Select first tab
    $('ul.nav.nav-tabs a[href="'+ window.location.hash+ '"]').tab('show'); // Select tab by name if provided in location hash
    $('ul.nav.nav-tabs a[data-toggle="tab"]').on('shown', function (event) {    // Update the location hash to current tab
        window.location.hash= event.target.hash;
    })
});

// Product Images Zoom

$(document).ready(function(){
$(".image-zoom").each(function(arg, el){
    var image = $(el).find("img");
    $(el).wrap('<span style="display:inline-block"></span>')
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
