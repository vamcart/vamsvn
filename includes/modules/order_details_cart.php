<?php
/* -----------------------------------------------------------------------------------------
   $Id: order_details_cart.php 1281 2007-02-06 20:41:56 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(order_details.php,v 1.8 2003/05/03); www.oscommerce.com 
   (c) 2003	 nextcommerce (order_details.php,v 1.16 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (order_details.php,v 1.16 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module = new vamTemplate;
$module->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed functions
require_once (DIR_FS_INC.'vam_check_stock.inc.php');
require_once (DIR_FS_INC.'vam_get_products_stock.inc.php');
require_once (DIR_FS_INC.'vam_remove_non_numeric.inc.php');
require_once (DIR_FS_INC.'vam_get_short_description.inc.php');
require_once (DIR_FS_INC.'vam_format_price.inc.php');
require_once (DIR_FS_INC.'vam_get_attributes_model.inc.php');

$module_content = array ();
$any_out_of_stock = '';
$mark_stock = '';

//echo var_dump($products);

$new_array = array();

foreach($products as $value){
    $new_array[$value["categories_name"]][] = $value;
}

//echo var_dump($new_array);


foreach($new_array as $key => $value){
	
	$productss[$key]['products'] = $value;
	

for ($i = 0, $n = sizeof($productss[$key]['products']); $i < $n; $i ++) {

	//if (STOCK_CHECK == 'true') {
		//$mark_stock = vam_check_stock($productss[$key]['products'][$i]['id'], $productss[$key]['products'][$i]['quantity']);
		//if ($mark_stock)
			//$_SESSION['any_out_of_stock'] = 1;
	//}
	
      if (STOCK_CHECK == 'true') {
        // begin Bundled Products
        if ($productss[$key]['products'][$i]['bundle'] == "yes") {
          $mark_stock = $bundles_stock_check[$productss[$key]['products'][$i]['id']];
        } elseif (in_array($productss[$key]['products'][$i]['id'], $product_ids_in_bundles)) {
          // if ordering individually product that is also contained in a bundle in this order must be able to cover both quantities
          // check against product left on hand after bundles have been sold
          $mark_stock = '';
          if ($product_on_hand[$productss[$key]['products'][$i]['id']] <= 0) {
            $mark_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_NOT_AVAILABLEINSTOCK . '</span>';
          } elseif ($product_on_hand[$productss[$key]['products'][$i]['id']] < $productss[$key]['products'][$i]['quantity']) {
            $mark_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_ONLY_THIS_AVAILABLEINSTOCK1 . $product_on_hand[$productss[$key]['products'][$i]['id']] . TEXT_ONLY_THIS_AVAILABLEINSTOCK2 . '</span>';
          }
        } else {
          $mark_stock = vam_check_stock($productss[$key]['products'][$i]['id'], $productss[$key]['products'][$i]['quantity']);
        }
        if (vam_not_null($mark_stock)) {
          $_SESSION['any_out_of_stock'] = 1;

          $products_name .= $mark_stock;
        }
      }
      if ($productss[$key]['products'][$i]['sold_in_bundle_only'] == 'yes') {
        $products_name .= '<br /><span class="markProductOutOfStock">' . TEXT_BUNDLE_ONLY . '</span>';
        $any_bundle_only = true;
      }
      // end Bundled Products	
	

	$image = '';
	if ($productss[$key]['products'][$i]['image'] != '') {
		$image = DIR_WS_THUMBNAIL_IMAGES.$productss[$key]['products'][$i]['image'];
	}
	if (!is_file($image)) $image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.gif';
	$module_content[$key][$i] = array (
	
	'PRODUCTS_NAME' => $productss[$key]['products'][$i]['name'].$mark_stock, 
	'PRODUCTS_CATEGORIES_ID' => $productss[$key]['products'][$i]['categories_id'], 
	'PRODUCTS_CATEGORIES_NAME' => $productss[$key]['products'][$i]['categories_name'], 
	'PRODUCTS_CATEGORIES_SORT_ORDER' => $productss[$key]['products'][$i]['categories_sort_order'], 
	'PRODUCTS_QTY' => vam_draw_input_field('cart_quantity[]', $productss[$key]['products'][$i]['quantity'], 'size="2" id="cart" class="form-control text-center item-quantity input-small"').vam_draw_hidden_field('products_id[]', $productss[$key]['products'][$i]['id'],'class="ajax_qty"').vam_draw_hidden_field('old_qty[]', $productss[$key]['products'][$i]['quantity']), 
	'PRODUCTS_STOCK' => $productss[$key]['products'][$i]['stock'],
	'PRODUCTS_QUANTITY' => $productss[$key]['products'][$i]['quantity'],
	'PRODUCTS_MODEL' => $productss[$key]['products'][$i]['model'],
	'PRODUCTS_SHIPPING_TIME'=>$productss[$key]['products'][$i]['shipping_time'], 
	'PRODUCTS_TAX' => number_format($productss[$key]['products'][$i]['tax'], TAX_DECIMAL_PLACES), 
	'PRODUCTS_IMAGE' => $image, 
	'IMAGE_ALT' => $productss[$key]['products'][$i]['name'], 
	'BOX_DELETE' => '<button class="button btn btn-outline-secondary add-to-cart cart_delete" type="button" value="'.$productss[$key]['products'][$i]['id'].'"><span>X</span></button>', 
   'PLUS' => '<button class="button btn btn-outline-secondary cart_change cart_plus" type="button" value="1"><span>+</span></button>',
   'MINUS' => '<button class="button btn btn-outline-secondary cart_change cart_minus" type="button" value="-1"><span>-</span></button>',
	'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($productss[$key]['products'][$i]['id'], $productss[$key]['products'][$i]['name'])), 
	'PRODUCTS_PRICE' => $vamPrice->Format($productss[$key]['products'][$i]['price'] * $productss[$key]['products'][$i]['quantity'], true), 
	'PRODUCTS_SINGLE_PRICE' =>$vamPrice->Format($productss[$key]['products'][$i]['price'], true), 
	'PRODUCTS_SHORT_DESCRIPTION' => vam_get_short_description($productss[$key]['products'][$i]['id']), 
	'ATTRIBUTES' => ''
	
	);
	// Product options names
	$attributes_exist = ((isset ($productss[$key]['products'][$i]['attributes'])) ? 1 : 0);
	if ($attributes_exist == 1) {
		$module_content[$key][$i]['ATTRIBUTES'] = array();
		foreach ($productss[$key]['products'][$i]['attributes'] as $option => $value) {
			if (ATTRIBUTE_STOCK_CHECK == 'true' && STOCK_CHECK == 'true') {
				$attribute_stock_check = vam_check_stock_attributes($productss[$key]['products'][$i][$option]['products_attributes_id'], $productss[$key]['products'][$i]['quantity']);
				if ($attribute_stock_check)
					$_SESSION['any_out_of_stock'] = 1;
			}

			$module_content[$key][$i]['ATTRIBUTES'][] = array (
			
			'ID' => $productss[$key]['products'][$i][$option]['products_attributes_id'], 
			'MODEL' => vam_get_attributes_model(vam_get_prid($productss[$key]['products'][$i]['id']), $productss[$key]['products'][$i][$option]['products_options_values_name'],$productss[$key]['products'][$i][$option]['products_options_name']), 
			'NAME' => $productss[$key]['products'][$i][$option]['products_options_name'], 'VALUE_NAME' => $productss[$key]['products'][$i][$option]['products_options_values_name'].$attribute_stock_check
			
			);

		}
	}

}
}

//echo var_dump($productss);
//echo var_dump($module_content);

$total_content = '';
$total_content_text = '';
$total_content_value = '';
$total_subtotal_text = '';
$total_subtotal_value = '';
$total_discount_text = '';
$total_discount_value = '';
$total =$_SESSION['cart']->show_total();
if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total-$_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $vamPrice->GetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$total_content = $_SESSION['customers_status']['customers_status_ot_discount'].' % '.SUB_TITLE_OT_DISCOUNT.' -'.vam_format_price($discount, $price_special = 1, $calculate_currencies = false).'<br />';
	$total_discount_name = SUB_TITLE_OT_DISCOUNT . " " . $_SESSION['customers_status']['customers_status_ot_discount'].'%';
	$total_discount_value = vam_format_price($discount, $price_special = 1, $calculate_currencies = false);
}

if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	$total_content .= SUB_TITLE_SUB_TOTAL.' ' .$vamPrice->Format($total, true).'<br />';
	$total_subtotal_name = SUB_TITLE_SUB_TOTAL;
	$total_subtotal_value = $vamPrice->Format($total, true);
} else {
	$total_content .= TEXT_INFO_SHOW_PRICE_NO.'<br />';
	$total_subtotal_name = TEXT_INFO_SHOW_PRICE_NO;
	$total_subtotal_value = '';
}
// display only if there is an ot_discount
if ($customer_status_value['customers_status_ot_discount'] != 0) {
	$total_content .= TEXT_CART_OT_DISCOUNT.$customer_status_value['customers_status_ot_discount'].'%';
}
if (SHOW_SHIPPING == 'true') {
	$module->assign('SHIPPING_INFO', ' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');
}

if (!$ajax_cart) {
$i = 0;
$max = count($_SESSION['tracking']['products_history']);

while ($i < $max) {

	
	$product_history_query = vamDBquery("select * from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id=pd.products_id and pd.language_id='".(int) $_SESSION['languages_id']."' and p.products_status = '1' and p.products_id = '".$_SESSION['tracking']['products_history'][$i]."'");
	$history_product = vam_db_fetch_array($product_history_query, true);
$cpath = vam_get_product_path($_SESSION['tracking']['products_history'][$i]);
	if ($history_product['products_status'] != 0) {

		$history_product = array_merge($history_product,array('cat_url' => vam_href_link(FILENAME_DEFAULT, 'cat='.$cpath)));
		$products_history[] = $product->buildDataArray($history_product);
	}
	$i ++;
}
$module->assign('products_history', $products_history);
}

$module->assign('UST_CONTENT', $_SESSION['cart']->show_tax());
$module->assign('UST_CONTENT_NAME', $_SESSION['cart']->show_tax_name());
$module->assign('UST_CONTENT_VALUE', $_SESSION['cart']->show_tax_value());
$module->assign('TOTAL_CONTENT', $total_content);
$module->assign('TOTAL_QUANTITY', $_SESSION['cart']->count_contents());
$module->assign('TOTAL_NAME', $total_content_name);
$module->assign('TOTAL_VALUE', $total_content_value);
$module->assign('TOTAL_SUBTOTAL_NAME', $total_subtotal_name);
$module->assign('TOTAL_SUBTOTAL_VALUE', $total_subtotal_value);
$module->assign('TOTAL_DISCOUNT_NAME', $total_discount_name);
$module->assign('TOTAL_DISCOUNT_VALUE', $total_discount_value);
$module->assign('language', $_SESSION['language']);
$module->assign('module_content', $module_content);
$module->assign('new_array', $new_array);

if (ACTIVATE_GIFT_SYSTEM == 'true')
include_once (DIR_WS_MODULES.'gift_cart_details.php');

include_once (DIR_WS_MODULES.'cross_selling_cart_details.php');

$module->caching = 0;
$module = $module->fetch(CURRENT_TEMPLATE.'/module/order_details.html');

$vamTemplate->assign('MODULE_order_details', $module);
?>