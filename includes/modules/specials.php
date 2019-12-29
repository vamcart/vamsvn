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

	$special_products_query = "select
                                           p.*,
                                           pd.*,
                                           s.specials_new_products_price
                                           from ".TABLE_PRODUCTS." p,
                                           ".TABLE_PRODUCTS_DESCRIPTION." pd,
                                           ".TABLE_SPECIALS." s where p.products_status = '1'
                                           and p.products_id = s.products_id
                                           and pd.products_id = s.products_id
                                           and pd.language_id = '".$_SESSION['languages_id']."'
                                           and s.status = '1'
                                           ".$group_check."
                                           ".$fsk_lock."                                             
                                           order by p.products_startpage_sort ASC, p.products_id DESC limit ".MAX_DISPLAY_SPECIAL_PRODUCTS;

$row = 0;
$module_content = array ();
$special_products_query = vamDBquery($special_products_query);
while ($special_products = vam_db_fetch_array($special_products_query, true)) {
	$module_content[] = $product->buildDataArray($special_products);

}
if (sizeof($module_content) >= 1) {
   $module->assign('SPECIALS_LINK', vam_href_link(FILENAME_SPECIALS));
	$module->assign('language', $_SESSION['language']);
	$module->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module->caching = 0;
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_default.html');
	} else {
		$module->caching = 1;
		$module->cache_lifetime = CACHE_LIFETIME;
		$module->cache_modified_check = CACHE_CHECK;
		$cache_id = $current_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		$module = $module->fetch(CURRENT_TEMPLATE.'/module/specials_default.html', $cache_id);
	}
	$default->assign('MODULE_specials_default', $module);
}
?>
