<?php
/* -----------------------------------------------------------------------------------------
   $Id: print_order.php 1185 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2003	 nextcommerce (print_order.php,v 1.5 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (print_order.php,v 1.5 2003/08/24); xt-commerce.com
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// include needed functions
require_once (DIR_FS_INC.'vam_get_order_data.inc.php');
require_once (DIR_FS_INC.'vam_get_attributes_model.inc.php');


$vamTemplate = new vamTemplate;

  $persons_query = vam_db_query("SELECT * FROM ".TABLE_PERSONS."
  					WHERE orders_id='".(int)$_GET['oID']."'");
  					
  $persons = vam_db_fetch_array($persons_query);

	$vamTemplate->assign('kvit_name', $persons['name']);
	$vamTemplate->assign('kvit_address', $persons['address']);

// check if custmer is allowed to see this order!
$order_query_check = vam_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".(int) $_GET['oID']."'");
$oID = (int) $_GET['oID'];
$order_check = vam_db_fetch_array($order_query_check);
if ($_SESSION['customer_id'] == $order_check['customers_id']) {
	// get order data

	include (DIR_WS_CLASSES.'order.php');
	$order = new order($oID);
	$vamTemplate->assign('address_label_customer', vam_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$vamTemplate->assign('address_label_shipping', vam_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	$vamTemplate->assign('address_label_payment', vam_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	$vamTemplate->assign('csID', $order->customer['csID']);
	// get products data
	$order_total = $order->getTotalData($oID); 
	$vamTemplate->assign('order_data', $order->getOrderData($oID));
	$vamTemplate->assign('order_total', $order_total['data']);
	$vamTemplate->assign('final_price', $order->info['total']);

	$vamTemplate->assign('kvitancia1', MODULE_PAYMENT_KVITANCIA_1);
	$vamTemplate->assign('kvitancia2', MODULE_PAYMENT_KVITANCIA_2);
	$vamTemplate->assign('kvitancia3', MODULE_PAYMENT_KVITANCIA_3);
	$vamTemplate->assign('kvitancia4', MODULE_PAYMENT_KVITANCIA_4);
	$vamTemplate->assign('kvitancia5', MODULE_PAYMENT_KVITANCIA_5);
	$vamTemplate->assign('kvitancia6', MODULE_PAYMENT_KVITANCIA_6);
	$vamTemplate->assign('kvitancia7', MODULE_PAYMENT_KVITANCIA_7);
	$vamTemplate->assign('kvitancia8', MODULE_PAYMENT_KVITANCIA_8);

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
   $vamTemplate->assign('charset', $_SESSION['language_charset']); 
	$vamTemplate->assign('oID', (int) $_GET['oID']);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$vamTemplate->assign('PAYMENT_METHOD', $payment_method);
	$vamTemplate->assign('COMMENT', $order->info['comments']);
	$vamTemplate->assign('DATE', vam_date_short($order->info['date_purchased']));
	$path = DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/';
	$vamTemplate->assign('tpl_path', $path);

	// dont allow cache
	$vamTemplate->caching = false;

	$vamTemplate->display(CURRENT_TEMPLATE.'/module/kvitancia.html');
} else {

	$vamTemplate->assign('ERROR', 'You are not allowed to view this order!');
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/error_message.html');
}
?>