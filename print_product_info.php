<?php

/* -----------------------------------------------------------------------------------------
   $Id: print_product_info.php 1282 2005-10-03 19:39:36Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_info.php,v 1.94 2003/05/04); www.oscommerce.com 
   (c) 2003	 nextcommerce (print_product_info.php,v 1.16 2003/08/25); www.nextcommerce.org

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_get_products_mo_images.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

$smarty = new Smarty;

$product_info_query = xtc_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int) $_GET['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int) $_SESSION['languages_id']."'");
$product_info = xtc_db_fetch_array($product_info_query);

$products_price = $xtPrice->xtcGetPrice($product_info['products_id'], $format = true, 1, $product_info['products_tax_class_id'], $product_info['products_price'], 1);

$products_attributes_query = xtc_db_query("select count(*) as total from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".(int) $_GET['products_id']."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."'");
$products_attributes = xtc_db_fetch_array($products_attributes_query);
if ($products_attributes['total'] > 0) {
	$products_options_name_query = xtc_db_query("select distinct popt.products_options_id, popt.products_options_name from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_ATTRIBUTES." patrib where patrib.products_id='".(int) $_GET['products_id']."' and patrib.options_id = popt.products_options_id and popt.language_id = '".(int) $_SESSION['languages_id']."' order by popt.products_options_name");
	while ($products_options_name = xtc_db_fetch_array($products_options_name_query)) {
		$selected = 0;

		$products_options_query = xtc_db_query("select pov.products_options_values_id, pov.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock, pa.attributes_model from ".TABLE_PRODUCTS_ATTRIBUTES." pa, ".TABLE_PRODUCTS_OPTIONS_VALUES." pov where pa.products_id = '".(int) $_GET['products_id']."' and pa.options_id = '".$products_options_name['products_options_id']."' and pa.options_values_id = pov.products_options_values_id and pov.language_id = '".(int) $_SESSION['languages_id']."'");
		while ($products_options = xtc_db_fetch_array($products_options_query)) {
			$module_content[] = array ('GROUP' => $products_options_name['products_options_name'], 'NAME' => $products_options['products_options_values_name']);

			if ($products_options['options_values_price'] != '0') {

				if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) {
					$tax_rate = $xtPrice->TAX[$product_info['products_tax_class_id']];
					$products_options['options_values_price'] = xtc_add_tax($products_options['options_values_price'], $xtPrice->TAX[$product_info['products_tax_class_id']]);
				}
				if ($_SESSION['customers_status']['customers_status_show_price'] == 1) {
					$module_content[sizeof($module_content) - 1]['NAME'] .= ' ('.$products_options['price_prefix'].$xtPrice->xtcFormat($products_options['options_values_price'], true).')';
				}
			}
		}
	}
}

// assign language to template for caching
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('charset', $_SESSION['language_charset']);

$image = '';
if ($product_info['products_image'] != '') {
	$image = DIR_WS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$product_info['products_image'];
}
if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
	$tax_rate = $xtPrice->TAX[$product_info['products_tax_class_id']];
	// price incl tax
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
		$smarty->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_INCL, $tax_rate.' %'));
	}
	// excl tax + tax at checkout
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$smarty->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_ADD, $tax_rate.' %'));
	}
	// excl tax
	if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
		$smarty->assign('PRODUCTS_TAX_INFO', sprintf(TAX_INFO_EXCL, $tax_rate.' %'));
	}
}
$smarty->assign('PRODUCTS_NAME', $product_info['products_name']);
$smarty->assign('PRODUCTS_EAN', $product_info['products_ean']);
$smarty->assign('PRODUCTS_QUANTITY', $product_info['products_quantity']);
$smarty->assign('PRODUCTS_WEIGHT', $product_info['products_weight']);
$smarty->assign('PRODUCTS_STATUS', $product_info['products_status']);
$smarty->assign('PRODUCTS_ORDERED', $product_info['products_ordered']);
$smarty->assign('PRODUCTS_MODEL', $product_info['products_model']);
$smarty->assign('PRODUCTS_DESCRIPTION', $product_info['products_description']);
$smarty->assign('PRODUCTS_IMAGE', $image);
$smarty->assign('PRODUCTS_PRICE', $products_price['formated']);
if (ACTIVATE_SHIPPING_STATUS == 'true') {
	$smarty->assign('SHIPPING_NAME', $main->getShippingStatusName($product_info['products_shippingtime']));
	if ($shipping_status['image'] != '')
		$smarty->assign('SHIPPING_IMAGE', $main->getShippingStatusImage($product_info['products_shippingtime']));
}
if (SHOW_SHIPPING == 'true')
	$smarty->assign('PRODUCTS_SHIPPING_LINK', ' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');	
		

$discount = 0.00;
if ($_SESSION['customers_status']['customers_status_public'] == 1 && $_SESSION['customers_status']['customers_status_discount'] != '0.00') {
	$discount = $_SESSION['customers_status']['customers_status_discount'];
	if ($product_info['products_discount_allowed'] < $_SESSION['customers_status']['customers_status_discount'])
		$discount = $product_info['products_discount_allowed'];
	if ($discount != '0.00')
		$smarty->assign('PRODUCTS_DISCOUNT', $discount.'%');
}

if ($product_info['products_vpe_status'] == 1 && $product_info['products_vpe_value'] != 0.0 && $products_price['plain'] > 0)
	$smarty->assign('PRODUCTS_VPE', $xtPrice->xtcFormat($products_price['plain'] * (1 / $product_info['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($product_info['products_vpe']));
$smarty->assign('module_content', $module_content);

//more images - by Novalis
$mo_images = xtc_get_products_mo_images($product_info['products_id']);
if (is_array($mo_images)) {
	foreach ($mo_images as $img) {
		$mo_img = DIR_WS_CATALOG.DIR_WS_THUMBNAIL_IMAGES.$img['image_name'];
		$smarty->assign('PRODUCTS_IMAGE_'.$img['image_nr'], $mo_img);
	}
}

// set cache ID
 if (!CacheCheck()) {
	$smarty->caching = 0;
} else {
	$smarty->caching = 1;
	$smarty->cache_lifetime = CACHE_LIFETIME;
	$smarty->cache_modified_check = CACHE_CHECK;
}
$cache_id = $_SESSION['language'].'_'.$product_info['products_id'];

$smarty->display(CURRENT_TEMPLATE.'/module/print_product_info.html', $cache_id);
?>