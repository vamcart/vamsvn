<?php
/*------------------------------------------------------------------------------
   $Id: password_double_opt.php,v 1.0 

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com 
   (c) 2003  nextcommerce www.nextcommerce.org
   (c) 2004  xt:Commerce xt-commerce.com

   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

// create template elements
$vamTemplate = new vamTemplate;

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_validate_password.inc.php');
require_once (DIR_FS_INC.'vam_rand.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

$case = double_opt;
$info_message = TEXT_PASSWORD_FORGOTTEN;
if (isset ($_GET['action']) && ($_GET['action'] == 'first_opt_in')) {

	$check_customer_query = vam_db_query("select customers_email_address, customers_id from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($_POST['email'])."'");
	$check_customer = vam_db_fetch_array($check_customer_query);

	$vlcode = vam_random_charcode(32);
	$link = vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=verified&customers_id='.$check_customer['customers_id'].'&key='.$vlcode, 'NONSSL');

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
	$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

	// assign vars
	$vamTemplate->assign('EMAIL', $check_customer['customers_email_address']);
	$vamTemplate->assign('LINK', $link);
	// dont allow cache
	$vamTemplate->caching = false;

	// create mails
	$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/password_verification_mail.html');
	$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/password_verification_mail.txt');

	if ($_POST['captcha'] == $_SESSION['vvcode']) {
		if (!vam_db_num_rows($check_customer_query)) {
			$case = wrong_mail;
			$info_message = TEXT_EMAIL_ERROR;
		} else {
			$case = first_opt_in;
			vam_db_query("update ".TABLE_CUSTOMERS." set password_request_key = '".$vlcode."' where customers_id = '".$check_customer['customers_id']."'");
			vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $check_customer['customers_email_address'], '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_PASSWORD_FORGOTTEN, $html_mail, $txt_mail);

		}
	} else {
		$case = code_error;
		$info_message = TEXT_CODE_ERROR;
	}
}

// Verification
if (isset ($_GET['action']) && ($_GET['action'] == 'verified')) {
	$check_customer_query = vam_db_query("select customers_id, customers_email_address, password_request_key from ".TABLE_CUSTOMERS." where customers_id = '".(int)$_GET['customers_id']."' and password_request_key = '".vam_db_input($_GET['key'])."'");
	$check_customer = vam_db_fetch_array($check_customer_query);
	if (!vam_db_num_rows($check_customer_query) || $_GET['key']=="") {

		$case = no_account;
		$info_message = TEXT_NO_ACCOUNT;
	} else {

		$newpass = vam_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
		$crypted_password = vam_encrypt_password($newpass);

		vam_db_query("update ".TABLE_CUSTOMERS." set customers_password = '".$crypted_password."' where customers_email_address = '".$check_customer['customers_email_address']."'");
		vam_db_query("update ".TABLE_CUSTOMERS." set password_request_key = '' where customers_id = '".$check_customer['customers_id']."'");
		// assign language to template for caching
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

		// assign vars
		$vamTemplate->assign('EMAIL', $check_customer['customers_email_address']);
		$vamTemplate->assign('NEW_PASSWORD', $newpass);
		// dont allow cache
		$vamTemplate->caching = false;
		// create mails
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/new_password_mail.html');
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/new_password_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $check_customer['customers_email_address'], '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_PASSWORD_NEW_PASSWORD, $html_mail, $txt_mail);
		if (!isset ($mail_error)) {
			vam_redirect(vam_href_link(FILENAME_LOGIN, 'info_message='.urlencode(TEXT_PASSWORD_SENT), 'SSL', true, false));
		}
	}
}

$breadcrumb->add(NAVBAR_TITLE_PASSWORD_DOUBLE_OPT, vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'NONSSL'));

require (DIR_WS_INCLUDES.'header.php');

switch ($case) {
	case first_opt_in :
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('info_message', $info_message);
		$vamTemplate->assign('info_message', TEXT_LINK_MAIL_SENDED);
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_messages.html');

		break;
	case second_opt_in :
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('info_message', $info_message);
		//    $vamTemplate->assign('info_message', TEXT_PASSWORD_MAIL_SENDED);
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_messages.html');
		break;
	case code_error :

		$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" name="captcha" />');
		$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha"', 'text', false));
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('info_message', $info_message);
		$vamTemplate->assign('message', TEXT_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('SHOP_NAME', STORE_NAME);
		$vamTemplate->assign('FORM_ACTION', vam_draw_form('sign', vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'NONSSL')));
		$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', vam_db_input($_POST['email'])));
		$vamTemplate->assign('BUTTON_SEND', vam_image_submit('submit.png', IMAGE_BUTTON_LOGIN));
		$vamTemplate->assign('FORM_END', '</form>');
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');

		break;
	case wrong_mail :

		$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" name="captcha" />');
		$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha"', 'text', false));
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('info_message', $info_message);
		$vamTemplate->assign('message', TEXT_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('SHOP_NAME', STORE_NAME);
		$vamTemplate->assign('FORM_ACTION', vam_draw_form('sign', vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'NONSSL')));
		$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', vam_db_input($_POST['email'])));
		$vamTemplate->assign('BUTTON_SEND', vam_image_submit('submit.png', IMAGE_BUTTON_LOGIN));
		$vamTemplate->assign('FORM_END', '</form>');
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');

		break;
	case no_account :
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('info_message', $info_message);
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_messages.html');

		break;
	case double_opt :

		$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" />');
		$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha"', 'text', false));
		$vamTemplate->assign('text_heading', HEADING_PASSWORD_FORGOTTEN);
		//    $vamTemplate->assign('info_message', $info_message);
		$vamTemplate->assign('message', TEXT_PASSWORD_FORGOTTEN);
		$vamTemplate->assign('SHOP_NAME', STORE_NAME);
		$vamTemplate->assign('FORM_ACTION', vam_draw_form('sign', vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, 'action=first_opt_in', 'NONSSL')));
		$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', vam_db_input($_POST['email'])));
		$vamTemplate->assign('BUTTON_SEND', vam_image_submit('submit.png',  IMAGE_BUTTON_LOGIN));
		$vamTemplate->assign('FORM_END', '</form>');
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->caching = 0;
		$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/password_double_opt_in.html');

		break;
}

$vamTemplate->assign('main_content', $main_content);
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PASSWORD_DOUBLE_OPT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PASSWORD_DOUBLE_OPT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>