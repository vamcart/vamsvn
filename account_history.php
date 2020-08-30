<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_history.php 1309 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_history.php,v 1.60 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_history.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (account_history.php,v 1.13 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_count_customer_orders.inc.php');
require_once (DIR_FS_INC.'vam_date_long.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_WS_CLASSES.'order.php');

if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY, vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));

$module_content = array ();
if (($orders_total = vam_count_customer_orders()) > 0) {
	$history_query_raw = "select o.orders_id, o.date_purchased, o.delivery_name, o.billing_name, ot.text as order_total, s.orders_status_name from ".TABLE_ORDERS." o, ".TABLE_ORDERS_TOTAL." ot, ".TABLE_ORDERS_STATUS." s where o.customers_id = '".(int) $_SESSION['customer_id']."' and o.orders_id = ot.orders_id and ot.class = 'ot_total' and o.orders_status = s.orders_status_id and s.language_id = '".(int) $_SESSION['languages_id']."' order by orders_id DESC";
	$history_split = new splitPageResults($history_query_raw, $_GET['page'], MAX_DISPLAY_ORDER_HISTORY);
	$history_query = vam_db_query($history_split->sql_query);

	while ($history = vam_db_fetch_array($history_query)) {
		$products_query = vam_db_query("select count(*) as count from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".$history['orders_id']."'");
		$products = vam_db_fetch_array($products_query);

		if (vam_not_null($history['delivery_name'])) {
			$order_type = TEXT_ORDER_SHIPPED_TO;
			$order_name = $history['delivery_name'];
		} else {
			$order_type = TEXT_ORDER_BILLED_TO;
			$order_name = $history['billing_name'];
		}
		$order = new order((int)$history['orders_id']);
		$order_info = $order->getOrderData((int)$history['orders_id']);
		foreach ($order->products as &$pr) {
			$pr['product_info'] = new product((int)$pr['id']);
			if ($pr['product_info']->data['products_image'] != '') {
				$pr['product_info']->data['products_image'] = DIR_WS_INFO_IMAGES.$pr['product_info']->data['products_image'];
			}
	   		if (!file_exists($pr['product_info']->data['products_image'])) {
	   			$pr['product_info']->data['products_image'] = DIR_WS_INFO_IMAGES.'../noimage.png';
   			}
   			foreach ($order_info as $oi) {
   				if ($pr['id'] == $oi['PRODUCTS_ID']) {
   					$pr['attributes'] = $oi['PRODUCTS_ATTRIBUTES'];
   				}
   			}
		}

		$module_content[] = array (
		'ORDER_ID' => $history['orders_id'], 
		'ORDER_STATUS' => $history['orders_status_name'], 
		'ORDER_DATE' => vam_date_long($history['date_purchased']), 
		'ORDER_PRODUCTS' => $products['count'], 
		'ORDER_TOTAL' => strip_tags($history['order_total']), 
		'ORDER_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'page='.(empty($_GET['page']) ? "1" : (int)$_GET['page']) .'&order_id='.$history['orders_id'], 'SSL').'">'.vam_image_button('view.png', SMALL_IMAGE_BUTTON_VIEW).'</a>', 
		'DUPLICATE_ORDER_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $history['orders_id'] . '&action=order', 'SSL').'">'.TEXT_DUPLICATE_ORDER.'</a>', 
		'DUPLICATE_CART_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $history['orders_id'] . '&action=cart', 'SSL').'">'.TEXT_DUPLICATE_ORDER_ADD_TO_CART.'</a>', 
		'ORDER_INFO' => $order
		);

	}
}

if ($orders_total > 0) {
	$vamTemplate->assign('SPLIT_BAR', TEXT_RESULT_PAGE.' '.$history_split->display_links(MAX_DISPLAY_PAGE_LINKS, vam_get_all_get_params(array ('page', 'info', 'x', 'y')))); 
	$vamTemplate->assign('SPLIT_BAR_PAGES', $history_split->display_count(TEXT_DISPLAY_NUMBER_OF_ORDERS)); 
}
$vamTemplate->assign('order_content', $module_content);
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/account_history.html');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_HISTORY.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_HISTORY.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>