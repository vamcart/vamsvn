$.fn.scoopmenu = function( settings ) {
	var oid = this.attr("id");
    // Scoop Menu default settings:
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
	var ScoopMenu = {
        ScoopMenuInit: function() {
			ScoopMenu.Handlethemelayout();
			ScoopMenu.HandleverticalMenuplacement();
			ScoopMenu.HandlehorizontalMenuplacement();
			ScoopMenu.HandleMenulayout();
			ScoopMenu.HandleDeviceType();
			ScoopMenu.Handlecomponetheight();
			ScoopMenu.HandleMenuOnClick();
			ScoopMenu.HandleMenuTrigger();
			ScoopMenu.HandleSubMenuTrigger();
			ScoopMenu.HandleActiveItem();
			ScoopMenu.HandleOffcanvasMenu();
			ScoopMenu.HandleVerticalLeftHeader();
			ScoopMenu.HandleThemeBackground();
			ScoopMenu.HandleActiveItemStyle();
			ScoopMenu.HandleItemBorder ();
			ScoopMenu.HandleBorderStyle ();
			ScoopMenu.HandleSubItemBorder ();
			ScoopMenu.HandleDropDownIconStyle ();
			ScoopMenu.HandleOptionSelectorPanel ();
			ScoopMenu.HandleNavbarPosition ();
			ScoopMenu.HandleVerticalSubMenuItemIconStyle ();
			ScoopMenu.HandleVerticalNavigationView ();
			ScoopMenu.HandleHorizontalItemIsCentered();
			ScoopMenu.HandleHorizontalItemAlignment ();
			ScoopMenu.HandleSubMenuOffset();
			ScoopMenu.HandleHorizontalStickyNavigation(); 
			ScoopMenu.HandleDocumentClickEvent(); 
			ScoopMenu.HandleVerticalScrollbar();
			ScoopMenu.HandleHorizontalMobileMenuToggle();
			ScoopMenu.horizontalNavigationMenuIcon();
			ScoopMenu.verticalNavigationSearchBar();
			ScoopMenu.safariBrowsercompatibility();
			
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
					$(this).parent('.scoop-search').toggleClass('open');
				});
			}  
		},
		horizontalNavigationMenuIcon: function() {
			if (settings.themelayout === "horizontal"){ 
				switch(settings.horizontalNavigationMenuIcon){
					case false: 
						$('#'+oid + '.scoop .scoop-navbar .scoop-item > li > a .scoop-micon').hide(); 
						$('#'+oid + '.scoop .scoop-navbar .scoop-item.scoop-search-item > li > a .scoop-micon').show(); 
					break; 
					default:  
				}
			}  
		},
		HandleHorizontalMobileMenuToggle: function() {
			if (settings.themelayout === "horizontal"){
				$('.scoopbrand-xs .menu-toggle a').on('click', function( ){
					$('.scoop-navbar').toggleClass('show-menu')
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
						$(".scoop-navbar").mCustomScrollbar({
							axis:"y",  
							autoHideScrollbar: false,
							scrollInertia: 100,
							theme:"minimal",    
						});
					} 
				}  
			}
			function scrollBarDestroy(){ 
				el=$(".scoop-navbar");
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
					var sdt = $('#'+oid).attr('scoop-device-type');
					var vnt = $('#'+oid).attr('vertical-nav-type');
					var el = $('#'+oid + ' .scoop-item li');
					if (!target.parents('.scoop-item').length) {
						if( sdt != "phone"){
							if( vnt != "expanded"){
								el.removeClass('scoop-trigger'); 
							} 
						}  
					}  
				});
			};
			function closeLeftbarSearch() {
				$(document).on('click', function(evt) {
					var target = $(evt.target); 
					var el = $('#'+oid + ' .scoop-search');
					if (!target.parents('.scoop-search').length) {
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
							$('.scoop-navbar').addClass('stickybar');
							$('stickybar').fadeIn(3000);
						}
						
						else if(scrolltop <= 100) {
							$('.scoop-navbar').removeClass('stickybar')
							$('.stickybar').fadeOut(3000);
						}
					});
				break;
				case  false:
					$('.scoop-navbar').removeClass('stickybar') 
				break;
				default:  
			}                                                                                  
        },
		HandleSubMenuOffset: function() { 
            switch(settings.themelayout){
				case 'horizontal':
					var trigger = settings.SubMenuTrigger;
				   if(trigger === "hover" ) {
					  $("li.scoop-hasmenu").on('mouseenter mouseleave', function (e) {
							if ($('.scoop-submenu', this).length) { 
								var elm = $('.scoop-submenu:first', this);
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
						 $("li.scoop-hasmenu").on('click', function (e) {
							 e.preventDefault();
							if ($('.scoop-submenu', this).length) { 
								var elm = $('.scoop-submenu:first', this);
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
						$('#'+oid + ' .scoop-navbar').addClass("isCentered");
					break;
					case false:
						$('#'+oid + ' .scoop-navbar').removeClass("isCentered");
					break;                                          
					default:                                         
				}
			}
        },
		HandleHorizontalItemAlignment: function() {
			var layout = settings.themelayout;
			if(layout === "horizontal" ) {
				function branditemalignment() { 
					var elm = $('#'+oid + '.scoop .scoop-navbar .scoop-brand');
					if (settings.horizontalBrandItem === true){
						
						switch(settings.horizontalBrandItemAlign){
							case 'left': 
								elm.removeClass('scoop-right-align');
								elm.addClass('scoop-left-align');
							break;
							case 'right': 
								elm.removeClass('scoop-left-align');
								elm.addClass('scoop-right-align');
							break;                                          
							default:                                         
						} 
					}else {
						elm.hide();
					}
				};
				function leftitemalignment() { 
					var elm = $('#'+oid + '.scoop .scoop-navbar .scoop-item.scoop-left-item');
					if (settings.horizontalLeftNavItem === true){
						switch(settings.horizontalLeftNavItemAlign){
							case 'left': 
								elm.removeClass('scoop-right-align');
								elm.addClass('scoop-left-align');
							break;
							case 'right': 
								elm.removeClass('scoop-left-align');
								elm.addClass('scoop-right-align');
							break;                                          
							default:                                         
						} 
					}else { 
						elm.hide();
					}
				};
				function rightitemalignment() {
					var elm = $('#'+oid + '.scoop .scoop-navbar .scoop-item.scoop-right-item');
					if (settings.horizontalRightItem === true){
						switch(settings.horizontalRightItemAlign){
							case 'left': 
								elm.removeClass('scoop-right-align');
								elm.addClass('scoop-left-align');
							break;
							case 'right': 
								elm.removeClass('scoop-left-align');
								elm.addClass('scoop-right-align');
							break;                                          
							default:                                         
						} 
					}else{ 
						elm.hide();
					}
				};
				function searchitemalignment() {
					var elm = $('#'+oid + '.scoop .scoop-navbar .scoop-search-item');
					if (settings.horizontalSearchItem === true){
						switch(settings.horizontalsearchItemAlign){
							case 'left': 
								elm.removeClass('scoop-right-align');
								elm.addClass('scoop-left-align');
							break;
							case 'right': 
								elm.removeClass('scoop-left-align');
								elm.addClass('scoop-right-align');
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
					$('#'+oid + '.scoop').attr("vnavigation-view", ev );
				break;
				case 'horizontal':
					var ev = settings.horizontalNavigationView;
					$('#'+oid + '.scoop').attr("hnavigation-view", ev );
				break;                                          
				default:                                         
				}  
        },
		HandleVerticalSubMenuItemIconStyle: function() { 
                switch(settings.themelayout){
				case 'vertical':
					var ev = settings.VerticalSubMenuItemIconStyle;
					$('#'+oid + ' .scoop-navbar .scoop-hasmenu').attr("subitem-icon", ev );
				break;
				case 'horizontal':
					 $('#'+oid + ' .scoop-navbar .scoop-hasmenu').attr("subitem-icon", ev );
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
						$('#'+oid + ' .scoop-navbar').attr("scoop-navbar-position", 'fixed' );
						$('#'+oid + ' .scoop-header .scoop-left-header').attr("scoop-lheader-position", 'fixed' );
					}else {
						$('#'+oid + ' .scoop-navbar').attr("scoop-navbar-position", 'absolute' ); 
						$('#'+oid + ' .scoop-header .scoop-left-header').attr("scoop-lheader-position", 'absolute' );
					}
					if ( headerposition == true){
						$('#'+oid + ' .scoop-header').attr("scoop-header-position", 'fixed' );
						$('#'+oid + ' .scoop-main-container').css('margin-top', $(".scoop-header").outerHeight());
						
					}else {
						$('#'+oid + ' .scoop-header').attr("scoop-header-position", 'relative' );
						$('#'+oid + ' .scoop-main-container').css('margin-top', '0px');
					}
				break;
				case 'horizontal':
					if ( navposition == true){
						$('#'+oid + ' .scoop-navbar').attr("scoop-navbar-position", 'fixed' );
						$('#'+oid + ' .scoop-header').attr("scoop-header-position", 'fixed' );
						$('#'+oid + ' .scoop-navbar').css('margin-top', $(".scoop-header").outerHeight());
					}else{
						$('#'+oid + ' .scoop-navbar').attr("scoop-navbar-position", ' ' );
						$('#'+oid + ' .scoop-header').attr("scoop-header-position", 'relative' );
						$('#'+oid + ' .scoop-navbar').css('margin-top', '0px');
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
					$('#'+oid + ' .scoop-navbar .scoop-hasmenu').attr("dropdown-icon", ev );
				break;
				case 'horizontal':
					 $('#'+oid + ' .scoop-navbar .scoop-hasmenu').attr("dropdown-icon", ev );
				break;                                          
				default:                                         
			}  
        },
		HandleSubItemBorder: function() { 
                switch(settings.SubItemBorder){
				case true:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("subitem-border","true" );
				break;
				case false:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("subitem-border","false" );
				break;                                          
				default:                                         
				}  
        },
		HandleBorderStyle: function() { 
				var ev = settings.ItemBorderStyle;
                switch(settings.ItemBorder){
				case true:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("item-border-style", ev );
				break;
				case false:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("item-border-style", "" );
				break;                                          
				default:                                         
				}  
        },
		HandleItemBorder: function() { 
            switch(settings.ItemBorder){
				case true:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("item-border","true" );
				break;
				case false:
					$('#'+oid + ' .scoop-navbar .scoop-item').attr("item-border","false" );
				break;                                          
				default:                                         
			}  
        },
		HandleActiveItemStyle: function() { 
                var ev = settings.ActiveItemStyle; 
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .scoop-navbar').attr("active-item-style", ev);
				} else {
					$('#'+oid + ' .scoop-navbar').attr("active-item-style", "style0");
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
					$('#'+oid + ' .scoop-header').attr("header-theme", ev);
				} else {
					$('#'+oid + ' .scoop-header').attr("header-theme", "theme1");
				}
            };
            function setlheadertheme() {
                var ev = settings.LHeaderBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .scoop-header .scoop-left-header').attr("lheader-theme", ev);
				} else {
					$('#'+oid + ' .scoop-header .scoop-left-header').attr("lheader-theme", "theme1");
				}
            };
            function setnavbartheme() {
                var ev = settings.NavbarBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .scoop-navbar').attr("navbar-theme", ev);
				} else {
					$('#'+oid + ' .scoop-navbar').attr("navbar-theme", "theme1");
				}
            };
			function setactiveitemtheme() {
                var ev = settings.ActiveItemBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .scoop-navbar').attr("active-item-theme", ev);
				} else {
					$('#'+oid + ' .scoop-navbar').attr("active-item-theme", "theme1");
				}
            };
			function setsubitemtheme() {
                var ev = settings.SubItemBackground;
				if(ev != undefined && ev != "") {
					$('#'+oid + ' .scoop-navbar').attr("sub-item-theme", ev);
				} else {
					$('#'+oid + ' .scoop-navbar').attr("sub-item-theme", "theme1");
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
					$('#'+oid + ' .scoop-header').addClass('iscollapsed');
					$('#'+oid + ' .scoop-header').removeClass('nocollapsed');
					$('#'+oid + '.scoop').addClass('iscollapsed');
					$('#'+oid + '.scoop').removeClass('nocollapsed');
					
				   /*  $('#'+oid + ' .scoop-header.nocollapsed .scoop-left-header').css('width', '');  */
				break;
				case false:  
					$('#'+oid + ' .scoop-header').removeClass('iscollapsed');
					$('#'+oid + ' .scoop-header').addClass('nocollapsed');
					$('#'+oid + '.scoop').removeClass('iscollapsed');
					$('#'+oid + '.scoop').addClass('nocollapsed');
				   /*  $('#'+oid + ' .scoop-header.nocollapsed .scoop-left-header').css('width', $(".scoop-navbar").width());  */
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
					$('li:not("li.scoop-hasmenu")').on( 'click', function () {
					var str = $(this).closest('.scoop-submenu').length;
						if (str === 0){  
								$(this).closest('.scoop-inner-navbar').find('li.active').removeClass('active');
								$(this).addClass('active');
							 
						}else{
							if($(this).hasClass('active')){
								$(this).removeClass('active');
							}else{
								$(this).closest('.scoop-inner-navbar').find('li.active').removeClass('active');
								$(this).parents('.scoop-hasmenu').addClass('active');
								$(this).addClass('active');
							}
						}
				});
				break;
				case  false:
					$('.scoop-header').removeClass(settings.navbbgclass); 
				break;
				default:  
			}                                                                                  
        },
		HandleSubMenuTrigger: function(){
				 switch(settings.SubMenuTrigger){
				case 'hover': 
				$('#'+oid + ' .scoop-navbar .scoop-hasmenu').addClass('is-hover');
					 // Initialize
					var $window = $(window);
					var $dropdown = $('.scoop-submenu > li');
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
									$(this).addClass('scoop-trigger'); 
								},
								function() {
									$(this).removeClass('scoop-trigger');
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
									var str = $(this).closest('.scoop-submenu').length; 
									if (str === 0){
										if($(this).hasClass('scoop-trigger')){
											$(this).removeClass('scoop-trigger');
										}else{
											$(this).closest('.scoop-inner-navbar').find('li.scoop-trigger').removeClass('scoop-trigger');
											$(this).addClass('scoop-trigger');
										}
									}else{
										if($(this).hasClass('scoop-trigger')){
											$(this).removeClass('scoop-trigger');
										}else{
											$(this).closest('.scoop-submenu').find('li.scoop-trigger').removeClass('scoop-trigger');
											$(this).addClass('scoop-trigger');
										}
									}
								}
							);
						}
					}
				break; 
				case 'click': 
				$('#'+oid + ' .scoop-navbar .scoop-hasmenu').removeClass('is-hover');
					$(".scoop-submenu > li").on( 'click', function (e) {
						e.stopPropagation();
					var str = $(this).closest('.scoop-submenu').length; 
						if (str === 0){
							if($(this).hasClass('scoop-trigger')){
								$(this).removeClass('scoop-trigger');
							}else{
								$(this).closest('.scoop-inner-navbar').find('li.scoop-trigger').removeClass('scoop-trigger');
								$(this).addClass('scoop-trigger');
							}
						}else{
							if($(this).hasClass('scoop-trigger')){
								$(this).removeClass('scoop-trigger');
							}else{
								$(this).closest('.scoop-submenu').find('li.scoop-trigger').removeClass('scoop-trigger');
								$(this).addClass('scoop-trigger');
							}
						}
				});
				break; 
				 }
		},
		HandleMenuTrigger: function(){ 
			
			switch(settings.MenuTrigger){
				case 'hover':
				$('#'+oid + ' .scoop-navbar').addClass('is-hover');
					 // Initialize
					var $window = $(window);
					var $dropdown = $(".scoop-item > li");
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
									$(this).addClass('scoop-trigger'); 
								},
								function() { 
									$(this).removeClass('scoop-trigger');
								}
							);
						}
						else if (eventType == 'click') {
							// Update currentEvent
							currentEvent = eventType;
							// Make sure all previous events are removed and attach hover
							$dropdown.off('mouseenter mouseleave').off('click').on('click',
								function() {
									if($(this).hasClass('scoop-trigger')){
										$(this).removeClass('scoop-trigger');
									}else{
										$(this).closest('.scoop-inner-navbar').find('li.scoop-trigger').removeClass('scoop-trigger');
										$(this).addClass('scoop-trigger');
									}
								}
							);
						}
					} 
				break; 
				case 'click':
				$('#'+oid + ' .scoop-navbar').removeClass('is-hover');
					$(".scoop-item > li ").on( 'click', function () {
						if($(this).hasClass('scoop-trigger')){
							$(this).removeClass('scoop-trigger');
						}else{
							$(this).closest('.scoop-inner-navbar').find('li.scoop-trigger').removeClass('scoop-trigger');
							$(this).addClass('scoop-trigger');
						}
						 
					});
				break; 
			}  
		},
		HandleMenuOnClick: function() {			
			var totalwidth = $(window)[0].innerWidth;
			if (settings.themelayout === "vertical" ) {
				$('.sidebar_toggle a, .scoop-overlay-box').on("click", function() {
					$(this).parent().find('.menu-icon').toggleClass("is-clicked");
					var dt = $('#'+oid).attr("scoop-device-type");
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
					$('.scoop').addClass("scoop-toggle-animate"); 
					setTimeout(function(){
						 $('.scoop').removeClass("scoop-toggle-animate");  
					}, 250);		
				});
			}else if (settings.themelayout === "horizontal" )  { 
				if (totalwidth >= 768 && totalwidth <= 1024) {
						$('#'+oid).attr("scoop-device-type", "tablet");
				} else if (totalwidth < 768) {
						$('#'+oid).attr("scoop-device-type", "phone");
				} else { 
						$('#'+oid).attr("scoop-device-type", "desktop");
				}
			}
		},
		Handlecomponetheight: function() {
			function setHeight() {
				var WH = $(window).height();
                var HH = $(".scoop-header").innerHeight();
                var NH = $(".scoop-navbar").innerHeight();
				var FH = $(".scoop-footer").innerHeight();
                var contentHH = WH - HH;
				var contentVH = WH - HH ;
				var lpanelH = WH - HH ;
				if (settings.themelayout === "horizontal" ) {  
					$(".scoop-main-container").css('min-height', contentHH);
				} else if (settings.themelayout === "vertical" ) {
					if ( contentVH >= lpanelH ){
						$(".scoop-main-container").css('min-height', contentVH); 
					}else {
						$(".scoop-main-container").css('min-height', lpanelH); 
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
						$('#'+oid).attr("scoop-device-type", "tablet");
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
						
						$('#'+oid).attr("scoop-device-type", "phone");
						
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
						$('#'+oid).attr("scoop-device-type", "desktop");
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
						$('#'+oid).attr("scoop-device-type", "tablet");
					} else if (totalwidth < 768) {
						$('#'+oid).attr("scoop-device-type", "phone");
					} else { 
						$('#'+oid).attr("scoop-device-type", "desktop");
					}
				
				}
			};
            devicesize();

             $(window).resize(function() { 
				tw = $(window)[0].innerWidth;
				dt = $('#'+oid).attr('scoop-device-type')
                if ( dt == 'desktop'  && tw < 1024 ) {
					devicesize();
					ScoopMenu.HandleVerticalScrollbar();
				} else if ( dt == 'phone'  && tw > 768 ) {
					devicesize();
					ScoopMenu.HandleVerticalScrollbar();
				} else if ( dt == 'tablet' && tw < 768 ) { 
					devicesize();
					ScoopMenu.HandleVerticalScrollbar();
				}else if ( dt == 'tablet' && tw > 1024 ) { 
					devicesize();
					ScoopMenu.HandleVerticalScrollbar();
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
	ScoopMenu.ScoopMenuInit();
};

 

 