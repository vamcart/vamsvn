<?php
/*------------------------------------------------------------------------------
   $Id: newsletter.php,v 1.0 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com 
   (c) 2003	 nextcommerce www.nextcommerce.org
   (c) 2004	 xt:Commerce xt-commerce.com
   
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
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {
	$vlcode = vam_random_charcode(32);
	$link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.vam_db_input($_POST['email']).'&key='.$vlcode, 'NONSSL');

	// assign language to template for caching
	$vamTemplate->assign('language', $_SESSION['language']);
	$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

	// assign vars
	$vamTemplate->assign('EMAIL', vam_db_input($_POST['email']));
	$vamTemplate->assign('LINK', $link);
	// dont allow cache
	$vamTemplate->caching = false;

	// create mails
	$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.html');
	$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.txt');

	// Check if email exists 

	if (($_POST['check'] == 'inp') && ($_POST['captcha'] == $_SESSION['vvcode'])) {

		$check_mail_query = vam_db_query("select customers_email_address, mail_status from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".vam_db_input($_POST['email'])."'");
		if (!vam_db_num_rows($check_mail_query)) {

			if (isset ($_SESSION['customer_id'])) {
				$customers_id = $_SESSION['customer_id'];
				$customers_status = $_SESSION['customers_status']['customers_status_id'];
				$customers_firstname = $_SESSION['customer_first_name'];
				$customers_lastname = $_SESSION['customer_last_name'];
			} else {

				$check_customer_mail_query = vam_db_query("select customers_id, customers_status, customers_firstname, customers_lastname, customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($_POST['email'])."'");
				if (!vam_db_num_rows($check_customer_mail_query)) {
					$customers_id = '0';
					$customers_status = '1';
					$customers_firstname = TEXT_CUSTOMER_GUEST;
					$customers_lastname = '';
				} else {
					$check_customer = vam_db_fetch_array($check_customer_mail_query);
					$customers_id = $check_customer['customers_id'];
					$customers_status = $check_customer['customers_status'];
					$customers_firstname = $check_customer['customers_firstname'];
					$customers_lastname = $check_customer['customers_lastname'];
				}

			}

			$sql_data_array = array ('customers_email_address' => vam_db_input($_POST['email']), 'customers_id' => vam_db_input($customers_id), 'customers_status' => vam_db_input($customers_status), 'customers_firstname' => vam_db_input($customers_firstname), 'customers_lastname' => vam_db_input($customers_lastname), 'mail_status' => '0', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
			vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

			$info_message = TEXT_EMAIL_INPUT;

			if (SEND_EMAILS == true) {
				vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, vam_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);
			}

		} else {
			$check_mail = vam_db_fetch_array($check_mail_query);

			if ($check_mail['mail_status'] == '0') {

				$info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;

				if (SEND_EMAILS == true) {
					vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, vam_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);
				}

			} else {
				$info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
			}

		}

	} else {
		$info_message = TEXT_WRONG_CODE;
	}

	if (($_POST['check'] == 'del') && ($_POST['captcha'] == $_SESSION['vvcode'])) {

		$check_mail_query = vam_db_query("select customers_email_address from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".vam_db_input($_POST['email'])."'");
		if (!vam_db_num_rows($check_mail_query)) {
			$info_message = TEXT_EMAIL_NOT_EXIST;
		} else {
			$del_query = vam_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address ='".vam_db_input($_POST['email'])."'");
			$info_message = TEXT_EMAIL_DEL;
		}
	}
}

// Accountaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'activate')) {
	$check_mail_query = vam_db_query("select mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".vam_db_input($_GET['email'])."'");
	if (!vam_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {
		$check_mail = vam_db_fetch_array($check_mail_query);
		if ($check_mail['mail_key'] != $_GET['key']) {
			$info_message = TEXT_EMAIL_ACTIVE_ERROR;
		} else {
			vam_db_query("update ".TABLE_NEWSLETTER_RECIPIENTS." set mail_status = '1' where customers_email_address = '".vam_db_input($_GET['email'])."'");
			$info_message = TEXT_EMAIL_ACTIVE;
		}
	}
}

// Accountdeaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'remove')) {
	$check_mail_query = vam_db_query("select mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".vam_db_input($_GET['email'])."'");
	if (!vam_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {
		$check_mail = vam_db_fetch_array($check_mail_query);
		if ($check_mail['mail_key'] != $_GET['key']) {
			$info_message = TEXT_EMAIL_DEL_ERROR;
		} else {
			$del_query = vam_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where  customers_email_address ='".vam_db_input($_GET['email'])."'");
			$info_message = TEXT_EMAIL_DEL;
		}
	}
}

$breadcrumb->add(NAVBAR_TITLE_NEWSLETTER, vam_href_link(FILENAME_NEWSLETTER, '', 'NONSSL'));

require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" name="captcha" />');
$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6"', 'text', false));

$vamTemplate->assign('text_newsletter', TEXT_NEWSLETTER);
$vamTemplate->assign('info_message', $info_message);
$vamTemplate->assign('FORM_ACTION', vam_draw_form('sign', vam_href_link(FILENAME_NEWSLETTER, 'action=process', 'NONSSL')));
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_field('email', vam_db_input($_POST['email'])));
$vamTemplate->assign('CHECK_INP', vam_draw_radio_field('check', 'inp'));
$vamTemplate->assign('CHECK_DEL', vam_draw_radio_field('check', 'del'));
$vamTemplate->assign('BUTTON_SEND', vam_image_submit('submit.png', IMAGE_BUTTON_LOGIN));
$vamTemplate->assign('FORM_END', '</form>');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/newsletter.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_NEWSLETTER.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_NEWSLETTER.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>