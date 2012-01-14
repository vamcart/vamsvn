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

$vamTemplate = new vamTemplate;
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
    $gv_amount_r = trim(str_replace(",", ".", $vamPrice->CalculateCurrEx($_POST['amount'], DEFAULT_CURRENCY)));
	if (preg_match('/[^0-9]/', $gv_amount)) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
	}
	if ($gv_amount_r > $customer_amount || $gv_amount == 0) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
	}
}
if ($_GET['action'] == 'process') {
	$id1 = create_coupon_code($mail['customers_email_address']);
	$gv_query = vam_db_query("select amount from ".TABLE_COUPON_GV_CUSTOMER." where customer_id='".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	$new_amount = $gv_result['amount'] - str_replace(",", ".", $vamPrice->CalculateCurrEx($_POST['amount'], DEFAULT_CURRENCY));
	$new_amount = str_replace(",", ".", $new_amount);
	if ($new_amount < 0) {
		$error = true;
		$error_amount = ERROR_ENTRY_AMOUNT_CHECK;
		$_GET['action'] = 'send';
	} else {
		$gv_query = vam_db_query("update ".TABLE_COUPON_GV_CUSTOMER." set amount = '".$new_amount."' where customer_id = '".$_SESSION['customer_id']."'");
		$gv_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
		$gv_customer = vam_db_fetch_array($gv_query);
		$gv_query = vam_db_query("insert into ".TABLE_COUPONS." (coupon_type, coupon_code, date_created, coupon_amount) values ('G', '".$id1."', NOW(), '".str_replace(",", ".", vam_db_input($vamPrice->CalculateCurrEx($_POST['amount'], DEFAULT_CURRENCY)))."')");
		$insert_id = vam_db_insert_id($gv_query);
		$gv_query = vam_db_query("insert into ".TABLE_COUPON_EMAIL_TRACK." (coupon_id, customer_id_sent, sent_firstname, sent_lastname, emailed_to, date_sent) values ('".$insert_id."' ,'".$_SESSION['customer_id']."', '".addslashes($gv_customer['customers_firstname'])."', '".addslashes($gv_customer['customers_lastname'])."', '".vam_db_input($_POST['email'])."', now())");

		$gv_email_subject = sprintf(EMAIL_GV_TEXT_SUBJECT, stripslashes($_POST['send_name']));

		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$vamTemplate->assign('GIFT_LINK', vam_href_link(FILENAME_GV_REDEEM, 'gv_no='.$id1, 'NONSSL', false));
		$vamTemplate->assign('AMMOUNT', $vamPrice->Format(str_replace(",", ".", $_POST['amount']), true));
		$vamTemplate->assign('GIFT_CODE', $id1);
		$vamTemplate->assign('MESSAGE', $_POST['message']);
		$vamTemplate->assign('NAME', $_POST['to_name']);
		$vamTemplate->assign('FROM_NAME', $_POST['send_name']);

		// dont allow cache
		$vamTemplate->caching = false;

		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/send_gift_to_friend.html');
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/send_gift_to_friend.txt');

		// send mail
		vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $_POST['email'], $_POST['to_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $gv_email_subject, $html_mail, $txt_mail);

	}
}
$breadcrumb->add(NAVBAR_GV_SEND);

require (DIR_WS_INCLUDES.'header.php');

if ($_GET['action'] == 'process') {
	$vamTemplate->assign('action', 'process');
	$vamTemplate->assign('LINK_DEFAULT', '<a class="button" href="'.vam_href_link(FILENAME_DEFAULT, '', 'NONSSL').'">'.vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE).'</a>');
}
if ($_GET['action'] == 'send' && !$error) {
	$vamTemplate->assign('action', 'send');
	// validate entries
	$gv_amount = (double) $gv_amount;
	$gv_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".$_SESSION['customer_id']."'");
	$gv_result = vam_db_fetch_array($gv_query);
	$send_name = $gv_result['customers_firstname'].' '.$gv_result['customers_lastname'];
	$vamTemplate->assign('FORM_ACTION', '<form action="'.vam_href_link(FILENAME_GV_SEND, 'action=process', 'NONSSL').'" method="post">');
	$vamTemplate->assign('MAIN_MESSAGE', sprintf(MAIN_MESSAGE, $vamPrice->Format(str_replace(",", ".", $_POST['amount']), true), stripslashes($_POST['to_name']), $_POST['email'], stripslashes($_POST['to_name']), $vamPrice->Format(str_replace(",", ".", $_POST['amount']), true), $send_name));
	if ($_POST['message']) {
		$vamTemplate->assign('PERSONAL_MESSAGE', sprintf(PERSONAL_MESSAGE, $gv_result['customers_firstname']));
		$vamTemplate->assign('POST_MESSAGE', stripslashes($_POST['message']));
	}
	$vamTemplate->assign('HIDDEN_FIELDS', vam_draw_hidden_field('send_name', $send_name).vam_draw_hidden_field('to_name', stripslashes($_POST['to_name'])).vam_draw_hidden_field('email', $_POST['email']).vam_draw_hidden_field('amount', $gv_amount).vam_draw_hidden_field('message', stripslashes($_POST['message'])));
	$vamTemplate->assign('LINK_BACK', vam_image_submit('back.png', IMAGE_BUTTON_BACK, 'name=back').'</a>');
	$vamTemplate->assign('LINK_SUBMIT', vam_image_submit('submit.png', IMAGE_BUTTON_CONTINUE));
}
elseif ($_GET['action'] == '' || $error) {
	$vamTemplate->assign('action', '');
	$vamTemplate->assign('FORM_ACTION', '<form action="'.vam_href_link(FILENAME_GV_SEND, 'action=send', 'NONSSL').'" method="post">');
	$vamTemplate->assign('LINK_SEND', vam_href_link(FILENAME_GV_SEND, 'action=send', 'NONSSL'));
	$vamTemplate->assign('INPUT_TO_NAME', vam_draw_input_field('to_name', stripslashes($_POST['to_name'])));
	$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', $_POST['email']));
	$vamTemplate->assign('ERROR_EMAIL', $error_email);
	$vamTemplate->assign('INPUT_AMOUNT', vam_draw_input_field('amount', $_POST['amount'], '', 'text', false));
	$vamTemplate->assign('ERROR_AMOUNT', $error_amount);
	$vamTemplate->assign('TEXTAREA_MESSAGE', vam_draw_textarea_field('message', 'soft', 50, 15, stripslashes($_POST['message'])));
	$vamTemplate->assign('LINK_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
}
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/gv_send.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_GV_SEND.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_GV_SEND.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>