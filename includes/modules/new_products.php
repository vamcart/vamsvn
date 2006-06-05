<?php

/* -----------------------------------------------------------------------------------------
   $Id: new_products.php 1292 2005-10-07 16:10:55Z mz $

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

if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
	if (GROUP_CHECK == 'true')
		$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	$new_products_query = "SELECT * FROM
	                                         ".TABLE_PRODUCTS." p,
	                                         ".TABLE_PRODUCTS_DESCRIPTION." pd WHERE
	                                         p.products_id=pd.products_id and
	                                         p.products_startpage = '1'
	                                         ".$group_check."
	                                         ".$fsk_lock."
	                                         and p.products_status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                         order by p.products_startpage_sort ASC limit ".MAX_DISPLAY_NEW_PRODUCTS;
} else {

	if (GROUP_CHECK == 'true')
		$group_check = "and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";

	if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
		$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
		$days = " and p.products_date_added > '".$date_new_products."' ";
	}
	$new_products_query = "SELECT * FROM
	                                        ".TABLE_PRODUCTS." p,
	                                        ".TABLE_PRODUCTS_DESCRIPTION." pd,
	                                        ".TABLE_PRODUCTS_TO_CATEGORIES." p2c,
	                                        ".TABLE_CATEGORIES." c
	                                        where c.categories_status='1'
	                                        and p.products_id = p2c.products_id and p.products_id=pd.products_id
	                                        and p2c.categories_id = c.categories_id
	                                        ".$group_check."
	                                        ".$fsk_lock."
	                                        and c.parent_id = '".$new_products_category_id."'
	                                        and p.products_status = '1' and pd.language_id = '".(int) $_SESSION['languages_id']."'
	                                        order by p.products_date_added DESC limit ".MAX_DISPLAY_NEW_PRODUCTS;
}
$row = 0;
$module_content = array ();
$new_products_query = xtDBquery($new_products_query);
while ($new_products = xtc_db_fetch_array($new_products_query, true)) {
	$SEF_parameter = '';
	if (SEARCH_ENGINE_FRIENDLY_URLS == 'true')
		$SEF_parameter = '&product='.xtc_cleanName($new_products['products_name']);

	if ($_SESSION['customers_status']['customers_status_show_price'] != '0') {
		$buy_now = '';
		if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
			if ($new_products['products_fsk18'] == '0')
				$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$new_products['products_id'].'&'.xtc_get_all_get_params(array ('action')), 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$new_products['products_name'].TEXT_NOW).'</a>';
		} else {
			$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), 'action=buy_now&BUYproducts_id='.$new_products['products_id'].'&'.xtc_get_all_get_params(array ('action')), 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$new_products['products_name'].TEXT_NOW).'</a>';
		}
		
		$tax_rate = $xtPrice->TAX[$new_products['products_tax_class_id']];
		if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
		    $tax_info = sprintf(TAX_INFO_INCL, $tax_rate.' %');
		}
		if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0) {
		    $tax_info = sprintf(TAX_INFO_EXCL, $tax_rate.' %');
		}
		
		$image = '';
		if ($new_products['products_image'] != '') {
			$image = DIR_WS_THUMBNAIL_IMAGES.$new_products['products_image'];
		}
$ship_info="";
		if (SHOW_SHIPPING=='true') {
			$ship_info= ' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>';
		} 

		$module_content[] = array ('PRODUCTS_NAME' => $new_products['products_name'], 
								   'PRODUCTS_DESCRIPTION' => $new_products['products_short_description'], 
								   'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($new_products['products_id'], $format = true, 1, $new_products['products_tax_class_id'], $new_products['products_price']), 
								   'PRODUCTS_TAX_INFO' => $tax_info,
								   'PRODUCTS_SHIPPING_LINK' => $ship_info,
								   'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($new_products['products_id'],$new_products['products_name'])), 
								   'PRODUCTS_IMAGE' => $image, 
								   'BUTTON_BUY_NOW' => $buy_now);

	} else {

		$image = '';
		if ($new_products['products_image'] != '')
			$image = DIR_WS_THUMBNAIL_IMAGES.$new_products['products_image'];
	
		$module_content[] = array ('PRODUCTS_NAME' => $new_products['products_name'], 
								   'PRODUCTS_DESCRIPTION' => $new_products['products_short_description'], 
								   'PRODUCTS_PRICE' => $xtPrice->xtcGetPrice($new_products['products_id'], $format = true, 1, $new_products['products_tax_class_id'], $new_products['products_price']), 
								   'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($new_products['products_id'],$new_products['products_name'])), 
								   'PRODUCTS_IMAGE' => $image);
	}
	$row ++;

}
if (sizeof($module_content) >= 1) {
	$module_smarty->assign('language', $_SESSION['language']);
	$module_smarty->assign('module_content', $module_content);
	
	// set cache ID
	 if (!CacheCheck()) {
		$module_smarty->caching = 0;
		if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html');
		} else {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products.html');
		}
	} else {
		$module_smarty->caching = 1;
		$module_smarty->cache_lifetime = CACHE_LIFETIME;
		$module_smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $new_products_category_id.$_SESSION['language'].$_SESSION['customers_status']['customers_status_name'].$_SESSION['currency'];
		if ((!isset ($new_products_category_id)) || ($new_products_category_id == '0')) {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_default.html', $cache_id);
		} else {
			$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/new_products.html', $cache_id);
		}
	}
	$default_smarty->assign('MODULE_new_products', $module);
}
?>
