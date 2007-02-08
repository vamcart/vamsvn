<?php
/* --------------------------------------------------------------
   $Id: create_account.php 1296 2007-02-08 11:13:01Z VaM $   

   VaM Shop - open source ecommerce solution
   http://vamshop.ru
   http://vamshop.com

   Copyright (c) 2007 VaM Shop
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(customers.php,v 1.76 2003/05/04); www.oscommerce.com 
   (c) 2003	 nextcommerce (create_account.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2004	 xt:Commerce (create_account.php,v 1.17 2003/08/24); xt-commerce.com

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contribution:
   Customers Status v3.x  (c) 2002-2003 Copyright Elari elari@free.fr | www.unlockgsm.com/dload-osc/ | CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require ('includes/application_top.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
require_once (DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
require_once (DIR_FS_INC.'xtc_php_mail.inc.php');
require_once (DIR_FS_INC.'xtc_create_password.inc.php');
require_once (DIR_FS_INC.'xtc_get_geo_zone_code.inc.php');


// initiate template engine for mail
$smarty = new Smarty;

$customers_statuses_array = xtc_get_customers_statuses();
if ($customers_password == '') {
	$customers_password_encrypted =  xtc_RandomString(8);
	$customers_password = xtc_encrypt_password($customers_password_encrypted);
}
if ($_GET['action'] == 'edit') {
	$customers_firstname = xtc_db_prepare_input($_POST['customers_firstname']);
	$customers_cid = xtc_db_prepare_input($_POST['csID']);
	$customers_vat_id = xtc_db_prepare_input($_POST['customers_vat_id']);
	$customers_vat_id_status = xtc_db_prepare_input($_POST['customers_vat_id_status']);
	$customers_lastname = xtc_db_prepare_input($_POST['customers_lastname']);
	$customers_email_address = xtc_db_prepare_input($_POST['customers_email_address']);
	$customers_telephone = xtc_db_prepare_input($_POST['customers_telephone']);
	$customers_fax = xtc_db_prepare_input($_POST['customers_fax']);
	$customers_status_c = xtc_db_prepare_input($_POST['status']);

	$customers_gender = xtc_db_prepare_input($_POST['customers_gender']);
	$customers_dob = xtc_db_prepare_input($_POST['customers_dob']);

	$default_address_id = xtc_db_prepare_input($_POST['default_address_id']);
	$entry_street_address = xtc_db_prepare_input($_POST['entry_street_address']);
	$entry_suburb = xtc_db_prepare_input($_POST['entry_suburb']);
	$entry_postcode = xtc_db_prepare_input($_POST['entry_postcode']);
	$entry_city = xtc_db_prepare_input($_POST['entry_city']);
	$entry_country_id = xtc_db_prepare_input($_POST['entry_country_id']);

	$entry_company = xtc_db_prepare_input($_POST['entry_company']);
	$entry_state = xtc_db_prepare_input($_POST['entry_state']);
	$entry_zone_id = xtc_db_prepare_input($_POST['entry_zone_id']);

	$customers_send_mail = xtc_db_prepare_input($_POST['customers_mail']);
	$customers_password_encrypted = xtc_db_prepare_input($_POST['entry_password']);
	$customers_password = xtc_encrypt_password($customers_password_encrypted);
	
	$customers_mail_comments = xtc_db_prepare_input($_POST['mail_comments']);

	$payment_unallowed = xtc_db_prepare_input($_POST['payment_unallowed']);
	$shipping_unallowed = xtc_db_prepare_input($_POST['shipping_unallowed']);

	if ($customers_password == '') {
		$customers_password_encrypted =  xtc_RandomString(8);
		$customers_password = xtc_encrypt_password($customers_password_encrypted);
	}
	$error = false; // reset error flag

	if (ACCOUNT_GENDER == 'true') {
		if (($customers_gender != 'm') && ($customers_gender != 'f')) {
			$error = true;
			$entry_gender_error = true;
		} else {
			$entry_gender_error = false;
		}
	}

	if (strlen($customers_password) < ENTRY_PASSWORD_MIN_LENGTH) {
		$error = true;
		$entry_password_error = true;
	} else {
		$entry_password_error = false;
	}

	if (($customers_send_mail != 'yes') && ($customers_send_mail != 'no')) {
		$error = true;
		$entry_mail_error = true;
	} else {
		$entry_mail_error = false;
	}

	if (strlen($customers_firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$entry_firstname_error = true;
	} else {
		$entry_firstname_error = false;
	}

	if (strlen($customers_lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;
		$entry_lastname_error = true;
	} else {
		$entry_lastname_error = false;
	}

	if (ACCOUNT_DOB == 'true') {
		if (checkdate(substr(xtc_date_raw($customers_dob), 4, 2), substr(xtc_date_raw($customers_dob), 6, 2), substr(xtc_date_raw($customers_dob), 0, 4))) {
			$entry_date_of_birth_error = false;
		} else {
			$error = true;
			$entry_date_of_birth_error = true;
		}
	}

	// Vat Check
	if (xtc_get_geo_zone_code($entry_country_id) != '6') {

		if ($customers_vat_id != '') {

			if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {

				$validate_vatid = validate_vatid($customers_vat_id);

				if ($validate_vatid == '0') {
					if (ACCOUNT_VAT_BLOCK_ERROR == 'true') {
						$entry_vat_error = true;
						$error = true;
					}
					$customers_vat_id_status = '0';
				}

				if ($validate_vatid == '1') {
					$customers_vat_id_status = '1';
				}

				if ($validate_vatid == '8') {
					if (ACCOUNT_VAT_BLOCK_ERROR == 'true') {
						$entry_vat_error = true;
						$error = true;
					}
					$customers_vat_id_status = '8';
				}

				if ($validate_vatid == '9') {
					if (ACCOUNT_VAT_BLOCK_ERROR == 'true') {
						$entry_vat_error = true;
						$error = true;
					}
					$customers_vat_id_status = '9';
				}

			}

		}
	}
	// Vat Check

// New VAT Check
	if (xtc_get_geo_zone_code($entry_country_id) != '6') {
	require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($customers_vat_id, '', '', $entry_country_id);

	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1){
	$entry_vat_error = true;
	$error = true;
  }

  }
// New VAT CHECK END

	if (strlen($customers_email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;
		$entry_email_address_error = true;
	} else {
		$entry_email_address_error = false;
	}

	if (!xtc_validate_email($customers_email_address)) {
		$error = true;
		$entry_email_address_check_error = true;
	} else {
		$entry_email_address_check_error = false;
	}

	if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;
		$entry_street_address_error = true;
	} else {
		$entry_street_address_error = false;
	}

	if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;
		$entry_post_code_error = true;
	} else {
		$entry_post_code_error = false;
	}

	if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;
		$entry_city_error = true;
	} else {
		$entry_city_error = false;
	}

	if ($entry_country_id == false) {
		$error = true;
		$entry_country_error = true;
	} else {
		$entry_country_error = false;
	}

	if (ACCOUNT_STATE == 'true') {
		if ($entry_country_error == true) {
			$entry_state_error = true;
		} else {
			$zone_id = 0;
			$entry_state_error = false;
			$check_query = xtc_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".xtc_db_input($entry_country_id)."'");
			$check_value = xtc_db_fetch_array($check_query);
			$entry_state_has_zones = ($check_value['total'] > 0);
			if ($entry_state_has_zones == true) {
				$zone_query = xtc_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".xtc_db_input($entry_country_id)."' and zone_name = '".xtc_db_input($entry_state)."'");
				if (xtc_db_num_rows($zone_query) == 1) {
					$zone_values = xtc_db_fetch_array($zone_query);
					$entry_zone_id = $zone_values['zone_id'];
				} else {
					$zone_query = xtc_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".xtc_db_input($entry_country)."' and zone_code = '".xtc_db_input($entry_state)."'");
					if (xtc_db_num_rows($zone_query) >= 1) {
						$zone_values = xtc_db_fetch_array($zone_query);
						$zone_id = $zone_values['zone_id'];
					} else {
						$error = true;
						$entry_state_error = true;
					}
				}
			} else {
				if ($entry_state == false) {
					$error = true;
					$entry_state_error = true;
				}
			}
		}
	}

	if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$entry_telephone_error = true;
	} else {
		$entry_telephone_error = false;
	}

	$check_email = xtc_db_query("select customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".xtc_db_input($customers_email_address)."' and customers_id <> '".xtc_db_input($customers_id)."'");
	if (xtc_db_num_rows($check_email)) {
		$error = true;
		$entry_email_address_exists = true;
	} else {
		$entry_email_address_exists = false;
	}

	if ($error == false) {
		$sql_data_array = array ('customers_status' => $customers_status_c, 'customers_cid' => $customers_cid, 'customers_vat_id' => $customers_vat_id, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_firstname' => $customers_firstname, 'customers_lastname' => $customers_lastname, 'customers_email_address' => $customers_email_address, 'customers_telephone' => $customers_telephone, 'customers_fax' => $customers_fax, 'payment_unallowed' => $payment_unallowed, 'shipping_unallowed' => $shipping_unallowed, 'customers_password' => $customers_password,'customers_date_added' => 'now()','customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $customers_gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = xtc_date_raw($customers_dob);

		xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array);

		$cc_id = xtc_db_insert_id();

		$sql_data_array = array ('customers_id' => $cc_id, 'entry_firstname' => $customers_firstname, 'entry_lastname' => $customers_lastname, 'entry_street_address' => $entry_street_address, 'entry_postcode' => $entry_postcode, 'entry_city' => $entry_city, 'entry_country_id' => $entry_country_id,'address_date_added' => 'now()','address_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['entry_gender'] = $customers_gender;
		if (ACCOUNT_COMPANY == 'true')
			$sql_data_array['entry_company'] = $entry_company;
		if (ACCOUNT_SUBURB == 'true')
			$sql_data_array['entry_suburb'] = $entry_suburb;
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
				$sql_data_array['entry_zone_id'] = $entry_zone_id;
				$sql_data_array['entry_state'] = '';
			} else {
				$sql_data_array['entry_zone_id'] = '0';
				$sql_data_array['entry_state'] = $entry_state;
			}
		}

		xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

		$address_id = xtc_db_insert_id();

		xtc_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".$cc_id."'");

		xtc_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".$cc_id."', '0', now())");
		// Create insert into admin access table if admin is created.
		if ($customers_status_c == '0') {
			xtc_db_query("INSERT into ".TABLE_ADMIN_ACCESS." (customers_id,start) VALUES ('".$cc_id."','1')");
		}

		// Create eMail
		if (($customers_send_mail == 'yes')) {

			// assign language to template for caching
			$smarty->assign('language', $_SESSION['language']);
			$smarty->caching = false;

			// set dirs manual
			$smarty->template_dir = DIR_FS_CATALOG.'templates';
			$smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
			$smarty->config_dir = DIR_FS_CATALOG.'lang';

			$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
			$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

			$smarty->assign('NAME', $customers_lastname.' '.$customers_firstname);
			$smarty->assign('EMAIL', $customers_email_address);
			$smarty->assign('COMMENTS', $customers_mail_comments);
			$smarty->assign('PASSWORD', $customers_password_encrypted);

			$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/create_account_mail.html');
			$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/create_account_mail.txt');

			xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $customers_email_address, $customers_lastname.' '.$customers_firstname, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);
		}
		xtc_redirect(xtc_href_link(FILENAME_CUSTOMERS, 'cID='.$cc_id, 'SSL'));
	}
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
        <td width="100%">

    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
  
  </td>
  </tr>
  <tr>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr><?php echo xtc_draw_form('customers', FILENAME_CREATE_ACCOUNT, xtc_get_all_get_params(array('action')) . 'action=edit', 'post', 'onSubmit="return check_form();"') . xtc_draw_hidden_field('default_address_id', $customers_default_address_id); ?>
        <td class="formAreaTitle"><?php echo CATEGORY_PERSONAL; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

if (ACCOUNT_GENDER == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_GENDER; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_gender_error == true) {
			echo xtc_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE.'&nbsp;'.ENTRY_GENDER_ERROR;
		} else {
			echo ($customers_gender == 'm') ? MALE : FEMALE;
			echo xtc_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE;
		}
	} else {
		echo xtc_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE;
	}
?></td>
          </tr>
<?php

}
?>
          <tr>
            <td class="main"><?php echo ENTRY_CID; ?></td>
            <td class="main"><?php


echo xtc_draw_input_field('csID', $customers_cid, 'maxlength="32"');
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_firstname_error == true) {
		echo xtc_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"').'&nbsp;'.ENTRY_FIRST_NAME_ERROR;
	} else {
		echo xtc_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"');
	}
} else {
	echo xtc_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"');
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_lastname_error == true) {
		echo xtc_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"').'&nbsp;'.ENTRY_LAST_NAME_ERROR;
	} else {
		echo xtc_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"');
	}
} else {
	echo xtc_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"');
}
?></td>
          </tr>
<?php

if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_date_of_birth_error == true) {
			echo xtc_draw_input_field('customers_dob', xtc_date_short($customers_dob), 'maxlength="10"').'&nbsp;'.ENTRY_DATE_OF_BIRTH_ERROR;
		} else {
			echo xtc_draw_input_field('customers_dob', xtc_date_short($customers_dob), 'maxlength="10"');
		}
	} else {
		echo xtc_draw_input_field('customers_dob', xtc_date_short($customers_dob), 'maxlength="10"');
	}
?></td>
          </tr>
<?php

}
?>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_email_address_error == true) {
		echo xtc_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR;
	}
	elseif ($entry_email_address_check_error == true) {
		echo xtc_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
	}
	elseif ($entry_email_address_exists == true) {
		echo xtc_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
	} else {
		echo xtc_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"');
	}
} else {
	echo xtc_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"');
}
?></td>
          </tr>
        </table></td>
      </tr>
<?php

if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_COMPANY; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_COMPANY; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_company_error == true) {
			echo xtc_draw_input_field('entry_company', $entry_company, 'maxlength="32"').'&nbsp;'.ENTRY_COMPANY_ERROR;
		} else {
			echo xtc_draw_input_field('entry_company', $entry_company, 'maxlength="32"');
		}
	} else {
		echo xtc_draw_input_field('entry_company', $entry_company, 'maxlength="32"');
	}
?></td>
          </tr>
<?php

	if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_VAT_ID; ?></td>
            <td class="main"><?php

		if ($error == true) {
			if ($entry_vat_error == true) {
				echo xtc_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"').'&nbsp;'.ENTRY_VAT_ERROR;
			} else {
				echo xtc_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"');
			}
		} else {
			echo xtc_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"');
		}
?></td>
          </tr>
<?php

	}
?>

        </table></td>
      </tr>
<?php

}
?>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_street_address_error == true) {
		echo xtc_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"').'&nbsp;'.ENTRY_STREET_ADDRESS_ERROR;
	} else {
		echo xtc_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"');
	}
} else {
	echo xtc_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"');
}
?></td>
          </tr>
<?php

if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_suburb_error == true) {
			echo xtc_draw_input_field('suburb', $entry_suburb, 'maxlength="32"').'&nbsp;'.ENTRY_SUBURB_ERROR;
		} else {
			echo xtc_draw_input_field('entry_suburb', $entry_suburb, 'maxlength="32"');
		}
	} else {
		echo xtc_draw_input_field('entry_suburb', $entry_suburb, 'maxlength="32"');
	}
?></td>
          </tr>
<?php

}
?>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_post_code_error == true) {
		echo xtc_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"').'&nbsp;'.ENTRY_POST_CODE_ERROR;
	} else {
		echo xtc_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"');
	}
} else {
	echo xtc_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"');
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_city_error == true) {
		echo xtc_draw_input_field('entry_city', $entry_city, 'maxlength="32"').'&nbsp;'.ENTRY_CITY_ERROR;
	} else {
		echo xtc_draw_input_field('entry_city', $entry_city, 'maxlength="32"');
	}
} else {
	echo xtc_draw_input_field('entry_city', $entry_city, 'maxlength="32"');
}
?></td>
          </tr>
<?php

if (ACCOUNT_STATE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STATE; ?></td>
            <td class="main"><?php

	$entry_state = xtc_get_zone_name($entry_country_id, $entry_zone_id, $entry_state);
	if ($error == true) {
		if ($entry_state_error == true) {
			if ($entry_state_has_zones == true) {
				$zones_array = array ();
				$zones_query = xtc_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".xtc_db_input($entry_country_id)."' order by zone_name");
				while ($zones_values = xtc_db_fetch_array($zones_query)) {
					$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
				}
				echo xtc_draw_pull_down_menu('entry_state', $zones_array).'&nbsp;'.ENTRY_STATE_ERROR;
			} else {
				echo xtc_draw_input_field('entry_state', xtc_get_zone_name($entry_country_id, $entry_zone_id, $entry_state)).'&nbsp;'.ENTRY_STATE_ERROR;
			}
		} else {
			echo xtc_draw_input_field('entry_state', xtc_get_zone_name($entry_country_id, $entry_zone_id, $entry_state));
		}
	} else {
		echo xtc_draw_input_field('entry_state', xtc_get_zone_name($entry_country_id, $entry_zone_id, $entry_state));
	}
?></td>
         </tr>
<?php

}
?>
          <tr>
            <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_country_error == true) {
		echo xtc_draw_pull_down_menu('entry_country_id', xtc_get_countries(xtc_get_country_name(STORE_COUNTRY)), $entry_country_id).'&nbsp;'.ENTRY_COUNTRY_ERROR;
	} else {
		echo xtc_draw_pull_down_menu('entry_country_id', xtc_get_countries(xtc_get_country_name(STORE_COUNTRY)), $entry_country_id);
	}
} else {
	echo xtc_draw_pull_down_menu('entry_country_id', xtc_get_countries(xtc_get_country_name(STORE_COUNTRY)), $entry_country_id);
}
?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_telephone_error == true) {
		echo xtc_draw_input_field('customers_telephone', $customers_telephone).'&nbsp;'.ENTRY_TELEPHONE_NUMBER_ERROR;
	} else {
		echo xtc_draw_input_field('customers_telephone', $customers_telephone);
	}
} else {
	echo xtc_draw_input_field('customers_telephone', $customers_telephone);
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main"><?php echo xtc_draw_input_field('customers_fax'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
            <td class="main"><?php

if ($processed == true) {
	echo xtc_draw_hidden_field('status');
} else {
	echo xtc_draw_pull_down_menu('status', $customers_statuses_array);
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_MAIL; ?></td>
            <td class="main">
<?php

if ($error == true) {
	if ($entry_mail_error == true) {
		echo xtc_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO.'&nbsp;'.ENTRY_MAIL_ERROR;
	} else {
		echo ($customers_gender == 'm') ? YES : NO;
		echo xtc_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO;
	}
} else {
	echo xtc_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.xtc_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO;
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_PAYMENT_UNALLOWED; ?></td>
            <td class="main"><?php echo xtc_draw_input_field('payment_unallowed'); ?></td>
          </tr>
           <tr>
            <td class="main"><?php echo ENTRY_SHIPPING_UNALLOWED; ?></td>
            <td class="main"><?php echo xtc_draw_input_field('shipping_unallowed'); ?></td>
          </tr>
            <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_PASSWORD; ?></td>
            <td class="main" bgcolor="#FFCC33"><?php

if ($error == true) {
	if ($entry_password_error == true) {
		echo xtc_draw_password_field('entry_password', $customers_password_encrypted).'&nbsp;'.ENTRY_PASSWORD_ERROR;
	} else {
		echo xtc_draw_password_field('entry_password', $customers_password_encrypted);
	}
} else {
	echo xtc_draw_password_field('entry_password', $customers_password_encrypted);
}
?></td>
          </tr>
            <td class="main" valign="top"><?php echo ENTRY_MAIL_COMMENTS; ?></td>
            <td class="main"><?php echo xtc_draw_textarea_field('mail_comments', 'soft', '60', '5', $mail_comments); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CUSTOMERS, xtc_get_all_get_params(array('action'))) .'">' . BUTTON_CANCEL . '</a>'; ?></td>
      </tr></form>
      </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
