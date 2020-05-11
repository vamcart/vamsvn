
$( document ).ready(function() {

	$( "#vamshop-menu" ).menu({
		themelayout: 'horizontal', 
		horizontalMenulayout: 'wide',
		horizontalMenuplacement: 'top',
		horizontalBrandItem: true,
		horizontalLeftNavItem: true,
		horizontalRightItem: true,
		horizontalSearchItem: true,
		horizontalBrandItemAlign: 'left',
		horizontalLeftNavItemAlign: 'left',
		horizontalRightItemAlign: 'right',
		horizontalsearchItemAlign: 'right',
		horizontalMobileMenu: true,
		MenuTrigger: 'hover',
		SubMenuTrigger: 'hover',
		activeMenuClass: 'active',
		ThemeBackgroundPattern: 'pattern6',
		HeaderBackground: 'theme4' ,
		LHeaderBackground :'theme2',
		NavbarBackground: 'theme2',
		ActiveItemBackground: 'theme0',
		SubItemBackground: 'theme2', 
		ActiveItemStyle: 'style0',
		ItemBorder: true,
		ItemBorderStyle: 'solid',
		SubItemBorder: true,
		DropDownIconStyle: 'style1', // Value should be style1,style2,style3
		FixedNavbarPosition: false,
		FixedHeaderPosition: false,
		horizontalNavIsCentered: false,
		horizontalstickynavigation: false,
		horizontalNavigationMenuIcon: true,
	});

 /* Navbar Theme Change function Start */
	function handlenavbartheme() {
		$('.theme-color > a.navbar-theme').on("click", function() {
			var navbartheme = $(this).attr("navbar-theme");
			$('.vamshop-menu-navbar').attr("navbar-theme", navbartheme);
        });
    };

	handlenavbartheme();
 /* Navbar Theme Change function Close */

 /* Navbar Theme Change function Start */
	function handleActiveItemTheme() {
		$('.theme-color > a.active-item-theme').on("click", function() {
			var AtciveItemTheme = $(this).attr("active-item-theme");
			$('.vamshop-menu-navbar').attr("active-item-theme", AtciveItemTheme);
        });
    };

	handleActiveItemTheme();
 /* Navbar Theme Change function Close */ 
 

 /* Theme background pattren Change function Start */
	function handlethemebgpattern() {
		$('.theme-color > a.themebg-pattern').on("click", function() {
			var themebgpattern = $(this).attr("themebg-pattern");
			$('body').attr("themebg-pattern", themebgpattern);
        });
    };

	handlethemebgpattern();
 /* Theme background pattren Change function Close */
  
 /* Theme Layout Change function start*/
	function handlethemehorizontallayout() {
		$('#theme-layout').val('wide').on('change', function (get_value) {
			get_value = $(this).val();
			$('.vamshop-menu').attr('horizontal-layout', get_value);
		});
	};

   handlethemehorizontallayout ();
 /* Theme Layout Change function Close*/
 
 /*Menu Placement change function start*/
   function handleMenuPlacement() {
		$('#navbar-placement').val('top').on('change', function (get_value) {
			get_value = $(this).val();
			$('.vamshop-menu').attr('horizontal-placement', get_value); 
		});
	};

   handleMenuPlacement ();
 /*Menu Placement change function Close*/
 
 
 
 /*Item border change function Start*/
	function handleIItemBorder() {
			$('#item-border').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu-navbar .vamshop-menu-item').attr('item-border', 'false');
				}else {
					$('.vamshop-menu-navbar .vamshop-menu-item').attr('item-border', 'true');
				}
			});
		};

   handleIItemBorder ();
 /*Item border change function Close*/
 
 
 /*SubItem border change function Start*/
   function handleSubIItemBorder() {
			$('#subitem-border').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu-navbar .vamshop-menu-item').attr('subitem-border', 'false');
				}else {
					$('.vamshop-menu-navbar .vamshop-menu-item').attr('subitem-border', 'true');
				}
			});
		};

   handleSubIItemBorder ();
 /*SubItem border change function Close*/
 
 
 /*Item border Style change function Start*/
   function handlBoderStyle() {
		$('#border-style').val('solid').on('change', function (get_value) {
			get_value = $(this).val();
			$('.vamshop-menu-navbar .vamshop-menu-item').attr('item-border-style', get_value);
		});
	};

   handlBoderStyle ();
 /*Item border Style change function Close*/
 
 
 
 
 /*Dropdown Icon change function Start*/
      function handleDropDownIconStyle() {
		$('#dropdown-icon').val('style1').on('change', function (get_value) {
			get_value = $(this).val();
			$('.vamshop-menu-navbar .vamshop-menu-hasmenu').attr('dropdown-icon', get_value);
		});
	};

   handleDropDownIconStyle ();
 /*Dropdown Icon change function Close*/
 
 
 
 
 
 /* Horizontal Navbar Position change function Start*/
	function handleNavigationPosition() {
			$('#sidebar-position').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu-navbar').attr("vamshop-menu-navbar-position", 'fixed' ); 
				}else {
					$('.vamshop-menu-navbar').attr("vamshop-menu-navbar-position", 'relative' ); 
				}
			});
		};

   handleNavigationPosition ();
   
 /* Horizontal Navbar Position change function Close*/
 /* Hide Show Menu Icon */
 	function handleNavigationMenuIcon() {
			$('#menu-icons').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item > li > a .vamshop-menu-micon:not(".vamshop-menu-search-item .vamshop-menu-micon")').hide();
				}else {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item > li > a .vamshop-menu-micon:not(".vamshop-menu-search-item .vamshop-menu-micon")').show();
				}
			});
		};

	handleNavigationMenuIcon ();
   /* Hide Show Brand logo */
    function handleVamshopMenuBrandVisibility() {
			$('#brand-visibility').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-brand').hide();
				}else {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-brand').show();
				}
			});
		};

	handleVamshopMenuBrandVisibility (); 
	function handleVamshopMenuLeftItemVisibility() {
			$('#leftitem-visibility').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-left-item').hide();
				}else {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-left-item').show();
				}
			});
		}; 
	handleVamshopMenuLeftItemVisibility ();
	function handleVamshopMenuRightItemVisibility() {
			$('#rightitem-visibility').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-right-item').hide();
				}else {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-right-item').show();
				}
			});
		}; 
	handleVamshopMenuRightItemVisibility ();
	function handleVamshopMenuSearchItemVisibility() {
			$('#searchitem-visibility').change(function() {
				if( $(this).is(":checked")) {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-search-item').hide();
				}else {
					$('.vamshop-menu .vamshop-menu-navbar .vamshop-menu-item.vamshop-menu-search-item').show();
				}
			});
		}; 
	handleVamshopMenuSearchItemVisibility ();
	
	function handleBrandItemAlign() {
		$('#branditem-align').val('left').on('change', function (get_value) {
			get_value = $(this).val();
			if (get_value === "left"){
				$('.vamshop-menu-navbar .vamshop-menu-brand').removeClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-brand').addClass('vamshop-menu-left-align');
			}else{
				$('.vamshop-menu-navbar .vamshop-menu-brand').addClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-brand').removeClass('vamshop-menu-left-align');
			}
		});
	};

   handleBrandItemAlign ();
   function handleLeftItemAlign() {
		$('#leftitem-align').val('left').on('change', function (get_value) {
			get_value = $(this).val();
			if (get_value === "left"){
				$('.vamshop-menu-navbar .vamshop-menu-left-item').removeClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-left-item').addClass('vamshop-menu-left-align');
			}else{
				$('.vamshop-menu-navbar .vamshop-menu-left-item').addClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-left-item').removeClass('vamshop-menu-left-align');
			}
		});
	};

   handleLeftItemAlign ();
   function handleRightItemAlign() {
		$('#rightitem-align').val('left').on('change', function (get_value) {
			get_value = $(this).val();
			if (get_value === "left"){
				$('.vamshop-menu-navbar .vamshop-menu-right-item').removeClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-right-item').addClass('vamshop-menu-left-align');
			}else{
				$('.vamshop-menu-navbar .vamshop-menu-right-item').addClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-right-item').removeClass('vamshop-menu-left-align');
			}
		});
	};

   handleRightItemAlign ();
   function handleSearchItemAlign() {
		$('#searchitem-align').val('left').on('change', function (get_value) {
			get_value = $(this).val();
			if (get_value === "left"){
				$('.vamshop-menu-navbar .vamshop-menu-search-item').removeClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-search-item').addClass('vamshop-menu-left-align');
			}else{
				$('.vamshop-menu-navbar .vamshop-menu-search-item').addClass('vamshop-menu-right-align');
				$('.vamshop-menu-navbar .vamshop-menu-search-item').removeClass('vamshop-menu-left-align');
			}
		});
	};

   handleSearchItemAlign ();
});
