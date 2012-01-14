<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_payment.php 1325 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_payment.php,v 1.110 2003/03/14); www.oscommerce.com
   (c) 2003	 nextcommerce (checkout_payment.php,v 1.20 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (checkout_payment.php,v 1.20 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   agree_conditions_1.01        	Autor:	Thomas Plдnkers (webmaster@oscommerce.at)

   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

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
require (DIR_FS_CATALOG . 'templates/' . CURRENT_TEMPLATE . '/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC . 'vam_address_label.inc.php');
require_once (DIR_FS_INC . 'vam_get_address_format_id.inc.php');
require_once (DIR_FS_INC . 'vam_check_stock.inc.php');
unset ($_SESSION['tmp_oID']);
// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id'])) {
	if (ACCOUNT_OPTIONS == 'guest') {
		vam_redirect(vam_href_link(FILENAME_CREATE_GUEST_ACCOUNT, '', 'SSL'));
	} else {
		vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
	}
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1)
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!isset ($_SESSION['shipping']))
	vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
	if ($_SESSION['cart']->cartID != $_SESSION['cartID'])
		vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

if (isset ($_SESSION['credit_covers']))
	unset ($_SESSION['credit_covers']); //ICW ADDED FOR CREDIT CLASS SYSTEM
// Stock Check
if ((STOCK_CHECK == 'true') && (STOCK_ALLOW_CHECKOUT != 'true')) {
	$products = $_SESSION['cart']->get_products();
	$any_out_of_stock = 0;
	for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
		if (vam_check_stock($products[$i]['id'], $products[$i]['quantity']))
			$any_out_of_stock = 1;
	}
	if ($any_out_of_stock == 1)
		vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));

}

// if no billing destination address was selected, use the customers own address as default
if (!isset ($_SESSION['billto'])) {
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
} else {
	// verify the selected billing address
	$check_address_query = vam_db_query("select count(*) as total from " . TABLE_ADDRESS_BOOK . " where customers_id = '" . (int) $_SESSION['customer_id'] . "' and address_book_id = '" . (int) $_SESSION['billto'] . "'");
	$check_address = vam_db_fetch_array($check_address_query);

	if ($check_address['total'] != '1') {
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
		if (isset ($_SESSION['payment']))
			unset ($_SESSION['payment']);
	}
}

if (!isset ($_SESSION['sendto']) || $_SESSION['sendto'] == "")
	$_SESSION['sendto'] = $_SESSION['billto'];

require (DIR_WS_CLASSES . 'order.php');
$order = new order();

require (DIR_WS_CLASSES . 'order_total.php'); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
$order_total_modules = new order_total(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

$total_weight = $_SESSION['cart']->show_weight();

//  $total_count = $_SESSION['cart']->count_contents();
$total_count = $_SESSION['cart']->count_contents_virtual(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

if ($order->billing['country']['iso_code_2'] != '')
	$_SESSION['delivery_zone'] = $order->billing['country']['iso_code_2'];

// load all enabled payment modules
require (DIR_WS_CLASSES . 'payment.php');
$payment_modules = new payment;

$order_total_modules->process();
// redirect if Coupon matches ammount

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_PAYMENT, vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_PAYMENT, vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

if (ACCOUNT_STREET_ADDRESS == 'true') {
$vamTemplate->assign('BILLING_ADDRESS', 'true');
}

$vamTemplate->assign('FORM_ACTION', vam_draw_form('checkout_payment', vam_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'), 'post', 'onsubmit="return check_form();"'));
$vamTemplate->assign('ADDRESS_LABEL', vam_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'));
$vamTemplate->assign('BUTTON_ADDRESS', '<a class="button" href="' . vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL') . '">' . vam_image_button('edit.png', IMAGE_BUTTON_CHANGE_ADDRESS) . '</a>');
$vamTemplate->assign('BUTTON_CONTINUE', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
$vamTemplate->assign('FORM_END', '</form>');

require (DIR_WS_INCLUDES . 'header.php');
$module = new vamTemplate;
//if ($order->info['total'] > 0 || $_SESSION['cart']->get_content_type() == 'virtual') {
	if (isset ($_GET['payment_error']) && is_object(${ $_GET['payment_error'] }) && ($error = ${$_GET['payment_error']}->get_error())) {

		$vamTemplate->assign('error', htmlspecialchars($error['error']));

	}

	$selection = $payment_modules->selection();

	$radio_buttons = 0;
	for ($i = 0, $n = sizeof($selection); $i < $n; $i++) {

		$selection[$i]['radio_buttons'] = $radio_buttons;
		if (($selection[$i]['id'] == $payment) || ($n == 1)) {
			$selection[$i]['checked'] = 1;
		}

		if (sizeof($selection) > 1) {
			$selection[$i]['selection'] = vam_draw_radio_field('payment', $selection[$i]['id'], ($selection[$i]['id'] == $selection[0]['id']), 'id="'.$selection[$i]['id'].'"');
		} else {
			$selection[$i]['selection'] = vam_draw_hidden_field('payment', $selection[$i]['id']);
		}

			$selection[$i]['id'] = $selection[$i]['id'];

		if (isset ($selection[$i]['error'])) {

		} else {

			$radio_buttons++;
		}
	}

	$module->assign('module_content', $selection);

//} else {
//	$vamTemplate->assign('GV_COVER', 'true');
//}

if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$vamTemplate->assign('module_gift', $order_total_modules->credit_selection());
}

$module->caching = 0;
$payment_block = $module->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_block.html');

$vamTemplate->assign('COMMENTS', vam_draw_textarea_field('comments', 'soft', '60', '5', $_SESSION['comments']) . vam_draw_hidden_field('comments_added', 'YES'));

$vamTemplate->assign('conditions', 'false');

//check if display conditions on checkout page is true
if (DISPLAY_CONDITIONS_ON_CHECKOUT == 'true') {

$vamTemplate->assign('conditions', 'true');

	if (GROUP_CHECK == 'true') {
		$group_check = "and group_ids LIKE '%c_" . $_SESSION['customers_status']['customers_status_id'] . "_group%'";
	}

	$shop_content_query = vam_db_query("SELECT
	                                                content_title,
	                                                content_heading,
	                                                content_text,
	                                                content_file
	                                                FROM " . TABLE_CONTENT_MANAGER . "
	                                                WHERE content_group='3' " . $group_check . "
	                                                AND languages_id='" . $_SESSION['languages_id'] . "'");
	$shop_content_data = vam_db_fetch_array($shop_content_query);

	if ($shop_content_data['content_file'] != '') {

		$conditions = '<iframe SRC="' . DIR_WS_CATALOG . 'media/content/' . $shop_content_data['content_file'] . '" width="100%" height="300">';
		$conditions .= '</iframe>';
	} else {

		$conditions = '<textarea name="blabla" cols="60" rows="10" readonly="readonly">' . strip_tags(str_replace('<br />', "\n", $shop_content_data['content_text'])) . '</textarea>';
	}

	$vamTemplate->assign('AGB', $conditions);
	$vamTemplate->assign('AGB_LINK', $main->getContentLink(3, MORE_INFO));
	// LUUPAY ZAHLUNGSMODUL
	if (isset ($_GET['step']) && $_GET['step'] == 'step2') {
		$vamTemplate->assign('AGB_checkbox', '<input type="checkbox" value="conditions" name="conditions" checked />');
	} else {
		$vamTemplate->assign('AGB_checkbox', '<input type="checkbox" value="conditions" name="conditions" />');
	}
	// LUUPAY END

}

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('PAYMENT_BLOCK', $payment_block);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE . '/module/checkout_payment.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_PAYMENT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_PAYMENT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>