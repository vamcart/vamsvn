<?php
/* -----------------------------------------------------------------------------------------
   $Id: products_new.php 1292 2005-10-07 16:10:55Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(products_new.php,v 1.25 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (products_new.php,v 1.16 2003/08/18); www.nextcommerce.org

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Enable_Disable_Categories 1.3        	Autor: Mikel Williams | mikel@ladykatcostumes.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed function
require_once (DIR_FS_INC.'xtc_date_long.inc.php');
require_once (DIR_FS_INC.'xtc_get_vpe_name.inc.php');

$breadcrumb->add(NAVBAR_TITLE_PRODUCTS_NEW, xtc_href_link(FILENAME_PRODUCTS_NEW));

require (DIR_WS_INCLUDES.'header.php');

$products_new_array = array ();
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
if (MAX_DISPLAY_NEW_PRODUCTS_DAYS != '0') {
	$date_new_products = date("Y.m.d", mktime(1, 1, 1, date(m), date(d) - MAX_DISPLAY_NEW_PRODUCTS_DAYS, date(Y)));
	$days = " and p.products_date_added > '".$date_new_products."' ";
}
$products_new_query_raw = "select distinct
                                    p.products_id,
                                    p.products_fsk18,
                                    pd.products_name,
                                    pd.products_short_description,
                                    p.products_image,
                                    p.products_price,
                               	    p.products_vpe,
                               	    p.products_vpe_status,
                                    p.products_vpe_value,                                                          
                                    p.products_tax_class_id,
                                    p.products_date_added,
                                    m.manufacturers_name
                                    from ".TABLE_PRODUCTS." p
                                    left join ".TABLE_MANUFACTURERS." m
                                    on p.manufacturers_id = m.manufacturers_id
                                    left join ".TABLE_PRODUCTS_DESCRIPTION." pd
                                    on p.products_id = pd.products_id,
                                    ".TABLE_CATEGORIES." c,
                                    ".TABLE_PRODUCTS_TO_CATEGORIES." p2c 
                                    WHERE pd.language_id = '".(int) $_SESSION['languages_id']."'
                                    and c.categories_status=1
                                    and p.products_id = p2c.products_id
                                    and c.categories_id = p2c.categories_id
                                    and products_status = '1'
                                    ".$group_check."
                                    ".$fsk_lock."                                    
                                    ".$days."
                                    order
                                    by
                                    p.products_date_added DESC ";


$products_new_split = new splitPageResults($products_new_query_raw, $_GET['page'], MAX_DISPLAY_PRODUCTS_NEW, 'p.products_id');

if (($products_new_split->number_of_rows > 0)) {
	$smarty->assign('NAVIGATION_BAR', '
		   <table border="0" width="100%" cellspacing="0" cellpadding="2">
		          <tr>
		            <td class="smallText">'.$products_new_split->display_count(TEXT_DISPLAY_NUMBER_OF_PRODUCTS_NEW).'</td>
		            <td align="right" class="smallText">'.TEXT_RESULT_PAGE.' '.$products_new_split->display_links(MAX_DISPLAY_PAGE_LINKS, xtc_get_all_get_params(array ('page', 'info', 'x', 'y'))).'</td>
		          </tr>
		        </table>
		
		   ');

}

$module_content = '';
if ($products_new_split->number_of_rows > 0) {
	$products_new_query = xtc_db_query($products_new_split->sql_query);
	while ($products_new = xtc_db_fetch_array($products_new_query)) {
		$products_price = $xtPrice->xtcGetPrice($products_new['products_id'], $format = true, 1, $products_new['products_tax_class_id'], $products_new['products_price'], 1);
		$vpePrice = '';
		if ($products_new['products_vpe_status'] == 1 && $products_new['products_vpe_value'] != 0.0)
			$vpePrice = $xtPrice->xtcFormat($products_price['plain'] * (1 / $products_new['products_vpe_value']), true).TXT_PER.xtc_get_vpe_name($products_new['products_vpe']);
		$buy_now = '';
		if ($_SESSION['customers_status']['customers_fsk18'] == '1') {
			if ($products_new['products_fsk18'] == '0')
				$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
		} else {
			$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&BUYproducts_id='.$products_new['products_id'], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_new['products_name'].TEXT_NOW).'</a>';
		}
		if ($products_new['products_image'] != '') {
			$products_image = DIR_WS_THUMBNAIL_IMAGES.$products_new['products_image'];
		} else {
			$products_image = '';
		}
		if ($_SESSION['customers_status']['customers_status_show_price'] != 0) {
			$tax_rate = $xtPrice->TAX[$products_new['products_tax_class_id']];
			// price incl tax
			if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] != 0) {
				$tax_info = sprintf(TAX_INFO_INCL, $tax_rate.' %');
			} 
			// excl tax + tax at checkout
			if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
				$tax_info = sprintf(TAX_INFO_ADD, $tax_rate.' %');
			}
			// excl tax
			if ($tax_rate > 0 && $_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) {
				$tax_info = sprintf(TAX_INFO_EXCL, $tax_rate.' %');
			}
		}
		$ship_info="";
		if (SHOW_SHIPPING=='true') {
		$ship_info=' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.xtc_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>';
		}
		$module_content[] = array ('PRODUCTS_NAME' => $products_new['products_name'],'PRODUCTS_SHIPPING_LINK' => $ship_info,'PRODUCTS_TAX_INFO' => $tax_info, 'PRODUCTS_DESCRIPTION' => $products_new['products_short_description'], 'PRODUCTS_PRICE' => $products_price['formated'], 'PRODUCTS_VPE' => $vpePrice, 'PRODUCTS_LINK' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products_new['products_id'], $products_new['products_name'])), 'PRODUCTS_IMAGE' => $products_image, 'BUTTON_BUY_NOW' => $buy_now);

	}
} else {

	$smarty->assign('ERROR', TEXT_NO_NEW_PRODUCTS);

}

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->assign('module_content', $module_content);
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/new_products_overview.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>