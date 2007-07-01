<?php
/* -----------------------------------------------------------------------------------------
   $Id: gv_send.php 1034 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (gv_send.php,v 1.1.2.3 2003/05/12); www.oscommerce.com
   (c) 2004 xt:Commerce (gv_send.php,v 1.1.2.3 2003/05/12); xt-commerce.com

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

require ('includes/application_top.php');

if (ACTIVATE_GIFT_SYSTEM != 'true')
	vam_redirect(FILENAME_DEFAULT);

require ('includes/classes/http_client.php');

require_once (DIR_FS_INC.'vam_validate_email.inc.php');

$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id'])) {
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
}

if (($_POST['back_x']) || ($_POST['back_y'])) {
	$_GET['action'] = '';
}
if ($_GET['action'] == 'send') {
	$error = false;
	if (!vam_validate_email(trim($_POST['email']))) {
		$error = true;
		$error_email = ERROR_ENTRY_EMAIL_ADDRESS_CHECK;
	}
	$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id = '".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	$customer_amount = $gv_result['amount'];
	$gv_amount = trim(str_replace(",", ".", $_POST['amount']));
	if (ereg('[^0-9/.]', $gv_amount)) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
	}
	if ($gv_amount > $customer_amount || $gv_amount == 0) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
	}
}
if ($_GET['action'] == 'process') {
	$id1 = create_coupon_code($mail['customers_email_address']);
	$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id='".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	$new_amount = $gv_result['amount'] - str_replace(",", ".", $_POST['amount']);
	$new_amount = str_replace(",", ".", $new_amount);
	if ($new_amount < 0) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
		$_GET['action'] = 'send';
	} else {
		$gv_query = vam_db_query("update ".TABLE_COUPON_GV_CUSTOMER." set amount = '".$new_amount."' where customer_id = '".$_SESSION['customer_id']."'");
		$gv_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
		$gv_customer = vam_db_fetch_array($gv_query);
		$gv_query = vam_db_query("insert into ".TABLE_COUPONS." (coupon_type, coupon_code, date_created, coupon_amount) values ('G', '".$id1."', NOW(), '".str_replace(",", ".", vam_db_input($_POST['amount']))."')");
		$insert_id = vam_db_insert_id($gv_query);
		$gv_query = vam_db_query("insert into ".TABLE_COUPON_EMAIL_TRACK." (coupon_id, customer_id_sent, sent_firstname, sent_lastname, emailed_to, date_sent) values ('".$insert_id."' ,'".$_SESSION['customer_id']."', '".addslashes($gv_customer['customers_firstname'])."', '".addslashes($gv_customer['customers_lastname'])."', '".vam_db_input($_POST['email'])."', now())");

		$gv_email_subject = sprintf(EMAIL_GV_TEXT_SUBJECT, stripslashes($_POST['send_name']));

		$smarty->assign('language', $_SESSION['language']);
		$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
		$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$smarty->assign('GIFT_LINK', vam_href_link(FILENAME_GV_REDEEM, 'gv_no='.$id1, 'NONSSL', false));
		$smarty->assign('AMMOUNT', $xtPrice->xtcFormat(str_replace(",", ".", $_POST['amount']), true));
		$smarty->assign('GIFT_CODE', $id1);
		$smarty->assign('MESSAGE', $_POST['message']);
		$smarty->assign('NAME', $_POST['to_name']);
		$smarty->assign('FROM_NAME', $_POST['send_name']);

		// dont allow cache
		$smarty->caching = false;

		$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/send_gift_to_friend.html');
		$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/send_gift_to_friend.txt');

		// send mail
		vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $_POST['email'], $_POST['to_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $gv_email_subject, $html_mail, $txt_mail);

	}
}
$breadcrumb->add(NAVBAR_GV_SEND);

require (DIR_WS_INCLUDES.'header.php');

if ($_GET['action'] == 'process') {
	$smarty->assign('action', 'process');
	$smarty->assign('LINK_DEFAULT', '<a href="'.vam_href_link(FILENAME_DEFAULT, '', 'NONSSL').'">'.vam_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');
}
if ($_GET['action'] == 'send' && !$error) {
	$smarty->assign('action', 'send');
	// validate entries
	$gv_amount = (double) $gv_amount;
	$gv_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	$send_name = $gv_result['customers_firstname'].' '.$gv_result['customers_lastname'];
	$smarty->assign('FORM_ACTION', '<form action="'.vam_href_link(FILENAME_GV_SEND, 'action=process', 'NONSSL').'" method="post">');
	$smarty->assign('MAIN_MESSAGE', sprintf(MAIN_MESSAGE, $xtPrice->xtcFormat(str_replace(",", ".", $_POST['amount']), true), stripslashes($_POST['to_name']), $_POST['email'], stripslashes($_POST['to_name']), $xtPrice->xtcFormat(str_replace(",", ".", $_POST['amount']), true), $send_name));
	if ($_POST['message']) {
		$smarty->assign('PERSONAL_MESSAGE', sprintf(PERSONAL_MESSAGE, $gv_result['customers_firstname']));
		$smarty->assign('POST_MESSAGE', stripslashes($_POST['message']));
	}
	$smarty->assign('HIDDEN_FIELDS', vam_draw_hidden_field('send_name', $send_name).vam_draw_hidden_field('to_name', stripslashes($_POST['to_name'])).vam_draw_hidden_field('email', $_POST['email']).vam_draw_hidden_field('amount', $gv_amount).vam_draw_hidden_field('message', stripslashes($_POST['message'])));
	$smarty->assign('LINK_BACK', vam_image_submit('button_back.gif', IMAGE_BUTTON_BACK, 'name=back').'</a>');
	$smarty->assign('LINK_SUBMIT', vam_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE));
}
elseif ($_GET['action'] == '' || $error) {
	$smarty->assign('action', '');
	$smarty->assign('FORM_ACTION', '<form action="'.vam_href_link(FILENAME_GV_SEND, 'action=send', 'NONSSL').'" method="post">');
	$smarty->assign('LINK_SEND', vam_href_link(FILENAME_GV_SEND, 'action=send', 'NONSSL'));
	$smarty->assign('INPUT_TO_NAME', vam_draw_input_field('to_name', stripslashes($_POST['to_name'])));
	$smarty->assign('INPUT_EMAIL', vam_draw_input_field('email', $_POST['email']));
	$smarty->assign('ERROR_EMAIL', $error_email);
	$smarty->assign('INPUT_AMOUNT', vam_draw_input_field('amount', $_POST['amount'], '', 'text', false));
	$smarty->assign('ERROR_AMOUNT', $error_amount);
	$smarty->assign('TEXTAREA_MESSAGE', vam_draw_textarea_field('message', 'soft', 50, 15, stripslashes($_POST['message'])));
	$smarty->assign('LINK_SUBMIT', vam_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
}
$smarty->assign('FORM_END', '</form>');
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/gv_send.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>