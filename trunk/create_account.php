<?php
/* -----------------------------------------------------------------------------------------
   $Id: create_account.php 1311 2007-02-06 19:20:03 VaM $

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
   (c) 2003  nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org 
   (c) 2004  xt:Commerce (create_account.php,v 1.27 2003/08/24); xt-commerce.com 

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

include ('includes/application_top.php');

if (isset ($_SESSION['customer_id'])) {
	vam_redirect(vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_get_country_list.inc.php');
require_once (DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_write_user_info.inc.php');

$process = false;
if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;

	if (ACCOUNT_GENDER == 'true')
		$gender = vam_db_prepare_input($_POST['gender']);
	$firstname = vam_db_prepare_input($_POST['firstname']);
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
	$newsletter = '0';
	$password = vam_db_prepare_input($_POST['password']);
	$confirmation = vam_db_prepare_input($_POST['confirmation']);

	$error = false;

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;

			$messageStack->add('create_account', ENTRY_GENDER_ERROR);
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
	}

	if (ACCOUNT_DOB == 'true') {
		if (checkdate((int)substr(vam_date_raw($dob), 4, 2), substr((int)vam_date_raw($dob), 6, 2), substr((int)vam_date_raw($dob), 0, 4)) == false) { 
			$error = true;

			$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
		}
	}

// New VAT Check
	require_once(DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($vat, '', '', $country);
	
	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];
	
	if($error==1){
	$messageStack->add('create_account', ENTRY_VAT_ERROR);
	$error = true;
  }

// New VAT CHECK END
	

	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
	}
	elseif (vam_validate_email($email_address) == false) {
		$error = true;

		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	} else {
		$check_email_query = vam_db_query("select count(*) as total from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0'");
		$check_email = vam_db_fetch_array($check_email_query);
		if ($check_email['total'] > 0) {
			$error = true;

			$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		}
	}

   if (ACCOUNT_STREET_ADDRESS == 'true') {
	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	}
  }
  
   if (ACCOUNT_POSTCODE == 'true') {
	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	}
  }

   if (ACCOUNT_CITY == 'true') {
	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_CITY_ERROR);
	}
  }

   if (ACCOUNT_COUNTRY == 'true') {
	if (is_numeric($country) == false) {
		$error = true;

		$messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	}
  }

	if (ACCOUNT_STATE == 'true') {		$zone_id = 0;		$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");		$check = vam_db_fetch_array($check_query);		$entry_state_has_zones = ($check['total'] > 0);		if ($entry_state_has_zones == true) {			$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and (zone_name like '".vam_db_input($state)."%' or zone_code like '%".vam_db_input($state)."%')");			if (vam_db_num_rows($zone_query) > 1) {				$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_name = '".vam_db_input($state)."'");			}			if (vam_db_num_rows($zone_query) >= 1) {				$zone = vam_db_fetch_array($zone_query);				$zone_id = $zone['zone_id'];			} else {				$error = true;				$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);			}		} else {			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {				$error = true;				$messageStack->add('create_account', ENTRY_STATE_ERROR);			}		}	}

   if (ACCOUNT_TELE == 'true') {
	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
	}
  }

	if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_PASSWORD_ERROR);
	}
	elseif ($password != $confirmation) {
		$error = true;

		$messageStack->add('create_account', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
	}

	//don't know why, but this happens sometimes and new user becomes admin
	if ($customers_status == 0 || !$customers_status)
		$customers_status = DEFAULT_CUSTOMERS_STATUS_ID;
	if (!$newsletter)
		$newsletter = 0;
	if ($error == false) {
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_status' => $customers_status, 'customers_firstname' => $firstname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax, 'orig_reference' => $html_referer, 'customers_newsletter' => $newsletter, 'customers_password' => vam_encrypt_password($password),'customers_date_added' => 'now()','customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = vam_date_raw($dob);

		vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

		$_SESSION['customer_id'] = vam_db_insert_id();
		$user_id = vam_db_insert_id();
		vam_write_user_info($user_id);
		$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'entry_firstname' => $firstname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => $country,'address_date_added' => 'now()','address_last_modified' => 'now()');

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
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_default_address_id'] = $address_id;
		$_SESSION['customer_country_id'] = $country;
		$_SESSION['customer_zone_id'] = $zone_id;
		$_SESSION['customer_vat_id'] = $vat;

		// restore cart contents
		$_SESSION['cart']->restore_contents();

		// build the message content
		$name = $firstname.' '.$lastname;

		// load data into array
		$module_content = array ();
		$module_content = array ('MAIL_NAME' => $name, 'MAIL_REPLY_ADDRESS' => EMAIL_SUPPORT_REPLY_ADDRESS, 'MAIL_GENDER' => $gender);

		// assign data to smarty
		$smarty->assign('language', $_SESSION['language']);
		$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$smarty->assign('content', $module_content);
		$smarty->caching = false;

if (isset ($_SESSION['tracking']['refID'])){
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


		if (ACTIVATE_GIFT_SYSTEM == 'true') {
			// GV Code Start
			// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* BEGIN
			if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
				$coupon_code = create_coupon_code();
				$insert_query = vam_db_query("insert into ".TABLE_COUPONS." (coupon_code, coupon_type, coupon_amount, date_created) values ('".$coupon_code."', 'G', '".NEW_SIGNUP_GIFT_VOUCHER_AMOUNT."', now())");
				$insert_id = vam_db_insert_id($insert_query);
				$insert_query = vam_db_query("insert into ".TABLE_COUPON_EMAIL_TRACK." (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('".$insert_id."', '0', 'Admin', '".$email_address."', now() )");

				$smarty->assign('SEND_GIFT', 'true');
				$smarty->assign('GIFT_AMMOUNT', $vamPrice->Format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT, true));
				$smarty->assign('GIFT_CODE', $coupon_code);
				$smarty->assign('GIFT_LINK', vam_href_link(FILENAME_GV_REDEEM, 'gv_no='.$coupon_code, 'NONSSL', false));

			}
			if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
				$coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;
				$coupon_query = vam_db_query("select * from ".TABLE_COUPONS." where coupon_code = '".$coupon_code."'");
				$coupon = vam_db_fetch_array($coupon_query);
				$coupon_id = $coupon['coupon_id'];
				$coupon_desc_query = vam_db_query("select * from ".TABLE_COUPONS_DESCRIPTION." where coupon_id = '".$coupon_id."' and language_id = '".(int) $_SESSION['languages_id']."'");
				$coupon_desc = vam_db_fetch_array($coupon_desc_query);
				$insert_query = vam_db_query("insert into ".TABLE_COUPON_EMAIL_TRACK." (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('".$coupon_id."', '0', 'Admin', '".$email_address."', now() )");

				$smarty->assign('SEND_COUPON', 'true');
				$smarty->assign('COUPON_DESC', $coupon_desc['coupon_description']);
				$smarty->assign('COUPON_CODE', $coupon['coupon_code']);

			}
			// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* END
			// GV Code End       // create templates
		}
		$smarty->caching = 0;
		$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
		$smarty->caching = 0;
		$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

		if (!isset ($mail_error)) {
			vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
		} else {
			echo $mail_error;
		}
	}
}

$breadcrumb->add(NAVBAR_TITLE_CREATE_ACCOUNT, vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'));

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('create_account') > 0) {
	$smarty->assign('error', $messageStack->output('create_account'));

}
$smarty->assign('FORM_ACTION', vam_draw_form('create_account', vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post', 'onsubmit="return checkform(this);"').vam_draw_hidden_field('action', 'process') . vam_draw_hidden_field('required', 'gender,firstname,lastname,dob,email,address,postcode,city,state,country,telephone,pass,confirmation', 'id="required"'));

if (ACCOUNT_GENDER == 'true') {
	$smarty->assign('gender', '1');

	$smarty->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm', '', 'id="gender"'));
	$smarty->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'id="gender"'));
   $smarty->assign('ENTRY_GENDER_ERROR', ENTRY_GENDER_ERROR);

} else {
	$smarty->assign('gender', '0');
}

$smarty->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', 'id="firstname"'));
$smarty->assign('ENTRY_FIRST_NAME_ERROR', ENTRY_FIRST_NAME_ERROR);
$smarty->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', 'id="lastname"'));
$smarty->assign('ENTRY_LAST_NAME_ERROR', ENTRY_LAST_NAME_ERROR);

if (ACCOUNT_DOB == 'true') {
	$smarty->assign('birthdate', '1');

	$smarty->assign('INPUT_DOB', vam_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), '', 'id="dob"'));
   $smarty->assign('ENTRY_DATE_OF_BIRTH_ERROR', ENTRY_DATE_OF_BIRTH_ERROR);

} else {
	$smarty->assign('birthdate', '0');
}

$smarty->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), '', 'id="email"'));
$smarty->assign('ENTRY_EMAIL_ADDRESS_ERROR', ENTRY_EMAIL_ADDRESS_ERROR);

if (ACCOUNT_COMPANY == 'true') {
	$smarty->assign('company', '1');
	$smarty->assign('INPUT_COMPANY', vam_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COMPANY_TEXT) ? '<span class="Requirement">'.ENTRY_COMPANY_TEXT.'</span>' : ''))));
} else {
	$smarty->assign('company', '0');
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
	$smarty->assign('vat', '1');
	$smarty->assign('INPUT_VAT', vam_draw_input_fieldNote(array ('name' => 'vat', 'text' => '&nbsp;'. (vam_not_null(ENTRY_VAT_TEXT) ? '<span class="Requirement">'.ENTRY_VAT_TEXT.'</span>' : ''))));
} else {
	$smarty->assign('vat', '0');
}

if (ACCOUNT_STREET_ADDRESS == 'true') {
   $smarty->assign('street_address', '1');
   $smarty->assign('INPUT_STREET', vam_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', 'id="address"'));
   $smarty->assign('ENTRY_STREET_ADDRESS_ERROR', ENTRY_STREET_ADDRESS_ERROR);
} else {
	$smarty->assign('street_address', '0');
}

if (ACCOUNT_SUBURB == 'true') {
	$smarty->assign('suburb', '1');
	$smarty->assign('INPUT_SUBURB', vam_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SUBURB_TEXT) ? '<span class="Requirement">'.ENTRY_SUBURB_TEXT.'</span>' : ''))));

} else {
	$smarty->assign('suburb', '0');
}

if (ACCOUNT_POSTCODE == 'true') {
	$smarty->assign('postcode', '1');
   $smarty->assign('INPUT_CODE', vam_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (vam_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="Requirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), '', 'id="postcode"'));
   $smarty->assign('ENTRY_POST_CODE_ERROR', ENTRY_POST_CODE_ERROR);

} else {
	$smarty->assign('postcode', '0');
}

if (ACCOUNT_CITY == 'true') {
	$smarty->assign('city', '1');
   $smarty->assign('INPUT_CITY', vam_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', 'id="city"'));
   $smarty->assign('ENTRY_CITY_ERROR', ENTRY_CITY_ERROR);
} else {
	$smarty->assign('city', '0');
}

if (ACCOUNT_STATE == 'true') {
	$smarty->assign('state', '1');

//	if ($process == true) {

    if ($process != true) {
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

		   $zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and (zone_name like '".vam_db_input($state)."%' or zone_code like '%".vam_db_input($state)."%')");

	      if (vam_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}
	}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, $zone_name, 'id="state"');
//        $state_input = vam_draw_pull_down_menu('state', $zones_array, $zone_name . ' id="state"');
      } else {
		$state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', 'id="state"');
//        $state_input = vam_draw_input_field('state', '', ' id="state"');
      }
		
			
//			$state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array);
//		} else {
//			$state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')));
//		}
//	} else {
//		$state_input = vam_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')));
//	}

	$smarty->assign('INPUT_STATE', $state_input);
   $smarty->assign('ENTRY_STATE_ERROR_SELECT', ENTRY_STATE_ERROR_SELECT);
} else {
	$smarty->assign('state', '0');
}

if ($_POST['country']) {
	$selected = $_POST['country'];
} else {
	$selected = STORE_COUNTRY;
}

if (ACCOUNT_COUNTRY == 'true') {
	$smarty->assign('country', '1');
//   $smarty->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected));

   $smarty->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected, 'id="country" onchange="document.getElementById(\'stateXML\').innerHTML = \'' . ENTRY_STATEXML_LOADING . '\';loadXMLDoc(\'loadStateXML\',{country_id: this.value});"'));
   
//   $smarty->assign('SELECT_COUNTRY_NOSCRIPT', '<noscript><br />' . vam_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE, 'name=loadStateXML') . '<br />' . ENTRY_STATE_RELOAD . '</noscript>');

   $smarty->assign('ENTRY_COUNTRY_ERROR', ENTRY_COUNTRY_ERROR);

} else {
	$smarty->assign('country', '0');
}

if (ACCOUNT_TELE == 'true') {
	$smarty->assign('telephone', '1');
   $smarty->assign('INPUT_TEL', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), '', 'id="telephone"'));
   $smarty->assign('ENTRY_TELEPHONE_NUMBER_ERROR', ENTRY_TELEPHONE_NUMBER_ERROR);
} else {
	$smarty->assign('telephone', '0');
}

if (ACCOUNT_FAX == 'true') {
	$smarty->assign('fax', '1');
   $smarty->assign('INPUT_FAX', vam_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : ''))));
} else {
	$smarty->assign('fax', '0');
}

$smarty->assign('INPUT_PASSWORD', vam_draw_password_fieldNote(array ('name' => 'password', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_TEXT.'</span>' : '')), '', 'id="pass"'));
$smarty->assign('ENTRY_PASSWORD_ERROR', ENTRY_PASSWORD_ERROR);
$smarty->assign('INPUT_CONFIRMATION', vam_draw_password_fieldNote(array ('name' => 'confirmation', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : '')), '', 'id="confirmation"'));
$smarty->assign('ENTRY_PASSWORD_ERROR_NOT_MATCHING', ENTRY_PASSWORD_ERROR_NOT_MATCHING);
$smarty->assign('FORM_END', '</form>');
$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$smarty->assign('BUTTON_SUBMIT', vam_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/create_account.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
