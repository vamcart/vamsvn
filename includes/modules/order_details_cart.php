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

for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {

	//if (STOCK_CHECK == 'true') {
		//$mark_stock = vam_check_stock($products[$i]['id'], $products[$i]['quantity']);
		//if ($mark_stock)
			//$_SESSION['any_out_of_stock'] = 1;
	//}
	
      if (STOCK_CHECK == 'true') {
        // begin Bundled Products
        if ($products[$i]['bundle'] == "yes") {
          $mark_stock = $bundles_stock_check[$products[$i]['id']];
        } elseif (in_array($products[$i]['id'], $product_ids_in_bundles)) {
          // if ordering individually product that is also contained in a bundle in this order must be able to cover both quantities
          // check against product left on hand after bundles have been sold
          $mark_stock = '';
          if ($product_on_hand[$products[$i]['id']] <= 0) {
            $mark_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_NOT_AVAILABLEINSTOCK . '</span>';
          } elseif ($product_on_hand[$products[$i]['id']] < $products[$i]['quantity']) {
            $mark_stock = '<span class="markProductOutOfStock">' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . '<br />' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . TEXT_ONLY_THIS_AVAILABLEINSTOCK1 . $product_on_hand[$products[$i]['id']] . TEXT_ONLY_THIS_AVAILABLEINSTOCK2 . '</span>';
          }
        } else {
          $mark_stock = vam_check_stock($products[$i]['id'], $products[$i]['quantity']);
        }
        if (vam_not_null($mark_stock)) {
          $_SESSION['any_out_of_stock'] = 1;

          $products_name .= $mark_stock;
        }
      }
      if ($products[$i]['sold_in_bundle_only'] == 'yes') {
        $products_name .= '<br /><span class="markProductOutOfStock">' . TEXT_BUNDLE_ONLY . '</span>';
        $any_bundle_only = true;
      }
      // end Bundled Products	
	

	$image = '';
	if ($products[$i]['image'] != '') {
		$image = DIR_WS_THUMBNAIL_IMAGES.$products[$i]['image'];
	}
	if (!is_file($image)) $image = DIR_WS_THUMBNAIL_IMAGES.'../noimage.gif';
	$module_content[$i] = array (
	
	'PRODUCTS_NAME' => $products[$i]['name'].$mark_stock, 
	'PRODUCTS_CATEGORIES_ID' => $products[$i]['categories_id'], 
	'PRODUCTS_CATEGORIES_NAME' => $products[$i]['categories_name'], 
	'PRODUCTS_CATEGORIES_SORT_ORDER' => $products[$i]['categories_sort_order'], 
	'PRODUCTS_QTY' => vam_draw_input_field('cart_quantity[]', $products[$i]['quantity'], 'size="2" id="cart" class="form-control col-sm-4 text-center item-quantity input-small"').vam_draw_hidden_field('products_id[]', $products[$i]['id'],'class="ajax_qty"').vam_draw_hidden_field('old_qty[]', $products[$i]['quantity']), 
	'PRODUCTS_STOCK' => $products[$i]['stock'],
	'PRODUCTS_MODEL' => $products[$i]['model'],
	'PRODUCTS_SHIPPING_TIME'=>$products[$i]['shipping_time'], 
	'PRODUCTS_TAX' => number_format($products[$i]['tax'], TAX_DECIMAL_PLACES), 
	'PRODUCTS_IMAGE' => $image, 
	'IMAGE_ALT' => $products[$i]['name'], 
	'BOX_DELETE' => '<button class="button btn btn-secondary add-to-cart cart_delete" type="button" value="'.$products[$i]['id'].'"><span>X</span></button>', 
   'PLUS' => '<button class="button btn btn-secondary cart_change cart_plus" type="button" value="1"><span>+</span></button>',
   'MINUS' => '<button class="button btn btn-secondary cart_change cart_minus" type="button" value="-1"><span>-</span></button>',
	'PRODUCTS_LINK' => vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products[$i]['id'], $products[$i]['name'])), 
	'PRODUCTS_PRICE' => $vamPrice->Format($products[$i]['price'] * $products[$i]['quantity'], true), 
	'PRODUCTS_SINGLE_PRICE' =>$vamPrice->Format($products[$i]['price'], true), 
	'PRODUCTS_SHORT_DESCRIPTION' => vam_get_short_description($products[$i]['id']), 
	'ATTRIBUTES' => ''
	
	);
	// Product options names
	$attributes_exist = ((isset ($products[$i]['attributes'])) ? 1 : 0);
	if ($attributes_exist == 1) {
		$module_content[$i]['ATTRIBUTES'] = array();
		foreach ($products[$i]['attributes'] as $option => $value) {
			if (ATTRIBUTE_STOCK_CHECK == 'true' && STOCK_CHECK == 'true') {
				$attribute_stock_check = vam_check_stock_attributes($products[$i][$option]['products_attributes_id'], $products[$i]['quantity']);
				if ($attribute_stock_check)
					$_SESSION['any_out_of_stock'] = 1;
			}

			$module_content[$i]['ATTRIBUTES'][] = array (
			
			'ID' => $products[$i][$option]['products_attributes_id'], 
			'MODEL' => vam_get_attributes_model(vam_get_prid($products[$i]['id']), $products[$i][$option]['products_options_values_name'],$products[$i][$option]['products_options_name']), 
			'NAME' => $products[$i][$option]['products_options_name'], 'VALUE_NAME' => $products[$i][$option]['products_options_values_name'].$attribute_stock_check
			
			);

		}
	}

}

$total_content = '';
$total =$_SESSION['cart']->show_total();
if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total-$_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $vamPrice->GetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$total_content = $_SESSION['customers_status']['customers_status_ot_discount'].' % '.SUB_TITLE_OT_DISCOUNT.' -'.vam_format_price($discount, $price_special = 1, $calculate_currencies = false).'<br />';
}

if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	$total_content .= SUB_TITLE_SUB_TOTAL.' ' .$vamPrice->Format($total, true).'<br />';
} else {
	$total_content .= TEXT_INFO_SHOW_PRICE_NO.'<br />';
}
// display only if there is an ot_discount
if ($customer_status_value['customers_status_ot_discount'] != 0) {
	$total_content .= TEXT_CART_OT_DISCOUNT.$customer_status_value['customers_status_ot_discount'].'%';
}
if (SHOW_SHIPPING == 'true') {
	$module->assign('SHIPPING_INFO', ' '.SHIPPING_EXCL.'<a href="javascript:newWin=void(window.open(\''.vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');
}

$module->assign('UST_CONTENT', $_SESSION['cart']->show_tax());
$module->assign('TOTAL_CONTENT', $total_content);
$module->assign('language', $_SESSION['language']);
$module->assign('module_content', $module_content);

$module->caching = 0;
$module = $module->fetch(CURRENT_TEMPLATE.'/module/order_details.html');

$vamTemplate->assign('MODULE_order_details', $module);
?>