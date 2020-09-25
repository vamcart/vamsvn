<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_payment_address.php 993 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_payment_address.php,v 1.13 2003/05/27); www.oscommerce.com 
   (c) 2003	 nextcommerce (checkout_payment_address.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (checkout_payment_address.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'vam_count_customer_address_book_entries.inc.php');
require_once (DIR_FS_INC.'vam_address_label.inc.php');


// if the customer is not logged on, redirect them to the login page
if (!isset ($_SESSION['customer_id']))
	vam_redirect(vam_href_link(FILENAME_LOGIN, '', 'SSL'));

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1)
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));

$error = false;
$process = false;
if (isset ($_POST['action']) && ($_POST['action'] == 'submit')) {
	// process a new billing address
	if (vam_not_null($_POST['firstname']) && vam_not_null($_POST['lastname']) && vam_not_null($_POST['street_address'])) {
		$process = true;

		if (ACCOUNT_GENDER == 'true')
			$gender = vam_db_prepare_input($_POST['gender']);
		if (ACCOUNT_COMPANY == 'true')
			$company = vam_db_prepare_input($_POST['company']);
		$firstname = vam_db_prepare_input($_POST['firstname']);
	if (ACCOUNT_SECOND_NAME == 'true')
   	$secondname = vam_db_prepare_input($_POST['secondname']);
	if (ACCOUNT_LAST_NAME == 'true')
		$lastname = vam_db_prepare_input($_POST['lastname']);
      if (ACCOUNT_STREET_ADDRESS == 'true')
		$street_address = vam_db_prepare_input($_POST['street_address']);
		if (ACCOUNT_SUBURB == 'true')
			$suburb = vam_db_prepare_input($_POST['suburb']);
      if (ACCOUNT_POSTCODE == 'true')
		$postcode = vam_db_prepare_input($_POST['postcode']);
      if (ACCOUNT_CITY == 'true')
		$city = vam_db_prepare_input($_POST['city']);
      if (ACCOUNT_COUNTRY == 'true') {
	   $country = vam_db_prepare_input($_POST['country']);
   	} else {
      $country = STORE_COUNTRY;
   	}
		if (ACCOUNT_STATE == 'true') {
			$zone_id = vam_db_prepare_input($_POST['zone_id']);
			$state = vam_db_prepare_input($_POST['state']);
		}

		if (ACCOUNT_GENDER == 'true') {
			if (($gender != 'm') && ($gender != 'f')) {
				$error = true;

				$messageStack->add('checkout_address', ENTRY_GENDER_ERROR);
			}
		}

		if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_FIRST_NAME_ERROR);
		}

		if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_LAST_NAME_ERROR);
		}

   if (ACCOUNT_STREET_ADDRESS == 'true') {
		if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_STREET_ADDRESS_ERROR);
		}
     }

   if (ACCOUNT_POSTCODE == 'true') {
		if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_POST_CODE_ERROR);
		}
     }

   if (ACCOUNT_CITY == 'true') {
		if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_CITY_ERROR);
		}
     }

		if (ACCOUNT_STATE == 'true') {
			$zone_id = 0;
			$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
			$check = vam_db_fetch_array($check_query);
			$entry_state_has_zones = ($check['total'] > 0);
			if ($entry_state_has_zones == true) {
				$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and (zone_name like '".vam_db_input($state)."%' or zone_code like '%".vam_db_input($state)."%')");

				if (vam_db_num_rows($zone_query) > 1) {
					$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_name = '".vam_db_input($state)."'");
				}
				if (vam_db_num_rows($zone_query) >= 1) {
					$zone = vam_db_fetch_array($zone_query);
					$zone_id = $zone['zone_id'];
				} else {
					$error = true;

					$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
				}
			} else {
				if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
					$error = true;

					$messageStack->add('checkout_address', ENTRY_STATE_ERROR);
				}
			}
		}

		if ((is_numeric($country) == false) || ($country < 1)) {
			$error = true;

			$messageStack->add('checkout_address', ENTRY_COUNTRY_ERROR);
		}

		if ($error == false) {
			$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'entry_firstname' => $firstname, 'entry_secondname' => $secondname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => $country);

			if (ACCOUNT_GENDER == 'true')
				$sql_data_array['entry_gender'] = $gender;
			if (ACCOUNT_COMPANY == 'true')
				$sql_data_array['entry_company'] = $company;
			if (ACCOUNT_SUBURB == 'true')
				$sql_data_array['entry_suburb'] = $suburb;
			if (ACCOUNT_STATE == 'true') {
				if ($zone_id > 0) {
					$sql_data_array['entry_zone_id'] = $zone_id;
					$sql_data_array['entry_state'] = '';
				} else {
					$sql_data_array['entry_zone_id'] = '0';
					$sql_data_array['entry_state'] = $state;
				}
			}

			vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

			$_SESSION['billto'] = vam_db_insert_id();

			if (isset ($_SESSION['payment']))
				unset ($_SESSION['payment']);

		if (SMART_CHECKOUT == 'true') {
			$_SESSION['changed_adress'] = true; //bug added
		}
		
	  if (SMART_CHECKOUT == 'true') {
      	vam_redirect(vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));
	  } else {
	  	vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
		}
		}
		// process the selected billing destination
	}
	elseif (isset ($_POST['address'])) {
		$reset_payment = false;
		if (isset ($_SESSION['billto'])) {
			if ($billto != $_POST['address']) {
				if (isset ($_SESSION['payment'])) {
					$reset_payment = true;
				}
			}
		}

		$_SESSION['billto'] = vam_db_prepare_input($_POST['address']);

		$check_address_query = vam_db_query("select count(*) as total from ".TABLE_ADDRESS_BOOK." where customers_id = '".$_SESSION['customer_id']."' and address_book_id = '".$_SESSION['billto']."'");
		$check_address = vam_db_fetch_array($check_address_query);

		if ($check_address['total'] == '1') {
			if ($reset_payment == true)
				unset ($_SESSION['payment']);
	  if (SMART_CHECKOUT == 'true') {
      	vam_redirect(vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));
	  } else {
	  	vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
		}
		} else {
			unset ($_SESSION['billto']);
		}
		// no addresses to select from - customer decided to keep the current assigned address
	} else {
		$_SESSION['billto'] = $_SESSION['customer_default_address_id'];

	  if (SMART_CHECKOUT == 'true') {
      	vam_redirect(vam_href_link(FILENAME_CHECKOUT, '', 'SSL'));
	  } else {
	  	vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
		}
	}
}

// if no billing destination address was selected, use their own address as default
if (!isset ($_SESSION['billto'])) {
	$_SESSION['billto'] = $_SESSION['customer_default_address_id'];
}

$breadcrumb->add(NAVBAR_TITLE_1_PAYMENT_ADDRESS, vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_PAYMENT_ADDRESS, vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'));

$addresses_count = vam_count_customer_address_book_entries();
require (DIR_WS_INCLUDES.'header.php');

$vamTemplate->assign('FORM_ACTION', vam_draw_form('checkout_address', vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL'), 'post', 'onsubmit="return checkform(this);"') . vam_draw_hidden_field('required', 'gender,firstname,lastname,address,postcode,city,state,country', 'id="required"'));

if ($messageStack->size('checkout_address') > 0) {
	$vamTemplate->assign('error', $messageStack->output('checkout_address'));

}

if ($process == false) {
	$vamTemplate->assign('ADDRESS_LABEL', vam_address_label($_SESSION['customer_id'], $_SESSION['billto'], true, ' ', '<br />'));

	if ($addresses_count > 1) {

		$address_content = '';
		$radio_buttons = 0;

		$addresses_query = vam_db_query("select address_book_id, entry_firstname as firstname, entry_secondname as secondname, entry_lastname as lastname, entry_company as company, entry_street_address as street_address, entry_suburb as suburb, entry_city as city, entry_postcode as postcode, entry_state as state, entry_zone_id as zone_id, entry_country_id as country_id from ".TABLE_ADDRESS_BOOK." where customers_id = '".$_SESSION['customer_id']."'");
		while ($addresses = vam_db_fetch_array($addresses_query)) {
			$format_id = vam_get_address_format_id($address['country_id']);
			$address_content .= '';
			if ($addresses['address_book_id'] == $_SESSION['billto']) {
				$address_content .= ''."\n";
			} else {
				$address_content .= ''."\n";
			}
			$address_content .= '<p><span class="bold">'.$addresses['firstname'].' '.$addresses['secondname'].' '.$addresses['lastname'].'</span>&nbsp;'.vam_draw_radio_field('address', $addresses['address_book_id'], ($addresses['address_book_id'] == $_SESSION['billto'])).'</p>
			                        <p>'.vam_address_format($format_id, $addresses, true, ' ', ', ').'</p>';

			$radio_buttons ++;
		}
		$address_content .= '';
		$vamTemplate->assign('BLOCK_ADDRESS', $address_content);

	}
}

if ($addresses_count < MAX_ADDRESS_BOOK_ENTRIES) {

	require (DIR_WS_MODULES.'checkout_new_address.php');
}
$vamTemplate->assign('BUTTON_CONTINUE', vam_draw_hidden_field('action', 'submit').vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));

if ($process == true) {
	$vamTemplate->assign('BUTTON_BACK', '<a class="button" href="'.vam_href_link(FILENAME_CHECKOUT_PAYMENT_ADDRESS, '', 'SSL').'">'.vam_image_button('back.png', IMAGE_BUTTON_BACK).'</a>');

}
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('language', $_SESSION['language']);

$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/checkout_payment_address.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_PAYMENT_ADDRESS.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_PAYMENT_ADDRESS.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>