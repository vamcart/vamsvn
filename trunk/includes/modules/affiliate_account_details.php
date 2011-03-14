<?php
/*------------------------------------------------------------------------------
   $Id: affiliate_account_details.php,v 1.2 2005/05/25 18:20:23 hubi74 Exp $

   XTC-Affiliate - Contribution for XT-Commerce http://www.xt-commerce.com
   modified by http://www.netz-designer.de

   Copyright (c) 2003 netz-designer
   -----------------------------------------------------------------------------
   based on:
   (c) 2003 OSC-Affiliate (affiliate_account_details.php, v 2.0 2003/09/29);
   http://oscaffiliate.sourceforge.net/

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   Released under the GNU General Public License
   ---------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'vam_draw_radio_field.inc.php');
require_once(DIR_FS_INC . 'vam_draw_hidden_field.inc.php');
require_once(DIR_FS_INC . 'vam_draw_password_field.inc.php');
require_once(DIR_FS_INC . 'vam_draw_checkbox_field.inc.php');
require_once(DIR_FS_INC . 'vam_date_short.inc.php');
require_once(DIR_FS_INC . 'vam_get_country_list.inc.php');
require_once(DIR_FS_INC . 'vam_get_zone_name.inc.php');

$module= new vamTemplate;

if (!isset($is_read_only)) $is_read_only = false;
if (!isset($processed)) $processed = false;

if (ACCOUNT_GENDER == 'true') {
	$module->assign('ACCOUNT_GENDER', 'true');
	$male = ($affiliate['affiliate_gender'] == 'm') ? true : false;
    $female = ($affiliate['affiliate_gender'] == 'f') ? true : false;
    if ($is_read_only == true) {
    	$gender_male = ($affiliate['affiliate_gender'] == 'm') ? MALE : FEMALE;
    }
	elseif ($error == true) {
		if ($entry_gender_error == true) {
			$gender_male = vam_draw_radio_field(array('name'=>'a_gender', 'suffix'=>MALE), 'm', $male);
			$gender_female = vam_draw_radio_field(array('name'=>'a_gender', 'suffix'=>FEMALE, 'text'=>ENTRY_GENDER_ERROR), 'f', $female);
		}
		else {
			$gender_male = ($a_gender == 'm') ? MALE : FEMALE;
			$gender_female = vam_draw_hidden_field('a_gender');
		}
	}
	else {
		$gender_male = vam_draw_radio_field(array('name'=>'a_gender', 'suffix'=>MALE), 'm', $male);
		$gender_female = vam_draw_radio_field(array('name'=>'a_gender', 'suffix'=>FEMALE, 'text'=>ENTRY_GENDER_TEXT), 'f', $female);
    }
    $module->assign('gender_male', $gender_male);
    $module->assign('gender_female', $gender_female);
}

if ($is_read_only == true) {
    $firstname_content = $affiliate['affiliate_firstname'];
} elseif ($error == true) {
    if ($entry_firstname_error == true) {
    	$firstname_content = vam_draw_input_fieldNote(array('name'=>'a_firstname', 'text'=>'&nbsp;' . ENTRY_FIRST_NAME_ERROR));
    }
	else {
		$firstname_content = $a_firstname . vam_draw_hidden_field('a_firstname');
    }
}
else {
	$firstname_content = vam_draw_input_fieldNote(array('name'=>'a_firstname', 'text'=>'&nbsp;' . ENTRY_FIRST_NAME_TEXT), $affiliate['affiliate_firstname']);
}
$module->assign('firstname_content', $firstname_content);

if ($is_read_only == true) {
    $lastname_content = $affiliate['affiliate_lastname'];
}
elseif ($error == true) {
	if ($entry_lastname_error == true) {
		$lastname_content = vam_draw_input_fieldNote(array('name'=>'a_lastname', 'text'=>'&nbsp;' . ENTRY_LAST_NAME_ERROR));
    }
	else {
		$lastname_content = $a_lastname . vam_draw_hidden_field('a_lastname');
    }
}
else {
	$lastname_content = vam_draw_input_fieldNote(array('name'=>'a_lastname', 'text'=>'&nbsp;' . ENTRY_FIRST_NAME_TEXT), $affiliate['affiliate_lastname']);
}
$module->assign('lastname_content', $lastname_content);

if (ACCOUNT_DOB == 'true') {
	$module->assign('ACCOUNT_DOB', 'true');
    if ($is_read_only == true) {
    	$dob_content = vam_date_short($affiliate['affiliate_dob']);
    }
	elseif ($error == true) {
		if ($entry_date_of_birth_error == true) {
			$dob_content = vam_draw_input_fieldNote(array('name'=>'a_dob', 'text'=>'&nbsp;' . ENTRY_DATE_OF_BIRTH_ERROR));
		}
		else {
			$dob_content = $a_dob . vam_draw_hidden_field('a_dob');
      	}
    }
	else {
		$dob_content = vam_draw_input_fieldNote(array('name'=>'a_dob', 'text'=>'&nbsp;' . ENTRY_DATE_OF_BIRTH_TEXT), vam_date_short($affiliate['affiliate_dob']));
    }
    $module->assign('dob_content', $dob_content);
}

if ($is_read_only == true) {
    $email_content = $affiliate['affiliate_email_address'];
}
elseif ($error == true) {
	if ($entry_email_address_error == true) {
		$email_content = vam_draw_input_fieldNote(array('name'=>'a_email_address', 'text'=>'&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR));
    }
	elseif ($entry_email_address_check_error == true) {
		$email_content = vam_draw_input_fieldNote(array('name'=>'a_email_address', 'text'=>'&nbsp;' . ENTRY_EMAIL_ADDRESS_CHECK_ERROR));
    }
	elseif ($entry_email_address_exists == true) {
		$email_content = vam_draw_input_fieldNote(array('name'=>'a_email_address', 'text'=>'&nbsp;' . ENTRY_EMAIL_ADDRESS_ERROR_EXISTS));
    }
	else {
		$email_content = $a_email_address . vam_draw_hidden_field('a_email_address');
    }
}
else {
	$email_content = vam_draw_input_fieldNote(array('name'=>'a_email_address', 'text'=>'&nbsp;' . ENTRY_EMAIL_ADDRESS_TEXT), $affiliate['affiliate_email_address']);
}
$module->assign('email_content', $email_content);

if (ACCOUNT_COMPANY == 'true') {
	$module->assign('ACCOUNT_COMPANY', 'true');
	if ($is_read_only == true) {
		$company_content = $affiliate['affiliate_company'];
    }
	elseif ($error == true) {
		if ($entry_company_error == true) {
			$company_content = vam_draw_input_fieldNote(array('name'=>'a_company', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_COMPANY_ERROR));
		}
		else {
			$company_content = $a_company . vam_draw_hidden_field('a_company');
		}
    }
	else {
		$company_content = vam_draw_input_fieldNote(array('name'=>'a_company', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_COMPANY_TEXT), $affiliate['affiliate_company']);
    }
    $module->assign('company_content', $company_content);

    if ($is_read_only == true) {
    	$company_taxid_content = $affiliate['affiliate_company_taxid'];
    }
	elseif ($error == true) {
		if ($entry_company_taxid_error == true) {
			$company_taxid_content = vam_draw_input_fieldNote(array('name'=>'a_company_taxid', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_COMPANY_TAXID_ERROR));
		}
		else {
			$company_taxid_content = $a_company_taxid . vam_draw_hidden_field('a_company_taxid');
		}
    }
	else {
		$company_taxid_content = vam_draw_input_fieldNote(array('name'=>'a_company_taxid', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_COMPANY_TAXID_TEXT), $affiliate['affiliate_company_taxid']);
    }
    $module->assign('company_taxid_content', $company_taxid_content);
}

if (AFFILIATE_USE_CHECK == 'true') {
	$module->assign('AFFILIATE_USE_CHECK', 'true');
	if ($is_read_only == true) {
		$payment_check_content = $affiliate['affiliate_payment_check'];
    }
	elseif ($error == true) {
		if ($entry_payment_check_error == true) {
			$payment_check_content = vam_draw_input_fieldNote(array('name'=>'a_payment_check', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_CHECK_ERROR));
		}
		else {
			$payment_check_content = $a_payment_check . vam_draw_hidden_field('a_payment_check');
		}
    }
	else {
		$payment_check_content = vam_draw_input_fieldNote(array('name'=>'a_payment_check', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_CHECK_TEXT), $affiliate['affiliate_payment_check']);
	}
	$module->assign('payment_check_content', $payment_check_content);
}

if (AFFILIATE_USE_PAYPAL == 'true') {
	$module->assign('AFFILIATE_USE_PAYPAL', 'true');
	if ($is_read_only == true) {
		$payment_paypal_content = $affiliate['affiliate_payment_paypal'];
    }
	elseif ($error == true) {
		if ($entry_payment_paypal_error == true) {
			$payment_paypal_content = vam_draw_input_fieldNote(array('name'=>'a_payment_paypal', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_PAYPAL_ERROR));
		}
		else {
			$payment_paypal_content = $a_payment_paypal . vam_draw_hidden_field('a_payment_paypal');
		}
	}
	else {
		$payment_paypal_content = vam_draw_input_fieldNote(array('name'=>'a_payment_paypal', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_PAYPAL_TEXT), $affiliate['affiliate_payment_paypal']);
    }
    $module->assign('payment_paypal_content', $payment_paypal_content);
}

if (AFFILIATE_USE_BANK == 'true') {
	$module->assign('AFFILIATE_USE_BANK', 'true');
	if ($is_read_only == true) {
		$payment_bank_name_content = $affiliate['affiliate_payment_bank_name'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_name_error == true) {
			$payment_bank_name_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_name', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_ERROR));
		}
		else {
			$payment_bank_name_content = $a_payment_bank_name . vam_draw_hidden_field('a_payment_bank_name');
		}
	}
	else {
		$payment_bank_name_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_name', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_NAME_TEXT), $affiliate['affiliate_payment_bank_name']);
    }
    $module->assign('payment_bank_name_content', $payment_bank_name_content);
    
    if ($is_read_only == true) {
    	$payment_bank_branch_number_content = $affiliate['affiliate_payment_bank_branch_number'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_branch_number_error == true) {
			$payment_bank_branch_number_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_branch_number', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_ERROR));
		}
		else {
			$payment_bank_branch_number_content = $a_payment_bank_branch_number . vam_draw_hidden_field('a_payment_bank_branch_number');
		}
	}
	else {
		$payment_bank_branch_number_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_branch_number', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_BRANCH_NUMBER_TEXT), $affiliate['affiliate_payment_bank_branch_number']);
    }
    $module->assign('payment_bank_branch_number_content', $payment_bank_branch_number_content);
    
    if ($is_read_only == true) {
    	$payment_bank_swift_code_content = $affiliate['affiliate_payment_bank_swift_code'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_swift_code_error == true) {
			$payment_bank_swift_code_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_swift_code', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_ERROR));
		}
		else {
			$payment_bank_swift_code_content = $a_payment_bank_swift_code . vam_draw_hidden_field('a_payment_bank_swift_code');
		}
	}
	else {
		$payment_bank_swift_code_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_swift_code', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_SWIFT_CODE_TEXT), $affiliate['affiliate_payment_bank_swift_code']);
    }
    $module->assign('payment_bank_swift_code_content', $payment_bank_swift_code_content);
    
    if ($is_read_only == true) {
    	$payment_bank_account_name_content = $affiliate['affiliate_payment_bank_account_name'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_account_name_error == true) {
			$payment_bank_account_name_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_account_name', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_ERROR));
		}
		else {
			$payment_bank_account_name_content = $a_payment_bank_account_name . vam_draw_hidden_field('a_payment_bank_account_name');
		}
	}
	else {
		$payment_bank_account_name_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_account_name', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NAME_TEXT), $affiliate['affiliate_payment_bank_account_name']);
    }
    $module->assign('payment_bank_account_name_content', $payment_bank_account_name_content);
    
    if ($is_read_only == true) {
    	$payment_bank_account_number_content = $affiliate['affiliate_payment_bank_account_number'];
    }
	elseif ($error == true) {
		if ($entry_payment_bank_account_number_error == true) {
			$payment_bank_account_number_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_account_number', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_ERROR));
		}
		else {
			$payment_bank_account_number_content = $a_payment_bank_account_number . vam_draw_hidden_field('a_payment_bank_account_number');
		}
	}
	else {
		$payment_bank_account_number_content = vam_draw_input_fieldNote(array('name'=>'a_payment_bank_account_number', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_PAYMENT_BANK_ACCOUNT_NUMBER_TEXT), $affiliate['affiliate_payment_bank_account_number']);
    }
    $module->assign('payment_bank_account_number_content', $payment_bank_account_number_content);
}

if ($is_read_only == true) {
	$street_address_content = $affiliate['affiliate_street_address'];
}
elseif ($error == true) {
	if ($entry_street_address_error == true) {
		$street_address_content = vam_draw_input_fieldNote(array('name'=>'a_street_address', 'text'=>'&nbsp;' . ENTRY_STREET_ADDRESS_ERROR));
    }
	else {
		$street_address_content = $a_street_address . vam_draw_hidden_field('a_street_address');
    }
}
else {
	$street_address_content = vam_draw_input_fieldNote(array('name'=>'a_street_address', 'text'=>'&nbsp;' . ENTRY_STREET_ADDRESS_TEXT), $affiliate['affiliate_street_address']);
}
$module->assign('street_address_content', $street_address_content);

if (ACCOUNT_SUBURB == 'true') {
	$module->assign('ACCOUNT_SUBURB', 'true');
	if ($is_read_only == true) {
		$suburb_content = $affiliate['affiliate_suburb'];
    }
	elseif ($error == true) {
		if ($entry_suburb_error == true) {
			$suburb_content = vam_draw_input_fieldNote(array('name'=>'a_suburb', 'text'=>'&nbsp;' . ENTRY_SUBURB_ERROR));
		}
		else {
			$suburb_content = $a_suburb . vam_draw_hidden_field('a_suburb');
		}
	}
	else {
		$suburb_content = vam_draw_input_fieldNote(array('name'=>'a_suburb', 'text'=>'&nbsp;' . ENTRY_SUBURB_TEXT), $affiliate['affiliate_suburb']);
    }
    $module->assign('suburb_content', $suburb_content);
}

if ($is_read_only == true) {
	$postcode_content = $affiliate['affiliate_postcode'];
}
elseif ($error == true) {
	if ($entry_post_code_error == true) {
		$postcode_content = vam_draw_input_fieldNote(array('name'=>'a_postcode', 'text'=>'&nbsp;' . ENTRY_POST_CODE_ERROR));
    }
	else {
		$postcode_content = $a_postcode . vam_draw_hidden_field('a_postcode');
    }
}
else {
	$postcode_content = vam_draw_input_fieldNote(array('name'=>'a_postcode', 'text'=>'&nbsp;' . ENTRY_POST_CODE_TEXT), $affiliate['affiliate_postcode']);
}
$module->assign('postcode_content', $postcode_content);

if ($is_read_only == true) {
	$city_content = $affiliate['affiliate_city'];
}
elseif ($error == true) {
	if ($entry_city_error == true) {
		$city_content = vam_draw_input_fieldNote(array('name'=>'a_city', 'text'=>'&nbsp;' . ENTRY_CITY_ERROR));
    }
	else {
		$city_content = $a_city . vam_draw_hidden_field('a_city');
    }
}
else {
	$city_content = vam_draw_input_fieldNote(array('name'=>'a_city', 'text'=>'&nbsp;' . ENTRY_CITY_TEXT), $affiliate['affiliate_city']);
}
$module->assign('city_content', $city_content);

if ($is_read_only == true) {
	$country_id_content = vam_get_country_name($affiliate['affiliate_country_id']);
}
elseif ($error == true) {
	if ($entry_country_error == true) {
		$country_id_content = vam_get_country_list(array('name'=>'a_country', 'text'=>'&nbsp;' . ENTRY_COUNTRY_ERROR));
    }
	else {
		$country_id_content = vam_get_country_name($a_country) . vam_draw_hidden_field('a_country');
    }
}
else {
if (!isset($affiliate['affiliate_country_id'])) $affiliate['affiliate_country_id']  = STORE_COUNTRY;
if (!isset($affiliate['affiliate_zone_id'])) $affiliate['affiliate_zone_id']  = STORE_ZONE;

	$country_id_content = vam_get_country_list('a_country', $affiliate['affiliate_country_id'], 'id="country"') . (vam_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="Requirement">' . ENTRY_COUNTRY_TEXT . '</span>': '');
}
$module->assign('country_id_content', $country_id_content);

if (ACCOUNT_STATE == 'true') {

if (!isset($affiliate['affiliate_country_id'])) $affiliate['affiliate_country_id']  = STORE_COUNTRY;
if (!isset($affiliate['affiliate_zone_id'])) $affiliate['affiliate_zone_id']  = STORE_ZONE;

	$module->assign('ACCOUNT_STATE', 'true');
	$state = vam_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $a_state);
    if ($is_read_only == true) {
    	$state_content = vam_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']);
    }

    if ($processed != true) {

//	    $a_country = (isset($_POST['a_country']) ? vam_db_prepare_input($_POST['a_country']) : STORE_COUNTRY);
	    $zone_id = 0;
		 $check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int)$affiliate['affiliate_country_id']."'");
		 $check = vam_db_fetch_array($check_query);
		 $entry_state_has_zones = ($check['total'] > 0);
		 if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = vam_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$affiliate['affiliate_country_id']."' order by zone_name");
			while ($zones_values = vam_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			
			$zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$affiliate['affiliate_country_id']."' and zone_code = '".vam_db_input($affiliate['affiliate_zone_id'])."'");

	      if (vam_db_num_rows($zone) > 0) {
	        $zone_id = $zone['zone_id'];
	        $zone_name = $zone['zone_name'];

	      } else {

		   $zone = vam_db_query("select distinct zone_id, zone_name from ".TABLE_ZONES." where zone_country_id = '".(int)$affiliate['affiliate_country_id']."' and zone_code = '".vam_db_input($affiliate['affiliate_zone_id'])."'");

	      if (vam_db_num_rows($zone) > 0) {
	          $zone_id = $zone['zone_id'];
	          $zone_name = $zone['zone_name'];
	        }
	      }
		}
	}

      if ($entry_state_has_zones == true) {
        $state_input = vam_draw_pull_down_menuNote(array ('name' => 'a_state', 'text' => '&nbsp;'. (defined(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array, vam_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']), ' id="state"');

      } else {
		 $state_input = vam_draw_input_fieldNote(array ('name' => 'a_state', 'text' => '&nbsp;'. (defined(ENTRY_STATE_TEXT) ? '<span class="Requirement">'.ENTRY_STATE_TEXT.'</span>' : '')), vam_get_zone_name($affiliate['affiliate_country_id'], $affiliate['affiliate_zone_id'], $affiliate['affiliate_state']), ' id="state"');

      }

	$module->assign('state_content', $state_input);
}

if ($is_read_only == true) {
	$telephone_content = $affiliate['affiliate_telephone'];
} elseif ($error == true) {
    if ($entry_telephone_error == true) {
    	$telephone_content = vam_draw_input_fieldNote(array('name'=>'a_telephone', 'text'=>'&nbsp;' . ENTRY_TELEPHONE_NUMBER_ERROR));
    }
	else {
		$telephone_content = $a_telephone . vam_draw_hidden_field('a_telephone');
    }
}
else {
	$telephone_content = vam_draw_input_fieldNote(array('name'=>'a_telephone', 'text'=>'&nbsp;' . ENTRY_TELEPHONE_NUMBER_TEXT), $affiliate['affiliate_telephone']);
}
$module->assign('telephone_content', $telephone_content);

if ($is_read_only == true) {
	$fax_content = $affiliate['affiliate_fax'];
}
elseif ($error == true) {
	if ($entry_fax_error == true) {
		$fax_content = vam_draw_input_fieldNote(array('name'=>'a_fax', 'text'=>'&nbsp;' . ENTRY_FAX_NUMBER_ERROR));
    }
	else {
		$fax_content = $a_fax . vam_draw_hidden_field('a_fax');
    }
}
else {
	$fax_content = vam_draw_input_fieldNote(array('name'=>'a_fax', 'text'=>'&nbsp;' . ENTRY_FAX_NUMBER_TEXT), $affiliate['affiliate_fax']);
}
$module->assign('fax_content', $fax_content);

if ($is_read_only == true) {
	$homepage_content = $affiliate['affiliate_homepage'];
}
elseif ($error == true) {
	if ($entry_homepage_error == true) {
		$homepage_content = vam_draw_input_fieldNote(array('name'=>'a_homepage', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_HOMEPAGE_ERROR));
    }
	else {
		$homepage_content = $a_homepage . vam_draw_hidden_field('a_homepage');
    }
}
else {
	$homepage_content = vam_draw_input_fieldNote(array('name'=>'a_homepage', 'text'=>'&nbsp;' . ENTRY_AFFILIATE_HOMEPAGE_TEXT), $affiliate['affiliate_homepage']);
}
$module->assign('homepage_content', $homepage_content);

if ($is_read_only == false) {
	$module->assign('PASSWORD_READONLY', 'false');
    if ($error == true) {
    	$module->assign('error', 'true');
    	if ($entry_password_error == true) {
    		$password_content = vam_draw_password_fieldNote(array('name'=>'a_password', 'text'=>'&nbsp;' . ENTRY_PASSWORD_ERROR));
    	}
		else {
			$password_content = PASSWORD_HIDDEN . vam_draw_hidden_field('a_password') . vam_draw_hidden_field('a_confirmation');
		}
	}
	else {
		$password_content = vam_draw_password_fieldNote(array('name'=>'a_password', 'text'=>'&nbsp;' . ENTRY_PASSWORD_TEXT));
    }
    if ( ($error == false) || ($entry_password_error == true) ) {
    	$password_confirmation_content = vam_draw_password_fieldNote(array('name'=>'a_confirmation', 'text'=>'&nbsp;' . ENTRY_PASSWORD_CONFIRMATION_TEXT));
    }
    $agb_content = vam_draw_selection_fieldNote(array('name'=>'a_agb', 'text'=>sprintf(ENTRY_AFFILIATE_ACCEPT_AGB, vam_href_link(FILENAME_CONTENT,'coID=9', 'SSL'))), 'checkbox', $value = '1', $checked = $affiliate['affiliate_agb']);
    if ($entry_agb_error == true) {
      $agb_content .= "<br>".ENTRY_AFFILIATE_AGB_ERROR;
    }
    $module->assign('agb_content', $agb_content);
	$module->assign('password_content', $password_content);
	$module->assign('password_confirmation_content', $password_confirmation_content);
}
$module->assign('language', $_SESSION['language']);
$module->caching = 0;
$module= $module->fetch(CURRENT_TEMPLATE.'/module/affiliate_account_details.html');
$vamTemplate->assign('main_content', $module);
