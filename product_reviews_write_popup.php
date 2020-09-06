<?php
/* -----------------------------------------------------------------------------------------
   $Id: product_reviews_write.php 1101 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(product_reviews_write.php,v 1.51 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (product_reviews_write.php,v 1.13 2003/08/1); www.nextcommerce.org
   (c) 2004	 xt:Commerce (product_reviews_write.php,v 1.13 2003/08/1); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

if ($_SESSION['customers_status']['customers_status_write_reviews'] == 0) {
             vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));
}

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
		
if (isset ($_GET['action']) && $_GET['action'] == 'process' && $spam_flag == false) {
	if (is_object($product) && $product->isProduct()) { // We got to the process but it is an illegal product, don't write

    $rating = vam_db_prepare_input($_POST['rating']);
    $review = vam_db_prepare_input($_POST['review']);

    $error = false;
    
    if ($_POST['captcha'] == '' or $_POST['captcha'] != $_SESSION['vvcode']) {
      $error = true;
	   $vamTemplate->assign('captcha_error', ENTRY_CAPTCHA_ERROR);
    }

    if (strlen($review) < REVIEW_TEXT_MIN_LENGTH) {
      $error = true;
   	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
    }

    if (($rating < 1) || ($rating > 5)) {
      $error = true;
   	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
    }

    if ($error == false) {
		$customer = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
		$customer_values = vam_db_fetch_array($customer);
		if ($customer_values['customers_firstname'] == '') {
			$customer_values['customers_firstname'] = TEXT_GUEST;
		}		
		$date_now = date('Ymd');
		//if ($customer_values['customers_lastname'] == '')
			//$customer_values['customers_lastname'] = TEXT_GUEST;
		vam_db_query("insert into ".TABLE_REVIEWS." (products_id, customers_id, customers_name, reviews_rating, date_added) values ('".$product->data['products_id']."', '".(int) $_SESSION['customer_id']."', '".addslashes($customer_values['customers_firstname'])."', '".addslashes($_POST['rating'])."', now())");
		$insert_id = vam_db_insert_id();
		vam_db_query("insert into ".TABLE_REVIEWS_DESCRIPTION." (reviews_id, languages_id, reviews_text) values ('".$insert_id."', '".(int) $_SESSION['languages_id']."', '".addslashes($_POST['review'])."')");
		
		if ($_SESSION['temp_reviews_id'] > 0) vam_db_query("update ".TABLE_REVIEWS_IMAGES." set reviews_id =  '".$insert_id."' where reviews_id = '".(int) $_SESSION['temp_reviews_id']."'");
		
		unset($_SESSION['temp_reviews_id']);

          if ($_POST['review'] != '') {

				// assign language to template for caching
				$vamTemplate->assign('language', $_SESSION['language']);
				$vamTemplate->caching = false;

				$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

		
				$vamTemplate->assign('CUSTOMERS_NAME', addslashes($customer_values['customers_firstname']));

				$vamTemplate->assign('CUSTOMERS_FIRST_NAME', $customer_values['customers_firstname']);
				$vamTemplate->assign('CUSTOMERS_LAST_NAME', $customer_values['customers_lastname']);

				$customer_id = $_SESSION['customer_id'];
				
				if ($customer_id > 0) {

				$customer_info_query = vam_db_query("select * from " . TABLE_CUSTOMERS . " c where c.customers_id = '" . vam_db_input($customer_id) . "'");
				$customer_info = vam_db_fetch_array($customer_info_query);

				$vamTemplate->assign('CUSTOMERS_TELEPHONE', $customer_info['customers_telephone']);
				$vamTemplate->assign('CUSTOMERS_EMAIL_ADDRESS', $customer_info['customers_email_address']);

				}

				$vamTemplate->assign('PRODUCTS_NAME', $product->data['products_name']);
				$vamTemplate->assign('PRODUCTS_IMAGE', $product->data['products_image']);
				$vamTemplate->assign('PRODUCTS_LINK', vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product->data['products_id'], $product->data['products_name'])));
				$vamTemplate->assign('REVIEWS_LINK', vam_href_link(FILENAME_PRODUCT_REVIEWS_INFO, 'products_id='.$product->data['products_id'].'&reviews_id='.$insert_id)); 
				$vamTemplate->assign('REVIEWS_ALL_LINK', vam_href_link(FILENAME_PRODUCT_REVIEWS, 'products_id='.$product->data['products_id'])); 
				$vamTemplate->assign('REVIEW_TEXT', addslashes($_POST['review']));

				$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/review_added_mail.html');
				$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/review_added_mail.txt');

            // create subject
           $review_added_subject = REVIEW_NEW_SUBJECT;

				if (filter_var(CONTACT_US_EMAIL_ADDRESS, FILTER_VALIDATE_EMAIL)) {

				vam_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $review_added_subject, $html_mail, $txt_mail);
				
				}
				
          }

   $_SESSION['error_cart_msg'] = sprintf(TEXT_REVIEW_DATE_ADDED, $product->data['products_name']);          

	vam_redirect(vam_href_link(FILENAME_PRODUCT_INFO, vam_product_link($product->data['products_id'], $product->data['products_name'])));
	}
 }
}

// lets retrieve all $HTTP_GET_VARS keys and values..
$get_params = vam_get_all_get_params();
$get_params_back = vam_get_all_get_params(array ('reviews_id')); // for back button
$get_params = substr($get_params, 0, -1); //remove trailing &
if (vam_not_null($get_params_back)) {
	$get_params_back = substr($get_params_back, 0, -1); //remove trailing &
} else {
	$get_params_back = $get_params;
}

$breadcrumb->add(NAVBAR_TITLE_REVIEWS_WRITE);

$customer_info_query = vam_db_query("select customers_firstname, customers_lastname from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
$customer_info = vam_db_fetch_array($customer_info_query);

require (DIR_WS_INCLUDES.'header.php');

if (!$product->isProduct()) {
	$vamTemplate->assign('error', ERROR_INVALID_PRODUCT);
} else {
	$name = $customer_info['customers_firstname'];
	if ($name == '') {
		$customer_info['customers_firstname'] = TEXT_GUEST;
		$customer_info['customers_lastname'] = TEXT_GUEST;
	}
	$vamTemplate->assign('PRODUCTS_NAME', $product->data['products_name']);
	$vamTemplate->assign('AUTHOR', $customer_info['customers_firstname']);
	$vamTemplate->assign('INPUT_TEXT', vam_draw_textarea_field('review', 'soft', 60, 15, $_POST['review'], '', false));
	$vamTemplate->assign('INPUT_RATING', vam_draw_radio_field('rating', '1','class="form-check-input"').' '.vam_draw_radio_field('rating', '2','class="form-check-input"').' '.vam_draw_radio_field('rating', '3','class="form-check-input"').' '.vam_draw_radio_field('rating', '4','class="form-check-input"').' '.vam_draw_radio_field('rating', '5','class="form-check-input"'));
	$vamTemplate->assign('FORM_ACTION', vam_draw_form('product_reviews_write', vam_href_link(FILENAME_PRODUCT_REVIEWS_WRITE_POPUP, 'action=process&'.vam_product_link($product->data['products_id'],$product->data['products_name'])), 'post', 'enctype="multipart/form-data" cf="true" onsubmit="return checkForm();"'));
	$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="javascript:history.back(1)">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');
	$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE).vam_draw_hidden_field('get_params', $get_params));
	$vamTemplate->assign('CAPTCHA_IMG', '<img src="'.vam_href_link(FILENAME_DISPLAY_CAPTCHA).'" alt="captcha" name="captcha" />');
	$vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha"', 'text', false));
	$vamTemplate->assign('FORM_END', '</form>');
	
}

if ($messageStack->size('uploads') > 0)
	$vamTemplate->assign('upload', $messageStack->output('uploads'));

$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/product_reviews_write_popup.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_WRITE_POPUP.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_PRODUCT_REVIEWS_WRITE_POPUP.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>