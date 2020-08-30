<?php
/* -----------------------------------------------------------------------------------------
   $Id: shopping_cart.php 1281 2007-02-07 12:30:44 VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(shopping_cart.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (shopping_cart.php,v 1.15 2003/08/17); www.nextcommerce.org 
   (c) 2004	 xt:Commerce (shopping_cart.php,v 1.15 2003/08/13); xt-commerce.com 

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/
$box = new vamTemplate;
$box->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
$box_price_string = '';
// include needed files
require_once (DIR_FS_INC.'vam_recalculate_price.inc.php');

if (strstr($PHP_SELF, FILENAME_CHECKOUT_PAYMENT) or strstr($PHP_SELF, FILENAME_CHECKOUT_CONFIRMATION) or strstr($PHP_SELF, FILENAME_CHECKOUT_SHIPPING))
	$box->assign('deny_cart', 'true');

if ($_SESSION['cart']->count_contents() > 0) {
	$products = $_SESSION['cart']->get_products();
	$products_in_cart = array ();
	$qty = 0;
	for ($i = 0, $n = sizeof($products); $i < $n; $i ++) {
		$qty += $products[$i]['quantity'];

		// Push all attributes information in an array
	        $product_attributes = array();
	        $product_attributes1 = $product_attributes;
	        $product_attributes_in_cart = "";

		if (isset ($products[$i]['attributes'])) {
			foreach ($products[$i]['attributes'] as $option => $value) {
				//$hidden_options .= vam_draw_hidden_field('id['.$products[$i]['id'].']['.$option.']', $value);
				$attributes = vam_db_query("select popt.products_options_name, popt.products_options_type, poval.products_options_values_name, pa.options_values_price, pa.price_prefix,pa.attributes_stock,pa.products_attributes_id,pa.attributes_model , pa.options_values_id
				                                      from ".TABLE_PRODUCTS_OPTIONS." popt, ".TABLE_PRODUCTS_OPTIONS_VALUES." poval, ".TABLE_PRODUCTS_ATTRIBUTES." pa
				                                      where pa.products_id = '".(int)$products[$i]['id']."'
				                                       and pa.options_id = '".(int)$option."'
				                                       and pa.options_id = popt.products_options_id
				                                       and pa.options_values_id = '".(int)$value."'
				                                       and pa.options_values_id = poval.products_options_values_id
				                                       and popt.language_id = '".(int) $_SESSION['languages_id']."'
				                                       and poval.language_id = '".(int) $_SESSION['languages_id']."'");
				$attributes_values = vam_db_fetch_array($attributes);

				if($attributes_values['products_options_type']=='2' || $attributes_values['products_options_type']=='3'){
					$hidden_options .= vam_draw_hidden_field('id[' . $products[$i]['id'] . '][txt_' . $option . '_'.$value.']',  $products[$i]['attributes_values'][$option]);
				    $attr_value = $products[$i]['attributes_values'][$option];
				}else{
					$hidden_options .= vam_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
				    $attr_value = $attributes_values['products_options_values_name'];
				}
				$product_attributes1[$option]['NAME']  = $attributes_values['products_options_name'];
				$product_attributes1[$option]['VALUE'] = $attr_value;
				$product_attributes_in_cart .= vam_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $attributes_values['options_values_id']);
			}
		}
		// Push all attributes information in an array
		$products_in_cart[] = array ('QTY' => $products[$i]['quantity'], 
									 'ID' => $products[$i]['id'], 
									 //'PRICE' => $products[$i]['price'] * $products[$i]['quantity'], 
									 'PRICE' => $products[$i]['price'], 
									 'LINK' => vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($products[$i]['id'],$products[$i]['name'])), 
'PRODUCTS_QTY' => $product_attributes_in_cart . vam_draw_hidden_field('cart_quantity[]', $products[$i]['quantity'] - 1) . vam_draw_hidden_field('products_id[]', $products[$i]['id']) . vam_draw_hidden_field('old_qty[]', $products[$i]['quantity']) . ($products[$i]['quantity'] < 2 ? vam_draw_hidden_field('cart_delete[]', $products[$i]['id']) : ''),
'ATTRIBUTES' => $product_attributes1,
                            'IMAGE' => (($products[$i]['image'] != '' ? DIR_WS_THUMBNAIL_IMAGES.$products[$i]['image'] : DIR_WS_IMAGES.'product_images/noimage.png')),
									 'NAME' => $products[$i]['name']);

	
	}
	$box->assign('PRODUCTS', $qty);
	$box->assign('empty', 'false');
} else {
	// cart empty
	$box->assign('empty', 'true');
}

if ($_SESSION['cart']->count_contents() > 0) {
	
	$total =$_SESSION['cart']->show_total();
if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == '1' && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		$price = $total-$_SESSION['cart']->show_tax(false);
	} else {
		$price = $total;
	}
	$discount = $vamPrice->GetDC($price, $_SESSION['customers_status']['customers_status_ot_discount']);
	$box->assign('DISCOUNT', $vamPrice->Format(($discount * (-1)), $price_special = 1, $calculate_currencies = false));
	
}


if ($_SESSION['customers_status']['customers_status_show_price'] == '1') {
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 0) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) $total-=$discount;
	if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 1) $total-=$discount;
	$box->assign('TOTAL', $vamPrice->Format($total, true));
} 
	

	$box->assign('UST', $_SESSION['cart']->show_tax());
	
	if (SHOW_SHIPPING=='true') { 
			$box->assign('SHIPPING_INFO',' '.SHIPPING_EXCL.'<a class="shippingInfo" href="javascript:newWin=void(window.open(\''.vam_href_link(FILENAME_POPUP_CONTENT, 'coID='.SHIPPING_INFOS).'\', \'popup\', \'toolbar=0, width=640, height=600\'))"> '.SHIPPING_COSTS.'</a>');	
	}
}
if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$box->assign('ACTIVATE_GIFT', 'true');
}

// GV Code Start
if (isset ($_SESSION['customer_id'])) {
	$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	if ($gv_result['amount'] > 0) {
		$box->assign('GV_AMOUNT', $vamPrice->Format($gv_result['amount'], true, 0, true));
		$box->assign('GV_SEND_TO_FRIEND_LINK', '<a href="'.vam_href_link(FILENAME_GV_SEND).'">');
	}
}
if (isset ($_SESSION['gv_id'])) {
	$gv_query = vam_db_query("select coupon_amount from ".TABLE_COUPONS." where coupon_id = '".$_SESSION['gv_id']."'");
	$coupon = vam_db_fetch_array($gv_query);
	$box->assign('COUPON_AMOUNT2', $vamPrice->Format($coupon['coupon_amount'], true, 0, true));
}
if (isset ($_SESSION['cc_id'])) {
	$box->assign('COUPON_HELP_LINK', '<a href="javascript:popupWindow(\''.vam_href_link(FILENAME_POPUP_COUPON_HELP, 'cID='.$_SESSION['cc_id']).'\')">');
}
// GV Code End
$box->assign('LINK_HOME', vam_href_link(FILENAME_DEFAULT, '', 'SSL'));
$box->assign('LINK_CART', vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$box->assign('LINK_CHECKOUT', vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$box->assign('products', $products_in_cart);

$box->caching = 0;
$box->assign('language', $_SESSION['language']);
$box_shopping_cart = $box->fetch(CURRENT_TEMPLATE.'/boxes/box_cart.html');
$vamTemplate->assign('box_CART', $box_shopping_cart);
?>