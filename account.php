<?php
/* -----------------------------------------------------------------------------------------
   $Id: account.php 1124 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2004      xt:Commerce (account.php,v 1.12 2003/08/17); xt:Commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_count_customer_orders.inc.php');
require_once (DIR_FS_INC.'vam_date_short.inc.php');
require_once (DIR_FS_INC.'vam_get_path.inc.php');
require_once (DIR_FS_INC.'vam_get_product_path.inc.php');
require_once (DIR_FS_INC.'vam_get_products_name.inc.php');
require_once (DIR_FS_INC.'vam_get_products_image.inc.php');
require_once (DIR_WS_CLASSES.'order.php');

$breadcrumb->add(NAVBAR_TITLE_ACCOUNT);

if ($messageStack->size('account') > 0)
	$vamTemplate->assign('error_message', $messageStack->output('account'));

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

$order_content = array();
if (vam_count_customer_orders() > 0) {

	$orders_query = vam_db_query("select
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
	                                  order by orders_id desc limit 10");

	while ($orders = vam_db_fetch_array($orders_query)) {
		if (vam_not_null($orders['delivery_name'])) {
			$order_name = $orders['delivery_name'];
			$order_country = $orders['delivery_country'];
		} else {
			$order_name = $orders['billing_name'];
			$order_country = $orders['billing_country'];
		}
		$order = new order((int)$orders['orders_id']);
		$order_info = $order->getOrderData((int)$orders['orders_id']);
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
		$order_content[] = array (
		'ORDER_ID' => $orders['orders_id'], 
		'ORDER_DATE' => vam_date_short($orders['date_purchased']), 
		'ORDER_STATUS' => $orders['orders_status_name'], 
		'ORDER_TOTAL' => $orders['order_total'], 
		'ORDER_LINK' => vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL'), 
		'ORDER_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL').'">'.vam_image_button('view.png', SMALL_IMAGE_BUTTON_VIEW).'</a>', 
		'DUPLICATE_ORDER_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $orders['orders_id'] . '&action=order', 'SSL').'">'.TEXT_DUPLICATE_ORDER.'</a>', 
		'DUPLICATE_CART_BUTTON' => '<a class="button mb-2" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $orders['orders_id'] . '&action=cart', 'SSL').'">'.TEXT_DUPLICATE_ORDER_ADD_TO_CART.'</a>', 
		'ORDER_INFO' => $order
		);
	}

}
$vamTemplate->assign('LINK_EDIT', vam_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
$vamTemplate->assign('LINK_ADDRESS', vam_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
$vamTemplate->assign('LINK_PASSWORD', vam_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));
if (!isset ($_SESSION['customer_id']))
	$vamTemplate->assign('LINK_LOGIN', vam_href_link(FILENAME_LOGIN, '', 'SSL'));
$vamTemplate->assign('LINK_ORDERS', vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$vamTemplate->assign('LINK_NEWSLETTER', vam_href_link(FILENAME_NEWSLETTER, '', 'SSL'));
$vamTemplate->assign('LINK_ALL', vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$vamTemplate->assign('order_content', $order_content);
$vamTemplate->assign('products_history', $products_history);
$vamTemplate->assign('also_purchased_history', $also_purchased_history);
$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/account.html');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>