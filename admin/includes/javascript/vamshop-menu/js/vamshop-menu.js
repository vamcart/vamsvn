$.fn.menu = function( settings ) {
	var oid = this.attr("id");
    // Menu default settings:
    var defaults = {
		// Common option both for vertical nad horizontal
			themelayout: 'vertical',  			// value should be horizontal/vertical
			MenuTrigger: 'click',      			 	// value should be hover/click
			SubMenuTrigger: 'click',      			// value should be hover/click 
			activeMenuClass: 'active',
			ThemeBackgroundPattern: 'pattern6', 	// Value should be 
			HeaderBackground: 'theme2' , 			// Value should be theme1/theme2/theme3/theme4/theme5/theme6/theme7/theme8/theme9
			LHeaderBackground :'theme4',			// Value should be theme1/theme2/theme3/theme4/theme5/theme6/theme7/theme8/theme9
			NavbarBackground: 'theme4',				// Value should be theme1/theme2/theme3/theme4/theme5/theme6/theme7/theme8/theme9
			ActiveItemBackground: 'theme0',			// Value should be theme1/theme2/theme3/theme4/theme5/theme6/theme7/theme8/theme9
			SubItemBackground: 'theme2', 			// Value should be theme1/theme2/theme3/theme4/theme5/theme6/theme7/theme8/theme9
			ActiveItemStyle: 'style0',
			ItemBorder: true,
			ItemBorderStyle: 'solid',   // value should be solid/dotted/dashed
			SubItemBorder: true,
			DropDownIconStyle: 'style1', // value should be style1,style2,style3
			FixedNavbarPosition: false,
			FixedHeaderPosition: false,
			
		// Horizontal Navigation option
			horizontalMenuplacement: 'top', 	// value should be top/bottom
			horizontalMenulayout: 'widebox', 		//value should be wide/box/widebox
			horizontalBrandItem: true,
			horizontalLeftNavItem: true,
			horizontalRightItem: false,
			horizontalSearchItem: false,
			horizontalBrandItemAlign: 'left',
			horizontalLeftNavItemAlign: 'right',
			horizontalRightItemAlign: 'right',
			horizontalsearchItemAlign: 'right',
			horizontalstickynavigation: false,
			horizontalNavigationView: 'view1',
			horizontalNavIsCentered: false, 
			horizontalNavigationMenuIcon: true,
		
		// Vertical Navigation option
			verticalMenuplacement: 'left',		// value should be left/right
			verticalMenulayout: 'wide',   		// value should be wide/box/widebox
			collapseVerticalLeftHeader: true,
			VerticalSubMenuItemIconStyle: 'style6',      // value should be style1,style2,style3
			VerticalNavigationView: 'view1',
			verticalMenueffect:{
				desktop : "shrink",
				tablet : "push",
				phone : "overlay",
			},
			defaultVerticalMenu: {
				desktop : "expanded",		// value should be offcanvas/collapsed/expanded/compact/compact-acc/fullpage/ex-popover/sub-expanded
				tablet : "collapsed",		// value should be offcanvas/collapsed/expanded/compact
				phone : "offcanvas",		// value should be offcanvas/collapsed/expanded/compact
			},
			onToggleVerticalMenu : {
				desktop : "collapsed",		// value should be offcanvas/collapsed/expanded/compact
				tablet : "expanded",		// value should be offcanvas/collapsed/expanded/compact
				phone : "expanded",			// value should be offcanvas/collapsed/expanded/compact
			},
    };
    var settings = $.extend( {}, defaults, settings );
	var VamshopMenu = {
        VamshopMenuInit: function() {
			VamshopMenu.Handlethemelayout();
			VamshopMenu.HandleverticalMenuplacement();
			VamshopMenu.HandlehorizontalMenuplacement();
			VamshopMenu.HandleMenulayout();
			VamshopMenu.HandleDeviceType();
			VamshopMenu.Handlecomponetheight();
			VamshopMenu.HandleMenuOnClick();
			VamshopMenu.HandleMenuTrigger();
			VamshopMenu.HandleSubMenuTrigger();
			VamshopMenu.HandleActiveItem();
			VamshopMenu.HandleOffcanvasMenu();
			VamshopMenu.HandleVerticalLeftHeader();
			VamshopMenu.HandleThemeBackground();
			VamshopMenu.HandleActiveItemStyle();
			VamshopMenu.HandleItemBorder ();
			VamshopMenu.HandleBorderStyle ();
			VamshopMenu.HandleSubItemBorder ();
			VamshopMenu.HandleDropDownIconStyle ();
			VamshopMenu.HandleOptionSelectorPanel ();
			VamshopMenu.HandleNavbarPosition ();
			VamshopMenu.HandleVerticalSubMenuItemIconStyle ();
			VamshopMenu.HandleVerticalNavigationView ();
			VamshopMenu.HandleHorizontalItemIsCentered();
			VamshopMenu.HandleHorizontalItemAlignment ();
			VamshopMenu.HandleSubMenuOffset();
			VamshopMenu.HandleHorizontalStickyNavigation(); 
			VamshopMenu.HandleDocumentClickEvent(); 
			VamshopMenu.HandleVerticalScrollbar();
			VamshopMenu.HandleHorizontalMobileMenuToggle();
			VamshopMenu.horizontalNavigationMenuIcon();
			VamshopMenu.verticalNavigationSearchBar();
			VamshopMenu.safariBrowsercompatibility();
			
        }, 
		safariBrowsercompatibility: function() {
			is_chrome = navigator.userAgent.indexOf('Chrome') > -1;
			is_explorer = navigator.userAgent.indexOf('MSIE') > -1;
			is_firefox = navigator.userAgent.indexOf('Firefox') > -1;
			is_safari = navigator.userAgent.indexOf("Safari") > -1;
			is_opera = navigator.userAgent.indexOf("Presto") > -1;
			is_mac = (navigator.userAgent.indexOf('Mac OS') != -1);
			is_windows = !is_mac;

			if (is_chrome && is_safari){
				is_safari=false;
			} 
			if (is_safari || is_windows){
				$('body').css('-webkit-text-stroke', '0.05px');
				$('body').css('-webkit-font-smoothing', 'antialiased');
			}  
		},
		verticalNavigationSearchBar: function() {
			if (settings.themelayout === "vertical"){ 
				$('.searchbar-toggle').on('click', function( ){ 
					$(this).parent('.vamshop-menu-search').toggleClass('open');
				});
			}  
		},
		horizontalNavigationMenuIcon: function() {
			if (settings.themelayout === "horizontal"){ 
				switch(settings.horizontalNavigationMenuIcon){
					case false: 
						$('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item > li > a .vamshop-menu-micon').hide(); 
						$('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-search-item > li > a .vamshop-menu-micon').show(); 
					break; 
					default:  
				}
			}  
		},
		HandleHorizontalMobileMenuToggle: function() {
			if (settings.themelayout === "horizontal"){
				$('.vamshop-menubrand-xs .menu-toggle a').on('click', function( ){
					$('.vamshop-menu-navbar').toggleClass('show-menu')
				});
			}  
		},
		  
		
		HandleVerticalScrollbar: function() {  
			console.log('called')
			function scrollBarStart(){ 
				scrollBarDestroy();
				if (settings.themelayout === "vertical"){ 
					satnt = $('#'+oid).attr('vertical-nav-type')
					if (satnt === "expanded" || satnt === "compact"){
						$(".vamshop-menu-navbar").mCustomScrollbar({
							axis:"y",  
							autoHideScrollbar: false,
							scrollInertia: 100,
							theme:"minimal",    
						});
					} 
				}  
			}
			function scrollBarDestroy(){ 
				el=$(".vamshop-menu-navbar");
				el.mCustomScrollbar("destroy"); 
			}  
			scrollBarStart();
			$(".sidebar_toggle a").click(function(){
				scrollBarStart();
			}); 
		}, 
		
		HandleDocumentClickEvent: function() {
			function closeSubMenu() {
				$(document).on('click', function(evt) {
					var target = $(evt.target); 
					var sdt = $('#'+oid).attr('vamshop-menu-device-type');
					var vnt = $('#'+oid).attr('vertical-nav-type');
					var el = $('#'+oid + ' .vamshop-menu-item li');
					if (!target.parents('.vamshop-menu-item').length) {
						if( sdt != "phone"){
							if( vnt != "expanded"){
								el.removeClass('vamshop-menu-trigger'); 
							} 
						}  
					}  
				});
			};
			function closeLeftbarSearch() {
				$(document).on('click', function(evt) {
					var target = $(evt.target); 
					var el = $('#'+oid + ' .vamshop-menu-search');
					if (!target.parents('.vamshop-menu-search').length) {
						el.removeClass('open'); 
					} 
					
				});
			};
		 
			closeSubMenu();
			closeLeftbarSearch();
		}, 
		
		
		
		
		HandleHorizontalStickyNavigation: function() {  
			switch(settings.horizontalstickynavigation){
				case true:
					$(window).on('scroll',function() {
						var scrolltop = $(this).scrollTop();
						
						if(scrolltop >= 100) { 
							$('.vamshop-menu-navbar').addClass('stickybar');
							$('stickybar').fadeIn(3000);
						}
						
						else if(scrolltop <= 100) {
							$('.vamshop-menu-navbar').removeClass('stickybar')
							$('.stickybar').fadeOut(3000);
						}
					});
				break;
				case  false:
					$('.vamshop-menu-navbar').removeClass('stickybar') 
				break;
				default:  
			}                                                                                  
        },
		HandleSubMenuOffset: function() { 
            switch(settings.themelayout){
				case 'horizontal':
					var trigger = settings.SubMenuTrigger;
				   if(trigger === "hover" ) {
					  $("li.vamshop-menu-hasmenu").on('mouseenter mouseleave', function (e) {
							if ($('.vamshop-menu-submenu', this).length) { 
								var elm = $('.vamshop-menu-submenu:first', this);
								var off = elm.offset();
								var l = off.left;
								var w = elm.width();
								var docH = $( window ).height();
								var docW = $( window ).width(); 
					
								var isEntirelyVisible = (l + w <= docW);
								if (!isEntirelyVisible) {
									$(this).addClass('edge');
								} else {
									$(this).removeClass('edge');
								}
							}     
					});
				   } else {
						 $("li.vamshop-menu-hasmenu").on('click', function (e) {
							 e.preventDefault();
							if ($('.vamshop-menu-submenu', this).length) { 
								var elm = $('.vamshop-menu-submenu:first', this);
								var off = elm.offset();
								var l = off.left;
								var w = elm.width();
								var docH = $( window ).height();
								var docW = $( window ).width(); 
					
								var isEntirelyVisible = (l + w <= docW);
								if (!isEntirelyVisible) {
									$(this).toggleClass('edge');
								} 
								 
							}     
					});  
				   }	 
				break;                                    
				default:                                         
			}  
        },
		HandleHorizontalItemIsCentered: function() {
			if (settings.themelayout === "horizontal"){
				switch(settings.horizontalNavIsCentered){
					case true:
						$('#'+oid + ' .vamshop-menu-navbar').addClass("isCentered");
					break;
					case false:
						$('#'+oid + ' .vamshop-menu-navbar').removeClass("isCentered");
					break;                                          
					default:                                         
				}
			}
        },
		HandleHorizontalItemAlignment: function() {
			var layout = settings.themelayout;
			if(layout === "horizontal" ) {
				function branditemalignment() { 
					var elm = $('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-brand');
					if (settings.horizontalBrandItem === true){
						
						switch(settings.horizontalBrandItemAlign){
							case 'left': 
								elm.removeClass('vamshop-menu-right-align');
								elm.addClass('vamshop-menu-left-align');
							break;
							case 'right': 
								elm.removeClass('vamshop-menu-left-align');
								elm.addClass('vamshop-menu-right-align');
							break;                                          
							default:                                         
						} 
					}else {
						elm.hide();
					}
				};
				function leftitemalignment() { 
					var elm = $('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-left-item');
					if (settings.horizontalLeftNavItem === true){
						switch(settings.horizontalLeftNavItemAlign){
							case 'left': 
								elm.removeClass('vamshop-menu-right-align');
								elm.addClass('vamshop-menu-left-align');
							break;
							case 'right': 
								elm.removeClass('vamshop-menu-left-align');
								elm.addClass('vamshop-menu-right-align');
							break;                                          
							default:                                         
						} 
					}else { 
						elm.hide();
					}
				};
				function rightitemalignment() {
					var elm = $('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-right-item');
					if (settings.horizontalRightItem === true){
						switch(settings.horizontalRightItemAlign){
							case 'left': 
								elm.removeClass('vamshop-menu-right-align');
								elm.addClass('vamshop-menu-left-align');
							break;
							case 'right': 
								elm.removeClass('vamshop-menu-left-align');
								elm.addClass('vamshop-menu-right-align');
							break;                                          
							default:                                         
						} 
					}else{ 
						elm.hide();
					}
				};
				function searchitemalignment() {
					var elm = $('#'+oid + '.vamshop-menu .vamshop-menu-navbar .vamshop-menu-search-item');
					if (settings.horizontalSearchItem === true){
						switch(settings.horizontalsearchItemAlign){
							case 'left': 
								elm.removeClass('vamshop-menu-right-align');
								elm.addClass('vamshop-menu-left-align');
							break;
							case 'right': 
								elm.removeClass('vamshop-menu-left-align');
								elm.addClass('vamshop-menu-right-align');
							break;                                          
							default:                                         
						} 
					}else {
						elm.hide();	 
					}
				};
				if (settings.horizontalNavIsCentered === false){
					branditemalignment();
					leftitemalignment(); 
					rightitemalignment();
					searchitemalignment(); 		 
				}
			}  
			
			
        },
		HandleVerticalNavigationView: function() { 
                switch(settings.themelayout){
				case 'vertical':
					var ev = settings.VerticalNavigationView;
					$('#'+oid + '.vamshop-menu').attr("vnavigation-view", ev );
				break;
				case 'horizontal':
					var ev = settings.horizontalNavigationView;
					$('#'+oid + '.vamshop-menu').attr("hnavigation-view", ev );
				break;                                          
				default:                                         
				}  
        },
		HandleVerticalSubMenuItemIconStyle: function() { 
                switch(settings.themelayout){
				case 'vertical':
					var ev = settings.VerticalSubMenuItemIconStyle;
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').attr("subitem-icon", ev );
				break;
				case 'horizontal':
					 $('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').attr("subitem-icon", ev );
				break;                                          
				default:                                         
				}  
        },
		HandleNavbarPosition: function() { 
				var navposition = settings.FixedNavbarPosition;
				var headerposition = settings.FixedHeaderPosition;
				var rheaderposition = settings.FixedRightHeaderPosition; 
                switch(settings.themelayout){
				case 'vertical':
					if ( navposition == true){
						$('#'+oid + ' .vamshop-menu-navbar').attr("vamshop-menu-navbar-position", 'fixed' );
						$('#'+oid + ' .vamshop-menu-header .vamshop-menu-left-header').attr("vamshop-menu-lheader-position", 'fixed' );
					}else {
						$('#'+oid + ' .vamshop-menu-navbar').attr("vamshop-menu-navbar-position", 'absolute' ); 
						$('#'+oid + ' .vamshop-menu-header .vamshop-menu-left-header').attr("vamshop-menu-lheader-position", 'absolute' );
					}
					if ( headerposition == true){
						$('#'+oid + ' .vamshop-menu-header').attr("vamshop-menu-header-position", 'fixed' );
						$('#'+oid + ' .vamshop-menu-main-container').css('margin-top', $(".vamshop-menu-header").outerHeight());
						
					}else {
						$('#'+oid + ' .vamshop-menu-header').attr("vamshop-menu-header-position", 'relative' );
						$('#'+oid + ' .vamshop-menu-main-container').css('margin-top', '0px');
					}
				break;
				case 'horizontal':
					if ( navposition == true){
						$('#'+oid + ' .vamshop-menu-navbar').attr("vamshop-menu-navbar-position", 'fixed' );
						$('#'+oid + ' .vamshop-menu-header').attr("vamshop-menu-header-position", 'fixed' );
						$('#'+oid + ' .vamshop-menu-navbar').css('margin-top', $(".vamshop-menu-header").outerHeight());
					}else{
						$('#'+oid + ' .vamshop-menu-navbar').attr("vamshop-menu-navbar-position", ' ' );
						$('#'+oid + ' .vamshop-menu-header').attr("vamshop-menu-header-position", 'relative' );
						$('#'+oid + ' .vamshop-menu-navbar').css('margin-top', '0px');
					}
				break;                                          
				default:                                         
				}  
        },
		HandleOptionSelectorPanel: function() {
            $('.selector-toggle > a').on("click", function() {
                $('#styleSelector').toggleClass('open')
            });

        },
		HandleDropDownIconStyle: function() { 
            var ev = settings.DropDownIconStyle;
			switch(settings.themelayout){
				case 'vertical':
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').attr("dropdown-icon", ev );
				break;
				case 'horizontal':
					 $('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').attr("dropdown-icon", ev );
				break;                                          
				default:                                         
			}  
        },
		HandleSubItemBorder: function() { 
                switch(settings.SubItemBorder){
				case true:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("subitem-border","true" );
				break;
				case false:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("subitem-border","false" );
				break;                                          
				default:                                         
				}  
        },
		HandleBorderStyle: function() { 
				var ev = settings.ItemBorderStyle;
                switch(settings.ItemBorder){
				case true:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("item-border-style", ev );
				break;
				case false:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("item-border-style", "" );
				break;                                          
				default:                                         
				}  
        },
		HandleItemBorder: function() { 
            switch(settings.ItemBorder){
				case true:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("item-border","true" );
				break;
				case false:
					$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-item').attr("item-border","false" );
				break;                                          
				default:                                         
			}  
        },
		HandleActiveItemStyle: function() { 
                var ev = settings.ActiveItemStyle; 
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-navbar').attr("active-item-style", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-navbar').attr("active-item-style", "style0");
				}
        },
		HandleThemeBackground: function() {
			 function themebackgroundpattern() {
                var ev = settings.ThemeBackgroundPattern; 
				if(ev != undefined && ev != "") {
					$('body').attr("themebg-pattern", ev);
				} else {
					$('body').attr("themebg-pattern", "pattern1");
				}
            };
             function setheadertheme() {
                var ev = settings.HeaderBackground; 
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-header').attr("header-theme", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-header').attr("header-theme", "theme1");
				}
            };
            function setlheadertheme() {
                var ev = settings.LHeaderBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-header .vamshop-menu-left-header').attr("lheader-theme", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-header .vamshop-menu-left-header').attr("lheader-theme", "theme1");
				}
            };
            function setnavbartheme() {
                var ev = settings.NavbarBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-navbar').attr("navbar-theme", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-navbar').attr("navbar-theme", "theme1");
				}
            };
			function setactiveitemtheme() {
                var ev = settings.ActiveItemBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-navbar').attr("active-item-theme", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-navbar').attr("active-item-theme", "theme1");
				}
            };
			function setsubitemtheme() {
                var ev = settings.SubItemBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .vamshop-menu-navbar').attr("sub-item-theme", ev);
				} else {
					$('#'+oid + ' .vamshop-menu-navbar').attr("sub-item-theme", "theme1");
				}
            };
			themebackgroundpattern();
			setheadertheme(); 
            setlheadertheme();
			setnavbartheme();  
			setactiveitemtheme();
			setsubitemtheme();
       
        },
		HandleVerticalLeftHeader: function() { 
			if (settings.themelayout === "vertical" ) {
			switch(settings.collapseVerticalLeftHeader){
				case true:
					$('#'+oid + ' .vamshop-menu-header').addClass('iscollapsed');
					$('#'+oid + ' .vamshop-menu-header').removeClass('nocollapsed');
					$('#'+oid + '.vamshop-menu').addClass('iscollapsed');
					$('#'+oid + '.vamshop-menu').removeClass('nocollapsed');
					
				   /*  $('#'+oid + ' .vamshop-menu-header.nocollapsed .vamshop-menu-left-header').css('width', '');  */
				break;
				case false:  
					$('#'+oid + ' .vamshop-menu-header').removeClass('iscollapsed');
					$('#'+oid + ' .vamshop-menu-header').addClass('nocollapsed');
					$('#'+oid + '.vamshop-menu').removeClass('iscollapsed');
					$('#'+oid + '.vamshop-menu').addClass('nocollapsed');
				   /*  $('#'+oid + ' .vamshop-menu-header.nocollapsed .vamshop-menu-left-header').css('width', $(".vamshop-menu-navbar").width());  */
				break;                                          
				default:                                         
				}
			}else {
				return false;
			}
        },
		HandleOffcanvasMenu: function() {
			if (settings.themelayout === "vertical" ) {  
				var vnt = $('#'+oid).attr("vertical-nav-type");
				 if ( vnt == "offcanvas" ){ 
					$('#'+oid).attr("vertical-layout", "wide" );   
				 } 
			}                                                                        
        },
		HandleActiveItem: function() {  
			switch(settings.activeMenuClass){
				case  "active":
					$('li:not("li.vamshop-menu-hasmenu")').on( 'click', function () {
					var str = $(this).closest('.vamshop-menu-submenu').length;
						if (str === 0){  
								$(this).closest('.vamshop-menu-inner-navbar').find('li.active').removeClass('active');
								$(this).addClass('active');
							 
						}else{
							if($(this).hasClass('active')){
								$(this).removeClass('active');
							}else{
								$(this).closest('.vamshop-menu-inner-navbar').find('li.active').removeClass('active');
								$(this).parents('.vamshop-menu-hasmenu').addClass('active');
								$(this).addClass('active');
							}
						}
				});
				break;
				case  false:
					$('.vamshop-menu-header').removeClass(settings.navbbgclass); 
				break;
				default:  
			}                                                                                  
        },
		HandleSubMenuTrigger: function(){
				 switch(settings.SubMenuTrigger){
				case 'hover': 
				$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').addClass('is-hover');
					 // Initialize
					var $window = $(window);
					var $dropdown = $('.vamshop-menu-submenu > li');
					var currentSize = $window.width();
					var currentEvent = '';
					// Attach current event on load
					(currentSize >= 767) ? bindTwo('hover') : bindTwo('click');
					// Atach window resize event
					$window.resize(function() {
						// get windows new size
						var newSize = $window.width();
						// Exit if size is same
						if (currentSize == newSize) {
							return;
						} 
						// Check if size changed, if its greater/smaller and which current event is attached so we dont attach multiple events
						if (newSize >= 767 && currentEvent != 'hover') {
							bindTwo('hover');
						} else if (newSize < 767 && currentEvent != 'click') {
							bindTwo('click');
						}
    
						// Update new size
						currentSize = newSize;
					});
					function bindTwo (eventType) {
						if (eventType == 'hover') {
							// Update currentEvent
							currentEvent = eventType;
							// Make sure all previous events are removed and attach hover
							$dropdown.off('click').off('mouseenter mouseleave').hover(
								function() {
									$(this).addClass('vamshop-menu-trigger'); 
								},
								function() {
									$(this).removeClass('vamshop-menu-trigger');
								}
							);
						}
						else if (eventType == 'click') {
							// Update currentEvent
							currentEvent = eventType;
							// Make sure all previous events are removed and attach hover
							$dropdown.off('mouseenter mouseleave').off('click').on('click',
								function(e) {
									e.stopPropagation();
									var str = $(this).closest('.vamshop-menu-submenu').length; 
									if (str === 0){
										if($(this).hasClass('vamshop-menu-trigger')){
											$(this).removeClass('vamshop-menu-trigger');
										}else{
											$(this).closest('.vamshop-menu-inner-navbar').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
											$(this).addClass('vamshop-menu-trigger');
										}
									}else{
										if($(this).hasClass('vamshop-menu-trigger')){
											$(this).removeClass('vamshop-menu-trigger');
										}else{
											$(this).closest('.vamshop-menu-submenu').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
											$(this).addClass('vamshop-menu-trigger');
										}
									}
								}
							);
						}
					}
				break; 
				case 'click': 
				$('#'+oid + ' .vamshop-menu-navbar .vamshop-menu-hasmenu').removeClass('is-hover');
					$(".vamshop-menu-submenu > li").on( 'click', function (e) {
						e.stopPropagation();
					var str = $(this).closest('.vamshop-menu-submenu').length; 
						if (str === 0){
							if($(this).hasClass('vamshop-menu-trigger')){
								$(this).removeClass('vamshop-menu-trigger');
							}else{
								$(this).closest('.vamshop-menu-inner-navbar').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
								$(this).addClass('vamshop-menu-trigger');
							}
						}else{
							if($(this).hasClass('vamshop-menu-trigger')){
								$(this).removeClass('vamshop-menu-trigger');
							}else{
								$(this).closest('.vamshop-menu-submenu').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
								$(this).addClass('vamshop-menu-trigger');
							}
						}
				});
				break; 
				 }
		},
		HandleMenuTrigger: function(){ 
			
			switch(settings.MenuTrigger){
				case 'hover':
				$('#'+oid + ' .vamshop-menu-navbar').addClass('is-hover');
					 // Initialize
					var $window = $(window);
					var $dropdown = $(".vamshop-menu-item > li");
					var currentSize = $window.width();
					var currentEvent = '';
					// Attach current event on load
					(currentSize >= 767) ? bindOne('hover') : bindOne('click');
					// Atach window resize event
					$window.resize(function() {
						// get windows new size
						var newSize = $window.width();
						// Exit if size is same
						if (currentSize == newSize) {
							return;
						} 
						// Check if size changed, if its greater/smaller and which current event is attached so we dont attach multiple events
						if (newSize >= 767 && currentEvent != 'hover') {
							bindOne('hover');
						} else if (newSize < 767 && currentEvent != 'click') {
							bindOne('click');
						}
    
						// Update new size
						currentSize = newSize;
					});
					function bindOne (eventType) {
						if (eventType == 'hover') {
							// Update currentEvent
							currentEvent = eventType;
							// Make sure all previous events are removed and attach hover
							$dropdown.off('click').off('mouseenter mouseleave').hover(
								function() {
									$(this).addClass('vamshop-menu-trigger'); 
								},
								function() { 
									$(this).removeClass('vamshop-menu-trigger');
								}
							);
						}
						else if (eventType == 'click') {
							// Update currentEvent
							currentEvent = eventType;
							// Make sure all previous events are removed and attach hover
							$dropdown.off('mouseenter mouseleave').off('click').on('click',
								function() {
									if($(this).hasClass('vamshop-menu-trigger')){
										$(this).removeClass('vamshop-menu-trigger');
									}else{
										$(this).closest('.vamshop-menu-inner-navbar').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
										$(this).addClass('vamshop-menu-trigger');
									}
								}
							);
						}
					} 
				break; 
				case 'click':
				$('#'+oid + ' .vamshop-menu-navbar').removeClass('is-hover');
					$(".vamshop-menu-item > li ").on( 'click', function () {
						if($(this).hasClass('vamshop-menu-trigger')){
							$(this).removeClass('vamshop-menu-trigger');
						}else{
							$(this).closest('.vamshop-menu-inner-navbar').find('li.vamshop-menu-trigger').removeClass('vamshop-menu-trigger');
							$(this).addClass('vamshop-menu-trigger');
						}
						 
					});
				break; 
			}  
		},
		HandleMenuOnClick: function() {			
			var totalwidth = $(window)[0].innerWidth;
			if (settings.themelayout === "vertical" ) {
				$('.sidebar_toggle a, .vamshop-menu-overlay-box').on("click", function() {
					$(this).parent().find('.menu-icon').toggleClass("is-clicked");
					var dt = $('#'+oid).attr("vamshop-menu-device-type");
					if ( dt == "desktop" ){
						var dmc = settings.onToggleVerticalMenu.desktop;
						var dm = settings.defaultVerticalMenu.desktop; 
						var dn = $('#'+oid).attr("vertical-nav-type");
						if ( dn == dm ) {
							$('#'+oid).attr("vertical-nav-type", dmc);
						}else if (dn == dmc ) {
							$('#'+oid).attr("vertical-nav-type", dm);
						} else {
							return false;
						}
					}else if ( dt == "tablet"){
						var tmc = settings.onToggleVerticalMenu.tablet;
						var tm = settings.defaultVerticalMenu.tablet; 
						var tn = $('#'+oid).attr("vertical-nav-type");
						if ( tn == tm ) {
							$('#'+oid).attr("vertical-nav-type", tmc);
						}else if (dn == dmc ) {
							$('#'+oid).attr("vertical-nav-type", tm);
						} 
					}else if ( dt == "phone"){
						var pmc = settings.onToggleVerticalMenu.phone;
						var pm = settings.defaultVerticalMenu.phone; 
						var pn = $('#'+oid).attr("vertical-nav-type");
						if ( pn == pm ) {
							$('#'+oid).attr("vertical-nav-type", pmc);
						}else if (dn == dmc ) {
							$('#'+oid).attr("vertical-nav-type", pm);
						} 
					}
					$('.vamshop-menu').addClass("vamshop-menu-toggle-animate"); 
					setTimeout(function(){
						 $('.vamshop-menu').removeClass("vamshop-menu-toggle-animate");  
					}, 250);		
				});
			}else if (settings.themelayout === "horizontal" )  { 
				if (totalwidth >= 768 && totalwidth <= 1024) {
						$('#'+oid).attr("vamshop-menu-device-type", "tablet");
				} else if (totalwidth < 768) {
						$('#'+oid).attr("vamshop-menu-device-type", "phone");
				} else { 
						$('#'+oid).attr("vamshop-menu-device-type", "desktop");
				}
			}
		},
		Handlecomponetheight: function() {
			function setHeight() {
				var WH = $(window).height();
                var HH = $(".vamshop-menu-header").innerHeight();
                var NH = $(".vamshop-menu-navbar").innerHeight();
				var FH = $(".vamshop-menu-footer").innerHeight();
                var contentHH = WH - HH;
				var contentVH = WH - HH ;
				var lpanelH = WH - HH ;
				if (settings.themelayout === "horizontal" ) {  
					$(".vamshop-menu-main-container").css('min-height', contentHH);
				} else if (settings.themelayout === "vertical" ) {
					if ( contentVH >= lpanelH ){
						$(".vamshop-menu-main-container").css('min-height', contentVH); 
					}else {
						$(".vamshop-menu-main-container").css('min-height', lpanelH); 
					}
				} else {
					return false;
				}                   
            }; 
			setHeight();

            $(window).resize(function() {
                setHeight();
            }); 
			 
        },
		HandleDeviceType: function() {			
            function devicesize() {
				var totalwidth = $(window)[0].innerWidth;
				if (settings.themelayout === "vertical" ) {  
					if (totalwidth >= 768 && totalwidth <= 1024) { 
						$('#'+oid).attr("vamshop-menu-device-type", "tablet");
						var value = settings.defaultVerticalMenu.tablet;
						if(value != undefined && value != "") {
							$('#'+oid).attr("vertical-nav-type", value);
						} else {
							$('#'+oid).attr("vertical-nav-type", "collapsed");
						} 
						
						var ev = settings.verticalMenueffect.tablet;
						if(ev != undefined && value != "") {
							$('#'+oid).attr("vertical-effect", ev);
						} else {
							$('#'+oid).attr("vertical-effect", "shrink");
						}   
						
					} else if (totalwidth < 768) {
						
						$('#'+oid).attr("vamshop-menu-device-type", "phone");
						
						var value = settings.defaultVerticalMenu.phone;
						if(value != undefined && value != "") {
							$('#'+oid).attr("vertical-nav-type", value);
						} else {
							$('#'+oid).attr("vertical-nav-type", "offcanvas");
						}
						
						var ev = settings.verticalMenueffect.phone;
						if(ev != undefined && value != "") {
							$('#'+oid).attr("vertical-effect", ev);
						} else {
							$('#'+oid).attr("vertical-effect", "push");
						} 
						
					} else { 
						$('#'+oid).attr("vamshop-menu-device-type", "desktop");
						var value = settings.defaultVerticalMenu.desktop;
						if(value != undefined && value != "") {
							$('#'+oid).attr("vertical-nav-type", value);
						} else {
							$('#'+oid).attr("vertical-nav-type", "expanded");
						}
						
						var ev = settings.verticalMenueffect.desktop;
						if(ev != undefined && value != "") {
							$('#'+oid).attr("vertical-effect", ev);
						} else {
							$('#'+oid).attr("vertical-effect", "shrink");
						} 
						
					} 
				}else if (settings.themelayout === "horizontal" )  { 
					if (totalwidth >= 768 && totalwidth <= 1024) {
						$('#'+oid).attr("vamshop-menu-device-type", "tablet");
					} else if (totalwidth < 768) {
						$('#'+oid).attr("vamshop-menu-device-type", "phone");
					} else { 
						$('#'+oid).attr("vamshop-menu-device-type", "desktop");
					}
				
				}
			};
            devicesize();

             $(window).resize(function() { 
				tw = $(window)[0].innerWidth;
				dt = $('#'+oid).attr('vamshop-menu-device-type')
                if ( dt == 'desktop'  && tw < 1024 ) {
					devicesize();
					VamshopMenu.HandleVerticalScrollbar();
				} else if ( dt == 'phone'  && tw > 768 ) {
					devicesize();
					VamshopMenu.HandleVerticalScrollbar();
				} else if ( dt == 'tablet' && tw < 768 ) { 
					devicesize();
					VamshopMenu.HandleVerticalScrollbar();
				}else if ( dt == 'tablet' && tw > 1024 ) { 
					devicesize();
					VamshopMenu.HandleVerticalScrollbar();
				}
            }); 
        }, 
		HandleMenulayout: function() {
			if (settings.themelayout === "vertical" ) { 
			switch(settings.verticalMenulayout){
				case 'wide':
					$('#'+oid).attr("vertical-layout","wide" );
				break;
				case 'box':  
					$('#'+oid).attr("vertical-layout","box" );
				break; 
				case 'widebox':  
					$('#'+oid).attr("vertical-layout","widebox" );
				break;                          
				default:                                         
				} 
			} 
			else if (settings.themelayout === "horizontal" ) { 
			switch(settings.horizontalMenulayout){
				case 'wide':
					$('#'+oid).attr("horizontal-layout","wide" );
				break;
				case 'box':  
					$('#'+oid).attr("horizontal-layout","box" );
				break;
				case 'widebox':  
					$('#'+oid).attr("horizontal-layout","widebox" );
				break;                                          
				default:                                         
				} 
			} 
			else {
				return false;
			}
			 
        }, 
		HandlehorizontalMenuplacement: function() {
			if (settings.themelayout === "horizontal" ) { 
			switch(settings.horizontalMenuplacement){
				case 'bottom':
					$('#'+oid).attr("horizontal-placement","bottom" );
				break;
				case 'top':  
					$('#'+oid).attr("horizontal-placement","top" );
				break;                                 
				default:                                         
				} 
			} 
			else {
				$('#'+oid).removeAttr("horizontal-placement");
			}                                                                                 
        },
		HandleverticalMenuplacement: function() {
			if (settings.themelayout === "vertical" ) { 
			switch(settings.verticalMenuplacement){
				case 'left':
					$('#'+oid).attr("vertical-placement","left" );
				break;
				case 'right':  
					$('#'+oid).attr("vertical-placement","right" );
				break;                                          
				default:                                         
				} 
			} 
			else {
				$('#'+oid).removeAttr("vertical-placement");
			}                                                                                 
        }, 
		Handlethemelayout: function() {
			switch(settings.themelayout){
				case 'horizontal':
					$('#'+oid).attr("theme-layout","horizontal" );
				break;
				case 'vertical':  
					$('#'+oid).attr("theme-layout","vertical" );
				break;                                          
				default:                                         
				}                                                                                  
        },  
    };
	VamshopMenu.VamshopMenuInit();
};

 

 