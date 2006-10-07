<?php

/* -----------------------------------------------------------------------------------------
   $Id: featured.php 1292 2005-10-07 16:10:55Z VaM $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	$fsk_lock = ' and p.products_fsk18!=1';

if ((!isset ($featured_products_category_id)) || ($featured_products_category_id == '0')) {
	if (GROUP_CHECK == 'true')
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	$featured_products_query = "SELECT * FROM
	                                         ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pd.products_id = p.products_id,
	                                         ".TABLE_FEATURED." f where
	                                         p.products_id=f.products_id ".$group_check."
	                                         ".$fsk_lock."
	                                         and p.products_status = '1' and f.status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                         order by p.products_date_added DESC limit ".MAX_DISPLAY_FEATURED_PRODUCTS;
} else {

	if (GROUP_CHECK == 'true')
		$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	$featured_products_query = "SELECT * FROM
	                                         ".TABLE_PRODUCTS." p left join " . TABLE_PRODUCTS_DESCRIPTION . " pd on pd.products_id = p.products_id,
	                                         ".TABLE_FEATURED." f,
	                                        ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
	                                        ".TABLE_CATEGORIES." c
	                                        where c.categories_status='1'
	                                        and p.products_id = p2c.products_id and p.products_id=f.products_id
	                                        and p2c.categories_id = c.categories_id
	                                        ".$group_check."
	                                        ".$fsk_lock."
	                                        and c.parent_id = '".$featured_products_category_id."'
	                                        and p.products_status = '1' and f.status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        order by p.products_date_added DESC limit ".MAX_DISPLAY_FEATURED_PRODUCTS;
}
$row = 0;
$module_content = array ();
$featured_products_query = xtDBquery($featured_products_query);
while ($featured_products = xtc_db_fetch_array($featured_products_query, true)) {
	$module_content[] = $product->buildDataArray($featured_products);

}
if (sizeof($module_content) >= 1) {
   $module_smarty->assign('FEATURED_LINK', xtc_href_link(FILENAME_FEATURED));
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module_smarty->caching = 0;
		if ((!isset ($featured_products_category_id)) || ($featured_products_category_id == '0')) {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/featured_products_default.html');
		} else {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/featured.html');
		}
	} else {
		$module_smarty->caching = 1;
		$module_smarty->cache_lifetime = CACHE_LIFETIME;
		$module_smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $featured_products_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		if ((!isset ($featured_products_category_id)) || ($featured_products_category_id == '0')) {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/featured_products_default.html', $cache_id);
		} else {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/featured.html', $cache_id);
		}
	}
	$default_smarty->assign('MODULE_featured_products', $module);
}
?>
