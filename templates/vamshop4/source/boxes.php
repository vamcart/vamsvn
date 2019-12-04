<?php
/* -----------------------------------------------------------------------------------------
   $Id: boxes.php 1298 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2004	 xt:Commerce (boxes.php,v 1.4 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  define('DIR_WS_BOXES',DIR_FS_CATALOG .'templates/'.CURRENT_TEMPLATE. '/source/boxes/');

  if (SET_BOX_SEARCH == 'true') require(DIR_WS_BOXES . 'search.php');
  if (SET_BOX_CATEGORIES == 'true') include(DIR_WS_BOXES . 'categories.php');
  if (DEFAULT_NAVIGATION == 'fullscreen_menu') require(DIR_WS_BOXES . 'categories2.php');
  if (DEFAULT_NAVIGATION == 'slide_menu') require(DIR_WS_BOXES . 'categories3.php');
  require(DIR_WS_BOXES . 'content_pull.php');
  include(DIR_WS_BOXES . 'news_dropdown.php');
  include(DIR_WS_BOXES . 'articles_new_dropdown.php');
  if (SET_BOX_DOWNLOADS == 'true') include(DIR_WS_BOXES . 'download.php');

$vamTemplate->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
?>