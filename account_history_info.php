<?php
/* -----------------------------------------------------------------------------------------
   $Id: account_history_info.php 1309 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_history_info.php,v 1.97 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_history_info.php,v 1.17 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (account_history_info.php,v 1.17 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_date_short.inc.php');
require_once (DIR_FS_INC.'vam_get_all_get_params.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_display_tax_value.inc.php');
require_once (DIR_FS_INC.'vam_format_price_order.inc.php');
require_once (DIR_WS_CLASSES.'order.php');

//security checks
if (!isset ($_SESSION['customer_id'])) { vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL')); }
if (!isset ($_GET['order_id']) || (isset ($_GET['order_id']) && !is_numeric($_GET['order_id']))) { 
   vam_redirect(vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
}
$customer_info_query = vam_db_query("select customers_id from ".TABLE_ORDERS." where orders_id = '".(int) $_GET['order_id']."'");
$customer_info = vam_db_fetch_array($customer_info_query);
if ($customer_info['customers_id'] != $_SESSION['customer_id']) { vam_redirect(vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL')); }

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_HISTORY_INFO, vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_HISTORY_INFO, vam_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
$breadcrumb->add(sprintf(NAVBAR_TITLE_3_ACCOUNT_HISTORY_INFO, (int)$_GET['order_id']), vam_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.(int)$_GET['order_id'], 'SSL'));

$order = new order((int)$_GET['order_id']);

// Delivery Info
if ($order->delivery != false) {
	$vamTemplate->assign('DELIVERY_LABEL', vam_address_format($order->delivery['format_id'], $order->delivery, 1, ' ', '<br />'));
	if ($order->info['shipping_method']) { $vamTemplate->assign('SHIPPING_METHOD', $order->info['shipping_method']); }
}

$order_total = $order->getTotalData((int)$_GET['order_id']); 

$vamTemplate->assign('order_data', $order->getOrderData((int)$_GET['order_id']));
$vamTemplate->assign('order_total', $order_total['data']);

// Payment Method
if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
	include (DIR_WS_LANGUAGES.'/'.$_SESSION['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
	$vamTemplate->assign('PAYMENT_METHOD', constant(MODULE_PAYMENT_.strtoupper($order->info['payment_method'])._TEXT_TITLE));
}



// Order History
$statuses_query = vam_db_query("select os.orders_status_name, osh.date_added, osh.comments from ".TABLE_ORDERS_STATUS." os, ".TABLE_ORDERS_STATUS_HISTORY." osh where osh.orders_id = '".(int) $_GET['order_id']."' and osh.orders_status_id = os.orders_status_id and os.language_id = '".(int) $_SESSION['languages_id']."' order by osh.date_added");
while ($statuses = vam_db_fetch_array($statuses_query)) {
	$history_block .= '<p>' . vam_date_short($statuses['date_added'])."\n".$statuses['orders_status_name']."\n". (empty ($statuses['comments']) ? '&nbsp;' : nl2br($statuses['comments']))."\n".'</p>';
}
$vamTemplate->assign('HISTORY_BLOCK', $history_block);

// Download-Products
if (DOWNLOAD_ENABLED == 'true') include (DIR_WS_MODULES.'downloads.php');

// Stuff

if ($order->info['payment_method'] == 'schet') {
$vamTemplate->assign('BUTTON_SCHET_PRINT', '<a class="button" target="_blank" href="'.vam_href_link(FILENAME_PRINT_SCHET, 'oID='.(int)$_GET['order_id']).'">'.vam_image_button('print.png', BUTTON_PRINT_SCHET).'</a>');
}

if ($order->info['payment_method'] == 'schet') {
$vamTemplate->assign('BUTTON_PACKINGSLIP_PRINT', '<a class="button" target="_blank" href="'.vam_href_link(FILENAME_PRINT_PACKINGSLIP, 'oID='.(int)$_GET['order_id']).'">'.vam_image_button('print.png', BUTTON_PRINT_PACKINGSLIP).'</a>');
}

if ($order->info['payment_method'] == 'kvitancia') {
$vamTemplate->assign('BUTTON_KVITANCIA_PRINT', '<a class="button" target="_blank" href="'.vam_href_link(FILENAME_PRINT_KVITANCIA, 'oID='.(int)$_GET['order_id']).'">'.vam_image_button('print.png', BUTTON_PRINT_KVITANCIA).'</a>');
}

$vamTemplate->assign('ORDER_NUMBER', (int)$_GET['order_id']);
$vamTemplate->assign('ORDER_DATE', vam_date_long($order->info['date_purchased']));
$vamTemplate->assign('ORDER_STATUS', $order->info['orders_status']);
$vamTemplate->assign('BILLING_LABEL', vam_address_format($order->billing['format_id'], $order->billing, 1, ' ', '<br />'));
$vamTemplate->assign('PRODUCTS_EDIT', vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
$vamTemplate->assign('SHIPPING_ADDRESS_EDIT', vam_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL'));
$vamTemplate->assign('BILLING_ADDRESS_EDIT', vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));
$vamTemplate->assign('BUTTON_PRINT', '<a class="button" target="_blank" href="'.vam_href_link(FILENAME_PRINT_ORDER, 'oID='.(int)$_GET['order_id']).'">'.vam_image_button('print.png', IMAGE_BUTTON_PRINT).'</a>');
$vamTemplate->assign('DUPLICATE_ORDER_BUTTON', '<a class="button" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $_GET['order_id'] . '&action=order', 'SSL').'">'.TEXT_DUPLICATE_ORDER.'</a>');
$vamTemplate->assign('DUPLICATE_CART_BUTTON', '<a class="button" href="'.vam_href_link(FILENAME_ACCOUNT_DUPLICATE_ORDER, 'order_id=' . $_GET['order_id'] . '&action=cart', 'SSL').'">'.TEXT_DUPLICATE_ORDER_ADD_TO_CART.'</a>');

$from_history = preg_match("/page=/i", vam_get_all_get_params()); // referer from account_history yes/no
$back_to = $from_history ? FILENAME_ACCOUNT_HISTORY : FILENAME_ACCOUNT; // if from account_history => return to account_history
$vamTemplate->assign('BUTTON_BACK','<a class="button" href="' . vam_href_link($back_to,vam_get_all_get_params(array ('order_id')), 'SSL') . '">' . vam_image_button('back.png', IMAGE_BUTTON_BACK) . '</a>');

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/account_history_info.html');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_HISTORY_INFO.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_ACCOUNT_HISTORY_INFO.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>