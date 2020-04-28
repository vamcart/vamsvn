<?php
/*
  $Id: one_click_buy.php,v 1.42 2003/06/11 17:35:01 hpdl Exp $

  osCommerce, Open Source E-Commerce Solutions
  http://www.oscommerce.com

  Copyright (c) 2003 osCommerce

  Released under the GNU General Public License
  Credits: Marg Davison, Loпc Richard, FaNaTiC, C. Bouwmeester
  Anpassungen fьr XT:Commerce 3.0.4 SP1: 2005/2006 BSB Beratung+Software Bleicher
  ASK_A_QUESTION.GIF Grafikdesign (c) 2005/2005 BSB Beratung+Software Bleicher

*/
include ('includes/application_top.php');

// include needed functions
require_once(DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_image_button.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

// create smarty elements
$vamTemplate = new vamTemplate;

$vamTemplate->assign('language', $_SESSION['language']);

		$spam_flag = false;

		if ( trim( $_POST['anti-bot-q'] ) != date('Y') ) { // answer is wrong - maybe spam
			$spam_flag = true;
			if ( empty( $_POST['anti-bot-q'] ) ) { // empty answer - maybe spam
				$antispam_error_message .= 'Error: empty answer. ['.$_POST['anti-bot-q'].']<br> ';
			} else {
				$antispam_error_message .= 'Error: answer is wrong. ['.$_POST['anti-bot-q'].']<br> ';
			}
		}
		if ( ! empty( $_POST['anti-bot-e-email-url'] ) ) { // field is not empty - maybe spam
			$spam_flag = true;
			$antispam_error_message .= 'Error: field should be empty. ['.$_POST['anti-bot-e-email-url'].']<br> ';
		}
		
if (isset ($_POST['action']) && ($_POST['action'] == 'process')  && $spam_flag == false) {

include ('includes/header.php');

$product_info_query = vam_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int)$_POST['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int)$_SESSION['languages_id']."'");
$product_info = vam_db_fetch_array($product_info_query);

	$error = false;

	if (isset($_SESSION['customer_id'])) { 
		$firstname = $_SESSION['customer_first_name'];
		$lastname = $_SESSION['customer_last_name'];
		$telephone = $_SESSION['customer_telephone'];
		$email_address =$_SESSION['customer_email_address'];
		$message = vam_db_input($_POST['message_body']);
		$to_email_address = $email_address;
		$to_name = $firstname .' '. $lastname;
  } else {    
		$firstname = vam_db_input($_POST['firstname']);
		$lastname = vam_db_input($_POST['lastname']);
		$telephone = vam_db_input($_POST['telephone']);
		$email_address = vam_db_input($_POST['email_address']);
		$message = vam_db_input($_POST['message_body']);
		$to_email_address = $email_address;
		$to_name = $firstname .' '. $lastname;
	}
	
	//if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_FIRST_NAME_ERROR);
	//}

	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$messageStack->add('one_click_buy', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	//if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_EMAIL_ADDRESS_ERROR);
	//}
	//elseif (vam_validate_email($email_address) == false) {
		//$error = true;
		//$messageStack->add('one_click_buy', ENTRY_EMAIL_ADDRESS_ERROR);
	//} 

	//if ($message == '') {
		//$error = true;
		//$messageStack->add('one_click_buy', TEXT_MESSAGE_ERROR);
	//}

	if ($messageStack->size('one_click_buy') > 0) {
$vamTemplate->assign('error', $messageStack->output('one_click_buy'));
	}

		if ($error == false) {
		$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
		$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);
		$vamTemplate->assign('TEXT_MESSAGE', $_POST['message_body']);
		$vamTemplate->assign('TEXT_FIRSTNAME', $firstname);
		$vamTemplate->assign('TEXT_LASTNAME', $lastname);
		$vamTemplate->assign('TEXT_TELEPHONE', $telephone);
		$vamTemplate->assign('TEXT_EMAIL', $email_address);
		$vamTemplate->assign('TEXT_EMAIL_SUCCESSFUL', sprintf(TEXT_EMAIL_SUCCESSFUL_SENT, $product_info['products_name']));
		$vamTemplate->assign('PRODUCT_LINK', vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product_info['products_id'], $product_info['products_name'])));
		$vamTemplate->caching = 0;
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/one_click_buy.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/one_click_buy.txt');
	// send mail to admin
	vam_php_mail(filter_var($to_email_address, FILTER_VALIDATE_EMAIL), EMAIL_SUPPORT_NAME, EMAIL_SUPPORT_ADDRESS, STORE_NAME, EMAIL_SUPPORT_FORWARDING_STRING, filter_var($to_email_address, FILTER_VALIDATE_EMAIL), $to_name, '', '', NAVBAR_TITLE_ASK, $html_mail, $txt_mail);
	// send mail to customer
	//vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $to_email_address, $to_name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', NAVBAR_TITLE_ASK, $html_mail, $txt_mail);

if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy_ok.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy_ok.html', $cache_id);
		}
	}else{
$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('one_click_buy', vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));

        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
$vamTemplate->assign('INPUT_LASTNAME', $_SESSION['customer_last_name']);
$vamTemplate->assign('INPUT_TELEPHONE', $_SESSION['customer_telephone']);
$vamTemplate->assign('INPUT_EMAIL', $_SESSION['customer_email_address']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_TELEPHONE', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 10, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CHECKOUT));
$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="javascript:window.close()">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

// set cache ID
 if (!CacheCheck()) {
	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html');
} else {
	$vamTemplate->caching = 1;
	$vamTemplate->cache_lifetime = CACHE_LIFETIME;
	$vamTemplate->cache_modified_check = CACHE_CHECK;
	$cache_id = $_SESSION['language'];
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html', $cache_id);
	}
}
}else{

$product_info_query = vam_db_query("select * FROM ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_status = '1' and p.products_id = '".(int)$_GET['products_id']."' and pd.products_id = p.products_id and pd.language_id = '".(int)$_SESSION['languages_id']."'");
$product_info = vam_db_fetch_array($product_info_query);

include ('includes/header.php');

$breadcrumb->add(NAVBAR_TITLE_ASK, vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$product->data['products_id'], 'SSL'));

$vamTemplate->assign('PRODUCTS_NAME', $product_info['products_name']);
$vamTemplate->assign('PRODUCTS_MODEL', $product_info['products_model']);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('one_click_buy', vam_href_link(FILENAME_ONE_CLICK_BUY, 'products_id='.$_GET['products_id'].'')).vam_draw_hidden_field('action', 'process').vam_draw_hidden_field('products_id', $_GET['products_id']));
        if (isset($_SESSION['customer_id'])) { 
		//-> registered user********************************************************
$vamTemplate->assign('INPUT_FIRSTNAME', $_SESSION['customer_first_name']);
$vamTemplate->assign('INPUT_LASTNAME', $_SESSION['customer_last_name']);
$vamTemplate->assign('INPUT_EMAIL', $_SESSION['customer_email_address']);
$vamTemplate->assign('INPUT_TELEPHONE', $_SESSION['customer_telephone']);
        }else{
		//-> guest *********************************************************  
$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : ''))));
$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '' : ''))));
$vamTemplate->assign('INPUT_TELEPHONE', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : ''))));
        }
$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('message_body', 'soft', 10, 3, stripslashes($_POST['message_body'])));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  "Оформить заказ"));
$vamTemplate->assign('BUTTON_CONTINUE', '<a class="button" href="javascript:window.close()">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

	$vamTemplate->caching = 0;
	$vamTemplate->display(CURRENT_TEMPLATE.'/module/one_click_buy.html');
}
?>