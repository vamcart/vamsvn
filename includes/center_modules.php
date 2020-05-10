<?php
/* -----------------------------------------------------------------------------------------
   $Id: center_modules.php 899 2007-02-06 20:14:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (center_modules.php,v 1.5 2003/08/13); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (center_modules.php,v 1.5 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


  require(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);

  require(DIR_WS_MODULES . FILENAME_FEATURED);

  require(DIR_WS_MODULES . FILENAME_NEWS);

  include (DIR_WS_MODULES.FILENAME_REVIEWS_ALL);

  //include (DIR_WS_MODULES.FILENAME_SITE_REVIEWS_ALL);
  
  include (DIR_WS_MODULES.FILENAME_SPECIALS);

  include (DIR_WS_MODULES.FILENAME_BEST_SELLERS);

  include (DIR_WS_MODULES.FILENAME_MANUFACTURERS);

  require(DIR_WS_MODULES . FILENAME_UPCOMING_PRODUCTS);

  require(DIR_WS_MODULES . FILENAME_SITEMAP);

  require (DIR_WS_MODULES.FILENAME_BANNER_MAINPAGE);

  require (DIR_WS_MODULES.FILENAME_ARTICLES);

  return $module;
?>