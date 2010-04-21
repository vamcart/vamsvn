<?php
/* -----------------------------------------------------------------------------------------
   $Id: checkout_alternative.php 993 2009-11-29 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2008 VaM Shop
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_payment_address.php,v 1.13 2003/05/27); www.oscommerce.com
   (c) 2003	 nextcommerce (checkout_payment_address.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2004	 xt:Commerce (checkout_payment_address.php,v 1.14 2003/08/17); xt-commerce.com

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

if (isset ($_SESSION['customer_id'])) {
		vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// check if checkout is allowed
if ($_SESSION['allow_checkout'] == 'false')
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
	

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1) {
	vam_redirect(vam_href_link(FILENAME_SHOPPING_CART));
}

	
// create smarty elements
$vamTemplate = new vamTemplate;

$total_weight = $_SESSION['cart']->show_weight();

//  $total_count = $_SESSION['cart']->count_contents();
$total_count = $_SESSION['cart']->count_contents_virtual(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

require_once (DIR_FS_INC.'vam_address_label.inc.php');
require_once (DIR_FS_INC.'vam_get_address_format_id.inc.php');
require_once (DIR_FS_INC.'vam_count_shipping_modules.inc.php');
require_once (DIR_FS_INC.'vam_draw_radio_field.inc.php');
require_once (DIR_FS_INC.'vam_get_country_list.inc.php');
require_once (DIR_FS_INC.'vam_draw_checkbox_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_password_field.inc.php');
require_once (DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_create_password.inc.php');
require_once (DIR_FS_INC.'vam_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'vam_draw_pull_down_menu.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_get_zone_name.inc.php');

require (DIR_WS_CLASSES . 'shipping.php');
require (DIR_WS_CLASSES . 'payment.php');

require (DIR_WS_CLASSES . 'order.php');
$order = new order();

$breadcrumb->add(TEXT_CHECKOUT_ALTERNATIVE);

$vamTemplate->assign('FORM_ACTION', vam_draw_form('checkout_alternative', vam_href_link(FILENAME_CHECKOUT_ALTERNATIVE, '', 'SSL'), 'post', 'onsubmit="return checkform(this);"').vam_draw_hidden_field('action', 'process') . vam_draw_hidden_field('required', 'gender,firstname,lastname,dob,email,address,postcode,city,state,country,telephone,pass,confirmation', 'id="required"'));
$vamTemplate->assign('ADDRESS_LABEL', vam_address_label($_SESSION['customer_id'], $_SESSION['sendto'], true, ' ', '<br />'));
//$vamTemplate->assign('BUTTON_ADDRESS', '<a href="'.vam_href_link(FILENAME_CHECKOUT_SHIPPING_ADDRESS, '', 'SSL').'">'.vam_image_button('button_change_address.gif', IMAGE_BUTTON_CHANGE_ADDRESS).'</a>');
$vamTemplate->assign('FORM_END', '</form>');

if ($order->content_type == 'virtual' || ($order->content_type == 'virtual_weight') || ($_SESSION['cart']->count_contents_virtual() == 0)) {

	$_SESSION['shipping'] = false;
	$_SESSION['sendto'] = false;

$vamTemplate->assign('virtual', 'true');

} else {

$vamTemplate->assign('virtual', 'false');

}

$process = false;
if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;

$_SESSION['wm'] = $_POST['wm'];

if (!isset($_SESSION['kvit_name'])) $_SESSION['kvit_name'] = $_POST['kvit_name'];
if (!isset($_SESSION['kvit_address'])) $_SESSION['kvit_address'] = $_POST['kvit_address'];

if (!isset($_SESSION['qiwi_telephone'])) $_SESSION['qiwi_telephone'] = $_POST['qiwi_telephone'];

if (isset($_POST['conditions'])) {
	$_SESSION['conditions'] = true;
}

$_SESSION['comments'] = vam_db_prepare_input($_POST['comments']);

$shipping_modules = new shipping;

if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true')) {
	switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
		case 'national' :
			if ($order->delivery['country_id'] == STORE_COUNTRY)
				$pass = true;
			break;
		case 'international' :
			if ($order->delivery['country_id'] != STORE_COUNTRY)
				$pass = true;
			break;
		case 'both' :
			$pass = true;
			break;
		default :
			$pass = false;
			break;
	}

	$free_shipping = false;
	if (($pass == true) && ($order->info['total'] - $order->info['shipping_cost'] >= $vamPrice->Format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, false, 0, true))) {
		$free_shipping = true;

		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_shipping.php');
	}
} else {
	$free_shipping = false;
}
// process the selected shipping method


	if ((vam_count_shipping_modules() > 0) || ($free_shipping == true)) {
		if ((isset ($_POST['shipping'])) && (strpos($_POST['shipping'], '_'))) {
			$_SESSION['shipping'] = $_POST['shipping'];

			list ($module, $method) = explode('_', $_SESSION['shipping']);
			if (is_object($$module) || ($_SESSION['shipping'] == 'free_free')) {
				if ($_SESSION['shipping'] == 'free_free') {
					$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
					$quote[0]['methods'][0]['cost'] = '0';
				} else {
					$quote = $shipping_modules->quote($method, $module);
				}
				if (isset ($quote['error'])) {
					unset ($_SESSION['shipping']);
				} else {
					if ((isset ($quote[0]['methods'][0]['title'])) && (isset ($quote[0]['methods'][0]['cost']))) {
						$_SESSION['shipping'] = array ('id' => $_SESSION['shipping'], 'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'].' ('.$quote[0]['methods'][0]['title'].')'), 'cost' => $quote[0]['methods'][0]['cost']);

                        //print "FILENAME_CHECKOUT_PAYMENT => ".FILENAME_CHECKOUT_PAYMENT;
                        //vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
					}
				}
			} else {
				unset ($_SESSION['shipping']);
			}
		}
	} else {
		$_SESSION['shipping'] = false;

        //print "redirect to ".FILENAME_CHECKOUT_PAYMENT;
		//vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
	}

if (isset ($_POST['payment']))
	$_SESSION['payment'] = vam_db_prepare_input($_POST['payment']);

	if (ACCOUNT_GENDER == 'true')
		$gender = vam_db_prepare_input($_POST['gender']);
	$firstname = vam_db_prepare_input($_POST['firstname']);
	if (ACCOUNT_SECOND_NAME == 'true')
	$secondname = vam_db_prepare_input($_POST['secondname']);
	$lastname = vam_db_prepare_input($_POST['lastname']);
	if (ACCOUNT_DOB == 'true')
		$dob = vam_db_prepare_input($_POST['dob']);
	$email_address = vam_db_prepare_input($_POST['email_address']);
	if (ACCOUNT_COMPANY == 'true')
		$company = vam_db_prepare_input($_POST['company']);
	if (ACCOUNT_COMPANY_VAT_CHECK == 'true')
		$vat = vam_db_prepare_input($_POST['vat']);
   if (ACCOUNT_STREET_ADDRESS == 'true')
	$street_address = vam_db_prepare_input($_POST['street_address']);
	if (ACCOUNT_SUBURB == 'true')
		$suburb = vam_db_prepare_input($_POST['suburb']);
   if (ACCOUNT_POSTCODE == 'true')
	$postcode = vam_db_prepare_input($_POST['postcode']);
	if (ACCOUNT_CITY == 'true')
	$city = vam_db_prepare_input($_POST['city']);
	$zone_id = vam_db_prepare_input($_POST['zone_id']);
	if (ACCOUNT_STATE == 'true')
		$state = vam_db_prepare_input($_POST['state']);
   if (ACCOUNT_COUNTRY == 'true') {
	   $country = vam_db_prepare_input($_POST['country']);
	} else {
      $country = STORE_COUNTRY;
	}
   if (ACCOUNT_TELE == 'true')
	$telephone = vam_db_prepare_input($_POST['telephone']);
   if (ACCOUNT_FAX == 'true')
	$fax = vam_db_prepare_input($_POST['fax']);
	//    $newsletter = vam_db_prepare_input($_POST['newsletter']);
	$newsletter = '0';
	$password = vam_db_prepare_input($_POST['password']);
	$confirmation = vam_db_prepare_input($_POST['confirmation']);

	$error = false;

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;

			$messageStack->add('checkout_alternative', ENTRY_GENDER_ERROR.'<br>');
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_FIRST_NAME_ERROR.'<br>');
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_LAST_NAME_ERROR.'<br>');
	}

	if (ACCOUNT_DOB == 'true') {
		if (checkdate(substr(vam_date_raw($dob), 4, 2), substr(vam_date_raw($dob), 6, 2), substr(vam_date_raw($dob), 0, 4)) == false) {
			$error = true;

			$messageStack->add('checkout_alternative', ENTRY_DATE_OF_BIRTH_ERROR.'<br>');
		}
	}

// New VAT Check
	require_once(DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($vat, '', '', $country,true);

	$customers_vat_id_status = 0;
	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1){
	$messageStack->add('checkout_alternative', ENTRY_VAT_ERROR.'<br>');
	$error = true;
  }
// New VAT CHECK END

	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_EMAIL_ADDRESS_ERROR);
	}
	elseif (vam_validate_email($email_address) == false) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	} else {
		$check_email_query = vam_db_query("select count(*) as total from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0'");
		$check_email = vam_db_fetch_array($check_email_query);
		if ($check_email['total'] > 0) {
			$error = true;

			$messageStack->add('checkout_alternative', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		}
	}

   if (ACCOUNT_STREET_ADDRESS == 'true') {
	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_STREET_ADDRESS_ERROR.'<br>');
	}
  }

   if (ACCOUNT_POSTCODE == 'true') {
	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_POST_CODE_ERROR.'<br>');
	}
  }

   if (ACCOUNT_CITY == 'true') {
	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_CITY_ERROR.'<br>');
	}
  }

   if (ACCOUNT_COUNTRY == 'true') {
	if (is_numeric($country) == false) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_COUNTRY_ERROR.'<br>');
	}
  }

	if (ACCOUNT_STATE == 'true') {
		$zone_id = 0;
		$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		$check = vam_db_fetch_array($check_query);
		$entry_state_has_zones = ($check['total'] > 0);
		if ($entry_state_has_zones == true) {
			$zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_name = '" . vam_db_input($state) . "'");
			if (vam_db_num_rows($zone_query) > 1) {
				$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_name = '".vam_db_input($state)."'");
			}
			if (vam_db_num_rows($zone_query) >= 1) {
				$zone = vam_db_fetch_array($zone_query);
				$zone_id = $zone['zone_id'];
			} else {
				$error = true;

				$messageStack->add('checkout_alternative', ENTRY_STATE_ERROR_SELECT.'<br>');
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;

				$messageStack->add('checkout_alternative', ENTRY_STATE_ERROR.'<br>');
			}
		}
	}

   if (ACCOUNT_TELE == 'true') {
	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_TELEPHONE_NUMBER_ERROR.'<br>');
	}
  }

        $extra_fields_query = vamDBquery("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $_SESSION['languages_id']);

   while($extra_fields = vam_db_fetch_array($extra_fields_query,true)){

    if(strlen($_POST['fields_' . $extra_fields['fields_id'] ])<$extra_fields['fields_size']){
      $error = true;
      $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);
      $messageStack->add('checkout_alternative', $string_error.'<br>');
    }
  }

	if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_PASSWORD_ERROR);
	}
	elseif ($password != $confirmation) {
		$error = true;

		$messageStack->add('checkout_alternative', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
	}

//	if ($customers_status == 0 || !$customers_status)
		$customers_status = DEFAULT_CUSTOMERS_STATUS_ID;
//	$password = vam_create_password(8);

	if (!$newsletter)
		$newsletter = 0;
	if ($error == false) {
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_status' => $customers_status, 'customers_firstname' => $firstname, 'customers_secondname' => $secondname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax, 'orig_reference' => $html_referer, 'customers_newsletter' => $newsletter, 'delete_user' => '0', 'account_type' => '0', 'customers_password' => vam_encrypt_password($password),'customers_date_added' => 'now()','customers_last_modified' => 'now()');

		$_SESSION['account_type'] = '1';

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = vam_date_raw($dob);

		vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

		$_SESSION['customer_id'] = vam_db_insert_id();

    $extra_fields_query = vamDBquery("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");

		$_SESSION['customer_id'] = vam_db_insert_id();
		$customers_id = $_SESSION['customer_id'];

   	  	$extra_fields_query = vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
    	  while($extra_fields = vam_db_fetch_array($extra_fields_query))
				{
				  if(isset($_POST['fields_' . $extra_fields['fields_id']])){
            $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => $_POST['fields_' . $extra_fields['fields_id']]);
       		}
       		else
					{
					  $sql_data_array = array('customers_id' => (int)$customers_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => '');
						$is_add = false;
						for($i = 1; $i <= $_POST['fields_' . $extra_fields['fields_id'] . '_total']; $i++)
						{
							if(isset($_POST['fields_' . $extra_fields['fields_id'] . '_' . $i]))
							{
							  if($is_add)
							  {
                  $sql_data_array['value'] .= "\n";
								}
								else
								{
                  $is_add = true;
								}
              	$sql_data_array['value'] .= $_POST['fields_' . $extra_fields['fields_id'] . '_' . $i];
							}
						}
					}

					vam_db_perform(TABLE_CUSTOMERS_TO_EXTRA_FIELDS, $sql_data_array);
      	}

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

		$address_id = vam_db_insert_id();

		vam_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".(int) $_SESSION['customer_id']."'");

		vam_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $_SESSION['customer_id']."', '0', now())");

        $sql_data_array = array('login_reference' => $html_referer);
        vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");

		if (SESSION_RECREATE == 'True') {
			vam_session_recreate();
		}

		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customer_second_name'] = $secondname;
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_default_address_id'] = $address_id;
		$_SESSION['customer_country_id'] = $country;
		$_SESSION['customer_zone_id'] = $zone_id;
		$_SESSION['customer_vat_id'] = $vat;

		// restore cart contents
		$_SESSION['cart']->restore_contents();

if (isset ($_SESSION[tracking]['refID'])){
      $campaign_check_query_raw = "SELECT *
			                            FROM ".TABLE_CAMPAIGNS."
			                            WHERE campaigns_refID = '".$_SESSION[tracking][refID]."'";
			$campaign_check_query = vam_db_query($campaign_check_query_raw);
		if (vam_db_num_rows($campaign_check_query) > 0) {
			$campaign = vam_db_fetch_array($campaign_check_query);
			$refID = $campaign['campaigns_id'];
			} else {
			$refID = 0;
		            }

			 vam_db_query("update " . TABLE_CUSTOMERS . " set
                                 refferers_id = '".$refID."'
                                 where customers_id = '".(int) $_SESSION['customer_id']."'");

			$leads = $campaign['campaigns_leads'] + 1 ;
		     vam_db_query("update " . TABLE_CAMPAIGNS . " set
		                         campaigns_leads = '".$leads."'
                                 where campaigns_id = '".$refID."'");
}

if (!isset ($_SESSION['sendto'])) {
	$_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
}

		vam_redirect(vam_href_link(FILENAME_CHECKOUT_CONFIRMATION, '', 'SSL'));
	}
}

if ($messageStack->size('checkout_alternative') > 0) {
	$vamTemplate->assign('error', $messageStack->output('checkout_alternative'));

}

if (ACCOUNT_GENDER == 'true') {
	$vamTemplate->assign('gender', '1');

	$vamTemplate->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm', '', 'id="gender" checked="checked"'));
	$vamTemplate->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'id="gender"'));
   $vamTemplate->assign('ENTRY_GENDER_ERROR', ENTRY_GENDER_ERROR);

} else {
	$vamTemplate->assign('gender', '0');
}

$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', 'id="firstname"'));
$vamTemplate->assign('ENTRY_FIRST_NAME_ERROR', ENTRY_FIRST_NAME_ERROR);
if (ACCOUNT_SECOND_NAME == 'true') {
	$vamTemplate->assign('secondname', '1');
$vamTemplate->assign('INPUT_SECONDNAME', vam_draw_input_fieldNote(array ('name' => 'secondname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')), '', 'id="secondname"'));
}
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', 'id="lastname"'));
$vamTemplate->assign('ENTRY_LAST_NAME_ERROR', ENTRY_LAST_NAME_ERROR);

if (ACCOUNT_DOB == 'true') {
	$vamTemplate->assign('birthdate', '1');

	$vamTemplate->assign('INPUT_DOB', vam_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), '', 'id="dob"'));
   $vamTemplate->assign('ENTRY_DATE_OF_BIRTH_ERROR', ENTRY_DATE_OF_BIRTH_ERROR);

} else {
	$vamTemplate->assign('birthdate', '0');
}

$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), '', 'id="email"'));
$vamTemplate->assign('ENTRY_EMAIL_ADDRESS_ERROR', ENTRY_EMAIL_ADDRESS_ERROR);

if (ACCOUNT_COMPANY == 'true') {
	$vamTemplate->assign('company', '1');
	$vamTemplate->assign('INPUT_COMPANY', vam_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="Requirement">'.ENTRY_COMPANY_TEXT.'</span>' : ''))));
} else {
	$vamTemplate->assign('company', '0');
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
	$vamTemplate->assign('vat', '1');
	$vamTemplate->assign('INPUT_VAT', vam_draw_input_fieldNote(array ('name' => 'vat', 'text' => '&nbsp;'. (vam_not_null(ENTRY_VAT_TEXT) ? '<span class="Requirement">'.ENTRY_VAT_TEXT.'</span>' : ''))));
} else {
	$vamTemplate->assign('vat', '0');
}

if (ACCOUNT_STREET_ADDRESS == 'true') {
   $vamTemplate->assign('street_address', '1');
   $vamTemplate->assign('INPUT_STREET', vam_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', 'id="address"'));
   $vamTemplate->assign('ENTRY_STREET_ADDRESS_ERROR', ENTRY_STREET_ADDRESS_ERROR);
} else {
	$vamTemplate->assign('street_address', '0');
}

if (ACCOUNT_SUBURB == 'true') {
	$vamTemplate->assign('suburb', '1');
	$vamTemplate->assign('INPUT_SUBURB', vam_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="Requirement">'.ENTRY_SUBURB_TEXT.'</span>' : ''))));
} else {
	$vamTemplate->assign('suburb', '0');
}

if (ACCOUNT_POSTCODE == 'true') {
   $vamTemplate->assign('postcode', '1');
   $vamTemplate->assign('INPUT_CODE', vam_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="Requirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), '', 'id="postcode"'));
   $vamTemplate->assign('ENTRY_POST_CODE_ERROR', ENTRY_POST_CODE_ERROR);
} else {
	$vamTemplate->assign('postcode', '0');
}

if (ACCOUNT_CITY == 'true') {
   $vamTemplate->assign('city', '1');
   $vamTemplate->assign('INPUT_CITY', vam_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', 'id="city"'));
   $vamTemplate->assign('ENTRY_CITY_ERROR', ENTRY_CITY_ERROR);
} else {
	$vamTemplate->assign('city', '0');
}

if (ACCOUNT_STATE == 'true') {
	$vamTemplate->assign('state', '1');

	    $country = (isset($_POST['country']) ? vam_db_prepare_input($_POST['country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		 $check = vam_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}

			$zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_code = '".vam_db_input($state)."'");

	      if (vam_db_num_rows($zone) > 0) {
	        $zone_id = $zone['zone_id'];
	        $zone_name = $zone['zone_name'];

	      } else {

		   $zone = vam_db_query("select distinct zone_id, zone_name from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "'");

	      if (vam_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,''), ' id="state"');
      } else {
		$state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'id="state"');
      }

	$vamTemplate->assign('INPUT_STATE', $state_input);
   $vamTemplate->assign('ENTRY_STATE_ERROR_SELECT', ENTRY_STATE_ERROR_SELECT);
} else {
	$vamTemplate->assign('state', '0');
}

if ($_POST['country']) {
	$selected = $_POST['country'];
} else {
	$selected = STORE_COUNTRY;
}

if (ACCOUNT_COUNTRY == 'true') {
	$vamTemplate->assign('country', '1');

   $vamTemplate->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected, 'id="country" onchange="document.getElementById(\'stateXML\').innerHTML = \'' . ENTRY_STATEXML_LOADING . '\';loadXMLDoc(\'loadStateXML\',{country_id: this.value});"'));


   $vamTemplate->assign('ENTRY_COUNTRY_ERROR', ENTRY_COUNTRY_ERROR);
} else {
	$vamTemplate->assign('country', '0');
}

if (ACCOUNT_TELE == 'true') {
   $vamTemplate->assign('telephone', '1');
   $vamTemplate->assign('INPUT_TEL', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), '', 'id="telephone"'));
   $vamTemplate->assign('ENTRY_TELEPHONE_NUMBER_ERROR', ENTRY_TELEPHONE_NUMBER_ERROR);
} else {
	$vamTemplate->assign('telephone', '0');
}

if (ACCOUNT_FAX == 'true') {
   $vamTemplate->assign('fax', '1');
   $vamTemplate->assign('INPUT_FAX', vam_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : ''))));
} else {
	$vamTemplate->assign('fax', '0');
}

	$vamTemplate->assign('customers_extra_fileds', '1');
   $vamTemplate->assign('INPUT_CUSTOMERS_EXTRA_FIELDS', vam_get_extra_fields($_SESSION['customer_id'],$_SESSION['languages_id']));
   
	$vamTemplate->assign('INPUT_PASSWORD', vam_draw_password_fieldNote(array ('name' => 'password', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_TEXT.'</span>' : '')), '', 'id="pass"'));
	$vamTemplate->assign('ENTRY_PASSWORD_ERROR', ENTRY_PASSWORD_ERROR);
	$vamTemplate->assign('INPUT_CONFIRMATION', vam_draw_password_fieldNote(array ('name' => 'confirmation', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : '')), '', 'id="confirmation"'));
	$vamTemplate->assign('ENTRY_PASSWORD_ERROR_NOT_MATCHING', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
   
 /*  */
/* SHIPPING_BLOCK */
// load all enabled shipping modules

if (!isset ($_POST['action']) && ($_POST['action'] != 'process')) {

$shipping_modules = new shipping;

}

if (defined('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING') && (MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING == 'true')) {
	switch (MODULE_ORDER_TOTAL_SHIPPING_DESTINATION) {
		case 'national' :
			if ($order->delivery['country_id'] == STORE_COUNTRY)
				$pass = true;
			break;
		case 'international' :
			if ($order->delivery['country_id'] != STORE_COUNTRY)
				$pass = true;
			break;
		case 'both' :
			$pass = true;
			break;
		default :
			$pass = false;
			break;
	}

	$free_shipping = false;
	if (($pass == true) && ($order->info['total'] - $order->info['shipping_cost'] >= $vamPrice->Format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, false, 0, true))) {
		$free_shipping = true;

		include (DIR_WS_LANGUAGES.$_SESSION['language'].'/modules/order_total/ot_shipping.php');
	}
} else {
	$free_shipping = false;
}
// process the selected shipping method
if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {

	if ((vam_count_shipping_modules() > 0) || ($free_shipping == true)) {
		if ((isset ($_POST['shipping'])) && (strpos($_POST['shipping'], '_'))) {
			$_SESSION['shipping'] = $_POST['shipping'];

			list ($module, $method) = explode('_', $_SESSION['shipping']);
			if (is_object($$module) || ($_SESSION['shipping'] == 'free_free')) {
				if ($_SESSION['shipping'] == 'free_free') {
					$quote[0]['methods'][0]['title'] = FREE_SHIPPING_TITLE;
					$quote[0]['methods'][0]['cost'] = '0';
				} else {
					$quote = $shipping_modules->quote($method, $module);
				}
				if (isset ($quote['error'])) {
					unset ($_SESSION['shipping']);
				} else {
					if ((isset ($quote[0]['methods'][0]['title'])) && (isset ($quote[0]['methods'][0]['cost']))) {
						$_SESSION['shipping'] = array ('id' => $_SESSION['shipping'], 'title' => (($free_shipping == true) ? $quote[0]['methods'][0]['title'] : $quote[0]['module'].' ('.$quote[0]['methods'][0]['title'].')'), 'cost' => $quote[0]['methods'][0]['cost']);

                        //print "FILENAME_CHECKOUT_PAYMENT => ".FILENAME_CHECKOUT_PAYMENT;
                        //vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
					}
				}
			} else {
				unset ($_SESSION['shipping']);
			}
		}
	} else {
		$_SESSION['shipping'] = false;

        //print "redirect to ".FILENAME_CHECKOUT_PAYMENT;
		//vam_redirect(vam_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));
	}
}

// get all available shipping quotes
$quotes = $shipping_modules->quote();

// if no shipping method has been selected, automatically select the cheapest method.
// if the modules status was changed when none were available, to save on implementing
// a javascript force-selection method, also automatically select the cheapest shipping
// method if more than one module is now enabled
if (!isset ($_SESSION['shipping']) || (isset ($_SESSION['shipping']) && ($_SESSION['shipping'] == false) && (vam_count_shipping_modules() > 1)))
	$_SESSION['shipping'] = $shipping_modules->cheapest();


if (ACCOUNT_STREET_ADDRESS == 'true') {
	$vamTemplate->assign('SHIPPING_ADDRESS', 'true');
}

$module = new vamTemplate;
if (vam_count_shipping_modules() > 0) {

	$showtax = $_SESSION['customers_status']['customers_status_show_price_tax'];

	$module->assign('FREE_SHIPPING', $free_shipping);

	# free shipping or not...

	if ($free_shipping == true) {

		$module->assign('FREE_SHIPPING_TITLE', FREE_SHIPPING_TITLE);

		$module->assign('FREE_SHIPPING_DESCRIPTION', sprintf(FREE_SHIPPING_DESCRIPTION, $vamPrice->Format(MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER, true, 0, true)).vam_draw_hidden_field('shipping', 'free_free'));

		$module->assign('FREE_SHIPPING_ICON', $quotes[$i]['icon']);

	} else {

		$radio_buttons = 0;

		#loop through installed shipping methods...

		for ($i = 0, $n = sizeof($quotes); $i < $n; $i ++) {

			if (!isset ($quotes[$i]['error'])) {

				for ($j = 0, $n2 = sizeof($quotes[$i]['methods']); $j < $n2; $j ++) {

					# set the radio button to be checked if it is the method chosen

					$quotes[$i]['methods'][$j]['radio_buttons'] = $radio_buttons;

					$checked = (($quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'] == $_SESSION['shipping']['id']) ? true : false);

					if (($checked == true) || ($n == 1 && $n2 == 1)) {

						$quotes[$i]['methods'][$j]['checked'] = 1;

					}

					if (($n > 1) || ($n2 > 1)) {
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = '';
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = 0;

						$quotes[$i]['methods'][$j]['price'] = $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true);

						$quotes[$i]['methods'][$j]['radio_field'] = vam_draw_radio_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id'], $checked,'id="'.$quotes[$i]['methods'][$j]['id'].'"');
						$quotes[$i]['methods'][$j]['id'] = $quotes[$i]['methods'][$j]['id'];

					} else {
						if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0)
							$quotes[$i]['tax'] = 0;

						$quotes[$i]['methods'][$j]['price'] = $vamPrice->Format(vam_add_tax($quotes[$i]['methods'][$j]['cost'], $quotes[$i]['tax']), true, 0, true).vam_draw_hidden_field('shipping', $quotes[$i]['id'].'_'.$quotes[$i]['methods'][$j]['id']);

					}

					$radio_buttons ++;

				}

			}

		}

		$module->assign('module_content', $quotes);

	}
	$module->caching = 0;
	$shipping_block = $module->fetch(CURRENT_TEMPLATE.'/module/checkout_shipping_block.html');
}

$vamTemplate->assign('SHIPPING_BLOCK', $shipping_block);
/* END SHIPPING_BLOCK */

/* PAYMENT_BLOCK */
// load all enabled payment modules

require (DIR_WS_CLASSES . 'order_total.php'); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM
$order_total_modules = new order_total(); // GV Code ICW ADDED FOR CREDIT CLASS SYSTEM

$payment_modules = new payment;

$order_total_modules->process();

$module = new vamTemplate;
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


if (ACTIVATE_GIFT_SYSTEM == 'true') {
	$vamTemplate->assign('module_gift', $order_total_modules->credit_selection());
}

$module->caching = 0;
$payment_block = $module->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_block.html');

$vamTemplate->assign('COMMENTS', vam_draw_textarea_field('comments', 'soft', '60', '5', $_POST['comments']) . vam_draw_hidden_field('comments_added', 'YES'));

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

   $vamTemplate->assign('AGB_checkbox', '<input type="checkbox" value="conditions" name="conditions" checked />');

}
$vamTemplate->assign('BUTTON_CONTINUE', vam_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

$vamTemplate->assign('PAYMENT_BLOCK', $payment_block);
/* END PAYMENT_BLOCK */
require (DIR_WS_INCLUDES.'header.php');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/checkout_alternative.html');
$vamTemplate->assign('main_content', $main_content);
if (!defined(RM))$vamTemplate->load_filter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_ALTERNATIVE.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CHECKOUT_ALTERNATIVE.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);

?>