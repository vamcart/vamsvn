<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_success.php 896 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_success.php,v 1.48 2003/02/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (checkout_success.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (checkout_success.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contribution:

   Credit Class/Gift Vouchers/Discount Coupons (Version 5.10)
   http://www.oscommerce.com/community/contributions,282
   Copyright (c) Strider | Strider@oscworks.com
   Copyright (c  Nick Stanko of UkiDev.com, nick@ukidev.com
   Copyright (c) Andre ambidex@gmx.net
   Copyright (c) 2001,2002 Ian C Wilson http://www.phesis.org


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// if the customer is not logged on, redirect them to the shopping cart page
if (!isset ($_SESSION['customer_id'])) {
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
}

if (isset ($_GET['action']) && ($_GET['action'] == 'update')) {

	if ($_SESSION['account_type'] != 1) {
		vam_redirect(vam_href_link(FILENAME_DEFAULT));
	} else {
		vam_redirect(vam_href_link(FILENAME_LOGOFF));
	}
}
$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_SUCCESS);
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_SUCCESS);

require (DIR_WS_INCLUDES.'header.php');

$orders_query = vam_db_query("select orders_id, orders_status from ".TABLE_ORDERS." where customers_id = '".$_SESSION['customer_id']."' order by orders_id desc limit 1");
$orders = vam_db_fetch_array($orders_query);
$last_order = $orders['orders_id'];
$order_status = $orders['orders_status'];

$vamTemplate->assign('FORM_ACTION', vam_draw_form('order', vam_href_link(FILENAME_CHECKOUT_SUCCESS, 'action=update', 'SSL')));
$vamTemplate->assign('BUTTON_CONTINUE', vam_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$vamTemplate->assign('BUTTON_PRINT', '<img src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print.gif" style="cursor:pointer" onclick="window.open(\''.vam_href_link(FILENAME_PRINT_ORDER, 'oID='.$orders['orders_id']).'\', \'popup\', \'toolbar=0, scrollbars=yes, width=640, height=600\')" />');
$vamTemplate->assign('FORM_END', '</form>');
// GV Code Start
$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id='".$_SESSION['customer_id']."'");
if ($gv_result = vam_db_fetch_array($gv_query)) {
	if ($gv_result['amount'] > 0) {
		$vamTemplate->assign('GV_SEND_LINK', vam_href_link(FILENAME_GV_SEND));
	}
}
// GV Code End

	include (DIR_WS_CLASSES.'order.php');
	$order = new order($orders['orders_id']);

if ($order->info['payment_method'] == 'schet') {
$vamTemplate->assign('BUTTON_SCHET_PRINT', '<img alt="' . MODULE_PAYMENT_SCHET_PRINT . '" src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print_schet.gif" style="cursor:pointer" onclick="window.open(\''.vam_href_link(FILENAME_PRINT_SCHET, 'oID='.$orders['orders_id']).'\', \'popup\', \'toolbar=0, scrollbars=yes, width=800, height=650\')" />');
}

if ($order->info['payment_method'] == 'schet') {
$vamTemplate->assign('BUTTON_PACKINGSLIP_PRINT', '<img alt="' . MODULE_PAYMENT_PACKINGSLIP_PRINT . '" src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print_packingslip.gif" style="cursor:pointer" onclick="window.open(\''.vam_href_link(FILENAME_PRINT_PACKINGSLIP, 'oID='.$orders['orders_id']).'\', \'popup\', \'toolbar=0, scrollbars=yes, width=800, height=650\')" />');
}

if ($order->info['payment_method'] == 'kvitancia') {
$vamTemplate->assign('BUTTON_KVITANCIA_PRINT', '<img alt="' . MODULE_PAYMENT_KVITANCIA_PRINT . '" src="'.'templates/'.CURRENT_TEMPLATE.'/buttons/'.$_SESSION['language'].'/button_print_kvitancia.gif" style="cursor:pointer" onclick="window.open(\''.vam_href_link(FILENAME_PRINT_KVITANCIA, 'oID='.$orders['orders_id']).'\', \'popup\', \'toolbar=0, scrollbars=yes, width=640, height=600\')" />');
}

// Google Conversion tracking
if (GOOGLE_CONVERSION == 'true') {

include(DIR_WS_MODULES . 'analytics/analytics.php');

	$vamTemplate->assign('google_tracking', 'true');
	$vamTemplate->assign('tracking_code', '
<script type="text/javascript">
	var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
	document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
	var pageTracker = _gat._getTracker("' . GOOGLE_CONVERSION_ID . '");
	pageTracker._initData();
	pageTracker._trackPageview();
   pageTracker._addTrans(
' . $transaction_string . '

);
' . $item_string . '
  pageTracker._trackTrans();
</script>
		    ');

}
if (DOWNLOAD_ENABLED == 'true')
	include (DIR_WS_MODULES.'downloads.php');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('PAYMENT_BLOCK', $payment_block);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/checkout_success.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_SUCCESS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_SUCCESS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>