<?php
/* -----------------------------------------------------------------------------------------
   $Id: index.php 1321 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(default.php,v 1.84 2003/05/07); www.oscommerce.com
   (c) 2003	 nextcommerce (default.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (default.php,v 1.13 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create template elements

$vamTemplate = new vamTemplate;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// the following cPath references come from application_top.php
$category_depth = 'top';
if (isset ($cPath) && vam_not_null($cPath)) {
	$categories_products_query = "select count(p.products_id) as total from ".TABLE_PRODUCTS_TO_CATEGORIES." as ptc, products as p where ptc.categories_id = '".$current_category_id."' and ptc.products_id=p.products_id and p.products_status='1'";
	$categories_products_query = vamDBquery($categories_products_query);
	$cateqories_products = vam_db_fetch_array($categories_products_query, true);
	if ($cateqories_products['total'] > 0) {
		$category_depth = 'products'; // display products
	} else {
		$category_parent_query = "select count(*) as total from ".TABLE_CATEGORIES." where parent_id = '".$current_category_id."'";
		$category_parent_query = vamDBquery($category_parent_query);
		$category_parent = vam_db_fetch_array($category_parent_query, true);
		if ($category_parent['total'] > 0) {
			$category_depth = 'nested'; // navigate through the categories
		} else {
			$category_depth = 'products'; // category has no products, but display the 'no products' message
		}
	}
}

if (($category_depth != 'top' || ($category_depth == 'top' && isset($_GET['manufacturers_id'])) )&& ! IsvalidCatOrMan($current_category_id, $_GET['manufacturers_id'], $_SESSION['languages_id'])) {
    header("HTTP/1.1 410 Gone");
    header("Status: 410 Gone");
}

include (DIR_WS_MODULES.'default.php');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_DEFAULT.'_'.$cID.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_DEFAULT.'_'.$cID.'.html' : CURRENT_TEMPLATE.'/index.html');
//$vamTemplate->debugging = true;
$vamTemplate->display($template);

include ('includes/application_bottom.php');  
?>