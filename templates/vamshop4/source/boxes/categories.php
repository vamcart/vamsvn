<?php
/* -----------------------------------------------------------------------------------------
   $Id: categories.php 1302 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (categories.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (categories.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// reset var
$start = microtime();
$box = new vamTemplate;
$box_content = '';
$id = '';

// include needed functions
require_once (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/inc/vam_draw_categories_tree.inc.php');
require_once (DIR_FS_INC.'vam_has_category_subcategories.inc.php');
require_once (DIR_FS_INC.'vam_count_products_in_category.inc.php');

$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box->assign('language', $_SESSION['language']);

// set cache ID
if (!CacheCheck()) {
	$cache=false;
	$box->caching = 0;
} else {
	$cache=true;
	$box->caching = 1;
	$box->cache_lifetime = CACHE_LIFETIME;
	$box->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'].$current_category_id;
}

if(!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id) || !$cache){

$categories_tree = vam_draw_categories_tree();

$box->assign('CATEGORIES_TREE', $categories_tree['data']);
$box->assign('CATEGORIES_INPUT', $categories_tree['inputs']);
$box->assign('CATEGORIES_CSS1', $categories_tree['css1']);
$box->assign('CATEGORIES_CSS2', $categories_tree['css2']);
$box->assign('CATEGORIES_CSS3', $categories_tree['css3']);
$box->assign('CATEGORIES_CSS4', $categories_tree['css4']);
}

// set cache ID
if (!$cache) {
	$box_categories = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html');
} else {
	$box_categories = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_categories.html', $cache_id);
}

$vamTemplate->assign('box_CATEGORIES', $box_categories);
?>