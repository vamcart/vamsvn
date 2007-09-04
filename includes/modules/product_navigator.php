<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_navigator.php 1292 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2004	 xt:Commerce (product_navigator.php,v 1.19 2003/08/1); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module_smarty = new vamTemplate;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');

// select products
//fsk18 lock
$fsk_lock = '';
if ($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
	$fsk_lock = ' and p.products_fsk18!=1';
}
$group_check = "";
if (GROUP_CHECK == 'true') {
	$group_check = " and p.group_permission_".$_SESSION['customers_status']['customers_status_id']."=1 ";
}
$products_query = vamDBquery("SELECT
                                 pc.products_id,
                                 pd.products_name
                                 FROM ".TABLE_PRODUCTS_TO_CATEGORIES." pc,
                                 ".TABLE_PRODUCTS." p,
                                 ".TABLE_PRODUCTS_DESCRIPTION." pd

                                 WHERE categories_id='".$current_category_id."'
                                 and p.products_id=pc.products_id
                                 and p.products_id = pd.products_id
                                 and pd.language_id = '".(int) $_SESSION['languages_id']."'
                                 and p.products_status=1 
                                 ".$fsk_lock.$group_check);
$i = 0;
while ($products_data = vam_db_fetch_array($products_query, true)) {
	$p_data[$i] = array ('pID' => $products_data['products_id'], 'pName' => $products_data['products_name']);
	if ($products_data['products_id'] == $product->data['products_id'])
		$actual_key = $i;
	$i ++;

}

// check if array key = first
if ($actual_key == 0) {
	// aktuel key = first product
} else {
	$prev_id = $actual_key -1;
	$prev_link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($p_data[$prev_id]['pID'], $p_data[$prev_id]['pName']));
	// check if prev id = first
	if ($prev_id != 0)
		$first_link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($p_data[0]['pID'], $p_data[0]['pName']));
}

// check if key = last
if ($actual_key == (sizeof($p_data) - 1)) {
	// actual key is last
} else {
	$next_id = $actual_key +1;
	$next_link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($p_data[$next_id]['pID'], $p_data[$next_id]['pName']));
	// check if next id = last
	if ($next_id != (sizeof($p_data) - 1))
		$last_link = vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($p_data[(sizeof($p_data) - 1)]['pID'], $p_data[(sizeof($p_data) - 1)]['pName']));

}
$module_smarty->assign('FIRST', $first_link);
$module_smarty->assign('PREVIOUS', $prev_link);
$module_smarty->assign('NEXT', $next_link);
$module_smarty->assign('LAST', $last_link);

$module_smarty->assign('PRODUCTS_COUNT', count($p_data));
$module_smarty->assign('language', $_SESSION['language']);

$module_smarty->caching = 0;
$product_navigator = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/product_navigator.html');

$info_smarty->assign('PRODUCT_NAVIGATOR', $product_navigator);
?>