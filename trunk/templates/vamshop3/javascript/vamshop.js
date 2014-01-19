// Responsive equal height
// http://codepen.io/micahgodbolt/pen/FgqLc

equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
}

if ($(window).width() > 767) {
$(window).load(function() {
  equalheight('.thumbnails .thumbnail');
});

$(window).resize(function(){
  equalheight('.thumbnails .thumbnail');
});
}

/*
|--------------------------------------------------------------------------
| UItoTop jQuery Plugin 1.2 by Matt Varone
| http://www.mattvarone.com/web-design/uitotop-jquery-plugin/
|--------------------------------------------------------------------------
*/
(function($){
	$.fn.UItoTop = function(options) {

 		var defaults = {
    			text: '',
    			min: 200,
    			inDelay:600,
				outDelay:400,
				containerID: 'toTop',
    			containerHoverID: 'toTopHover',
    			scrollSpeed: 1200,
    			easingType: 'linear'
 		    },
            settings = $.extend(defaults, options),
            containerIDhash = '#' + settings.containerID,
            containerHoverIDHash = '#'+settings.containerHoverID;
		
		$('body').append('<a href="#" id="'+settings.containerID+'">'+settings.text+'</a>');
		$(containerIDhash).hide().on('click.UItoTop',function(){
			$('html, body').animate({scrollTop:0}, settings.scrollSpeed, settings.easingType);
			$('#'+settings.containerHoverID, this).stop().animate({'opacity': 0 }, settings.inDelay, settings.easingType);
			return false;
		})
		.prepend('<span id="'+settings.containerHoverID+'"></span>')
		.hover(function() {
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 1
				}, 600, 'linear');
			}, function() { 
				$(containerHoverIDHash, this).stop().animate({
					'opacity': 0
				}, 700, 'linear');
			});
					
		$(window).scroll(function() {
			var sd = $(window).scrollTop();
			if(typeof document.body.style.maxHeight === "undefined") {
				$(containerIDhash).css({
					'position': 'absolute',
					'top': sd + $(window).height() - 50
				});
			}
			if ( sd > settings.min ) 
				$(containerIDhash).fadeIn(settings.inDelay);
			else 
				$(containerIDhash).fadeOut(settings.Outdelay);
		});
};
})(jQuery);

// Only apply the fixed stuff to desktop devices
// -----------------------------------------------------------------------------

$(function(){

    if ( ! /Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent) ) {

        // #navigation fixed
        if ($(window).width() > 767) {
            //
            var menu = $('#navigation'),
                pos = menu.offset();

            $(window).scroll(function(){
                if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
                    menu.fadeOut('fast', function(){
                        $(this).removeClass('default').addClass('fixed').fadeIn('fast');
                    });
                } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
                    menu.fadeOut('fast', function(){
                        $(this).removeClass('fixed').addClass('default').fadeIn('fast');
                    });
                }
            });
        }
    }

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
    $('.shopping-cart .cart').hover(
        function(){
            $('.shopping-cart .cart-dropdown').show();
        },
        function (){
            $('.shopping-cart .cart-dropdown').hide();
        }
    );
    $('.shopping-cart .cart-dropdown').bind({
        mouseenter: function(){
            $(this).show();
        },
        mouseleave: function(){
            $(this).hide();
        }
    });

    $('ul.icons.check a').click(function(){

        if ($(this).closest('li').hasClass('on')) {
            $(this).closest('li').removeClass('on');
            return false;
        }

        else {
            $(this).closest('li').addClass('on');
            return false;
        }

    });

    // tooltip
    // -----------------------------------------------------------------------------
    $("a[data-toggle=tooltip]").tooltip();

    // Main menu
    // -----------------------------------------------------------------------------
    (function() {
		var $menu = $('.navbar-inner ul.nav'),
			optionsList = '<option value="" selected>...</option>';
		$menu.find('li').each(function() {
			var $this   = $(this),
				$anchor = $this.children('a'),
				depth   = $this.parents('ul').length - 1,
				indent  = '';
			if( depth ) {
				while( depth > 0 ) {
					indent += ' - ';
					depth--;
				}
			}
			optionsList += '<option value="' + $anchor.attr('href') + '">' + indent + ' ' + $anchor.text() + '</option>';
		}).end().after('<div class="res-menu-wrap"><select class="res-menu">' + optionsList + '</select><div class="res-menu-title"></div></div>');

		$('.res-menu').on('change', function() {
			window.location = $(this).val();
		});
	})();
    
    // To Top Button
    // -----------------------------------------------------------------------------
    $(function(){
        $().UItoTop({ easingType: 'easeOutQuart' });
    });

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

});
