<?php
/* -----------------------------------------------------------------------------------------
   $Id: comparison.php 1238 2012-06-06 19:20:03 VaM $

   VamShop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2012 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(cookie_usage.php,v 1.1 2003/03/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (cookie_usage.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (cookie_usage.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');


$breadcrumb->add(TEXT_COMPARE, vam_href_link(FILENAME_COMPARISON));

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);

  require_once (DIR_WS_FUNCTIONS . 'products_specifications.php');

  if( $current_category_id == 0 ) {
    vam_redirect( vam_href_link( FILENAME_DEFAULT ) );
  }

    require_once (DIR_WS_MODULES . FILENAME_COMPARISON);

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/comparison.html');
} else {
	$vamTemplate->caching = 0;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/comparison.html', $cache_id);
}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_COMPARISON.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_COMPARISON.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>