<?php
/* -----------------------------------------------------------------------------------------
   $Id: login.php 1143 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(login.php,v 1.79 2003/05/19); www.oscommerce.com 
   (c) 2003      nextcommerce (login.php,v 1.13 2003/08/17); www.nextcommerce.org
   (c) 2004      xt:Commerce (login.php,v 1.13 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

if (isset ($_SESSION['customer_id'])) {
	vam_redirect(vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_validate_password.inc.php');
require_once (DIR_FS_INC.'vam_array_to_string.inc.php');
require_once (DIR_FS_INC.'vam_write_user_info.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
require_once (DIR_FS_INC.'vam_render_vvcode.inc.php');

// redirect the customer to a friendly cookie-must-be-enabled page if cookies are disabled (or the session has not started)
if ($session_started == false) {
	vam_redirect(vam_href_link(FILENAME_COOKIE_USAGE));
}

if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {
	$email_address = vam_db_prepare_input($_POST['email_address']);
	$password = vam_db_prepare_input($_POST['password']);

	// Check if email exists
	$check_customer_query = vam_db_query("select customers_id, customers_vat_id, customers_firstname,customers_lastname, customers_gender, customers_password, customers_email_address, login_tries, login_time, customers_default_address_id from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0'");
	if (!vam_db_num_rows($check_customer_query)) {
		$_GET['login'] = 'fail';
		$info_message = TEXT_NO_EMAIL_ADDRESS_FOUND;
	} else {
		$check_customer = vam_db_fetch_array($check_customer_query);

// Check the login is blocked while login_tries is more than 5 and blocktime is not over
	$blocktime = LOGIN_TIME; 	 																 			// time to block the login in seconds
	$time = time();  																				// time now as a timestamp
	$logintime = strtotime($check_customer['login_time']);  // conversion from the ISO date format to a timestamp
	$difference = $time - $logintime; 											// The difference time in seconds between the last login and now
  if ($check_customer['login_tries'] >= LOGIN_NUM and $difference < $blocktime) {
		// Action for bцse ?
    $vamTemplate->assign('CAPTCHA_IMG', '<img src="'.FILENAME_DISPLAY_CAPTCHA.'" alt="captcha" name="captcha" />');    
    $vamTemplate->assign('CAPTCHA_INPUT', vam_draw_input_field('captcha', '', 'size="6" id="captcha" maxlength="6"', 'text', false));
    if ($_POST['captcha'] == $_SESSION['vvcode']){
    // code ok
		// Check that password is good
		if (!vam_validate_password($password, $check_customer['customers_password'])) {
			$_GET['login'] = 'fail';
      // Login tries + 1
		  vam_db_query("update ".TABLE_CUSTOMERS." SET login_tries = login_tries+1, login_time = now() WHERE customers_email_address = '".vam_db_input($email_address)."'");		
			$info_message = TEXT_LOGIN_ERROR;
		} else {
			if (SESSION_RECREATE == 'True') {
				vam_session_recreate();
			}
      // Login tries = 0			$date_now = date('Ymd');
		  vam_db_query("update ".TABLE_CUSTOMERS." SET login_tries = 0, login_time = now() WHERE customers_email_address = '".vam_db_input($email_address)."'");		
		  
			$check_country_query = vam_db_query("select entry_country_id, entry_zone_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $check_customer['customers_id']."' and address_book_id = '".$check_customer['customers_default_address_id']."'");
			$check_country = vam_db_fetch_array($check_country_query);

			$_SESSION['customer_gender'] = $check_customer['customers_gender'];
			$_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
			$_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
			$_SESSION['customer_email_address'] = $check_customer['customers_email_address'];
			$_SESSION['customer_id'] = $check_customer['customers_id'];
			$_SESSION['customer_vat_id'] = $check_customer['customers_vat_id'];
			$_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
			$_SESSION['customer_country_id'] = $check_country['entry_country_id'];
			$_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];

// #CHAVEIRO14#  Autologon	
        if ((ALLOW_AUTOLOGON == 'false') || ($_POST['remember_me'] == '')) {
              vam_autologincookie(false);
		}
        else {
              vam_autologincookie(true);
		}
// #CHAVEIRO14#  Autologon	END

			vam_db_query("update ".TABLE_CUSTOMERS_INFO." SET customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");
			vam_write_user_info((int) $_SESSION['customer_id']);
			// restore cart contents
			$_SESSION['cart']->restore_contents();

			if ($_SESSION['cart']->count_contents() > 0) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
			} else {
				vam_redirect(vam_href_link(FILENAME_ACCOUNT));
			}

		}
    }else{
    // code falsch
    $info_message = TEXT_WRONG_CODE;
    // Login tries + 1
		vam_db_query("update ".TABLE_CUSTOMERS." SET login_tries = login_tries+1, login_time = now() WHERE customers_email_address = '".vam_db_input($email_address)."'");		
    }		
	} else {
		// Check that password is good
		if (!vam_validate_password($password, $check_customer['customers_password'])) {
			$_GET['login'] = 'fail';
      // Login tries + 1
		  vam_db_query("update ".TABLE_CUSTOMERS." SET login_tries = login_tries+1, login_time = now() WHERE customers_email_address = '".vam_db_input($email_address)."'");		
			$info_message = TEXT_LOGIN_ERROR;
		} else {
			if (SESSION_RECREATE == 'True') {
				vam_session_recreate();
			}
      // Login tries = 0			$date_now = date('Ymd');
		  vam_db_query("update ".TABLE_CUSTOMERS." SET login_tries = 0, login_time = now() WHERE customers_email_address = '".vam_db_input($email_address)."'");		
		  
			$check_country_query = vam_db_query("select entry_country_id, entry_zone_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".(int) $check_customer['customers_id']."' and address_book_id = '".$check_customer['customers_default_address_id']."'");
			$check_country = vam_db_fetch_array($check_country_query);

			$_SESSION['customer_gender'] = $check_customer['customers_gender'];
			$_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
			$_SESSION['customer_last_name'] = $check_customer['customers_lastname'];
			$_SESSION['customer_email_address'] = $check_customer['customers_email_address'];
			$_SESSION['customer_id'] = $check_customer['customers_id'];
			$_SESSION['customer_vat_id'] = $check_customer['customers_vat_id'];
			$_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
			$_SESSION['customer_country_id'] = $check_country['entry_country_id'];
			$_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];

// #CHAVEIRO14#  Autologon	
        if ((ALLOW_AUTOLOGON == 'false') || ($_POST['remember_me'] == '')) {
              vam_autologincookie(false);
		}
        else {
              vam_autologincookie(true);
		}
// #CHAVEIRO14#  Autologon	END

			vam_db_query("update ".TABLE_CUSTOMERS_INFO." SET customers_info_date_of_last_logon = now(), customers_info_number_of_logons = customers_info_number_of_logons+1 WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");
			vam_write_user_info((int) $_SESSION['customer_id']);
			// restore cart contents
			$_SESSION['cart']->restore_contents();

			if ($_SESSION['cart']->count_contents() > 0) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
			} else {
				vam_redirect(vam_href_link(FILENAME_ACCOUNT));
			}

		}
	 }
	}
}

$breadcrumb->add(NAVBAR_TITLE_LOGIN);
require (DIR_WS_INCLUDES.'header.php');

if ($_GET['info_message']) $info_message = $_GET['info_message'];
$vamTemplate->assign('info_message', $info_message);
$vamTemplate->assign('BUTTON_NEW_ACCOUNT', '<a class="button" href="'.vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL').'">'.vam_image_button('submit.png', IMAGE_BUTTON_CONTINUE).'</a>');
$vamTemplate->assign('BUTTON_LOGIN', vam_image_submit('login.png', IMAGE_BUTTON_LOGIN));
$vamTemplate->assign('FORM_ACTION', vam_draw_form('login', vam_href_link(FILENAME_LOGIN, 'action=process', 'SSL')));
$vamTemplate->assign('INPUT_MAIL', vam_draw_input_field('email_address'));
$vamTemplate->assign('INPUT_PASSWORD', vam_draw_password_field('password'));
$vamTemplate->assign('INPUT_REMEMBER', vam_draw_checkbox_field('remember_me', '1', true, 'id="remember_me"'));
$vamTemplate->assign('LINK_LOST_PASSWORD', vam_href_link(FILENAME_PASSWORD_DOUBLE_OPT, '', 'SSL'));
$vamTemplate->assign('FORM_END', '</form>');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/login.html');
$vamTemplate->assign('main_content', $main_content);

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_LOGIN.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_LOGIN.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>