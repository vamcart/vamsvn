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

if (isset ($_SESSION['customer_id']) && !isset($_GET['social_login'])) {
	vam_redirect(vam_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

// create template elements
$vamTemplate = new vamTemplate;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'vam_get_country_list.inc.php');
require_once (DIR_FS_INC.'vam_validate_email.inc.php');
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'vam_get_zone_name.inc.php');
require_once (DIR_FS_INC.'vam_write_user_info.inc.php');
require_once (DIR_FS_INC.'vam_random_charcode.inc.php');

$process = false;

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
	$process = true;

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
	$newsletter = '0';
	$newsletter = vam_db_prepare_input($_POST['newsletter']);
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
	
	$customers_vat_id_status = 0;
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

	if (ACCOUNT_STATE == 'true') {		$zone_id = 0;		$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");		$check = vam_db_fetch_array($check_query);		$entry_state_has_zones = ($check['total'] > 0);		if ($entry_state_has_zones == true) {			$zone_query = vam_db_query("select distinct zone_id from " . TABLE_ZONES . " where zone_country_id = '" . (int)$country . "' and zone_name = '" . vam_db_input($state) . "'");			if (vam_db_num_rows($zone_query) > 1) {				$zone_query = vam_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_name = '".vam_db_input($state)."'");			}			if (vam_db_num_rows($zone_query) >= 1) {				$zone = vam_db_fetch_array($zone_query);				$zone_id = $zone['zone_id'];			} else {				$error = true;				$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);			}		} else {			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {				$error = true;				$messageStack->add('create_account', ENTRY_STATE_ERROR);			}		}	}

   if (ACCOUNT_TELE == 'true') {
	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;

		$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
	}
  }

        $extra_fields_query = vamDBquery("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . $_SESSION['languages_id']);

   while($extra_fields = vam_db_fetch_array($extra_fields_query,true)){
   
    if(strlen($_POST['fields_' . $extra_fields['fields_id'] ])<$extra_fields['fields_size']){
      $error = true;
      $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);
      $messageStack->add('create_account', $string_error);
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
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_status' => $customers_status, 'customers_firstname' => $firstname, 'customers_secondname' => $secondname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax, 'orig_reference' => $html_referer, 'customers_newsletter' => $newsletter, 'customers_password' => vam_encrypt_password($password),'customers_date_added' => 'now()','customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = vam_date_raw($dob);

		vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

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

		$user_id = vam_db_insert_id();
		vam_write_user_info($user_id);
		$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'entry_firstname' => $firstname, 'entry_secondname' => $secondname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => $country,'address_date_added' => 'now()','address_last_modified' => 'now()');

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
		$_SESSION['customer_email_address'] = $email_address;
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

		// assign data to template
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$vamTemplate->assign('content', $module_content);
		$vamTemplate->caching = false;

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

				$vamTemplate->assign('SEND_GIFT', 'true');
				$vamTemplate->assign('GIFT_AMMOUNT', $vamPrice->Format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT, true));
				$vamTemplate->assign('GIFT_CODE', $coupon_code);
				$vamTemplate->assign('GIFT_LINK', vam_href_link(FILENAME_GV_REDEEM, 'gv_no='.$coupon_code, 'NONSSL', false));

			}
			if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
				$coupon_code = NEW_SIGNUP_DISCOUNT_COUPON;
				$coupon_query = vam_db_query("select * from ".TABLE_COUPONS." where coupon_code = '".$coupon_code."'");
				$coupon = vam_db_fetch_array($coupon_query);
				$coupon_id = $coupon['coupon_id'];
				$coupon_desc_query = vam_db_query("select * from ".TABLE_COUPONS_DESCRIPTION." where coupon_id = '".$coupon_id."' and language_id = '".(int) $_SESSION['languages_id']."'");
				$coupon_desc = vam_db_fetch_array($coupon_desc_query);
				$insert_query = vam_db_query("insert into ".TABLE_COUPON_EMAIL_TRACK." (coupon_id, customer_id_sent, sent_firstname, emailed_to, date_sent) values ('".$coupon_id."', '0', 'Admin', '".$email_address."', now() )");

				$vamTemplate->assign('SEND_COUPON', 'true');
				$vamTemplate->assign('COUPON_DESC', $coupon_desc['coupon_description']);
				$vamTemplate->assign('COUPON_CODE', $coupon['coupon_code']);

			}
			// ICW - CREDIT CLASS CODE BLOCK ADDED  ******************************************************* END
			// GV Code End       // create templates
		}
		$vamTemplate->caching = 0;

      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
      $vamTemplate->assign('PASSWORD', $password);
		
    if ($newsletter) {
      $vlcode = vam_random_charcode(32);
      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($_SESSION['customer_id']), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
      // assign vars
      $vamTemplate->assign('LINK', $link);
    } else {
      $vamTemplate->assign('LINK', false);
    }		
		
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

		if (!isset ($mail_error)) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
		} else {
			echo $mail_error;
		}
	}
}


// Social Login

//Facebook

if (isset ($_GET['social_login']) && ($_GET['social_login'] == 'fb')) {
	
		$provider = 'fb';
		
		$clientId = FACEBOOK_OAUTH_CLIENT_ID; //ID Приложения
		$clientSecret = FACEBOOK_OAUTH_SECRET_KEY; //Защищённый ключ
		$redirectUrl = HTTP_SERVER.DIR_WS_CATALOG.FILENAME_CREATE_ACCOUNT.'?social_login=fb';  //return url (url to script)
		$homeUrl = HTTP_SERVER.DIR_WS_CATALOG;  //return to home

		if (isset($_REQUEST['code'])) {
			$result = false;
			
		    $params = array(
		        'client_id' => $clientId,
		        'client_secret' => $clientSecret,
		        'code' => $_REQUEST['code'],
		        'redirect_uri' => $redirectUrl
		    );
		
		  $token = 'https://graph.facebook.com/oauth/access_token' . '?' . urldecode(http_build_query($params));

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $token);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $results = json_decode($contents, true); 
        
        //echo var_dump($results);

		    if (count($results) > 0 && isset($results['access_token'])) {
		        
				$query = urldecode(http_build_query(array(

					"access_token" => $results['access_token'],
					"fields"       => "id,name,first_name,last_name,email"
				)));		        
		        
		        $userInfo = json_decode(file_get_contents('https://graph.facebook.com/me' . '?' . $query), true);
		        if (isset($userInfo['id'])) {
		            $userInfo = $userInfo;
		            $result = true;
		        }
		    }

        //echo var_dump($userInfo);
        
			$_SESSION['fb_token'] = $results['access_token'];
			$_SESSION['fb_user_id'] = $userInfo['id'];
			$_SESSION['fb_user_email'] = $userInfo['email'];
			
			header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));

		}

		if ($_SESSION['fb_token'] && $_SESSION['fb_user_email'] != '' && $_SESSION['fb_user_id'] > 0) {

	$process = true;

	require_once (DIR_FS_INC.'vam_create_password.inc.php');
	require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
	
	$firstname = html_entity_decode($userInfo['first_name']);
	$secondname = ''; 
	$lastnam﻿e = html_entity_decode($userInfo['last_name']);
	$fullname = html_entity_decode($userInfo['name']);
	$email_address = html_entity_decode($_SESSION['fb_user_email']);
	$password = vam_RandomString(8);
	$country = STORE_COUNTRY;
	$zone_id = STORE_ZONE;
	$vat = 0;

	$sql_data_array = array (
	
	'customers_vat_id' => 0, 
	'customers_vat_id_status' => 0, 
	'customers_status' => DEFAULT_CUSTOMERS_STATUS_ID, 
	'customers_firstname' => $firstname, 
	'customers_secondname' => $secondname, 
	'customers_lastname' => $lastname, 
	'customers_email_address' => $email_address, 
	'customers_telephone' => '', 
	'customers_fax' => '', 
	'orig_reference' => '', 
	'customers_newsletter' => 1, 
	'customers_password' => vam_encrypt_password($password),
	'customers_date_added' => 'now()',
	'customers_last_modified' => 'now()'
	
	);

	$check_email_query = vam_db_query("select * from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0' order by customers_id DESC");
	$check_email = vam_db_fetch_array($check_email_query);

	if (vam_db_num_rows($check_email_query) > 0 && $check_email['customers_status'] != 0) {

	$_SESSION['customer_id'] = $check_email['customers_id'];
	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");

	} else {

	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	$_SESSION['customer_id'] = vam_db_insert_id();
	vam_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $_SESSION['customer_id']."', '0', now())");
		$sql_data_array = array (
		
		'customers_id' => $_SESSION['customer_id'], 
		'entry_firstname' => $firstname, 
		'entry_secondname' => $secondname, 
		'entry_lastname' => $lasttname, 
		'entry_street_address' => '', 
		'entry_postcode' => '', 
		'entry_city' => '', 
		'entry_country_id' => $country,
		'address_date_added' => 'now()',
		'address_last_modified' => 'now()'
		
		);

		vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
		$address_id = vam_db_insert_id();
		vam_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".(int) $_SESSION['customer_id']."'");
	}        

		$user_id = $_SESSION['customer_id'];
		vam_write_user_info($user_id);

		if (SESSION_RECREATE == 'True') {
			vam_session_recreate();
		}

		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customer_second_name'] = $secondname;
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_email_address'] = $email_address;
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

		// assign data to template
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$vamTemplate->assign('content', $module_content);
		$vamTemplate->caching = false;

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


		$vamTemplate->caching = 0;

      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
      $vamTemplate->assign('PASSWORD', $password);
		
    if ($newsletter) {
      $vlcode = vam_random_charcode(32);
      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($_SESSION['customer_id']), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
      // assign vars
      $vamTemplate->assign('LINK', $link);
    } else {
      $vamTemplate->assign('LINK', false);
    }		
		
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

		if (!isset ($mail_error)) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
		} else {
			echo $mail_error;
		}
}
}	

//Google

if (isset ($_GET['social_login']) && ($_GET['social_login'] == 'google')) {
	
		$provider = 'google';
		
		$clientId = GOOGLE_OAUTH_CLIENT_ID; //ID Приложения
		$clientSecret = GOOGLE_OAUTH_SECRET_KEY; //Защищённый ключ
		$redirectUrl = HTTP_SERVER.DIR_WS_CATALOG.FILENAME_CREATE_ACCOUNT.'?social_login=google';  //return url (url to script)
		$homeUrl = HTTP_SERVER.DIR_WS_CATALOG;  //return to home

		require_once (DIR_FS_CATALOG.'vendor/google/Google_Client.php');
		$gClient = new Google_Client();
		$gClient->setApplicationName('VamShop');
		$gClient->setClientId($clientId);
		$gClient->setClientSecret($clientSecret);
		$gClient->setRedirectUri($redirectUrl);
		
		require_once (DIR_FS_CATALOG.'vendor/google/contrib/Google_Oauth2Service.php');
		$google_oauthV2 = new Google_Oauth2Service($gClient);

		//print_r($_GET);die;
		//echo debug($_REQUEST);
		//echo debug($gClient);

		if(isset($_REQUEST['code'])){
			$gClient->authenticate();
			$_SESSION['token'] = $gClient->getAccessToken();
			header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));
		}
		
		if (isset($_SESSION['token'])) {
			$gClient->setAccessToken($_SESSION['token']);
		}
				
		if ($gClient->getAccessToken()) {
			$userProfile = $google_oauthV2->userinfo->get();
			//echo debug($userProfile);

	$process = true;

	require_once (DIR_FS_INC.'vam_create_password.inc.php');
	require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
	
	$firstnam﻿e = html_entity_decode($userProfile['given_name']);
	$secondname = ''; 
	$lastname = html_entity_decode($userProfile['family_name']);
	$fullname = html_entity_decode($userProfile['given_name']." ".$userProfile['family_name']);
	$email_address = html_entity_decode($userProfile['email']);
	$password = vam_RandomString(8);
	$country = STORE_COUNTRY;
	$zone_id = STORE_ZONE;
	$vat = 0;

	$sql_data_array = array (
	
	'customers_vat_id' => 0, 
	'customers_vat_id_status' => 0, 
	'customers_status' => DEFAULT_CUSTOMERS_STATUS_ID, 
	'customers_firstname' => $firstname, 
	'customers_secondname' => $secondname, 
	'customers_lastname' => $lastname, 
	'customers_email_address' => $email_address, 
	'customers_telephone' => '', 
	'customers_fax' => '', 
	'orig_reference' => '', 
	'customers_newsletter' => 1, 
	'customers_password' => vam_encrypt_password($password),
	'customers_date_added' => 'now()',
	'customers_last_modified' => 'now()'
	
	);

	$check_email_query = vam_db_query("select * from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0' order by customers_id DESC");
	$check_email = vam_db_fetch_array($check_email_query);

	if (vam_db_num_rows($check_email_query) > 0 && $check_email['customers_status'] != 0) {

	$_SESSION['customer_id'] = $check_email['customers_id'];
	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");

	} else {

	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	$_SESSION['customer_id'] = vam_db_insert_id();
	vam_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $_SESSION['customer_id']."', '0', now())");
		$sql_data_array = array (
		
		'customers_id' => $_SESSION['customer_id'], 
		'entry_firstname' => $firstname, 
		'entry_secondname' => $secondname, 
		'entry_lastname' => $lasttname, 
		'entry_street_address' => '', 
		'entry_postcode' => '', 
		'entry_city' => '', 
		'entry_country_id' => $country,
		'address_date_added' => 'now()',
		'address_last_modified' => 'now()'
		
		);

		vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
		$address_id = vam_db_insert_id();
		vam_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".(int) $_SESSION['customer_id']."'");
	}        

		$user_id = $_SESSION['customer_id'];
		vam_write_user_info($user_id);

		if (SESSION_RECREATE == 'True') {
			vam_session_recreate();
		}

		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customer_second_name'] = $secondname;
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_email_address'] = $email_address;
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

		// assign data to template
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$vamTemplate->assign('content', $module_content);
		$vamTemplate->caching = false;

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


		$vamTemplate->caching = 0;

      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
      $vamTemplate->assign('PASSWORD', $password);
		
    if ($newsletter) {
      $vlcode = vam_random_charcode(32);
      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($_SESSION['customer_id']), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
      // assign vars
      $vamTemplate->assign('LINK', $link);
    } else {
      $vamTemplate->assign('LINK', false);
    }		
		
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

		if (!isset ($mail_error)) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
		} else {
			echo $mail_error;
		}

		} else {
			$authUrl = $gClient->createAuthUrl();
		}
		
		if(isset($authUrl)) {
			echo vam_redirect($authUrl);
		} else {
			//echo '<a href="/site/social_logout">Logout</a>';
		}

}	

//VK

if (isset ($_GET['social_login']) && ($_GET['social_login'] == 'vk')) {
	
		$provider = 'vk';
		
		$clientId = VK_OAUTH_CLIENT_ID; //ID Приложения
		$clientSecret = VK_OAUTH_SECRET_KEY; //Защищённый ключ
		$clientServiceKey = VK_OAUTH_SERVICE_KEY; //Сервисный ключ доступа
		$redirectUrl = HTTP_SERVER.DIR_WS_CATALOG.FILENAME_CREATE_ACCOUNT.'?social_login=vk';  //return url (url to script)
		$homeUrl = HTTP_SERVER.DIR_WS_CATALOG;  //return to home

		if (isset($_REQUEST['code'])) {
			$result = false;
			
		    $params = array(
		        'client_id' => $clientId,
		        'client_secret' => $clientSecret,
		        'code' => $_REQUEST['code'],
		        'redirect_uri' => $redirectUrl
		    );
		
		  $token = 'https://oauth.vk.com/access_token' . '?' . urldecode(http_build_query($params));

        // create curl resource
        $ch = curl_init();

        // set url
        curl_setopt($ch, CURLOPT_URL, $token);

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string
        $output = curl_exec($ch);

        // close curl resource to free up system resources
        curl_close($ch);  

        $contents = $output;
        $results = json_decode($contents, true); 
        
        //echo var_dump($results);
        
			$_SESSION['vk_token'] = $results['access_token'];
			$_SESSION['vk_user_id'] = $results['user_id'];
			$_SESSION['vk_user_email'] = $results['email'];

			$user_id = $results['user_id'];
			$request_params = array(
			'user_id' => $user_id,
			'fields' => 'first_name,last_name,photo_100',
			'v' => '5.52',
			'access_token' => $results['access_token']
			);
			$get_params = http_build_query($request_params);
			$result = json_decode(file_get_contents('https://api.vk.com/method/users.get?'. $get_params));
			//echo var_dump($result);
			
			header('Location: ' . filter_var($redirectUrl, FILTER_SANITIZE_URL));

		}

		if ($_SESSION['vk_token'] && $_SESSION['vk_user_email'] != '' && $_SESSION['vk_user_id'] > 0) {

	$process = true;

	require_once (DIR_FS_INC.'vam_create_password.inc.php');
	require_once (DIR_FS_INC.'vam_random_charcode.inc.php');
	
	$firstname = html_entity_decode($result->response[0]->first_name);
	$secondname = ''; 
	$lastname = html_entity_decode($result->response[0]->last_name);
	$fullname = html_entity_decode($result->response[0]->first_name . ' ' . $result->response[0]->last_name);
	$email_address = html_entity_decode($_SESSION['vk_user_email']);
	$password = vam_RandomString(8);
	$country = STORE_COUNTRY;
	$zone_id = STORE_ZONE;
	$vat = 0;

	$sql_data_array = array (
	
	'customers_vat_id' => 0, 
	'customers_vat_id_status' => 0, 
	'customers_status' => DEFAULT_CUSTOMERS_STATUS_ID, 
	'customers_firstname' => $firstname, 
	'customers_secondname' => $secondname, 
	'customers_lastname' => $lastname, 
	'customers_email_address' => $email_address, 
	'customers_telephone' => '', 
	'customers_fax' => '', 
	'orig_reference' => '', 
	'customers_newsletter' => 1, 
	'customers_password' => vam_encrypt_password($password),
	'customers_date_added' => 'now()',
	'customers_last_modified' => 'now()'
	
	);

	$check_email_query = vam_db_query("select * from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($email_address)."' and account_type = '0' order by customers_id DESC");
	$check_email = vam_db_fetch_array($check_email_query);

	if (vam_db_num_rows($check_email_query) > 0 && $check_email['customers_status'] != 0) {

	$_SESSION['customer_id'] = $check_email['customers_id'];
	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '" . (int) $_SESSION['customer_id'] . "'");

	} else {

	vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);
	$_SESSION['customer_id'] = vam_db_insert_id();
	vam_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $_SESSION['customer_id']."', '0', now())");
		$sql_data_array = array (
		
		'customers_id' => $_SESSION['customer_id'], 
		'entry_firstname' => $firstname, 
		'entry_secondname' => $secondname, 
		'entry_lastname' => $lasttname, 
		'entry_street_address' => '', 
		'entry_postcode' => '', 
		'entry_city' => '', 
		'entry_country_id' => $country,
		'address_date_added' => 'now()',
		'address_last_modified' => 'now()'
		
		);

		vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);
		$address_id = vam_db_insert_id();
		vam_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".(int) $_SESSION['customer_id']."'");
	}        

		$user_id = $_SESSION['customer_id'];
		vam_write_user_info($user_id);

		if (SESSION_RECREATE == 'True') {
			vam_session_recreate();
		}

		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customer_second_name'] = $secondname;
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_email_address'] = $email_address;
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

		// assign data to template
		$vamTemplate->assign('language', $_SESSION['language']);
		$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
		$vamTemplate->assign('content', $module_content);
		$vamTemplate->caching = false;

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


		$vamTemplate->caching = 0;

      $vamTemplate->assign('EMAIL_ADDRESS', $email_address);
      $vamTemplate->assign('PASSWORD', $password);
		
    if ($newsletter) {
      $vlcode = vam_random_charcode(32);
      $link = vam_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.$email_address.'&key='.$vlcode, 'NONSSL');
      $sql_data_array = array ('customers_email_address' => vam_db_input($email_address), 'customers_id' => vam_db_input($_SESSION['customer_id']), 'customers_status' => 2, 'customers_firstname' => vam_db_input($firstname), 'customers_lastname' => vam_db_input($lastname), 'mail_status' => '1', 'mail_key' => vam_db_input($vlcode), 'date_added' => 'now()');
      vam_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);
      // assign vars
      $vamTemplate->assign('LINK', $link);
    } else {
      $vamTemplate->assign('LINK', false);
    }		
		
		$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.html');
		$vamTemplate->caching = 0;
		$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/create_account_mail.txt');

		vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $email_address, $name, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);

		if (!isset ($mail_error)) {
				if ($_SESSION['nologin']){
				vam_redirect(vam_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
				}else{
				        vam_redirect(vam_href_link(FILENAME_SHOPPING_CART, '', 'SSL'));
				}
		} else {
			echo $mail_error;
		}
}
}	



$breadcrumb->add(NAVBAR_TITLE_CREATE_ACCOUNT);

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('create_account') > 0) {
	$vamTemplate->assign('error', $messageStack->output('create_account'));

}
$vamTemplate->assign('FORM_ACTION', vam_draw_form('create_account', vam_href_link(FILENAME_CREATE_ACCOUNT, '', 'SSL'), 'post').vam_draw_hidden_field('action', 'process'));

if (ACCOUNT_GENDER == 'true') {
	$vamTemplate->assign('gender', '1');

	$vamTemplate->assign('INPUT_MALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm', '', 'id="gender" checked="checked"'));
	$vamTemplate->assign('INPUT_FEMALE', vam_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (vam_not_null(ENTRY_GENDER_TEXT) ? '<span class="Requirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', '', 'id="gender"'));

} else {
	$vamTemplate->assign('gender', '0');
}

$vamTemplate->assign('INPUT_FIRSTNAME', vam_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', 'id="firstname"'));
if (ACCOUNT_SECOND_NAME == 'true') {
	$vamTemplate->assign('secondname', '1');
$vamTemplate->assign('INPUT_SECONDNAME', vam_draw_input_fieldNote(array ('name' => 'secondname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_SECOND_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_SECOND_NAME_TEXT.'</span>' : '')), '', 'id="secondname"'));
}
$vamTemplate->assign('INPUT_LASTNAME', vam_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (vam_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="Requirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', 'id="lastname"'));

if (ACCOUNT_DOB == 'true') {
	$vamTemplate->assign('birthdate', '1');

	$vamTemplate->assign('INPUT_DOB', vam_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (vam_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="Requirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), '', 'id="dob"'));

} else {
	$vamTemplate->assign('birthdate', '0');
}

$vamTemplate->assign('INPUT_EMAIL', vam_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), '', 'id="email_address"'));

$vamTemplate->assign('INPUT_NEWSLETTER', vam_draw_checkbox_field('newsletter', '1', true));

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
   $vamTemplate->assign('INPUT_STREET', vam_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="Requirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', 'id="street_address"'));
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

} else {
	$vamTemplate->assign('postcode', '0');
}

if (ACCOUNT_CITY == 'true') {
	$vamTemplate->assign('city', '1');
   $vamTemplate->assign('INPUT_CITY', vam_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (vam_not_null(ENTRY_CITY_TEXT) ? '<span class="Requirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', 'id="city"'));
} else {
	$vamTemplate->assign('city', '0');
}

if (ACCOUNT_STATE == 'true') {
	$vamTemplate->assign('state', '1');

//	if ($process == true) {

//    if ($process != true) {
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

		}
//	}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (vam_not_null(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, ($process == true) ? $state : vam_get_zone_name(STORE_COUNTRY, STORE_ZONE,''), 'id="state"');
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

	$vamTemplate->assign('INPUT_STATE', $state_input);
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
//   $vamTemplate->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected));

   $vamTemplate->assign('SELECT_COUNTRY', vam_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected, 'id="country"'));
   
//   $vamTemplate->assign('SELECT_COUNTRY_NOSCRIPT', '<noscript><br />' . vam_image_submit('button_update.gif', IMAGE_BUTTON_UPDATE, 'name=loadStateXML') . '<br />' . ENTRY_STATE_RELOAD . '</noscript>');

} else {
	$vamTemplate->assign('country', '0');
}

if (ACCOUNT_TELE == 'true') {
	$vamTemplate->assign('telephone', '1');
   $vamTemplate->assign('INPUT_TEL', vam_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (vam_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="Requirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), '', 'id="telephone"'));
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
$vamTemplate->assign('INPUT_CONFIRMATION', vam_draw_password_fieldNote(array ('name' => 'confirmation', 'text' => '&nbsp;'. (vam_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="Requirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : '')), '', 'id="confirmation"'));
$vamTemplate->assign('FORM_END', '</form>');
$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->caching = 0;
$vamTemplate->assign('BUTTON_SUBMIT', vam_image_submit('submit.png',  IMAGE_BUTTON_CONTINUE));
$main_content = $vamTemplate->fetch(CURRENT_TEMPLATE.'/module/create_account.html');

$vamTemplate->assign('language', $_SESSION['language']);
$vamTemplate->assign('main_content', $main_content);
$vamTemplate->caching = 0;
if (!defined(RM)) $vamTemplate->loadFilter('output', 'note');
$template = (file_exists('templates/'.CURRENT_TEMPLATE.'/'.FILENAME_CREATE_ACCOUNT.'.html') ? CURRENT_TEMPLATE.'/'.FILENAME_CREATE_ACCOUNT.'.html' : CURRENT_TEMPLATE.'/index.html');
$vamTemplate->display($template);
include ('includes/application_bottom.php');
?>