<?php
/* -----------------------------------------------------------------------------------------
   $Id: popup_search_help.php 1238 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(popup_search_help.php,v 1.3 2003/02/13); www.oscommerce.com
   (c) 2003	 nextcommerce (popup_search_help.php,v 1.6 2003/08/17); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (popup_search_help.php,v 1.6 2003/08/17); xt-commerce.com 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

$vamTemplate = new vamTemplate;

include ('includes/header.php');

$vamTemplate->assign('link_close', 'javascript:window.close()');
$vamTemplate->assign('language', $_SESSION['language']);

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/popup_search_help.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/popup_search_help.html', $cache_id);
}
?>