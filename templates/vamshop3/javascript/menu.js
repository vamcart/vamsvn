$(document).ready(function() {
    MenuDatapp = {
        appinit: function() {
            MenuDatapp.HandleSidebartoggle();
            MenuDatapp.Handlelpanel();
            MenuDatapp.Handlelpanelmenu();
            MenuDatapp.Handlethemeoption();
            MenuDatapp.Handlesidebareffect();
            MenuDatapp.Handlesidebarposition();
            MenuDatapp.Handlecontentheight();
            MenuDatapp.Handlethemecolor();
			MenuDatapp.Handlenavigationtype();
			MenuDatapp.Handlesidebarside();
			MenuDatapp.Handleactivestatemenu();
			MenuDatapp.Handlethemelayout();
			MenuDatapp.Handlethemebackground();
			 

        },
		Handlethemebackground: function() {
            function setthemebgcolor() {
                $('#theme-color > a.theme-bg').on("click", function() {
                    $('body').attr("theme-bg", $(this).attr("menu-themebg-type"));
                });
            };
			setthemebgcolor(); 
        },
		Handlethemelayout: function() {
			 $('#theme-layout').on("change", function() {
                if ($(this).val() == 'box-layout') {
                  $('body').attr("theme-layout", "box-layout");
                }else {
				 $('body').attr("theme-layout", "wide-layout");
				}
            });
        },
		Handleactivestatemenu: function() {
			 $(".panel-list li:not('.menu-has-menu') > a").on("click", function() {
				if ($('body').attr("menu-navigation-type") == "vertical" || $('body').attr("menu-navigation-type") == "vertical-compact")   {
					if ($(this).closest('li.menu-has-menu').length === 1){
						$(this).closest('.panel-list').find('li.active').removeClass('active');
						$(this).parent().addClass('active');
						$(this).parent().closest('.menu-has-menu').addClass('active');
						$(this).parent('li').closest('li').closest('.menu-has-menu').addClass('active');
					} else {
						$(this).closest('.panel-list').find('li.active').removeClass('active');
						$(this).closest('.panel-list').find('li.opened').removeClass('opened');
						$(this).closest('.panel-list').find('ul:visible').slideUp('fast');
						$(this).parent().addClass('active');
						 
					}
				}
			});
        }, 
		Handlesidebarside: function() {
			 $('#navigation-side').on("change", function() {
                if ($(this).val() == 'rightside') {
                  $('body').attr("menu-nav-placement", "right"); 
				  $('body').attr("menu-navigation-type", "vertical");
				  $('#menuapp-wrapper').removeClass("compact-hmenu");
                }else {
				 $('body').attr("menu-nav-placement", "left"); 
				 $('body').attr("menu-navigation-type", "vertical");
				  $('#menuapp-wrapper').removeClass("compact-hmenu");
				}
            });
        },
		Handlenavigationtype: function() {
			 $('#navigation-type').on("change", function() {
                if ($(this).val() == 'horizontal') {
                    $('body').attr("menu-navigation-type", "horizontal");
					$('#menuapp-wrapper').removeClass("compact-hmenu");
					$('#menu-header, #menuapp-container').removeClass("menu-minimized-lpanel");
					$('body').attr("menu-nav-placement", "left");
					$('#menu-header').attr("menu-color-type","logo-bg7");
					
                }else if  ($(this).val() == 'horizontal-compact'){
                    $('body').attr("menu-navigation-type", "horizontal");
					$('#menuapp-wrapper').addClass("compact-hmenu");
					$('#menu-header, #menuapp-container').removeClass("menu-minimized-lpanel");
					$('body').attr("menu-nav-placement", "left");
					$('#menu-header').attr("menu-color-type","logo-bg7");
                }else if  ($(this).val() == 'vertical-compact'){
                    $('body').attr("menu-navigation-type", "vertical-compact");
					$('#menuapp-wrapper').removeClass("compact-hmenu");
					$('#menu-header, #menuapp-container').addClass("menu-minimized-lpanel");
					$('body').attr("menu-nav-placement", "left"); 
                }else {
					$('body').attr("menu-navigation-type", "vertical");
					$('#menuapp-wrapper').removeClass("compact-hmenu");
					$('#menu-header, #menuapp-container').removeClass("menu-minimized-lpanel");
					$('body').attr("menu-nav-placement", "left"); 
				}
            });
        },
		
        Handlethemecolor: function() {

            function setheadercolor() {
                $('#theme-color > a.header-bg').on("click", function() {
                    $('#menu-header > .menu-right-header').attr("menu-color-type", $(this).attr("menu-color-type"));
                });
            };

            function setlpanelcolor() {
                $('#theme-color > a.lpanel-bg').on("click", function() {
                    $('#menuapp-container').attr("menu-color-type", $(this).attr("menu-color-type"));
                });
            };

            function setllogocolor() {
                $('#theme-color > a.logo-bg').on("click", function() {
                    $('#menu-header').attr("menu-color-type", $(this).attr("menu-color-type"));
                });
            };
            setheadercolor();
            setlpanelcolor();
            setllogocolor();
        },
        Handlecontentheight: function() {

            function setHeight() {
                var WH = $(window).height();
                var HH = $("#menu-header").innerHeight();
                var FH = $("#footer").innerHeight();
                var contentH = WH - HH;
				var lpanelH = WH - HH;
                $("#main-content ").css('min-height', contentH)
				 $(".inner-left-panel ").css('height', lpanelH)

            };
            setHeight();

            $(window).resize(function() {
                setHeight();
            });
        },
        Handlesidebarposition: function() {

            $('#sidebar-position').on("change", function() {
                if ($(this).val() == 'fixed') {
                    $('#menu-left-panel,.menu-left-header').attr("menu-position-type", "fixed");
                } else {
                    $('#menu-left-panel,.menu-left-header').attr("menu-position-type", "absolute");
                }
            });
        },
        Handlesidebareffect: function() {
            $('#leftpanel-effect').on("change", function() {
                if ($(this).val() == 'overlay') {
                    $('#menu-header, #menuapp-container').attr("menu-lpanel-effect", "overlay");
                } else if ($(this).val() == 'push') {
                    $('#menu-header, #menuapp-container').attr("menu-lpanel-effect", "push");
                } else {
                    $('#menu-header, #menuapp-container').attr("menu-lpanel-effect", "shrink");
                }
            });

        },

        Handlethemeoption: function() {
            $('.selector-toggle > a').on("click", function() {
                $('#styleSelector').toggleClass('open')
            });

        },
        Handlelpanelmenu: function() {
            $('.menu-has-menu > a').on("click", function() {
                var compactMenu = $(this).closest('.menu-minimized-lpanel').length;
                if (compactMenu === 0) {
                    $(this).parent('.menu-has-menu').parent('ul').find('ul:visible').slideUp('fast');
                    $(this).parent('.menu-has-menu').parent('ul').find('.opened').removeClass('opened');
                    var submenu = $(this).parent('.menu-has-menu').find('>.menu-sub-menu');
                    if (submenu.is(':hidden')) {
                        submenu.slideDown('fast');
                        $(this).parent('.menu-has-menu').addClass('opened');
                    } else {
                        $(this).parent('.menu-has-menu').parent('ul').find('ul:visible').slideUp('fast');
                        $(this).parent('.menu-has-menu').removeClass('opened');
                    }
                }
            });

        },
        HandleSidebartoggle: function() {
            $('.menu-sidebar-toggle a').on("click", function() {
                if ($('#menuapp-wrapper').attr("menu-device-type") !== "phone") {
                    $('#menuapp-container').toggleClass('menu-minimized-lpanel');
                    $('#menu-header').toggleClass('menu-minimized-lpanel');
					if ($('body').attr("menu-navigation-type") !== "vertical-compact") {
						$('body').attr("menu-navigation-type", "vertical-compact"); 
					}else{
						$('body').attr("menu-navigation-type", "vertical"); 
					}
                } else {
                    if (!$('#menuapp-wrapper').hasClass('menu-hide-lpanel')) {
                        $('#menuapp-wrapper').addClass('menu-hide-lpanel');
                    } else {
                        $('#menuapp-wrapper').removeClass('menu-hide-lpanel');
                    }
                }
            });

        },
        Handlelpanel: function() {

            function Responsivelpanel() {
                
				var totalwidth = $(window)[0].innerWidth;
                if (totalwidth >= 768 && totalwidth <= 1024) {
                    $('#menuapp-wrapper').attr("menu-device-type", "tablet");
                    $('#menu-header, #menuapp-container').addClass('menu-minimized-lpanel');
					$('li.theme-option select').attr('disabled', false);
                } else if (totalwidth < 768) {
                    $('#menuapp-wrapper').attr("menu-device-type", "phone");
                    $('#menu-header, #menuapp-container').removeClass('menu-minimized-lpanel');
					$('li.theme-option select').attr('disabled', 'disabled');
                } else {
					if ($('body').attr("menu-navigation-type") !== "vertical-compact") {
						$('#menuapp-wrapper').attr("menu-device-type", "desktop");
						$('#menu-header, #menuapp-container').removeClass('menu-minimized-lpanel');
						$('li.theme-option select').attr('disabled', false);
					}else {
						$('#menuapp-wrapper').attr("menu-device-type", "desktop");
						$('#menu-header, #menuapp-container').addClass('menu-minimized-lpanel');
						$('li.theme-option select').attr('disabled', false);	
						
					}
                }
            }
            Responsivelpanel();
            $(window).resize(Responsivelpanel);

        },

    };
    MenuDatapp.appinit();
});