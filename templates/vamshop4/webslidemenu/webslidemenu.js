/* global jQuery */
/* global document */

jQuery(function () {
  'use strict';

  document.addEventListener("touchstart", function () {}, false);
  jQuery(function () {

    /* Automation Div */
    jQuery('body').wrapInner('<div class="wsmenucontainer" />');
    jQuery('<div class="overlapblackbg"></div>').prependTo('.wsmenu');

    jQuery('#wsnavtoggle').click(function () {
      jQuery('body').toggleClass('wsactive');
    });

    jQuery('.overlapblackbg').click(function () {
      jQuery("body").removeClass('wsactive');
    });

    /* Append and Toggle Class */
    jQuery('.wsmenu-list> li').has('.sub-menu').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow"></i></span>');
    jQuery('.wsmenu-list > li').has('.wsshoptabing').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow"></i></span>');
    jQuery('.wsmenu-list > li').has('.wsmegamenu').prepend('<span class="wsmenu-click"><i class="wsmenu-arrow"></i></span>');
    jQuery('.wsmenu-click').on('click', function () {
      jQuery(this).toggleClass('ws-activearrow').parent().siblings().children().removeClass('ws-activearrow');
      jQuery(".sub-menu, .wsshoptabing, .wsmegamenu").not(jQuery(this).siblings('.sub-menu, .wsshoptabing, .wsmegamenu')).slideUp('slow');
      jQuery(this).siblings('.sub-menu').slideToggle('slow');
      jQuery(this).siblings('.wsshoptabing').slideToggle('slow');
      jQuery(this).siblings('.wsmegamenu').slideToggle('slow');
      return false;
    });

    jQuery('.wstabitem > li').has('.wstitemright').prepend('<span class="wsmenu-click02"><i class="wsmenu-arrow"></i></span>');
    jQuery('.wsmenu-click02').on('click', function () {
      jQuery(this).siblings('.wstitemright').slideToggle('slow');
      jQuery(this).toggleClass('ws-activearrow02').parent().siblings().children().removeClass('ws-activearrow02');
      jQuery(".wstitemright").not(jQuery(this).siblings('.wstitemright')).slideUp('slow');
      return false;
    });

    jQuery('.wstabitem02 > li').has('.wstbrandbottom').prepend('<span class="wsmenu-click03"><i class="wsmenu-arrow"></i></span>');
    jQuery('.wsmenu-click03').on('click', function () {
      jQuery(this).siblings('.wstbrandbottom').slideToggle('slow');
      jQuery(this).toggleClass('ws-activearrow03').parent().siblings().children().removeClass('ws-activearrow03');
      jQuery(".wstbrandbottom").not(jQuery(this).siblings('.wstbrandbottom')).slideUp('slow');
      return false;
    });

    /* Add Class in ever tabing menu LI When MouseEnter */
    jQuery(window).ready(function () {
      jQuery(".wsshoptabing.wtsdepartmentmenu > .wsshopwp > .wstabitem > li").on('mouseenter', function () {
        jQuery(this).addClass("wsshoplink-active").siblings(this).removeClass("wsshoplink-active");
        return false;
      });
      jQuery(".wsshoptabing.wtsbrandmenu > .wsshoptabingwp > .wstabitem02 > li").on('mouseenter', function () {
        jQuery(this).addClass("wsshoplink-active").siblings(this).removeClass("wsshoplink-active");
        return false;
      });
    });
    setmenuheight();
    jQuery(window).on("load resize", function () {
      var w_height = jQuery(window).outerWidth();
      if (w_height <= 991) {
        jQuery(".wsshopwp").css('height', '100%');
        jQuery(".wstitemright").css('height', '100%');
      } else {
        setmenuheight();
      }
    });


    /* Calculating Height */
    function setmenuheight() {
      var TabgetHeight = 1;
      jQuery(".wstabitem > li").each(function () {
        var forHeight = jQuery(this).find(".wstitemright").innerHeight();
        TabgetHeight = forHeight > TabgetHeight ? forHeight : TabgetHeight;
        jQuery(this).find(".wstitemright").css('height', 'auto');
      });
      jQuery(".wsshopwp").css('height', TabgetHeight + 0);
    }


    /* Removing inLine Style  */
    jQuery(document).ready(function (jQuery) {
      function removeStyles() {
        if (jQuery(window).outerWidth() >= 991) {
          jQuery('.wsshoptabing, .wstitemright, .wstbrandbottom, .wsmegamenu, ul.sub-menu').css({
            'display': '',
          });
        }
      }
      removeStyles();
      jQuery(window).resize(removeStyles);
    });


    /* Removing Class  */
    jQuery(window).on('resize', function () {
      if (jQuery(window).outerWidth() <= 991) {
        jQuery('.wsmenu').css('height', jQuery(this).height() + "px");
        jQuery('.wsmenucontainer').css('min-width', jQuery(this).width() + "px");
      } else {
        jQuery('.wsmenu').removeAttr("style");
        jQuery('.wsmenucontainer').removeAttr("style");
        jQuery('body').removeClass("wsactive");
        jQuery('.wsmenu-click').removeClass("ws-activearrow");
        jQuery('.wsmenu-click02').removeClass("ws-activearrow02");
        jQuery('.wsmenu-click03').removeClass("ws-activearrow03");
      }
    });
    jQuery(window).trigger('resize');


  });

  //Mobile Search Box
  jQuery(window).on("load", function () {
    jQuery('.wsmobileheader .wssearch').on("click", function () {
      jQuery(this).toggleClass("wsopensearch");
      jQuery("input:text:visible:first").focus();
    });
    jQuery("body, .wsopensearch .wsclosesearch").on("click", function () {
      jQuery(".wssearch").removeClass('wsopensearch');
    });
    jQuery(".wssearch, .wssearchform form").on("click", function (e) {
      e.stopPropagation();
    });
  });

  /* Top Fixed */
  jQuery(window).scroll(function () {
    var sticky = jQuery('.wsmain');
    var header = jQuery('header').height();
    var menu = jQuery('.headerfull').height();
    var scroll = jQuery(window).scrollTop();
    if (scroll >= header-menu) sticky.addClass('wsfixed');
    else sticky.removeClass('wsfixed');
  });
  /* End Top Fixed */
  
}());