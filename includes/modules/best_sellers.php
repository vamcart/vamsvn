<?php
/* -----------------------------------------------------------------------------------------
   $Id: specials.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_products.php,v 1.33 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (new_products.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (new_products.php,v 1.9 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0')
	$fsk_lock = ' and p.products_fsk18!=1';

	if (GROUP_CHECK == 'true')
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - 90, date(Y)));
		//$days = " and p.products_date_added > '".$date_new_products."' ";
	}

	$best_sellers_query = "select distinct
	                                        p.*,
	                                        pd.* from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd, ".TABLE_PRODUCTS_TO_CATEGORIES." p2c, ".TABLE_CATEGORIES." c
	                                        where p.products_status = '1'
	                                        and c.categories_status = '1'
	                                        and p.products_ordered > 0
	                                        and p.products_quantity > 0
	                                        and p.products_id = pd.products_id
	                                        and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        and p.products_id = p2c.products_id
	                                        ".$group_check."
	                                         ".$days."
	                                        ".$fsk_lock."
	                                        and p2c.categories_id = c.categories_id and '".$current_category_id."'
	                                        in (c.categories_id, c.parent_id)
	                                        group by p.products_id order by rand() limit ".MAX_DISPLAY_BESTSELLERS;

$row = 0;
$module_content = array ();
$best_sellers_query = vamDBquery($best_sellers_query);
while ($best_sellers = vam_db_fetch_array($best_sellers_query, true)) {
	$module_content[] = $product->buildDataArray($best_sellers);

}
if (sizeof($module_content) >= 1) {
   $module->assign('BEST_SELLERS_LINK', vam_href_link(FILENAME_BEST_SELLERS));
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/best_sellers_default.html');
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $current_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/best_sellers_default.html', $cache_id);
	}
	$default->assign('MODULE_best_sellers_default', $module);
}
?>
