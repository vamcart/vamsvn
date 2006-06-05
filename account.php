<?php

/* -----------------------------------------------------------------------------------------
   $Id: account.php 1124 2005-07-28 08:50:04Z mz $

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'xtc_count_customer_orders.inc.php');
require_once (DIR_FS_INC.'xtc_date_short.inc.php');
require_once (DIR_FS_INC.'xtc_get_path.inc.php');
require_once (DIR_FS_INC.'xtc_get_product_path.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_name.inc.php');
require_once (DIR_FS_INC.'xtc_get_products_image.inc.php');

$breadcrumb->add(NAVBAR_TITLE_ACCOUNT, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('account') > 0)
	$smarty->assign('error_message', $messageStack->output('account'));

$i = 0;
$max = count($_SESSION['tracking']['products_history']);

while ($i < $max) {

	$product_history_query = xtDBquery("select * from ".TABLE_PRODUCTS." where products_status = '1' and products_id = '".$_SESSION['tracking']['products_history'][$i]."'");
	$history_product = xtc_db_fetch_array($product_history_query, true);
	$products_name = xtc_get_products_name($_SESSION['tracking']['products_history'][$i]);
	$products_image = xtc_get_products_image((int) $_SESSION['tracking']['products_history'][$i]);
	$products_price = $xtPrice->xtcGetPrice($history_product['products_id'], $format = true, 1, $history_product['products_tax_class_id'], $history_product['products_price']);
	$buy_now = '<a href="'.xtc_href_link(basename($PHP_SELF), xtc_get_all_get_params(array ('action')).'action=buy_now&amp;BUYproducts_id='.$_SESSION['tracking']['products_history'][$i], 'NONSSL').'">'.xtc_image_button('button_buy_now.gif', TEXT_BUY.$products_name.TEXT_NOW).'</a>';
	$cpath = xtc_get_product_path($_SESSION['tracking']['products_history'][$i]);
	if ($history_product['products_status'] != 0) {
		$products_history[] = array ('PRODUCTS_NAME' => $products_name, 
									 'PRODUCTS_IMAGE' => DIR_WS_THUMBNAIL_IMAGES.$products_image, 
									 'PRODUCTS_PRICE' => $products_price, 
									 'PRODUCTS_URL' => xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($_SESSION['tracking']['products_history'][$i],$products_name)), 
									 'PRODUCTS_CATEGORY_URL' => xtc_href_link(FILENAME_DEFAULT, 'cPath='.$cpath), 'BUY_NOW_BUTTON' => $buy_now);
		$i ++;
	}
}

$order_content = '';
if (xtc_count_customer_orders() > 0) {

	$orders_query = xtc_db_query("select
	                                  o.orders_id,
	                                  o.date_purchased,
	                                  o.delivery_name,
	                                  o.delivery_country,
	                                  o.billing_name,
	                                  o.billing_country,
	                                  ot.text as order_total,
	                                  s.orders_status_name
	                                  from ".TABLE_ORDERS." o, ".TABLE_ORDERS_TOTAL."
	                                  ot, ".TABLE_ORDERS_STATUS." s
	                                  where o.customers_id = '".(int) $_SESSION['customer_id']."'
	                                  and o.orders_id = ot.orders_id
	                                  and ot.class = 'ot_total'
	                                  and o.orders_status = s.orders_status_id
	                                  and s.language_id = '".(int) $_SESSION['languages_id']."'
	                                  order by orders_id desc limit 3");

	while ($orders = xtc_db_fetch_array($orders_query)) {
		if (xtc_not_null($orders['delivery_name'])) {
			$order_name = $orders['delivery_name'];
			$order_country = $orders['delivery_country'];
		} else {
			$order_name = $orders['billing_name'];
			$order_country = $orders['billing_country'];
		}
		$order_content[] = array ('ORDER_ID' => $orders['orders_id'], 'ORDER_DATE' => xtc_date_short($orders['date_purchased']), 'ORDER_STATUS' => $orders['orders_status_name'], 'ORDER_TOTAL' => $orders['order_total'], 'ORDER_LINK' => xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL'), 'ORDER_BUTTON' => '<a href="'.xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL').'">'.xtc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW).'</a>');
	}

}
$smarty->assign('LINK_EDIT', xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
$smarty->assign('LINK_ADDRESS', xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
$smarty->assign('LINK_PASSWORD', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));
if (!isset ($_SESSION['customer_id']))
	$smarty->assign('LINK_LOGIN', xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
$smarty->assign('LINK_ORDERS', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$smarty->assign('LINK_NEWSLETTER', xtc_href_link(FILENAME_NEWSLETTER, '', 'SSL'));
$smarty->assign('LINK_ALL', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$smarty->assign('order_content', $order_content);
$smarty->assign('products_history', $products_history);
$smarty->assign('also_purchased_history', $also_purchased_history);
$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>