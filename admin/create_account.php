<?php
/* --------------------------------------------------------------
   $Id: create_account.php 1296 2013-02-08 11:13:01Z VaM $   

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
require_once (DIR_FS_INC.'vam_encrypt_password.inc.php');
require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.phpmailer.php');
if (EMAIL_TRANSPORT == 'smtp')
require_once (DIR_FS_CATALOG . 'includes/external/phpmailer/class.smtp.php');
require_once (DIR_FS_INC.'vam_php_mail.inc.php');
require_once (DIR_FS_INC.'vam_create_password.inc.php');
require_once (DIR_FS_INC.'vam_get_geo_zone_code.inc.php');


// initiate template engine for mail
$vamTemplate = new vamTemplate;

$customers_statuses_array = vam_get_customers_statuses();
if ($customers_password == '') {
	$customers_password_encrypted =  vam_RandomString(8);
	$customers_password = vam_encrypt_password($customers_password_encrypted);
}
if ($_GET['action'] == 'edit') {
	$customers_firstname = vam_db_prepare_input($_POST['customers_firstname']);
	$customers_secondname = vam_db_prepare_input($_POST['customers_secondname']);
	$customers_cid = vam_db_prepare_input($_POST['csID']);
	$customers_vat_id = vam_db_prepare_input($_POST['customers_vat_id']);
	$customers_vat_id_status = vam_db_prepare_input($_POST['customers_vat_id_status']);
	$customers_lastname = vam_db_prepare_input($_POST['customers_lastname']);
	$customers_email_address = vam_db_prepare_input($_POST['customers_email_address']);
	$customers_telephone = vam_db_prepare_input($_POST['customers_telephone']);
	$customers_fax = vam_db_prepare_input($_POST['customers_fax']);
	$customers_status_c = vam_db_prepare_input($_POST['status']);

	$customers_gender = vam_db_prepare_input($_POST['customers_gender']);
	$customers_dob = vam_db_prepare_input($_POST['customers_dob']);

	$default_address_id = vam_db_prepare_input($_POST['default_address_id']);
	$entry_street_address = vam_db_prepare_input($_POST['entry_street_address']);
	$entry_suburb = vam_db_prepare_input($_POST['entry_suburb']);
	$entry_postcode = vam_db_prepare_input($_POST['entry_postcode']);
	$entry_city = vam_db_prepare_input($_POST['entry_city']);
	$entry_country_id = vam_db_prepare_input($_POST['entry_country_id']);

	$entry_company = vam_db_prepare_input($_POST['entry_company']);
	$entry_state = vam_db_prepare_input($_POST['state']);
	$entry_zone_id = vam_db_prepare_input($_POST['entry_zone_id']);

	$customers_send_mail = vam_db_prepare_input($_POST['customers_mail']);
	$customers_password_encrypted = vam_db_prepare_input($_POST['entry_password']);
	$customers_password = vam_encrypt_password($customers_password_encrypted);
	
	$customers_mail_comments = vam_db_prepare_input($_POST['mail_comments']);

	$payment_unallowed = vam_db_prepare_input($_POST['payment_unallowed']);
	$shipping_unallowed = vam_db_prepare_input($_POST['shipping_unallowed']);

	if ($customers_password == '') {
		$customers_password_encrypted =  vam_RandomString(8);
		$customers_password = vam_encrypt_password($customers_password_encrypted);
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
		if (checkdate(substr(vam_date_raw($customers_dob), 4, 2), substr(vam_date_raw($customers_dob), 6, 2), substr(vam_date_raw($customers_dob), 0, 4))) {
			$entry_date_of_birth_error = false;
		} else {
			$error = true;
			$entry_date_of_birth_error = true;
		}
	}

	// Vat Check
	if (vam_get_geo_zone_code($entry_country_id) != '6') {

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
	if (vam_get_geo_zone_code($entry_country_id) != '6') {
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

	if (!vam_validate_email($customers_email_address)) {
		$error = true;
		$entry_email_address_check_error = true;
	} else {
		$entry_email_address_check_error = false;
	}

        if (ACCOUNT_STREET_ADDRESS == 'true') {
	if (strlen($entry_street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;
		$entry_street_address_error = true;
	} else {
		$entry_street_address_error = false;
	}
        }

        if (ACCOUNT_POSTCODE == 'true') {
	if (strlen($entry_postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;
		$entry_post_code_error = true;
	} else {
		$entry_post_code_error = false;
	}
		  }

        if (ACCOUNT_CITY == 'true') {
	if (strlen($entry_city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;
		$entry_city_error = true;
	} else {
		$entry_city_error = false;
	}
        }


		$entry_country_error = false;

if (isset($_POST['country'])) { $entry_country_id = $_POST['country']; } else { $entry_country_id = STORE_COUNTRY; }
$entry_state = $_POST['state'];

	if (ACCOUNT_STATE == 'true') {
		if ($entry_country_error == true) {
			$entry_state_error = true;
		} else {
			$zone_id = 0;
			$entry_state_error = false;
			$check_query = vam_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country_id)."'");
			$check_value = vam_db_fetch_array($check_query);
			$entry_state_has_zones = ($check_value['total'] > 0);
			if ($entry_state_has_zones == true) {
				$zone_query = vam_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country_id)."' and zone_name = '".vam_db_input($entry_state)."'");
				if (vam_db_num_rows($zone_query) == 1) {
					$zone_values = vam_db_fetch_array($zone_query);
					$entry_zone_id = $zone_values['zone_id'];
				} else {
					$zone_query = vam_db_query("select zone_id from ".TABLE_ZONES." where zone_country_id = '".vam_db_input($entry_country)."' and zone_code = '".vam_db_input($entry_state)."'");
					if (vam_db_num_rows($zone_query) >= 1) {
						$zone_values = vam_db_fetch_array($zone_query);
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

        if (ACCOUNT_TELE == 'true') {
	if (strlen($customers_telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$entry_telephone_error = true;
	} else {
		$entry_telephone_error = false;
	}
        }

	$check_email = vam_db_query("select customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".vam_db_input($customers_email_address)."' and customers_id <> '".vam_db_input($customers_id)."'");
	if (vam_db_num_rows($check_email)) {
		$error = true;
		$entry_email_address_exists = true;
	} else {
		$entry_email_address_exists = false;
	}

      $extra_fields_query = vam_db_query("select ce.fields_id, ce.fields_input_type, ce.fields_required_status, cei.fields_name, ce.fields_status, ce.fields_input_type, ce.fields_size from " . TABLE_EXTRA_FIELDS . " ce, " . TABLE_EXTRA_FIELDS_INFO . " cei where ce.fields_status=1 and ce.fields_required_status=1 and cei.fields_id=ce.fields_id and cei.languages_id =" . (int)$_SESSION['languages_id']);
      while($extra_fields = vam_db_fetch_array($extra_fields_query)){
        if(strlen($_POST['fields_' . $extra_fields['fields_id'] ])<$extra_fields['fields_size']){
          $error = true;
          $string_error=sprintf(ENTRY_EXTRA_FIELDS_ERROR,$extra_fields['fields_name'],$extra_fields['fields_size']);
          $messageStack->add($string_error);
        }
      }

	if ($error == false) {
		$sql_data_array = array ('customers_status' => $customers_status_c, 'customers_cid' => $customers_cid, 'customers_vat_id' => $customers_vat_id, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_firstname' => $customers_firstname, 'customers_secondname' => $customers_secondname, 'customers_lastname' => $customers_lastname, 'customers_email_address' => $customers_email_address, 'customers_telephone' => $customers_telephone, 'customers_fax' => $customers_fax, 'payment_unallowed' => $payment_unallowed, 'shipping_unallowed' => $shipping_unallowed, 'customers_password' => $customers_password,'customers_date_added' => 'now()','customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $customers_gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = vam_date_raw($customers_dob);

		vam_db_perform(TABLE_CUSTOMERS, $sql_data_array);

		$cc_id = vam_db_insert_id();

		$sql_data_array = array ('customers_id' => $cc_id, 'entry_firstname' => $customers_firstname, 'entry_secondname' => $customers_secondname, 'entry_lastname' => $customers_lastname, 'entry_street_address' => $entry_street_address, 'entry_postcode' => $entry_postcode, 'entry_city' => $entry_city, 'entry_country_id' => $entry_country_id,'address_date_added' => 'now()','address_last_modified' => 'now()');

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

		vam_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

		$address_id = vam_db_insert_id();

		vam_db_query("update ".TABLE_CUSTOMERS." set customers_default_address_id = '".$address_id."' where customers_id = '".$cc_id."'");

		vam_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".$cc_id."', '0', now())");
		// Create insert into admin access table if admin is created.
		if ($customers_status_c == '0') {
			vam_db_query("INSERT into ".TABLE_ADMIN_ACCESS." (customers_id,start) VALUES ('".$cc_id."','1')");
		}

		// Create eMail
		if (($customers_send_mail == 'yes')) {

			// assign language to template for caching
			$vamTemplate->assign('language', $_SESSION['language']);
			$vamTemplate->caching = false;

			$vamTemplate->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
			$vamTemplate->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

			$vamTemplate->assign('NAME', $customers_lastname.' '.$customers_firstname);
			$vamTemplate->assign('EMAIL', $customers_email_address);
			$vamTemplate->assign('COMMENTS', $customers_mail_comments);
			$vamTemplate->assign('PASSWORD', $customers_password_encrypted);

			$html_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/create_account_mail.html');
			$txt_mail = $vamTemplate->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/create_account_mail.txt');

			vam_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, $customers_email_address, $customers_lastname.' '.$customers_firstname, EMAIL_SUPPORT_FORWARDING_STRING, EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', EMAIL_SUPPORT_SUBJECT, $html_mail, $txt_mail);
		}
		
        vam_db_query("delete from " . TABLE_CUSTOMERS_TO_EXTRA_FIELDS . " where customers_id=" . (int)$cc_id);
        $extra_fields_query =vam_db_query("select ce.fields_id from " . TABLE_EXTRA_FIELDS . " ce where ce.fields_status=1 ");
        while($extra_fields = vam_db_fetch_array($extra_fields_query)){
            $sql_extra_data_array = array('customers_id' => (int)$cc_id,
                              'fields_id' => $extra_fields['fields_id'],
                              'value' => $_POST['fields_' . $extra_fields['fields_id'] ]);
            vam_db_perform(TABLE_CUSTOMERS_TO_EXTRA_FIELDS, $sql_extra_data_array);
        }
		
		
		vam_redirect(vam_href_link(FILENAME_CUSTOMERS, 'cID='.$cc_id, 'SSL'));
	}
}
?>
<!DOCTYPE html>
<html <?php echo HTML_PARAMS; ?>>
<head>
<!--<meta name="viewport" content="initial-scale=1.0, width=device-width" />-->
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<!-- Header JS, CSS -->
<?php require(DIR_FS_ADMIN.DIR_WS_INCLUDES . 'header_include.php'); ?>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
<?php if (ADMIN_DROP_DOWN_NAVIGATION == 'false') { ?>
    <td width="<?php echo BOX_WIDTH; ?>" align="left" valign="top">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </td>
<?php } ?>
<!-- body_text //-->
    <td class="boxCenter" valign="top">
    
    <h1 class="contentBoxHeading"><?php echo HEADING_TITLE; ?></h1>
    
    <table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr><?php echo vam_draw_form('customers', FILENAME_CREATE_ACCOUNT, vam_get_all_get_params(array('action')) . 'action=edit', 'post', 'onSubmit="return check_form();"') . vam_draw_hidden_field('default_address_id', $customers_default_address_id); ?>
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
			echo vam_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE.'&nbsp;'.ENTRY_GENDER_ERROR;
		} else {
			echo ($customers_gender == 'm') ? MALE : FEMALE;
			echo vam_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE;
		}
	} else {
		echo vam_draw_radio_field('customers_gender', 'm', false, $customers_gender).'&nbsp;&nbsp;'.MALE.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_gender', 'f', false, $customers_gender).'&nbsp;&nbsp;'.FEMALE;
	}
?></td>
          </tr>
<?php

}
?>
          <tr>
            <td class="main"><?php echo ENTRY_CID; ?></td>
            <td class="main"><?php


echo vam_draw_input_field('csID', $customers_cid, 'maxlength="32"');
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_FIRST_NAME; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_firstname_error == true) {
		echo vam_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"').'&nbsp;'.ENTRY_FIRST_NAME_ERROR;
	} else {
		echo vam_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"');
	}
} else {
	echo vam_draw_input_field('customers_firstname', $customers_firstname, 'maxlength="32"');
}
?></td>
          </tr>
<?php

if (ACCOUNT_SECOND_NAME == 'true' or ACCOUNT_SECOND_NAME == 'optional') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SECOND_NAME; ?></td>
            <td class="main"><?php

	echo vam_draw_input_field('customers_secondname', $customers_secondname, 'maxlength="32"');

?></td>
          </tr>
<?php

	}
?>
<?php

if (ACCOUNT_LAST_NAME == 'true' or ACCOUNT_LAST_NAME == 'optional') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_LAST_NAME; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_lastname_error == true) {
		echo vam_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"').'&nbsp;'.ENTRY_LAST_NAME_ERROR;
	} else {
		echo vam_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"');
	}
} else {
	echo vam_draw_input_field('customers_lastname', $customers_lastname, 'maxlength="32"');
}
?></td>
          </tr>
<?php

	}
?>
          
<?php

if (ACCOUNT_DOB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_DATE_OF_BIRTH; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_date_of_birth_error == true) {
			echo vam_draw_input_field('customers_dob', vam_date_short($customers_dob), 'maxlength="10"').'&nbsp;'.ENTRY_DATE_OF_BIRTH_ERROR;
		} else {
			echo vam_draw_input_field('customers_dob', vam_date_short($customers_dob), 'maxlength="10"');
		}
	} else {
		echo vam_draw_input_field('customers_dob', vam_date_short($customers_dob), 'maxlength="10"');
	}
?></td>
          </tr>
<?php

}
?>
<?php

if (ACCOUNT_EMAIL == 'true' or ACCOUNT_EMAIL == 'optional') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_EMAIL_ADDRESS; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_email_address_error == true) {
		echo vam_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR;
	}
	elseif ($entry_email_address_check_error == true) {
		echo vam_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_CHECK_ERROR;
	}
	elseif ($entry_email_address_exists == true) {
		echo vam_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"').'&nbsp;'.ENTRY_EMAIL_ADDRESS_ERROR_EXISTS;
	} else {
		echo vam_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"');
	}
} else {
	echo vam_draw_input_field('customers_email_address', $customers_email_address, 'maxlength="96"');
}
?></td>
          </tr>
<?php

}
?>
        </table></td>
      </tr>
<?php

if (ACCOUNT_COMPANY == 'true') {
?>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
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
			echo vam_draw_input_field('entry_company', $entry_company, 'maxlength="32"').'&nbsp;'.ENTRY_COMPANY_ERROR;
		} else {
			echo vam_draw_input_field('entry_company', $entry_company, 'maxlength="32"');
		}
	} else {
		echo vam_draw_input_field('entry_company', $entry_company, 'maxlength="32"');
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
				echo vam_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"').'&nbsp;'.ENTRY_VAT_ERROR;
			} else {
				echo vam_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"');
			}
		} else {
			echo vam_draw_input_field('customers_vat_id', $customers_vat_id, 'maxlength="32"');
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
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

	if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_ADDRESS; ?></td>
      </tr>
<?php

	}
?>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

	if (ACCOUNT_STREET_ADDRESS == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_STREET_ADDRESS; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_street_address_error == true) {
		echo vam_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"').'&nbsp;'.ENTRY_STREET_ADDRESS_ERROR;
	} else {
		echo vam_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"');
	}
} else {
	echo vam_draw_input_field('entry_street_address', $entry_street_address, 'maxlength="64"');
}
?></td>
          </tr>
<?php

	}
?>
<?php

if (ACCOUNT_SUBURB == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_SUBURB; ?></td>
            <td class="main"><?php

	if ($error == true) {
		if ($entry_suburb_error == true) {
			echo vam_draw_input_field('suburb', $entry_suburb, 'maxlength="32"').'&nbsp;'.ENTRY_SUBURB_ERROR;
		} else {
			echo vam_draw_input_field('entry_suburb', $entry_suburb, 'maxlength="32"');
		}
	} else {
		echo vam_draw_input_field('entry_suburb', $entry_suburb, 'maxlength="32"');
	}
?></td>
          </tr>
<?php

}
?>
<?php

	if (ACCOUNT_POSTCODE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_POST_CODE; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_post_code_error == true) {
		echo vam_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"').'&nbsp;'.ENTRY_POST_CODE_ERROR;
	} else {
		echo vam_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"');
	}
} else {
	echo vam_draw_input_field('entry_postcode', $entry_postcode, 'maxlength="8"');
}
?></td>
          </tr>
<?php

	}
?>
<?php

	if (ACCOUNT_CITY == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_CITY; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_city_error == true) {
		echo vam_draw_input_field('entry_city', $entry_city, 'maxlength="32"').'&nbsp;'.ENTRY_CITY_ERROR;
	} else {
		echo vam_draw_input_field('entry_city', $entry_city, 'maxlength="32"');
	}
} else {
	echo vam_draw_input_field('entry_city', $entry_city, 'maxlength="32"');
}
?></td>
          </tr>
<?php

	}
?>
<?php
  if (ACCOUNT_COUNTRY == 'true') {
?>
              <tr>
                <td class="main"><?php echo ENTRY_COUNTRY; ?></td>
                <td class="main"><?php echo vam_get_country_list('country',STORE_COUNTRY, 'onChange="changeselect();"') . '&nbsp;' . (defined(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': ''); ?></td>
              </tr>
<?php
  }
?>
<?php
if (ACCOUNT_STATE == 'true') {
?>
             <tr>
               <td class="main"><?php echo ENTRY_STATE;?></td>
               <td class="main">
<script language="javascript">
<!--
function changeselect(reg) {
//clear select
    document.customers.state.length=0;
    var j=0;
    for (var i=0;i<zones.length;i++) {
      if (zones[i][0]==document.customers.country.value) {
   document.customers.state.options[j]=new Option(zones[i][1],zones[i][1]);
   j++;
   }
      }
    if (j==0) {
      document.customers.state.options[0]=new Option('-','-');
      }
    if (reg) { document.customers.state.value = reg; }
}
   var zones = new Array(
   <?php
       $zones_query = vam_db_query("select zone_country_id,zone_name from " . TABLE_ZONES . " order by zone_name asc");
       $mas=array();
       while ($zones_values = vam_db_fetch_array($zones_query)) {
         $zones[] = 'new Array('.$zones_values['zone_country_id'].',"'.$zones_values['zone_name'].'")';
       }
       echo implode(',',$zones);
       ?>
       );
document.write('<SELECT NAME="state">');
document.write('</SELECT>');
changeselect("<?php echo vam_db_prepare_input($_POST['state']); ?>");
-->
</script>
          </td>
             </tr>
<?php
}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
<?php

	if (ACCOUNT_TELE == 'true') {
?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_CONTACT; ?></td>
      </tr>
<?php

	}
?>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
<?php

	if (ACCOUNT_TELE == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_TELEPHONE_NUMBER; ?></td>
            <td class="main"><?php

if ($error == true) {
	if ($entry_telephone_error == true) {
		echo vam_draw_input_field('customers_telephone', $customers_telephone).'&nbsp;'.ENTRY_TELEPHONE_NUMBER_ERROR;
	} else {
		echo vam_draw_input_field('customers_telephone', $customers_telephone);
	}
} else {
	echo vam_draw_input_field('customers_telephone', $customers_telephone);
}
?></td>
          </tr>
<?php

	}
?>
<?php

	if (ACCOUNT_FAX == 'true') {
?>
          <tr>
            <td class="main"><?php echo ENTRY_FAX_NUMBER; ?></td>
            <td class="main"><?php echo vam_draw_input_field('customers_fax'); ?></td>
          </tr>
<?php

	}
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <?php echo vam_get_extra_fields($_GET['cID'],$_SESSION['languages_id']); ?>
      <tr>
        <td class="formAreaTitle"><?php echo CATEGORY_OPTIONS; ?></td>
      </tr>
      <tr>
        <td class="formArea"><table border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td class="main"><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
            <td class="main"><?php

if ($processed == true) {
	echo vam_draw_hidden_field('status');
} else {
	echo vam_draw_pull_down_menu('status', $customers_statuses_array, 2);
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_MAIL; ?></td>
            <td class="main">
<?php

if ($error == true) {
	if ($entry_mail_error == true) {
		echo vam_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO.'&nbsp;'.ENTRY_MAIL_ERROR;
	} else {
		echo vam_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO;
	}
} else {
	echo vam_draw_radio_field('customers_mail', 'yes', true, $customers_send_mail).'&nbsp;&nbsp;'.YES.'&nbsp;&nbsp;'.vam_draw_radio_field('customers_mail', 'no', false, $customers_send_mail).'&nbsp;&nbsp;'.NO;
}
?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_PAYMENT_UNALLOWED; ?></td>
            <td class="main"><?php echo vam_draw_input_field('payment_unallowed'); ?></td>
          </tr>
           <tr>
            <td class="main"><?php echo ENTRY_SHIPPING_UNALLOWED; ?></td>
            <td class="main"><?php echo vam_draw_input_field('shipping_unallowed'); ?></td>
          </tr>
            <td class="main" bgcolor="#FFCC33"><?php echo ENTRY_PASSWORD; ?></td>
            <td class="main" bgcolor="#FFCC33"><?php

if ($error == true) {
	if ($entry_password_error == true) {
		echo vam_draw_password_field('entry_password', $customers_password_encrypted).'&nbsp;'.ENTRY_PASSWORD_ERROR;
	} else {
		echo vam_draw_password_field('entry_password', $customers_password_encrypted);
	}
} else {
	echo vam_draw_password_field('entry_password', $customers_password_encrypted);
}
?></td>
          </tr>
            <td class="main" valign="top"><?php echo ENTRY_MAIL_COMMENTS; ?></td>
            <td class="main"><?php echo vam_draw_textarea_field('mail_comments', 'soft', '60', '5', $mail_comments); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo vam_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo '<span class="button"><button type="submit" value="' . BUTTON_INSERT . '">' . vam_image(DIR_WS_IMAGES . 'icons/buttons/submit.png', '', '12', '12') . '&nbsp;' . BUTTON_INSERT . '</button></span> <a class="button" href="' . vam_href_link(FILENAME_CUSTOMERS, vam_get_all_get_params(array('action'))) .'"><span>' . vam_image(DIR_WS_IMAGES . 'icons/buttons/cancel.png', '', '12', '12') . '&nbsp;' . BUTTON_CANCEL . '</span></a>'; ?></td>
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