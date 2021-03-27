<?php
/* -----------------------------------------------------------------------------------------
   $Id: best_sellers.php 1292 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(best_sellers.php,v 1.20 2003/02/10); www.oscommerce.com 
   (c) 2003	 nextcommerce (best_sellers.php,v 1.10 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (best_sellers.php,v 1.10 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
// reset var
$box = new vamTemplate;
$box_content = '';

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
		$cache_id = $_SESSION['language'].$current_category_id;
	}

//if (!$box->isCached(CURRENT_TEMPLATE.'/boxes/box_best_sellers.html', $cache_id) || !$cache) {
	$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

// include needed functions
require_once (DIR_FS_INC.'vam_row_number_format.inc.php');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if (isset ($current_category_id) && ($current_category_id > 0)) {
	$best_sellers_query = "select distinct
	                                        p.products_id,
	                                        p.products_fsk18,	                                        p.products_price,
	                                        p.products_tax_class_id,
	                                        p.products_image,
                                           p.products_vpe,
				                           p.products_vpe_status,
				                           p.products_vpe_value,
	                                        pd.products_name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c
	                                        where p.products_status = '1'
	                                        and c.categories_status = '1'
	                                        and p.products_ordered > 0
	                                        and p.products_id = pd.products_id
	                                        and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        and p.products_id = p2c.products_id
	                                        ".$group_check."
	                                        ".$fsk_lock."
	                                        and p2c.categories_id = c.categories_id and '".$current_category_id."'
	                                        in (c.categories_id, c.parent_id)
	                                        order by p.products_ordered desc limit ".MAX_DISPLAY_BESTSELLERS;
} else {
	$best_sellers_query = "select distinct
	                                        p.products_id,
	                                        p.products_fsk18,	                                        p.products_image,
	                                        p.products_price,
                                           p.products_vpe,
				                           p.products_vpe_status,
				                           p.products_vpe_value,
	                                        p.products_tax_class_id,
	                                        pd.products_name from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd
	                                        where p.products_status = '1'
	                                        ".$group_check."
	                                        and p.products_ordered > 0
	                                        and p.products_id = pd.products_id ".$fsk_lock."
	                                        and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        order by p.products_ordered desc limit ".MAX_DISPLAY_BESTSELLERS;
}
$best_sellers_query = vamDBquery($best_sellers_query);
if (vam_db_num_rows($best_sellers_query, true) >= MIN_DISPLAY_BESTSELLERS) {

	$rows = 0;
	$box_content = array ();
	while ($best_sellers = vam_db_fetch_array($best_sellers_query, true)) {
		$rows ++;
		$image = '';
		
		$best_sellers = array_merge($best_sellers, array ('ID' => vam_row_number_format($rows)));
		$box_content[] = $product->buildDataArray($best_sellers);
		
	}

	$box->assign('box_content', $box_content);
}

	// set cache ID
	 if (!$cache) {
	 	if ($box_content!='') {
		$box_best_sellers = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_best_sellers.html');
	 	}
	} else {
		$box_best_sellers = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_best_sellers.html', $cache_id);
	}

	$vamTemplate->assign('box_BESTSELLERS', $box_best_sellers);

//}
?>